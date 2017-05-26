<?php

namespace App\Http\Controllers;

// Request
use Illuminate\Http\Request;

// Model
use App\Product;
use App\User;

class ProductController extends Controller
{
  public function index()
  {
    $products = Product::all();
    echo $products;
    //return response()->json($users);
  }

  public function store(Request $request)
  {

    $new_product = array(
      'product_id'          => $request->json()->get('product_id'),
      'user_id'             => $request->json()->get('user_id'),
    );
    Product::create($new_product);

    $message = array("message"   =>  "Insert Data Product Succeed");
    $message = json_encode($message);
    echo $message;
  }

  public function update(Request $request, $id)
  {
    $update_product = array(
      'user_id'             => $request->json()->get('user_id'),
    );

    $product = Product::where("product_id",'=',$id);
    $product->update($update_product);
    $product->save();

    $message = array("message"   =>  "Update Data Product Succeed");
    $message = json_encode($message);
    echo $message;
  }

  public function delete($id)
  {
    $product = Product::where('product_id','=',$id);
    $product->delete();

    $message = array("message"   =>  "Delete Data Product Succeed");
    $message = json_encode($message);
    echo $message;
  }

  // READ PRODUCT BUKALAPAK API
  public function selectProductById($id)
  {
    //$product_id = "1cc074"; // For Debug Purpose
    $read_product_status    = "Read Product Failed";
    $review_product_status  = "Get Review Product Failed";

    // READ PRODUCT DETAIL BY PRODUCT ID
    $product_id = $id;
    $url_read_product     = 'https://api.bukalapak.com/v2/products/'.$product_id.'.json';
    $read_product         = curl_init();
    curl_setopt($read_product, CURLOPT_URL, $url_read_product);
    curl_setopt($read_product, CURLOPT_RETURNTRANSFER, 1);
    $response_read_product = curl_exec($read_product);
    $response_read_product = json_decode($response_read_product);
    if($response_read_product->status == "ERROR"){
      $read_product_status = "Read Product Failed";
      $total_response['product'] = "";
    }else if($response_read_product->status == "OK"){
      $read_product_status = "Read Product Succeed";
      $total_response['product'] = $response_read_product->product;
    }

    // READ REVIEW PRODUCT BY PRODUCT ID
    $url_review_product     = 'https://api.bukalapak.com/v2/products/'.$product_id.'/reviews.json';
    $review_product         = curl_init();
    curl_setopt($review_product, CURLOPT_URL, $url_review_product);
    curl_setopt($review_product, CURLOPT_RETURNTRANSFER, 1);
    $response_review_product = curl_exec($review_product);
    $response_review_product = json_decode($response_review_product);
    if($response_review_product->status == "ERROR"){
      $review_product_status = "Get Review Product Failed";
      $total_response['reviews'] = "";
    }else if($response_review_product->status == "OK"){
      $review_product_status = "Get Review Product Succeed";
      if($response_review_product->reviews == NULL):
        $total_response['reviews'] = "";
      else:
        $total_response['reviews'] = $response_review_product->reviews;
      endif;
    }
    $total_response['product_status'] = $read_product_status;
    $total_response['review_status'] = $review_product_status;

    $total_response = json_encode($total_response);
    echo $total_response;
  }

  public function productListByUserId($keyword)
  {
    $users = User::all();
    $total_response = array();

    foreach( $users as $user ):
      $url_read_product     = 'https://api.bukalapak.com/v2/products.json?keywords='.$keyword.'&user_id='.$user->id; // 31040836
      $read_product         =  curl_init();
      curl_setopt($read_product, CURLOPT_URL, $url_read_product);
      curl_setopt($read_product, CURLOPT_RETURNTRANSFER, 1);
      $response_read_product = curl_exec($read_product);
      $response_read_product = json_decode($response_read_product);

      if($response_read_product->status == "OK"):
        if($response_read_product->products != NULL):

          $index = 0;
          foreach($response_read_product->products as $read_product ):
            // READ REVIEW PRODUCT BY PRODUCT ID
            if($index < 10):
              $product = array();
              $product['id']    = $read_product->id;
              $product['name']  = $read_product->name;
              $product['owner'] = $read_product->seller_name;
              $product['price'] = $read_product->price;
              $product['image'] = $read_product->images[0];

              $url_review_product     = 'https://api.bukalapak.com/v2/products/'.$read_product->id.'/reviews.json';
              $review_product         = curl_init();
              curl_setopt($review_product, CURLOPT_URL, $url_review_product);
              curl_setopt($review_product, CURLOPT_RETURNTRANSFER, 1);
              $response_review_product = curl_exec($review_product);
              $response_review_product = json_decode($response_review_product);
              $review_product_status   = "";
              if($response_review_product->status == "ERROR"){
                $review_product_status = "Get Review Product Failed";
                $product['reviews'] = "";
              }else if($response_review_product->status == "OK"){
                $review_product_status = "Get Review Product Succeed";
                if($response_review_product->reviews == NULL):
                  $product['reviews'] = "";
                else:
                  $product['reviews'] = $response_review_product->reviews;
                endif;
              }
              $product['review_status'] = $review_product_status;
              array_push($total_response,$product);
            else:
              break;
            endif;
            $index++;
          endforeach;

        endif;
      endif;

    endforeach;

    $total_response = json_encode($total_response);
    echo $total_response;
  }

