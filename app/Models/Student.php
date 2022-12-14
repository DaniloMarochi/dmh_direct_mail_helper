<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "id",
        "name",
        "email",
        "frequence",
        "occurrence",
        "course_id",
        "mailed",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    protected $dates = [
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function setFrequenceAndMailedAttribute($value) {
        if ($value > 75) {
            $this->attributes['mailed'] = !$this->attributes['mailed'];
        }
        $this->attributes['frequence'] = $value;
    }
}
