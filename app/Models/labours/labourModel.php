<?php

namespace App\Models\labours;

use App\Models\customers\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\managedocs\managedocsModel;
use App\Models\globalsets\GlobalSetValueModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class labourModel extends Model
{
    use HasFactory;
    protected $table = 'labours';
    protected $primaryKey = 'labour_id';
    protected $fillable = ['labour_prefix',
     'labour_idcard_number','labour_note',
    'labour_firstname',
    'labour_lastname', 'labour_birthday', 'labour_phone_one', 'labour_phone_two', 'labour_passport_number', 'labour_passport_issue_date', 'labour_passport_expiry_date', 'labour_hospital', 'labour_disease_receive_date', 'labour_disease_issue_date', 'company_id', 'labour_register_number', 'country_id', 'job_group_id', 'position_id', 'labour_status', 'lacation_test_id', 'lacation_test_date', 'staff_id', 'staff_sub_id', 'labour_image_path', 'labour_image_thumbnail_path', 'managedoc_id', 'created_by', 'updated_by'];

    public function listFiles()
    {
        return $this->hasMany(listfilesModel::class, 'labour_id', 'labour_id');
    }

    public function labourStatus()
    {
        return $this->belongsTo(GlobalSetValueModel::class, 'labour_status', 'id');
    }
    //hospital
    public function hospital()
    {
        return $this->belongsTo(GlobalSetValueModel::class, 'labour_hospital', 'id');
    }
    //hospital
    public function country()
    {
        return $this->belongsTo(GlobalSetValueModel::class, 'country_id', 'id');
    }
    //jobGroup
    public function jobGroup()
    {
        return $this->belongsTo(GlobalSetValueModel::class, 'job_group_id', 'id');
    }
    //position
    public function position()
    {
        return $this->belongsTo(GlobalSetValueModel::class, 'position_id', 'id');
    }
    //examinationCenter
    public function examinationCenter()
    {
        return $this->belongsTo(GlobalSetValueModel::class, 'lacation_test_id', 'id');
    }
    //examinationCenter
    public function staff()
    {
        return $this->belongsTo(GlobalSetValueModel::class, 'staff_id', 'id');
    }
    //examinationCenter
    public function staffSub()
    {
        return $this->belongsTo(GlobalSetValueModel::class, 'staff_sub_id', 'id');
    }
    public function company()
    {
        return $this->belongsTo(Customer::class, 'company_id', 'id');
    }
    public function manageDoc()
    {
        return $this->belongsTo(managedocsModel::class, 'managedoc_id', 'managedoc_id');
    }

    public function getCompletedStepsAttribute()
    {
        return $this->listFiles()
            ->selectRaw(
                "
                managefile_step,
                COUNT(*)            AS total_files,
                SUM(file_path IS NOT NULL) AS has_files
            ",
            )
            ->groupBy('managefile_step')
            ->havingRaw('total_files = has_files')
            ->pluck('managefile_step')
            ->toArray();
    }
    // app/Models/labourModel.php
    public function scopeFilter($q, array $filters): void
{
    $q->when($filters['company_id']   ?? null, fn($q,$v)=>$q->where('company_id',$v))
      ->when($filters['labour_status']?? null, fn($q,$v)=>$q->where('labour_status',$v))
      ->when($filters['country_id']   ?? null, fn($q,$v)=>$q->where('country_id',$v))
      ->when($filters['date_from']    ?? null, fn($q,$v)=>$q->whereDate('created_at','>=',$v))
      ->when($filters['date_to']      ?? null, fn($q,$v)=>$q->whereDate('created_at','<=',$v))
      ->withCompletedSteps($filters['steps'] ?? []);   // <── ใหม่
}
    // app/Models/labourModel.php
    public function scopeStepCompleted($q, string|array $steps)
    {
        $steps = (array) $steps; // รับได้ทั้ง ‘A’ หรือ ['A','B']

        $q->whereExists(function ($sub) use ($steps) {
            $sub->selectRaw(1)
                ->from('list_files') // ตารางของ relation
                ->whereColumn('list_files.labour_id', 'labours.labour_id')
                ->whereIn('managefile_step', $steps)
                ->groupBy('managefile_step')
                ->havingRaw('COUNT(*) = SUM(file_path IS NOT NULL)');
        });

        /* หมายเหตุ: if ต้องครบทุก step ในอาร์เรย์ ให้ใช้ loop whereExists ทีละ step
         แต่ถ้าต้องการ 'ครบอย่างน้อยหนึ่ง step ในชุดที่เลือก' โค้ดด้านบนใช้ได้เลย */
    }

    public function scopeWithCompletedSteps(Builder $q, array $steps): Builder
    {
        if (empty($steps)) {
            return $q; // ไม่กรองถ้าไม่ได้เลือก
        }

        return $q->whereIn('labour_id', function ($sub) use ($steps) {
            $sub->from('list_files')->select('labour_id')->whereIn('managefile_step', $steps)->groupBy('labour_id', 'managefile_step')->havingRaw('COUNT(*) = SUM(file_path IS NOT NULL)');
        });
    }
}
