<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Temp;
use Auth;
use Carbon\Carbon;
use DB;

class HomeController extends Controller
{
    // View home page
    public function index()
    {
        // Get settings data
        $settings = DB::table('settings')->find(1);
        // if auth
        if (Auth::user()) {
            // check if there is cache
            $cache = Temp::where('user_id', Auth::user()->id)->where('created_at', '<=', Carbon::now()->subMinutes(30))->sum('file_size');
            return view('frontend.home', ['settings' => $settings, 'cache' => $cache]);
        } else {
            return view('frontend.home', ['settings' => $settings]);
        }
    }

}
