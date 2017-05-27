<?php

namespace App\Http\Controllers;

// Request
use Illuminate\Http\Request;

// library
use Carbon\Carbon;
use DateTime;
use DB;

// Model
use App\Userbuyrequest;
use App\Buyrequest;

class UserbuyrequestController extends Controller
{
  public function index()
  {
    $userbuyrequests = Userbuyrequest::all();
    echo $userbuyrequests;
  }

  public function store(Request $request)
  {
    $new_userbuyrequest = array(
      'user_id'       => $request->json()->get('user_id'),
      'keyword'       => $request->json()->get('keyword'),
    );

    Userbuyrequest::create($new_userbuyrequest);

    $message = array("message"   =>  "Insert Data User Buy Request Succeed");
    $message = json_encode($message);
    echo $message;

  }

  public function update(Request $request, $id)
  {
    $update_userbuyrequest = array(
      'user_id'       => $request->json()->get('user_id'),
      'keyword'       => $request->json()->get('keyword'),
    );
    $userbuyrequest = Userbuyrequest::find($id);
    $userbuyrequest->update($update_userbuyrequest);
    $userbuyrequest->save();

    $message = array("message"   =>  "Update Data User Buy Request Succeed");
    $message = json_encode($message);
    echo $message;
  }

  public function delete($id)
  {
    $userbuyrequest = Userbuyrequest::find($id);
    $userbuyrequest->delete();

    $message = array("message"   =>  "Delete Data User Buy Request Succeed");
    $message = json_encode($message);
    echo $message;
  }

  // GET ALL SUBSCRIBED KEYWORD USER ADDED
  public function userSubscribeKeywords(Request $request)
  {
    //$user_id = 31040836;
    $user_id  = $request->json()->get('user_id');
    $userbuyrequests = Userbuyrequest::where('user_id','=',$user_id)->get();

    $message = array();
    foreach($userbuyrequests as $userbuyrequest):
      $userkeywords   = Buyrequest::select('*', DB::raw('count(*) as total'))
                         ->where('keyword','like','%'.$userbuyrequest->keyword.'%')
                         ->groupBy('keyword')
                         ->orderBy('total','DESC')
                         ->first();
      $data = array(
        "keyword"   =>  $userkeywords->keyword,
        "total"     =>  $userkeywords->total,
      );
      array_push($message,$data);
    endforeach;
    $message = json_encode($message);
    echo $message;
  }



}
