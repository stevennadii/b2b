<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{


    public function form_login()
    {
        if (Session::get('access_token')) {
            return redirect('/dashboard');
        }
        $title = "B2B";
        return view('auth.login', compact('title'));
    }
    public function proses_login(Request $request)
    {
        // Validasi input form
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',

        ]);
        //    dd($request->all());
        $params = [
            "username"  => $request->input('username'),
            "password"  => $request->input('password'),
            "version" => env('VERSION')
        ];

        try {

            $dataUser = [
                'username' => $request->username,
                'password' => $request->password,
                "version" => env('VERSION')
            ];
            $header = [
                'Content-Type' => 'application/json',
            ];



            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post(env('SRV_URL') . '/login', $params);

            $data = $response->json();
            // dd($data);
            // dd($data);
            if ($response->successful() && $data['meta']['status'] == "success") {
                // Simpan token atau informasi user di session
                Session::put('access_token', $data['data']['access_token']);
                Session::put('user', $data['data']['user']);

                // Redi rect ke halaman dashboard atau lainnya
                return redirect()->route('dashboard'); // Sesuaikan dengan route Anda
            } else {

                return back()->with('message', $data['meta']['message']);
            }
        } catch (\Exception $e) {
            // Tangani error exception
            return back()->with(['message' => "terjadi kesalahan!"]);
        }
    }


    public function logout(Request $request)
    {

        try {
            $user = $request->session()->get('access_token');
            Http::withHeaders([
                'Content-Type' => 'application/json',
                'Access_token' => 'Bearer ' . $user
            ])->post(env('SRV_URL') . 'logout');
            $request->session()->flush();
            return redirect('/')->with('message', 'berhasil logout');
        } catch (Exception $error) {
            return redirect('dashboard')->with('message', $error);
        }
    }

    public function ganti_password(Request $request)
    {
        try {
            $user = $request->session()->get('access_token');
            $username = Session::get('user.username');

            $body = [
                'username' => $username,
                'password' => $request->input('pw_lama'),
                'new_password' => $request->input('pw_baru'),
                'confirm_password' => $request->input('pw_baru2')
            ];
            Http::withHeaders([
                'Content-Type' => 'application/json',
                'Access_token' => 'Bearer ' . $user
            ])->post(env('SRV_URL') . 'change_password', $body);
            $request->session()->flush();
            return redirect('dashboard')->with('message', 'Password berhasil diganti');
        } catch (Exception $error) {
            return redirect('dashboard')->with('message', $error);
        }
    }
}
