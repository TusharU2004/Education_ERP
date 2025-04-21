<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAttendance extends Model
{

    protected $fillable = [
        'employee_id',
        'date',
        'attend_status'
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }
}
