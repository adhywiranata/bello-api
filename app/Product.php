<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    protected $fillable=
    [
      'product_id',
      'user_id',
      'for_sale'
    ];



}