  public function addToCart(Request $request)
  {
    // Debug Purpose
    //$product_id     = "7svyn8";
    //$quantity       = 2;
    //$user_id        = 31040836;
    //$token          = "23pfzt8jT0u8tfuhw85";

    $product_id   = $request->json()->get('product_id');
    $quantity     = $request->json()->get('quantity');
    $user_id      = $request->json()->get('user_id');
    $token        = $request->json()->get('token');
    $message      = array();

    $status_product_owner = "This product is not owner product";

    $url_read_user_product     = 'https://api.bukalapak.com/v2/products.json?user_id='.$user_id; // 31040836
    $read_user_product         =  curl_init();
    curl_setopt($read_user_product, CURLOPT_URL, $url_read_user_product);
    curl_setopt($read_user_product, CURLOPT_RETURNTRANSFER, 1);
    $response_read_user_product = curl_exec($read_user_product);
    $response_read_user_product = json_decode($response_read_user_product);

    if($response_read_user_product->status == "OK"):
      if($response_read_user_product->products != NULL):
        foreach($response_read_user_product->products as $user_product):
          if( $product_id == $user_product->id):
            $status_product_owner = "You cannot add your product to your cart";
            break;
          endif;
        endforeach;
      endif;
    endif;
    $message['status_product_owner'] = $status_product_owner;

    // ADD TO CART
    if($status_product_owner == "This product is not owner product"):
      $header_login = array(
        "Authorization: Bearer ".base64_encode($user_id.":".$token)
      );
      $post_data = array(
        'id'          => $product_id,
        'quantity'    => $quantity
      );
      $url_add_to_cart    = 'https://api.bukalapak.com/v2/carts/add_product/'.$product_id.'.json';
      $add_to_cart        =  curl_init();

      curl_setopt($add_to_cart, CURLOPT_URL, $url_add_to_cart);
      curl_setopt($add_to_cart, CURLOPT_HTTPHEADER, $header_login);
      curl_setopt($add_to_cart, CURLOPT_POST, 1);
      curl_setopt($add_to_cart, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($add_to_cart, CURLOPT_POSTFIELDS, $post_data);
      $response_add_to_cart = curl_exec($add_to_cart);
      $response_add_to_cart = json_decode($response_add_to_cart);

      $message['status_cart'] = "Your Product is added to cart";
    else:
      $message['status_cart'] = "Your Product cannot be added to cart";
    endif;

    $message = json_encode($message);
    echo $message;
  }

  public function selectCart(Request $request)
  {
    $user_id      = $request->json()->get('user_id');
    $token        = $request->json()->get('token');

    $header_login = array(
      "Authorization: Bearer ".base64_encode($user_id.":".$token)
    );

    $url_view_cart    = 'https://api.bukalapak.com/v2/carts.json';
    $view_cart        =  curl_init();

    curl_setopt($view_cart, CURLOPT_URL, $url_view_cart);
    curl_setopt($view_cart, CURLOPT_HTTPHEADER, $header_login);
    curl_setopt($view_cart, CURLOPT_RETURNTRANSFER, 1);
    $response_view_cart = curl_exec($view_cart);

    echo $response_view_cart;
  }

  public function deleteCart(Request $request)
  {
    $user_id      = $request->json()->get('user_id');
    $token        = $request->json()->get('token');

    $header_login = array(
      "Authorization: Bearer ".base64_encode($user_id.":".$token)
    );
    $post_data = array(
      'id'          => $request->json()->get('product_id'),
    );
    $url_delete_cart    = 'https://api.bukalapak.com/v2/carts.json';
    $delete_cart        =  curl_init();

    curl_setopt($delete_cart, CURLOPT_URL, $url_delete_cart);
    curl_setopt($delete_cart, CURLOPT_HTTPHEADER, $header_login);
    curl_setopt($delete_cart, CURLOPT_POST, 1);
    curl_setopt($delete_cart, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($delete_cart, CURLOPT_POSTFIELDS, $post_data);
    $response_delete_cart = curl_exec($delete_cart);

    echo $response_delete_cart;
  }

}
