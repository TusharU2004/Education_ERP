<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountEmployeeSalary extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'amount',
    ];

    protected $hidden = [
        'employee_id',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }



}
