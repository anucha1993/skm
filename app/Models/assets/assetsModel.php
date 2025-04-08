<?php

namespace App\Models\assets;

use App\Models\category\branchModel;
use App\Models\category\brandsModel;
use App\Models\category\vendersModel;
use App\Models\employee\employeeModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\category\deviceTypesModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class assetsModel extends Model
{
    use HasFactory;
    protected $table = 'assets';
    protected $primaryKey = 'asset_id';
    protected $fillable = [
        'asset_code',
        'asset_code',
        'asset_type',
        'asset_brand',
        'asset_vender',
        'asset_adessories_number',
        'asset_model',
        'asset_type_other',
        'asset_serialnumber',
        'asset_purchase_date',
        'asset_warranty_end_date',
        'asset_detail',
        'asset_user_ad',
        'asset_notes',
        'asset_status',

    ];

    public function deviceTypes()
    {
        return $this->belongsTo(deviceTypesModel::class, 'asset_type', 'type_id');
    }
    public function brand()
    {
        return $this->belongsTo(brandsModel::class, 'asset_brand', 'brand_id');
    }
    public function userAD()
    {
        return $this->belongsTo(employeeModel::class, 'asset_user_ad', 'emp_id');
    }
    public function vender()
    {
        return $this->belongsTo(vendersModel::class, 'asset_vender', 'vender_id');
    }


}
