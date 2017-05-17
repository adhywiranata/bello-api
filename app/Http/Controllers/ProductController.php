<?php

namespace App\Http\Controllers;

// Request
use Illuminate\Http\Request;

// Model
use App\Product;

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
    $message = '['.$message.']';
    print_r($message);

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
    $message = '['.$message.']';
    print_r($message);
  }

  public function delete($id)
  {
    $product = Product::where('product_id','=',$id);
    $product->delete();

    $message = array("message"   =>  "Delete Data Product Succeed");
    $message = json_encode($message);
    $message = '['.$message.']';
    print_r($message);
  }
}
