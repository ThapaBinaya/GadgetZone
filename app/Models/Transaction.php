<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table='transactions';
    protected $fillable=[
        'id',
        'Order_No',
        'Order_By',
        'email',
        'amount',
        'status',
        'created_at',
                   
        
        


    ];
}
