<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model {

    protected $table = 'internships';

    protected $fillable = [
        'title',
        'content'
    ];

}
