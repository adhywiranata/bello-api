<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Productview extends Model
{
    use SoftDeletes;
    protected $table = 'productviews';
    protected $fillable=
    [
      'product_id',
      'user_id',
      'interested_status'
    ];



}
