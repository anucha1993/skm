<?php

namespace App\Models\managedocs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class managefilesModel extends Model
{

    use HasFactory;
    protected $table = 'managefiles';
    protected $primaryKey = 'managefile_id';
    protected $fillable = [
        'managefile_no',
        'managefile_code',
        'managefile_name',
        'managefile_step',
        'managefile_status',
        'managedoc_id',
    ];
}
