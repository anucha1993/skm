<?php

namespace App\Models\customers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerFile extends Model
{

    use HasFactory;
    protected $table = 'customer_files';
    protected $primaryKey = 'id';
    protected $fillable = [
        'customer_id',
        'file_path',
        'file_original_name',
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
