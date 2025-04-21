<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountOtherCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'amount',
        'description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
