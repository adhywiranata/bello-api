<?php

namespace App\Http\Controllers;

// Request
use Illuminate\Http\Request;

// Model
use App\User;

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
      $message = '['.$message.']';
      print_r($message);

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
      $message = '['.$message.']';
      print_r($message);
    }

    public function delete($id)
    {
      $user = User::find($id);
      $user->delete();

      $message = array("message"   =>  "Delete Data User Succeed");
      $message = json_encode($message);
      $message = '['.$message.']';
      print_r($message);
    }

}
