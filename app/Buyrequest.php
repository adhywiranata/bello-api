<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buyrequest extends Model
{
    use SoftDeletes;
    protected $table = 'buyrequests';
    protected $fillable=
    [
      'user_id',
      'keyword',
      'is_purchase',
      'is_cancel',
      'cancelation_reason',
      'reminder_schedule',
    ];



}
