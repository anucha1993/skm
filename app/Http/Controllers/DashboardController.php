<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\labours\labourModel;
use Illuminate\Support\Facades\DB;
use App\Exports\NotificationExport;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // คำนวณสถิติต่างๆ
        $statistics = $this->calculateStatistics();
        
        // คำนวณการแจ้งเตือน
        $notifications = $this->calculateNotifications();
        
        return view('dashboard.index', compact('statistics', 'notifications'));
    }
    
    private function calculateStatistics()
    {
        return [
            'total_labours' => labourModel::count(),
            'working_labours' => $this->getWorkingLabours(),
            'cancelled_labours' => $this->getCancelledLabours(),
            'visa_approved' => labourModel::where('labour_visa_status', 'อนุมัติ')->count(),
            'visa_rejected' => labourModel::where('labour_visa_status', 'ไม่อนุมัติ')->count(),
            'visa_no_update' => labourModel::whereNotNull('labour_visa_submission_date')
                                         ->where('labour_visa_submission_date', '<=', Carbon::now()->subDays(75))
                                         ->whereNull('labour_visa_approval_date')
                                         ->count(),
        ];
    }
    
    private function getWorkingLabours()
    {
        // ตรวจสอบจาก Global Set ว่า value ไหนคือ "บินไปทำงานแล้ว"
        $workingStatusId = \App\Models\globalsets\GlobalSetValueModel::where('value', 'บินไปทำงานแล้ว')->first()?->id;
        
        if ($workingStatusId) {
            return labourModel::where('labour_status', $workingStatusId)->count();
        }
        
        return 0;
    }
    
    private function getCancelledLabours()
    {
        // ตรวจสอบจาก Global Set ว่า value ไหนคือ "ยกเลิก"
        $cancelledStatusId = \App\Models\globalsets\GlobalSetValueModel::where('value', 'ยกเลิก')->first()?->id;
        
        if ($cancelledStatusId) {
            return labourModel::where('labour_status', $cancelledStatusId)->count();
        }
        
        return 0;
    }
    
    private function calculateNotifications()
    {
        $today = Carbon::now();
        $warningDays = 15;
        
        return [
            'disease_expiring' => $this->getDiseaseExpiring($today, $warningDays),
            'passport_expiring' => $this->getPassportExpiring($today, $warningDays),
            'cid_expiring' => $this->getCidExpiring($today, $warningDays),
            'affidavit_expiring' => $this->getAffidavitExpiring($today, $warningDays),
            'unpaid_deposits' => $this->getUnpaidDeposits($today),
        ];
    }
    
    private function getDiseaseExpiring($today, $warningDays)
    {
        $endDate = $today->copy()->addDays($warningDays);
        return labourModel::whereNotNull('labour_disease_issue_date')
                         ->whereRaw('DATE_ADD(labour_disease_issue_date, INTERVAL 30 DAY) BETWEEN ? AND ?', 
                                   [$today->format('Y-m-d'), $endDate->format('Y-m-d')])
                         ->with(['company', 'labourStatus'])
                         ->get();
    }
    
    private function getPassportExpiring($today, $warningDays)
    {
        $endDate = $today->copy()->addDays($warningDays);
        return labourModel::whereNotNull('labour_passport_expiry_date')
                         ->whereBetween('labour_passport_expiry_date', 
                                      [$today->format('Y-m-d'), $endDate->format('Y-m-d')])
                         ->with(['company', 'labourStatus'])
                         ->get();
    }
    
    private function getCidExpiring($today, $warningDays)
    {
        $endDate = $today->copy()->addDays($warningDays);
        return labourModel::whereNotNull('labour_cid_expiry_date')
                         ->whereBetween('labour_cid_expiry_date', 
                                      [$today->format('Y-m-d'), $endDate->format('Y-m-d')])
                         ->with(['company', 'labourStatus'])
                         ->get();
    }
    
    private function getAffidavitExpiring($today, $warningDays)
    {
        $endDate = $today->copy()->addDays($warningDays);
        return labourModel::whereNotNull('labour_affidavit_expiry_date')
                         ->whereBetween('labour_affidavit_expiry_date', 
                                      [$today->format('Y-m-d'), $endDate->format('Y-m-d')])
                         ->with(['company', 'labourStatus'])
                         ->get();
    }
    
    private function getUnpaidDeposits($today)
    {
        // คำนวณวันที่ที่เกิน 15 วันหลังจากยื่น CID
        $fifteenDaysAgo = $today->copy()->subDays(15);
        
        return labourModel::whereNotNull('labour_cid_stand_date')
                         ->where('labour_cid_stand_date', '<=', $fifteenDaysAgo->format('Y-m-d'))
                         ->whereNull('labour_cid_deposit_date')
                         ->with(['company', 'labourStatus', 'country', 'jobGroup', 'position'])
                         ->get();
    }
    
    public function exportNotification(Request $request)
    {
        $type = $request->get('type');
        $notifications = $this->calculateNotifications();
        
        $data = $notifications[$type] ?? collect();
        
        return Excel::download(new NotificationExport($data, $type), 
                              'notification-' . $type . '-' . Carbon::now()->format('Y-m-d') . '.xlsx');
    }
    
    public function viewNotificationDetails(Request $request)
    {
        $type = $request->get('type');
        $notifications = $this->calculateNotifications();
        
        $data = $notifications[$type] ?? collect();
        $title = $this->getNotificationTitle($type);
        
        return view('dashboard.notification-details', compact('data', 'title', 'type'));
    }
    
    private function getNotificationTitle($type)
    {
        $titles = [
            'disease_expiring' => 'แจ้งเตือนผลโรคหมดอายุ',
            'passport_expiring' => 'แจ้งเตือนพาสปอร์ตหมดอายุ',
            'cid_expiring' => 'แจ้งเตือน CID หมดอายุ',
            'affidavit_expiring' => 'แจ้งเตือน Affidavit หมดอายุ',
            'unpaid_deposits' => 'แจ้งเตือนเงินมัดจำ CID ค้างชำระ',
        ];
        
        return $titles[$type] ?? 'การแจ้งเตือน';
    }
    
    public function viewStatisticDetails(Request $request)
    {
        $type = $request->get('type');
        $data = collect();
        $title = '';
        
        switch ($type) {
            case 'working':
                $workingStatusId = \App\Models\globalsets\GlobalSetValueModel::where('value', 'บินไปทำงานแล้ว')->first()?->id;
                if ($workingStatusId) {
                    $data = labourModel::where('labour_status', $workingStatusId)
                                     ->with(['company', 'labourStatus', 'country', 'jobGroup', 'position'])
                                     ->get();
                }
                $title = 'รายการคนงานที่ไปทำงานแล้ว';
                break;
                
            case 'cancelled':
                $cancelledStatusId = \App\Models\globalsets\GlobalSetValueModel::where('value', 'ยกเลิก')->first()?->id;
                if ($cancelledStatusId) {
                    $data = labourModel::where('labour_status', $cancelledStatusId)
                                     ->with(['company', 'labourStatus', 'country', 'jobGroup', 'position'])
                                     ->get();
                }
                $title = 'รายการคนงานที่ยกเลิก';
                break;
                
            case 'visa_approved':
                $data = labourModel::where('labour_visa_status', 'อนุมัติ')
                                 ->with(['company', 'labourStatus', 'country', 'jobGroup', 'position'])
                                 ->get();
                $title = 'รายการ VISA ที่อนุมัติแล้ว';
                break;
                
            case 'visa_rejected':
                $data = labourModel::where('labour_visa_status', 'ไม่อนุมัติ')
                                 ->with(['company', 'labourStatus', 'country', 'jobGroup', 'position'])
                                 ->get();
                $title = 'รายการ VISA ที่ไม่อนุมัติ';
                break;
                
            case 'visa_no_update':
                $data = labourModel::whereNotNull('labour_visa_submission_date')
                                 ->where('labour_visa_submission_date', '<=', Carbon::now()->subDays(75))
                                 ->whereNull('labour_visa_approval_date')
                                 ->with(['company', 'labourStatus', 'country', 'jobGroup', 'position'])
                                 ->get();
                $title = 'รายการ VISA ที่ไม่ Update (75+ วัน)';
                break;
                
            default:
                $title = 'ไม่พบข้อมูล';
        }
        
        return view('dashboard.statistic-details', compact('data', 'title', 'type'));
    }
    
    public function exportStatistic(Request $request)
    {
        $type = $request->get('type');
        
        // Get data using same logic as viewStatisticDetails
        $data = collect();
        
        switch ($type) {
            case 'working':
                $workingStatusId = \App\Models\globalsets\GlobalSetValueModel::where('value', 'บินไปทำงานแล้ว')->first()?->id;
                if ($workingStatusId) {
                    $data = labourModel::where('labour_status', $workingStatusId)
                                     ->with(['company', 'labourStatus', 'country', 'jobGroup', 'position'])
                                     ->get();
                }
                break;
                
            case 'cancelled':
                $cancelledStatusId = \App\Models\globalsets\GlobalSetValueModel::where('value', 'ยกเลิก')->first()?->id;
                if ($cancelledStatusId) {
                    $data = labourModel::where('labour_status', $cancelledStatusId)
                                     ->with(['company', 'labourStatus', 'country', 'jobGroup', 'position'])
                                     ->get();
                }
                break;
                
            case 'visa_approved':
                $data = labourModel::where('labour_visa_status', 'อนุมัติ')
                                 ->with(['company', 'labourStatus', 'country', 'jobGroup', 'position'])
                                 ->get();
                break;
                
            case 'visa_rejected':
                $data = labourModel::where('labour_visa_status', 'ไม่อนุมัติ')
                                 ->with(['company', 'labourStatus', 'country', 'jobGroup', 'position'])
                                 ->get();
                break;
                
            case 'visa_no_update':
                $data = labourModel::whereNotNull('labour_visa_submission_date')
                                 ->where('labour_visa_submission_date', '<=', Carbon::now()->subDays(75))
                                 ->whereNull('labour_visa_approval_date')
                                 ->with(['company', 'labourStatus', 'country', 'jobGroup', 'position'])
                                 ->get();
                break;
        }
        
        return Excel::download(new \App\Exports\StatisticExport($data, $type), 
                              'statistic-' . $type . '-' . Carbon::now()->format('Y-m-d') . '.xlsx');
    }
}
