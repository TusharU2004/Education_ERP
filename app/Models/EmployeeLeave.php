<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeave extends Model
{
    protected $fillable = [
        'employee_id',
        'reason',
        'start_date',
        'end_date'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }

}