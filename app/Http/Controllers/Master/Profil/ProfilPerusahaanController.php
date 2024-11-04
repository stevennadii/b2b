<?php

namespace App\Http\Controllers\Master\Profil;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ProfilPerusahaanController extends Controller
{
    public function index()
        {
            $token = Session::get("access_token");
            $user_id = Session::get("user.username");
            $authsp = Session::get("user.Auth_SP");
            $namaAPI = env('NAMA_API_PROFIL_PERUSAHAAN');
            return inertia('vue/ProfilPerusahaan',['token'=>$token, 'user_id'=>$user_id, 'authsp' =>$authsp,'namaAPI' =>$namaAPI]);
        }

    public function angkutan()
        {
            return inertia('vue/JenisAngkutan');
        }

    public function detail($id)
        {
            $token = Session::get("access_token");
            $user_id = Session::get("user.username");
            $authsp = Session::get("user.Auth_SP");
            // dd($authsp);
            $params = [
                "kode_perusahaan" => env('KODE_PERUSAHAAN'),
                "id_user" => $user_id,
                "auth_sp" => $authsp,
                "version" => env('VERSION'),
                "nama_api" => env('NAMA_API_PROFIL_PERUSAHAAN'),
                "locale" => env('LOCALE'),
                "id" => $id,
                
            ];
            // First API call
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ])->post(env('SRV_URL') . '/profil_perusahaan/get_detail_profil_perusahaan/'. $id, $params);

            // Check if the first response is successful
            if ($response->successful() && isset($response['data']['data'])) {
                $data = $response['data']['data'];
            } else {
                // Handle error for the first API response
                return response()->json([
                    'error' => 'Failed to fetch profil_perusahaan data',
                    'details' => $response->body()
                ], $response->status());
            }   
            // dd($data);
            return view('detail',['detail'=>$data]);
        }
    public function list()
        {
            $token = Session::get("access_token");
            $user_id = Session::get("user.username");
            $authsp = Session::get("user.Auth_SP");
            // dd($authsp);
            $params = [
                "kode_perusahaan" => env('KODE_PERUSAHAAN'),
                "id_user" => $user_id,
                "auth_sp" => $authsp,
                "version" => env('VERSION'),
                "nama_api" => env('NAMA_API_PROFIL_PERUSAHAAN'),
                "locale" => env('LOCALE'),
                
            ];
            // First API call
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ])->post(env('SRV_URL') . '/profil_perusahaan/get_profil_perusahaan', $params);

            // Check if the first response is successful
            if ($response->successful() && isset($response['data']['data'])) {
                $data = $response['data']['data'];
            } else {
                // Handle error for the first API response
                return response()->json([
                    'error' => 'Failed to fetch profil_perusahaan data',
                    'details' => $response->body()
                ], $response->status());
            }   
            // dd($data);
            return inertia('vue/ListPerusahaan', ['companies'=>$data]);
        }
  

    public function SimpanProfilPerusahaan(Request $request)
        {
            $token = Session::get("access_token");
            $user_id = Session::get("user.username");
            $authsp = Session::get("user.Auth_SP");
            // Validasi input dari request (opsional)
            // dd($token);
            $request->validate([
                'kode_perusahaan'      => 'required|max:3',
               
                'badan_usaha'          => 'string|max:100',
                'nama_perusahaan'      => 'string|max:255',
                'alamat_usaha'         => 'string',
                'negara'               => 'string|max:100',
                'provinsi'             => 'string|max:100',
                'kabupaten_kota'       => 'string|max:100',
                'telepon'              => 'string|max:20',
                'status_pajak'         => 'string|max:50',
                'npwp'                 => 'string|max:20',
                'nama_pic'             => 'string|max:100',
                'jabatan'              => 'string|max:100',
                'ponsel'               => 'string|max:20',
                'cara_bayar'           => 'string|max:50',
                'tempo'                => 'string|max:50',
                'tipe_pembayaran'      => 'string|max:50',
             
                'bank'                 => 'string|max:100',
                'cabang'               => 'string|max:100',
                'nama_nasabah'         => 'string|max:100',
                'no_rekening'          => 'string|max:50',
                'swift_code'           => 'string|max:20',
                'userid'               => 'string|max:20',
                'id_user'              => 'string|max:20',
                'auth_sp'              => 'string|max:20',
                'nama_api'             => 'string|max:200',
            ]);

            // Data yang akan dikirim ke API
            $data = [
                'kode_perusahaan'      => env('KODE_PERUSAHAAN'),
                'jenis_ekspedisi'      => $request->input('jenis_ekspedisi'),
                'badan_usaha'          => $request->input('badan_usaha'),
                'nama_perusahaan'      => $request->input('nama_perusahaan'),
                'alamat_usaha'         => $request->input('alamat_usaha'),
                'negara'               => $request->input('negara'),
                'provinsi'             => $request->input('provinsi'),
                'kabupaten_kota'       => $request->input('kabupaten_kota'),
                'telepon'              => $request->input('telepon'),
                'status_pajak'         => $request->input('status_pajak'),
                'npwp'                 => $request->input('npwp'),
                'nama_pic'             => $request->input('nama_pic'),
                'jabatan'              => $request->input('jabatan'),
                'ponsel'               => $request->input('ponsel'),
                'cara_bayar'           => $request->input('cara_bayar'),
                'tempo'                => $request->input('tempo'),
                'tipe_pembayaran'      => $request->input('tipe_pembayaran'),
                'jenis_ekspedisi_2'    => $request->input('jenis_ekspedisi_2'),
                'bank'                 => $request->input('bank'),
                'cabang'               => $request->input('cabang'),
                'nama_nasabah'         => $request->input('nama_nasabah'),
                'no_rekening'          => $request->input('no_rekening'),
                'swift_code'           => $request->input('swift_code'),
                'userid'               => $request->input('userid'),
                'id_user'              => $request->input('id_user'),
                'auth_sp'              => $request->input('auth_sp'),
                'nama_api'             => $request->input('nama_api'),
            ];

            try {
                // POST request ke API
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json', 
                    "Authorization" => 'Bearer ' . $token
                ])->post(env('SRV_URL') . '/simpan-profil-perusahaan', $data);

                // Cek apakah response berhasil
                if ($response->successful()) {
                    return response()->json([
                        'status'  => 'success',
                        'message' => 'Profil perusahaan berhasil disimpan',
                        'data'    => $response->json(),
                    ], 200);
                } else {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Gagal menyimpan profil perusahaan',
                        'error'   => $response->json(),
                    ], $response->status());
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Terjadi kesalahan saat menghubungi API',
                    'error'   => $e->getMessage(),
                ], 500);
            }
        }

    }
