<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseProblem extends Model {

    protected $table = 'course_problems';

    protected $fillable = [
        'title',
        'filename',
        'file'
    ];

    public function course() {
        return $this->belongsTo('App\Course', 'course', 'id')->first();
    }

}
