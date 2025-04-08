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
        'labour_firstname',
        'labour_lastname',
    ];
}
