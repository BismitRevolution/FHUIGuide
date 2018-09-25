<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengkarpedia extends Model {

    protected $table = 'pengkarpedias';

    protected $fillable = [
        'title',
        'content'
    ];

}
