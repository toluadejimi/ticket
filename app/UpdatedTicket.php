<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UpdatedTicket extends Model
{
    protected $fillable = [
        'ticket_id',
        'description',

    ];
}
