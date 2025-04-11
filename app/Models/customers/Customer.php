<?php

namespace App\Models\customers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'country',
        'status',
        'notes',
    ];

    // ความสัมพันธ์ One-to-Many กับไฟล์แนบ
    public function files()
    {
        return $this->hasMany(CustomerFile::class);
    }
}
