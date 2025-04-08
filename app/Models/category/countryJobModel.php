<?php

namespace App\Models\category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class countryJobModel extends Model
{

    use HasFactory;
    protected $table = 'country_job';
    protected $primaryKey = 'country_job_id ';
    protected $fillable = [
        'country_job_name'
    ];
}
