<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignSubject extends Model
{
    protected $fillable = [
        'class_id',
        'subject_id',
        'full_mark',
        'pass_mark',
        'subjective_mark'
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function student_class()
    {
        return $this->belongsTo(StudentClass::class, 'class_id', 'id');
    }
    
    public function school_subject()
    {
        return $this->belongsTo(SchoolSubject::class, 'subject_id', 'id');
    }

}
