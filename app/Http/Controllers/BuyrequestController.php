<?php

namespace App\Http\Controllers;

// Request
use Illuminate\Http\Request;

// Model
use App\Buyrequest;

class BuyrequestController extends Controller
{
  public function index()
  {
    $buyrequests = Buyrequest::all();
    echo $buyrequests;
    //return response()->json($users);
  }

  public function store(Request $request)
  {

    $new_buyrequest = array(
      'user_id'             => $request->json()->get('user_id'),
      'keyword'             => $request->json()->get('keyword'),
      'is_purchase'         => $request->json()->get('is_purchase'),
      'reminder_schedule'   => date('Y-m-d',strtotime($request->json()->get('reminder_schedule'))),
    );
    Buyrequest::create($new_buyrequest);

    $message = array("message"   =>  "Insert Data Buy Request Succeed");
    $message = json_encode($message);
    echo $message;

  }

  public function update(Request $request, $id)
  {
    $update_buyrequest = array(
      'user_id'             => $request->json()->get('user_id'),
      'keyword'             => $request->json()->get('keyword'),
      'is_purchase'         => $request->json()->get('is_purchase'),
      'reminder_schedule'   => date('Y-m-d',strtotime($request->json()->get('reminder_schedule'))),
    );
    $buyrequest = Buyrequest::find($id);
    $buyrequest->update($update_user);
    $buyrequest->save();

    $message = array("message"   =>  "Update Data Buy Request Succeed");
    $message = json_encode($message);
    echo $message;
  }

  public function delete($id)
  {
    $buyrequest = Buyrequest::find($id);
    $buyrequest->delete();

    $message = array("message"   =>  "Delete Data Buy Request Succeed");
    $message = json_encode($message);
    echo $message;
  }
}
