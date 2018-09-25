<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvoReport extends Model {

    protected $table = 'advo_reports';

    protected $fillable = [
      'sender',
      'title',
      'report',
      'image'
    ];

}
