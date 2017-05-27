<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Userbuyrequest extends Model
{
    use SoftDeletes;
    protected $table = 'userbuyrequests';
    protected $fillable=
    [
      'user_id',
      'keyword'
    ];

    public function user()
    {
      return $this->belongsTo('App\User', 'user_id', 'id');
    }


}
