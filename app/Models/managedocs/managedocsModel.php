<?php

namespace App\Models\managedocs;

use App\Models\category\countryJobModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class managedocsModel extends Model
{
  
    use HasFactory;
    protected $table = 'managedocs';
    protected $primaryKey = 'managedoc_id';
    protected $fillable = [
        'managedoc_country',
        'managedoc_name',
        'managedoc_status',
    ];

    public function managefile()
    {
        return $this->belongsTo(managefilesModel::class, 'managedoc_id', 'managedoc_id');
    }

    public function country()
    {
        return $this->belongsTo(countryJobModel::class, 'managedoc_country', 'country_job_id');
    }
}
