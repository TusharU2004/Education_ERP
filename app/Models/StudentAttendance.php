<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
   protected $table = 'student_attendances'; // Ensure the correct table name

    protected $fillable = [
        'year_id',
        'class_id',
        'student_id',
        'roll',
        'date',
        'attend_status',
    ];
   public function year(){
      return $this->belongsTo(AssignStudent::class,'year_id','year_id');
   }

   public function class(){
      return $this->belongsTo(AssignStudent::class,'class_id','class_id');
   }

   public function roll(){
      return $this->belongsTo(AssignStudent::class,'roll','roll');
   }

   public function student(){
      return $this->belongsTo(AssignStudent::class,'student_id','stuednt_id');
   }

}
