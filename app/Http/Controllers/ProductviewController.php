<?php

namespace App\Http\Controllers;

// Request
use Illuminate\Http\Request;

// Model
use App\Productview;

class ProductviewController extends Controller
{
  public function index()
  {
    $productviews = Productview::all();
    echo $productviews;
    //return response()->json($users);
  }

  public function store(Request $request)
  {
    $new_productview = array(
      'product_id'          => $request->json()->get('product_id'),
      'user_id'             => $request->json()->get('user_id'),
      'interested_status'   => $request->json()->get('interested_status')
    );
    Productview::create($new_productview);

    $message = array("message"   =>  "Insert Data Product View Succeed");
    $message = json_encode($message);
    echo $message;

  }

  public function update(Request $request, $id)
  {
    $update_productview = array(
      'product_id'          => $request->json()->get('product_id'),
      'user_id'             => $request->json()->get('user_id'),
      'interested_status'   => $request->json()->get('interested_status')
    );

    $productview = Productview::find($id);
    $productview->update($update_productview);
    $productview->save();

    $message = array("message"   =>  "Update Data Product Succeed");
    $message = json_encode($message);
    echo $message;
  }

  public function delete($id)
  {
    $productview = Productview::find($id);
    $productview->delete();

    $message = array("message"   =>  "Delete Data Product Succeed");
    $message = json_encode($message);
    echo $message;
  }
}
