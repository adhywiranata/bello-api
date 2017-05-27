<?php

namespace App\Http\Controllers;

// Request
use Illuminate\Http\Request;

// library
use Carbon\Carbon;
use DateTime;
use DB;


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

  public function select($user_id)
  {
    $buyrequests = Buyrequest::where("user_id","=",$user_id)->get();
    echo $buyrequests;
  }


  public function store(Request $request)
  {

    $new_buyrequest = array(
      'user_id'             => $request->json()->get('user_id'),
      'keyword'             => $request->json()->get('keyword'),
      'is_purchase'         => $request->json()->get('is_purchase'),
      'reminder_schedule'   => date('Y-m-d',strtotime($request->json()->get('reminder_schedule'))),
      'is_cancel'           => $request->json()->get('is_cancel'),
      'cancelation_reason'  => $request->json()->get('cancelation_reason'),
      'is_delete'           => $request->json()->get('is_delete'),
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
      'is_cancel'           => $request->json()->get('is_cancel'),
      'cancelation_reason'  => $request->json()->get('cancelation_reason'),
      'is_delete'           => $request->json()->get('is_delete'),
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

  public function updateCustom(Request $request)
  {
    $update_buyrequest = array();
    if($request->json()->get('is_purchase')):
      $update_buyrequest['is_purchase'] = $request->json()->get('is_purchase');
    endif;

    if($request->json()->get('reminder_schedule')):
      $update_buyrequest['reminder_schedule'] = $request->json()->get('reminder_schedule');
    endif;

    if($request->json()->get('is_cancel')):
      $update_buyrequest['is_cancel'] = $request->json()->get('is_cancel');
    endif;

    if($request->json()->get('cancelation_reason')):
      $update_buyrequest['cancelation_reason'] = $request->json()->get('cancelation_reason');
    endif;

    if($request->json()->get('is_delete')):
      $update_buyrequest['is_delete'] = $request->json()->get('is_delete');
    endif;

    $buyrequest = Buyrequest::where('user_id','=',$request->json()->get('user_id'))
                            ->where('keyword','=',$request->json()->get('keyword'))
                            ->orderBy('created_at',"DESC")
                            ->first();

    $buyrequest->update($update_buyrequest);
    $buyrequest->save();

    $message = array("message"   =>  "Update Custom Data Buy Request Succeed");
    $message = json_encode($message);
    echo $message;
  }

  // GET ANALYTICS MONTHLY BY A KEYWORD
  public function keywordAnalytics(Request $request)
  {
    //$keyword  = "iphone";
    $keyword  = $request->json()->get('keyword');
    $message  = array();
    $year     = date('Y');
    $analytics = Buyrequest::where('keyword','like','%'.$keyword.'%')
                            ->whereYear('created_at','=',$year)
                            ->orderBy('created_at','ASC')
                            ->get()
                            ->groupBy(function($date) {
                                return Carbon::parse($date->created_at)->format('m');
                              });

    if(sizeof($analytics) > 0):
      foreach($analytics as  $index => $analytic):
        $month      = intval($index);
        $dateObj    = DateTime::createFromFormat('!m', $month);
        $monthName  = $dateObj->format('F');
        $monthName  = substr($monthName,0,3);

        $count = count($analytic);
        $data = array(
          "month" => $monthName,
          "total" => $count
        );
        array_push($message,$data);
      endforeach;
    endif;
    $message = json_encode($message);
    echo $message;
  }

  // GET KEYWORD LIST FOR USER SUBSCRIBE
  public function keywordTrends()
  {
    $trends = Buyrequest::select('*', DB::raw('count(*) as total'))
                 ->groupBy('keyword')
                 ->orderBy('total','DESC')
                 ->get();
    echo $trends;
  }



}
