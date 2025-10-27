<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NotificationExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $data;
    protected $type;
    
    public function __construct($data, $type)
    {
        $this->data = $data;
        $this->type = $type;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data;
    }
    
    public function headings(): array
    {
        return [
            'ลำดับ',
            'ชื่อ-นามสกุล',
            'เลขบัตรประชาชน',
            'บริษัท',
            'สถานะ',
            'วันที่หมดอายุ',
            'จำนวนวันที่เหลือ',
            'โทรศัพท์',
            'อีเมล'
        ];
    }
    
    public function map($labour): array
    {
        static $index = 0;
        $index++;
        
        $expiryDate = $this->getExpiryDate($labour);
        $daysLeft = $expiryDate ? now()->diffInDays($expiryDate, false) : 0;
        
        return [
            $index,
            $labour->labour_prefix . ' ' . $labour->labour_firstname . ' ' . $labour->labour_lastname,
            $labour->labour_idcard_number,
            $labour->company->name ?? '',
            $labour->labourStatus->value ?? '',
            $expiryDate ? $expiryDate->format('d/m/Y') : '',
            $daysLeft > 0 ? $daysLeft . ' วัน' : 'หมดอายุแล้ว',
            $labour->labour_phone_one,
            $labour->labour_email
        ];
    }
    
    private function getExpiryDate($labour)
    {
        switch ($this->type) {
            case 'disease_expiring':
                return $labour->labour_disease_issue_date ? 
                       \Carbon\Carbon::parse($labour->labour_disease_issue_date)->addDays(30) : null;
            case 'passport_expiring':
                return $labour->labour_passport_expiry_date ? 
                       \Carbon\Carbon::parse($labour->labour_passport_expiry_date) : null;
            case 'cid_expiring':
                return $labour->labour_cid_expiry_date ? 
                       \Carbon\Carbon::parse($labour->labour_cid_expiry_date) : null;
            case 'affidavit_expiring':
                return $labour->labour_affidavit_expiry_date ? 
                       \Carbon\Carbon::parse($labour->labour_affidavit_expiry_date) : null;
            default:
                return null;
        }
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
