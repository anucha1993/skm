<?php

namespace App\Models\globalsets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalSetModel extends Model
{
    use HasFactory;
    protected $table = 'global_sets';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
        'sort_order_preference',
    ];

   // ระบุ foreign key ชัด ๆ ว่าใช้คอลัมน์ global_set_id
   public function values()
   {
       return $this->hasMany(GlobalSetValueModel::class, 'global_set_id');
   }
}
