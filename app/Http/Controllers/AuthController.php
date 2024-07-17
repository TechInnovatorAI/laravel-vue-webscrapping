<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->updated_at = date("Y-m-d H:i:s");
            $user->save();
            return response()->json(['res' => [
                "updated_at" => date("Y-m-d H:i:s"),
                "ended_at" => $user->ended_at]], 200);

        }
    }
    public function sign(Request $request)
    {
        $user = new User();
        $user->email = $request->email;
        $user->password = $request->pass;
        $user->save();
        return response()->json("ok", 200);
    }
    public function updateEnddate(Request $request)
    {
        $email = $request->email;
        $period = $request->period;
        $user = User::where('email', $email)->first();

        $current_time = time(); // Get the current timestamp
        switch ($period) {
            case 'oneMonth':
                $time_later = strtotime('+1 month', $current_time); // Add one week to the current timestamp
                break;
            case 'sixMonths':
                $time_later = strtotime('+6 months', $current_time); // Add one week to the current timestamp
                break;
            case 'oneYear':
                $time_later = strtotime('+1 year', $current_time); // Add one week to the current timestamp
                break;
            
            default:
                # code...
                break;
        }
        $time_formatted = date('Y-m-d H:i:s', $time_later); // Format the timestamp as date and time
        $user->ended_at = $time_formatted;
        $user->save();
        return response()->json(["res"=>$time_formatted], 200);
    }
}
