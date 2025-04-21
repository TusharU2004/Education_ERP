<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTable extends Model
{
    use HasFactory;
    protected $fillable = [
        'class_id',
        'subject_id',
        'day',
        'start_time',
        'end_time',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function class()
    {
        return $this->belongsTo(StudentClass::class, 'class_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(SchoolSubject::class, 'subject_id', 'id');
    }

}
