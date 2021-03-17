<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class FCMController extends Controller
{
    public function index(Request $request){
        $input = $request->all();
        $fcm_token = $input['fcm_token'];
        $user_id = $input['user_id'];


        $user = User::findorFail($user_id);

        $user->fcm_token = $fcm_token;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User Token Updated Successfully'
        ]);
    }
}
