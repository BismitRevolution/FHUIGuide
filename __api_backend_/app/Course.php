<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model {

    protected $table = 'courses';

    protected $fillable = [
        'name',
        'type'
    ];

    public function coursePlan() {
        return $this->belongsTo('App\CoursePlan', 'type', 'id')->first();
    }

    public function materials() {
        return $this->hasMany('App\CourseMaterial', 'course', 'id')->get();
    }

}
