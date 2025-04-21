<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignStudent extends Model
{

    protected $fillable = [
        'student_id',
        'roll',
        'class_id',
        'year_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    public function discount()
    {
        return $this->belongsTo(DiscountStudent::class, 'id', 'assign_student_id');
    }


    public function student_class()
    {
        return $this->belongsTo(StudentClass::class, 'class_id', 'id');
    }


    public function student_year()
    {
        return $this->belongsTo(StudentYear::class, 'year_id', 'id');
    }


    public function group()
    {
        return $this->belongsTo(StudentGroup::class, 'group_id', 'id');
    }


    public function shift()
    {
        return $this->belongsTo(StudentShift::class, 'shift_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    public function subject()
    {
        return $this->hasMany(AssignSubject::class, 'class_id', 'class_id');
    }

    public function timetable()
    {
        return $this->hasMany(TimeTable::class, 'class_id', 'class_id');
    }
}
