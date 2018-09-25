<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LatestInfo extends Model {

    protected $table = 'latest_info';

    protected $fillable = [
        'info'
    ];

}
