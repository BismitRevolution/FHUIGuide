<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advografis extends Model {

    protected $table = 'advografises';

    protected $fillable = [
        'title',
        'content'
    ];

}
