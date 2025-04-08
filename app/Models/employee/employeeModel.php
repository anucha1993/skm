<?php

namespace App\Models\employee;

use App\Models\category\AdpermissionModel;
use App\Models\category\departmentModel;
use App\Models\category\officeModel;
use App\Models\category\positionModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employeeModel extends Model
{
    use HasFactory;
    protected $table = 'employee';
    protected $primaryKey = 'emp_id';
    protected $casts = [
        'emp_unity' => 'array',
        'emp_express' => 'array',
        'emp_permission' => 'array',
    ];
    protected $fillable = [
        'emp_name',
        'emp_dep',
        'emp_office',
        'emp_branch',
        'emp_position',
        'emp_ad',
        'emp_express',
        'emp_unity',
        'emp_permission',
        'emp_code',
        'created_by',
        'updated_by',
        'emp_status',
    ];

    public function department()
    {
        return $this->belongsTo(departmentModel::class, 'emp_dep', 'dep_id');
    }
    public function office()
    {
        return $this->belongsTo(officeModel::class, 'emp_office', 'office_id');
    }
    public function position()
    {
        return $this->belongsTo(positionModel::class, 'emp_position', 'position_id');
    }

}
