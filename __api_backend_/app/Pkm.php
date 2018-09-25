<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pkm extends Model {

    protected $table = 'pkms';

    protected $fillable = [
        'title',
        'content'
    ];

}
