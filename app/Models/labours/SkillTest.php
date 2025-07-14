<?php
namespace App\Models\labours;

use App\Models\customers\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\globalsets\GlobalSetValueModel;

class SkillTest extends Model
{
    use HasFactory;
    protected $table = 'skill_tests';
    protected $primaryKey = 'skill_test_id';
    protected $fillable = [
        'labour_id',
        'customer_id',
        'test_date',
        'test_location_id',
        'test_position_id',
        'test_result_id',
        'note',
    ];

    public function labour()
    {
        return $this->belongsTo(labourModel::class, 'labour_id', 'labour_id');
    }
  public function customer()
{
    return $this->belongsTo(Customer::class, 'customer_id', 'id');
}
    public function testLocation()
    {
        return $this->belongsTo(GlobalSetValueModel::class, 'test_location_id', 'id');
    }
    public function testPosition()
    {
        return $this->belongsTo(GlobalSetValueModel::class, 'test_position_id', 'id');
    }
    public function testResult()
    {
        return $this->belongsTo(GlobalSetValueModel::class, 'test_result_id', 'id');
    }
}
