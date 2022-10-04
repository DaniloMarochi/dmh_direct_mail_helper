<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=[
        "id",
        "name",
        "email",
        "frequence",
        "occurrence",
        "course_id",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }
}
