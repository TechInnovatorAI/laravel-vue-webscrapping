<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Notification;
use App\Models\Setting;
use App\Jobs\DepositMailJob;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function uploadImage($request, $image){
        if($request->hasFile($image)){
            $img = $request->file($image);
            $imgName = time() ."-". str_replace(" ", "_", $img->getClientOriginalName());
            $img->move(public_path('uploads'), $imgName);
            return $imgName;
        }else{
            return null;
        }
    }
}
