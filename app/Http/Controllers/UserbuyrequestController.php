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

    Userbuyrequest::firstOrCreate($new_userbuyrequest);

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

    $message  = array();
    $year     = date('Y');
    foreach($userbuyrequests as $userbuyrequest):

      $analytics = Buyrequest::where('keyword','like','%'.$userbuyrequest->keyword.'%')
                              ->whereYear('created_at','=',$year)
                              ->orderBy('created_at','ASC')
                              ->get()
                              ->groupBy(function($date) {
                                  return Carbon::parse($date->created_at)->format('m');
                                });

      $reports            = array();
      $countAnalytics     = 0;
      $arrayMonthlyExist  = array();
      if(sizeof($analytics) > 0):
        foreach($analytics as  $index => $analytic):
          $month      = intval($index);
          $dateObj    = DateTime::createFromFormat('!m', $month);
          $monthName  = $dateObj->format('F');
          $monthName  = substr($monthName,0,3);
          $count = count($analytic);
          $data = array(
            "monthNumber" => $month,
            "month"       => $monthName,
            "total"       => $count
          );
          $countAnalytics += $count;
          array_push($arrayMonthlyExist,$month);
          array_push($reports,$data);
        endforeach;
      endif;

      for ($i=1; $i<=12; $i++):
        if ( !in_array($i, $arrayMonthlyExist) ):

          $dateObj    = DateTime::createFromFormat('!m', $i);
          $monthName  = $dateObj->format('F');
          $monthName  = substr($monthName,0,3);
          $count = 0;
          $data = array(
            "monthNumber" => $i,
            "month"       => $monthName,
            "total"       => $count
          );
          array_push($reports,$data);

        endif;
      endfor;

      usort($reports,function($a, $b) {
         return $a['monthNumber'] - $b['monthNumber'];
      });

      $dataKeywordAnalytics = array(
        "id"        =>  $userbuyrequest->id,
        "keyword"   =>  $userbuyrequest->keyword,
        "total"     =>  $countAnalytics,
        "reports"   =>  $reports,
      );
      array_push($message,$dataKeywordAnalytics);
    endforeach;
    $message = json_encode($message);
    echo $message;

    /* PREVIOUS CODE
   $userkeywords   = Buyrequest::select('*') //DB::raw('count("keyword") as total')
                     ->where('keyword','like','%'.$userbuyrequest->keyword.'%')
                     ->groupBy('keyword')
                     ->orderBy('total','DESC')
                     ->get();
    */
    //return response()->json($message);
  }



}
