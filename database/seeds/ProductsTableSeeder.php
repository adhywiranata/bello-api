<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// Model
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //Before 14-05-2017
        Product::create(array(
          'product_id'  =>  "e8h6m",
          'user_id'     =>  "2886652",
          'for_sale'    =>  "1",
          'created_at'  => date("Y-m-d H:i:s",strtotime("2017-01-05 13:25:12")),
          'updated_at'  => date("Y-m-d H:i:s",strtotime("2017-01-05 13:25:12")),
        ));

        Product::create(array(
          'product_id'  =>  "1s1r64",
          'user_id'     =>  "1979833",
          'for_sale'    =>  "1",
          'created_at'  => date("Y-m-d H:i:s",strtotime("2017-02-13 10:13:24")),
          'updated_at'  => date("Y-m-d H:i:s",strtotime("2017-02-13 10:13:24")),
        ));

        Product::create(array(
          'product_id'  =>  "5yugh8",
          'user_id'     =>  "2166751",
          'for_sale'    =>  "1",
          'created_at'  => date("Y-m-d H:i:s",strtotime("2017-04-21 16:28:51")),
          'updated_at'  => date("Y-m-d H:i:s",strtotime("2017-04-21 16:28:51")),
        ));

      //After 14-05-2017
        Product::create(array(
          'product_id'  =>  "echnd",
          'user_id'     =>  "2166751",
          'for_sale'    =>  "1",
          'created_at'  => date("Y-m-d H:i:s",strtotime("2017-05-15 15:42:32")),
          'updated_at'  => date("Y-m-d H:i:s",strtotime("2017-05-15 15:42:32")),
        ));

        Product::create(array(
          'product_id'  =>  "185q4o",
          'user_id'     =>  "2166751",
          'for_sale'    =>  "1",
          'created_at'  => date("Y-m-d H:i:s",strtotime("2017-05-18 07:37:17")),
          'updated_at'  => date("Y-m-d H:i:s",strtotime("2017-05-18 07:37:17")),
        ));

        Product::create(array(
          'product_id'  =>  "3uwsaj",
          'user_id'     =>  "9500417",
          'for_sale'    =>  "1",
          'created_at'  => date("Y-m-d H:i:s",strtotime("2017-05-24 20:55:31")),
          'updated_at'  => date("Y-m-d H:i:s",strtotime("2017-05-24 20:55:31")),
        ));




    }
}
