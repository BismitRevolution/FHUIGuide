<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Infografis extends Model {

    protected $table = 'infografises';

    protected $fillable = [
        'title',
        'image'
    ];

}
