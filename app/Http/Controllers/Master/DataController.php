<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class DataController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $role = Session::get('user.role_id');
            if ($role == '1' || $role == '2') {
                return $next($request);
            }
            abort(404);
        });
    }

    public static function jumlah()
    {
        // $user = Session::get('access_token');
        // $title = 'Validasi Pendaftaran';
        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json',
        //     'Authorization' => 'Bearer ' . $user
        // ])->post(env('SRV_URL') . 'pendaftar');
        // $data = $response['data']['data'];
        // $jumlah = count($data);
        // return $jumlah;
    }

    public static function data()
    {
        // $user = Session::get('access_token');
        // $title = 'Validasi Pendaftaran';
        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json',
        //     'Authorization' => 'Bearer ' . $user
        // ])->post(env('SRV_URL') . 'pendaftar');
        // $data = $response['data']['data'];

        // return $data;
    }
}
