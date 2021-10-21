<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    
    public $table = "staffs";
    protected $fillable = [
        'staff_name', 'phone_no','email',
    ];
}
