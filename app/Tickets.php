<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    
    protected $fillable = [
            'incident_number',
            'provider_ticket_number',
            'fault_time',
            'circuit_id',
            'department_id',
            'user_id',
            'token_no',
            'description',
            'status',

    ];
    
    
    
    
    public function users(){
        return $this->belongsTo('App\User', 'assigned_to');
    }

    public function submittedBy(){
        return $this->belongsTo('App\User', 'user_id');
    }


    public function departments(){
        return $this->belongsTo('App\Departments', 'department_id');
    }


    public function customers(){
        return $this->belongsToMany('App\Customer', 'customer_id');
    }




}
