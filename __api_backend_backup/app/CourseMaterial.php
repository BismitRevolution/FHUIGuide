<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseMaterial extends Model {

    protected $table = 'course_materials';

    protected $fillable = [
        'title',
        'filename',
        'file'
    ];

    public function course() {
        return $this->belongsTo('App\Course', 'course', 'id')->first();
    }

}
