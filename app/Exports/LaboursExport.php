<?php

namespace App\Exports;

use App\Models\labours\labourModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\{
    FromQuery, WithHeadings, WithMapping, WithEvents, ShouldAutoSize
};

class LaboursExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, ShouldQueue   // ต่อ queue ได้ทันที
{
    protected array $filters;          // รับเงื่อนไขจากฟอร์ม

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /** 1. สร้าง query ตามเงื่อนไข */
    public function query()
    {
        return labourModel::query()
            ->with(['company','country','position','jobGroup','hospital'])->filter($this->filters)
            ->when($this->filters['company_id'] ?? null, fn($q,$v)   => $q->where('company_id',$v))
            ->when($this->filters['labour_status'] ?? null, fn($q,$v)=> $q->where('labour_status',$v))
            ->when($this->filters['country_id'] ?? null,  fn($q,$v)  => $q->where('country_id',$v))
            ->when($this->filters['date_from'] ?? null,   fn($q)     => $q->whereDate('created_at','>=',$this->filters['date_from']))
            ->when($this->filters['date_to']   ?? null,   fn($q)     => $q->whereDate('created_at','<=',$this->filters['date_to']));
    }

    /** 2. จัดรูปข้อมูลแต่ละแถว */
    public function map($labour): array
    {
        $steps = implode(', ', $labour->completed_steps);
        
        return [
            $labour->labour_register_number,
            $labour->labour_prefix.' '.$labour->labour_firstname.' '.$labour->labour_lastname,
            $labour->company?->name,
            $labour->country?->value,
            optional($labour->position)->value,
            $labour->labourStatus?->value,
            $steps,
            $labour->labour_phone_one,
            $labour->labour_passport_number,
            date('d/m/Y',strtotime($labour->labour_passport_issue_date)),
            date('d/m/Y',strtotime($labour->labour_passport_expiry_date)),
            $labour->created_at->format('d/m/Y H:i'),
        ];
    }

    /** 3. หัวตาราง */
    public function headings(): array
    {
        return [
            'เลขสมัคร',
            'ชื่อ-สกุล',
            'บริษัท',
            'สัญชาติ',
            'ตำแหน่งงาน',
            'สถานะ',
            'Step',
            'โทรศัพท์',
            'Passport',
            'ออก Passport',
            'หมดอายุ Passport',
            'บันทึกเมื่อ',
        ];
    }
}
