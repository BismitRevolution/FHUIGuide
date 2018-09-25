<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model {

    protected $table = 'scholarships';

    protected $fillable = [
        'title',
        'content'
    ];

}
