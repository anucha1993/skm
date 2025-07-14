<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\labours\labourModel;
use Illuminate\Http\Request;

class LabourFullController extends Controller
{
    public function index(Request $request)
    {
        $data = collect();
        if ($request->filled('apiid')) {
            $query = labourModel::with([
                'company:id,name',
                'labourStatus:id,value',
                'country:id,value',
                'jobGroup:id,value',
                'position:id,value',
                'examinationCenter:id,value',
                'staff:id,value',
                'staffSub:id,value',
                'manageDoc:managedoc_id,managedoc_name',
                'listFiles:list_file_id,labour_id,managefile_code,managefile_name,managefile_step,file_path,updated_at',
            ])->where('api_candidate_id', $request->input('apiid'));

            $labours = $query->get();

            $data = $labours->map(function($item) {
                $arr = $item->toArray();
                if (isset($arr['labourStatus'])) {
                    $arr['labour_status'] = $arr['labourStatus'];
                    unset($arr['labourStatus']);
                }
                if (isset($arr['jobGroup'])) {
                    $arr['job_group'] = $arr['jobGroup'];
                    unset($arr['jobGroup']);
                }
                if (isset($arr['position'])) {
                    $arr['position'] = $arr['position'];
                }
                if (isset($arr['examinationCenter'])) {
                    $arr['examination_center'] = $arr['examinationCenter'];
                    unset($arr['examinationCenter']);
                }
                if (isset($arr['staff'])) {
                    $arr['staff'] = $arr['staff'];
                }
                if (isset($arr['staffSub'])) {
                    $arr['staff_sub'] = $arr['staffSub'];
                    unset($arr['staffSub']);
                }
                if (isset($arr['manageDoc'])) {
                    $arr['manage_doc'] = $arr['manageDoc'];
                    unset($arr['manageDoc']);
                }
                if (isset($arr['listFiles'])) {
                    $arr['list_files'] = $arr['listFiles'];
                    unset($arr['listFiles']);
                }
                return $arr;
            });
        }
        return response()->json(['data' => $data]);
    }

    public function searchByEmail(Request $request)
    {
        $data = collect();
        if ($request->filled('apiid')) {
            $query = labourModel::with([
                'company:id,name',
                'labourStatus:id,value',
                'country:id,value',
                'jobGroup:id,value',
                'position:id,value',
                'examinationCenter:id,value',
                'staff:id,value',
                'staffSub:id,value',
                'manageDoc:managedoc_id,managedoc_name',
                'SkillTest.customer:id,name',
                'SkillTest.testLocation:id,value',
                'SkillTest.testPosition:id,value',
                'SkillTest.testResult:id,value',
                'listFiles:list_file_id,labour_id,managefile_code,managefile_name,managefile_step,file_path,updated_at',
            ])->where('api_candidate_id', $request->input('apiid'));

            $labours = $query->get();

            $data = $labours->map(function($item) {
                $arr = $item->toArray();
                if (isset($arr['labourStatus'])) {
                    $arr['labour_status'] = $arr['labourStatus'];
                    unset($arr['labourStatus']);
                }
                if (isset($arr['jobGroup'])) {
                    $arr['job_group'] = $arr['jobGroup'];
                    unset($arr['jobGroup']);
                }
                if (isset($arr['position'])) {
                    $arr['position'] = $arr['position'];
                }
                if (isset($arr['examinationCenter'])) {
                    $arr['examination_center'] = $arr['examinationCenter'];
                    unset($arr['examinationCenter']);
                }
                if (isset($arr['staff'])) {
                    $arr['staff'] = $arr['staff'];
                }
                if (isset($arr['staffSub'])) {
                    $arr['staff_sub'] = $arr['staffSub'];
                    unset($arr['staffSub']);
                }
                if (isset($arr['manageDoc'])) {
                    $arr['manage_doc'] = $arr['manageDoc'];
                    unset($arr['manageDoc']);
                }
                if (isset($arr['listFiles'])) {
                    $arr['list_files'] = $arr['listFiles'];
                    unset($arr['listFiles']);
                }
                if (isset($arr['SkillTest'])) {
                    $arr['skill_tests'] = $arr['SkillTest'];
                    unset($arr['SkillTest']);
                }
                return $arr;
            });
        }
        return response()->json(['data' => $data]);
    }
}
