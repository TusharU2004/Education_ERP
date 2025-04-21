<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'assign_student_id',
        'fee_category_id',
        'discount'
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
