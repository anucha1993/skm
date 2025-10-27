<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StatisticExport implements FromCollection, WithHeadings, WithMapping, WithStyles
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
            'ประเทศ',
            'กลุ่มงาน',
            'ตำแหน่ง',
            'สถานะ',
            'สถานะ VISA',
            'วันที่ยื่น VISA',
            'วันที่อนุมัติ VISA',
            'โทรศัพท์',
            'อีเมล'
        ];
    }
    
    public function map($labour): array
    {
        static $index = 0;
        $index++;
        
        return [
            $index,
            $labour->labour_prefix . ' ' . $labour->labour_firstname . ' ' . $labour->labour_lastname,
            $labour->labour_idcard_number,
            $labour->company->name ?? '',
            $labour->country->value ?? '',
            $labour->jobGroup->value ?? '',
            $labour->position->value ?? '',
            $labour->labourStatus->value ?? '',
            $labour->labour_visa_status ?? '',
            $labour->labour_visa_submission_date ? \Carbon\Carbon::parse($labour->labour_visa_submission_date)->format('d/m/Y') : '',
            $labour->labour_visa_approval_date ? \Carbon\Carbon::parse($labour->labour_visa_approval_date)->format('d/m/Y') : '',
            $labour->labour_phone_one,
            $labour->labour_email
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
