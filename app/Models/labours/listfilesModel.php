<?php

namespace App\Models\labours;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listfilesModel extends Model
{
    use HasFactory;
    protected $table = 'list_files';
    protected $primaryKey = 'list_file_id';
    protected $fillable = [
        'labour_id',
        'managedoc_id',
        'managefile_id',
        'managefile_no',
        'managefile_code',
        'managefile_name',
        'managefile_step',
        'file_path',
    ];
}
