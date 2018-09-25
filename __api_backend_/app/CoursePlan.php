<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoursePlan extends Model {

    protected $table = 'course_plans';

    protected $fillable = [
        'name',
        'design',
        'mandatory'
    ];

    public function courses() {
        return $this->hasMany('App\Course', 'type', 'id')->get();
    }

}
