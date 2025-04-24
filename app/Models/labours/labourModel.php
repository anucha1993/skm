<?php

namespace App\Models\labours;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class labourModel extends Model
{
    use HasFactory;
    protected $table = 'labours';
    protected $primaryKey = 'labour_id';
    protected $fillable = [
        'labour_prefix',
        'labour_idcard_number',
        'labour_firstname',
        'labour_lastname',
        'labour_birthday',
        'labour_phone_one',
        'labour_phone_two',
        'labour_passport_number',
        'labour_passport_issue_date',
        'labour_passport_expiry_date',
        'labour_hospital',
        'labour_disease_receive_date',
        'labour_disease_issue_date',
        'company_id',
        'labour_register_number',
        'country_id',
        'job_group_id',
        'position_id',
        'labour_status',
        'lacation_test_id',
        'staff_id',
        'staff_sub_id',
        'labour_image_path',
        'labour_image_thumbnail_path',
        'managedoc_id',
        'created_by',
        'updated_by',
    ];
}
