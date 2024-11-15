<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    // memanggil database dan memilih table 
    protected $table = 'alumnis';

    // menentukan field yang dapat diisi oleh user
    protected $fillable = [
        'name',
        'phone',
        'address',
        'graduation_year',
        'status',
        'company_name',
        'position'
    ];
}
