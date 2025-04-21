<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSallaryLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'previous_salary',
        'present_salary',
        'increment_salary',
        'effected_salary'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
