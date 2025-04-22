<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ticketResponse extends Model
{
    protected $fillable = [
        'response',
        'ticket_id',
        'user_id',
    ];
    protected $casts = [ // luego investigar sobre los casts y los apartados de los modelos
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    function ticket(){
        return $this->belongsTo(Ticket::class);
    }

    function user(){
        return $this->belongsTo(User::class);
    }
}
