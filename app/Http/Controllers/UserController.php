<?php

namespace App\Http\Controllers;

// Request
use Illuminate\Http\Request;

// Model
use App\User;
use App\Product;

class UserController extends Controller
{
    public function index()
  	{
  		$users = User::all();
      echo $users;
      //return response()->json($users);
  	}

    public function store(Request $request)
    {

      $new_user = array(
        "id"        => $request->json()->get('id'),
        "username"  => $request->json()->get('username'),
        "name"      => $request->json()->get('name'),
        "email"     => $request->json()->get('email'),
        "phone"     => $request->json()->get('phone'),
        "gender"    => $request->json()->get('gender'),
      );
      User::create($new_user);

      $message = array("message"   =>  "Insert Data User Succeed");
	    $message = json_encode($message);
      echo $message;
    }

    public function update(Request $request, $id)
    {
      $update_user = array(
        "username"  => $request->json()->get('username'),
        "name"      => $request->json()->get('name'),
        "email"     => $request->json()->get('email'),
        "phone"     => $request->json()->get('phone'),
        "gender"    => $request->json()->get('gender'),
      );
      $user = User::find($id);
      $user->update($update_user);
      $user->save();

      $message = array("message"   =>  "Update Data User Succeed");
      $message = json_encode($message);
      echo $message;
    }

    public function delete($id)
    {
      $user = User::find($id);
      $user->delete();

      $message = array("message"   =>  "Delete Data User Succeed");
      $message = json_encode($message);
      echo $message;
    }

    public function loginApi(Request $request)
    {
      $username = $request->json()->get('username');
      $password = $request->json()->get('password');

      $message = array();
      $login_status = "Login Failed";
      $detail_user_status = "Get Detail User Failed";
      $lapak_sale_user_status = "Get User Lapak Sale Failed";
      $lapak_unsale_user_status = "Get User Lapak Not Sale Failed";
      // USER LOGIN BUKALAPAK API
      $url_login    = 'https://api.bukalapak.com/v2/authenticate.json';
      $header_login = array(
        "Authorization: Bearer ".base64_encode($username.":".$password)
      );

      $login   = curl_init();
      curl_setopt($login, CURLOPT_URL, $url_login);
      curl_setopt($login, CURLOPT_HTTPHEADER, $header_login);
      curl_setopt($login, CURLOPT_POST, 1);
      curl_setopt($login, CURLOPT_RETURNTRANSFER, 1);
      $response_login = curl_exec($login);
      $response_login = json_decode($response_login);

      if($response_login->status == "ERROR"){
        $login_status = "Login Failed";
      }else if($response_login->status == "OK"){
        $login_status = "Login Succeed";

        // USER DETAIL INFO BUKALAPAK API
        $url_detail    = 'https://api.bukalapak.com/v2/users/info.json';
        $header_detail = array(
          "Authorization: Bearer ".base64_encode($response_login->user_id.":".$response_login->token)
        );

        $detail   = curl_init();
        curl_setopt($detail, CURLOPT_URL, $url_detail);
        curl_setopt($detail, CURLOPT_HTTPHEADER, $header_detail);
        curl_setopt($detail, CURLOPT_RETURNTRANSFER, 1);
        $response_detail = curl_exec($detail);
        $response_detail = json_decode($response_detail);

        if($response_detail->status == "ERROR"){
          $detail_user_status = "Get Detail User Failed";
        }else if($response_detail->status == "OK"){
          $detail_user_status = "Get Detail User Succeed";

          // INSERT OR UPDATE USER
          $condition_user = array(
            "id"          => $response_login->user_id,
          );
          $response_user  = array(
            "username"    => $response_detail->user->username,
            "name"        => $response_login->user_name,
            "email"       => $response_login->email,
            "token"       => $response_login->token,
            "phone"       => $response_detail->user->phone,
            "gender"      => $response_detail->user->gender,
          );
          $user = User::updateOrCreate($condition_user,$response_user);
          $user->save();

          // RETURN DATA USER
          $message['username'] = $response_detail->user->username;
          $message['name'] = $response_login->user_name;
          $message['email'] = $response_login->email;
          $message['token'] = $response_login->token;
          $message['phone'] = $response_detail->user->phone;
          $message['gender'] = $response_detail->user->gender;

          // USER LAPAK INFO
          // => SALE PRODUCT
          $url_lapak_sale    = 'https://api.bukalapak.com/v2/products/mylapak.json';
          $header_lapak_sale = array(
            "Authorization: Bearer ".base64_encode($response_login->user_id.":".$response_login->token)
          );

          $lapak_sale   = curl_init();
          curl_setopt($lapak_sale, CURLOPT_URL, $url_lapak_sale);
          curl_setopt($lapak_sale, CURLOPT_HTTPHEADER, $header_lapak_sale);
          curl_setopt($lapak_sale, CURLOPT_RETURNTRANSFER, 1);
          $response_lapak_sale = curl_exec($lapak_sale);
          $response_lapak_sale = json_decode($response_lapak_sale);

          if($response_lapak_sale->status == "ERROR"){
            $lapak_sale_user_status = "Get User Lapak Sale Failed";
          }else if($response_lapak_sale->status == "OK"){
            $lapak_sale_user_status = "Get User Lapak Sale Succeed";
            foreach($response_lapak_sale->products as $lapak_sale):
              $condition_user_product = array(
                "product_id"  =>  $lapak_sale->id
              );
              $response_user_product = array(
                "user_id"     =>  $lapak_sale->seller_id,
                "for_sale"    =>  1,
              );
              $product = Product::updateOrCreate($condition_user_product,$response_user_product);
              $product->save();
            endforeach;
          }

          // USER LAPAK INFO
          // => NOT SALE PRODUCT
          $url_lapak_unsale    = 'https://api.bukalapak.com/v2/products/mylapak.json?not_for_sale_only=1';
          $header_lapak_unsale = array(
            "Authorization: Bearer ".base64_encode($response_login->user_id.":".$response_login->token)
          );

          $lapak_unsale   = curl_init();
          curl_setopt($lapak_unsale, CURLOPT_URL, $url_lapak_unsale);
          curl_setopt($lapak_unsale, CURLOPT_HTTPHEADER, $header_lapak_unsale);
          curl_setopt($lapak_unsale, CURLOPT_RETURNTRANSFER, 1);
          $response_lapak_unsale = curl_exec($lapak_unsale);
          $response_lapak_unsale = json_decode($response_lapak_unsale);

          if($response_lapak_unsale->status == "ERROR"){
            $lapak_unsale_user_status = "Get User Lapak Not Sale Failed";
          }else if($response_lapak_unsale->status == "OK"){
            $lapak_unsale_user_status = "Get User Lapak Not Sale Succeed";
            foreach($response_lapak_unsale->products as $lapak_unsale):
              $condition_user_product = array(
                "product_id"  =>  $lapak_unsale->id
              );
              $response_user_product = array(
                "user_id"     =>  $lapak_unsale->seller_id,
                "for_sale"    =>  0,
              );
              $product = Product::updateOrCreate($condition_user_product,$response_user_product);
              $product->save();
            endforeach;
          }// END IF USER LAPAK NOT SALE STATUS
        }// END IF USER DETAIL STATUS
      }// END IF USER LOGIN STATUS

      $message["login_status"] = $login_status;
      $message["detail_user_status"] = $detail_user_status;
      $message["lapak_sale_status"] = $lapak_sale_user_status;
      $message["lapak_unsale_status"] = $lapak_unsale_user_status;

      $message = json_encode($message);
      echo $message;
    }



}
