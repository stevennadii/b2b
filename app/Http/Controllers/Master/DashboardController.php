<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function dashboard_page()
    {
        $token = Session::get('access_token');
        $title = "Dashboard";
        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json',
        //     'Authorization' => 'Bearer ' . $token,
        // ])->post(env('SRV_URL') . 'dashboard')->json();
        // $data = $response['data'];
        $data  = [];
        return view('master.dashboard', compact('title', 'data'));
    }
}
