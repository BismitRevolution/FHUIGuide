<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bop extends Model {

    protected $table = 'bops';

    protected $fillable = [
        'title',
        'content'
    ];

}
