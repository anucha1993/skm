<?php

namespace App\Models\globalsets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalSetValueModel extends Model
{
    use HasFactory;
    protected $table = 'global_set_values';
    protected $primaryKey = 'id';
    protected $fillable = [
        'global_set_id',
        'value',
    ];

    public function globalSet()
    {
        return $this->belongsTo(GlobalSetModel::class, 'global_set_id');
    }
}
