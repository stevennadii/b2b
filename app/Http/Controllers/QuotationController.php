<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class QuotationController extends Controller
{
    public function index(){
        return inertia('vue/ListQuotation');
    }

    public function detailQuotation(){
        return inertia('vue/DetailQuotation');
    }

    public function quotation(){
        $token = session()->get('access_token');
        $users =  session()->get('user');
        $AuthSP = $users['Auth_SP'];
        $username = $users['username'];
        $KodeSupplier = $users['Kode_Supplier'];
        $Lokasi = $users['Lokasi'];

        $params = [
            "kode_perusahaan" => env('KODE_PERUSAHAAN'),
            "id_user" => $username,
            "auth_sp" => $AuthSP,
            "version" => env('VERSION'),
            "nama_api" => env('NAMA_API_EXPEDITION'),
            "locale" => env('LOCALE'),   
        ];
        function fetchData($endpoint, $token, $params)
        {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ])->post(env('SRV_URL') . $endpoint, $params);
        
            if ($response->successful() && isset($response['data']['data'])) {
                return $response['data']['data'];
            } else {
                return response()->json([
                    'error' => 'Failed to fetch data from ' . $endpoint,
                    'details' => $response->body()
                ], $response->status());
            }
        }

        $pelabuhanAsal = fetchData('/freight/get_pelabuhan_asal', $token, $params);
        if ($pelabuhanAsal instanceof \Illuminate\Http\JsonResponse) {
            return $pelabuhanAsal;
        } 

        $tujuan = fetchData('/freight/get_master_tujuan', $token, $params);
        if ($tujuan instanceof \Illuminate\Http\JsonResponse) {
            return $tujuan;
        } 

        $mataUang = fetchData('/freight/get_master_mata_uang', $token, $params);
        if ($mataUang instanceof \Illuminate\Http\JsonResponse) {
            return $mataUang;
        } 

        $pengiriman = fetchData('/freight/get_master_pengiriman', $token, $params);
        if ($pengiriman instanceof \Illuminate\Http\JsonResponse) {
            return $pengiriman;
        } 

        $container = fetchData('/freight/get_master_container', $token, $params);
        if ($container instanceof \Illuminate\Http\JsonResponse) {
            return $container;
        } 
     

        $faktur = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->post(env('SRV_URL') . '/faktur/get_quotation');

        // dd($faktur->body());
        if ($faktur->successful()) {
            // Jika berhasil, mengembalikan semua data dalam satu response
            return inertia('vue/FreightQuotation', [
                'dataPelabuhanAsal' => $pelabuhanAsal,
                'dataTujuan' => $tujuan,
                'dataMataUang' => $mataUang,
                'dataPengiriman' => $pengiriman,
                'dataContainer' => $container,
                'dataFaktur' => $faktur->body(),
                'AuthSP' =>$AuthSP,
                'Token' =>$token,
                'UserId' =>$username,
                'KodeSupplier' =>$KodeSupplier,
                'Lokasi' =>$Lokasi
               // Menambahkan data faktur
            ]);
        } else {
            return response()->json([
                'error' => 'Failed to fetch data from ' . 'faktur/get_quotation',
                'details' => $faktur->body()
            ], $faktur->status());
        }

    }

    public function expense(){
        $token = Session::get("access_token");
        $user_id = Session::get("user.username");
        $authsp = Session::get("user.Auth_SP");

        $params = [
            "kode_perusahaan" => env('KODE_PERUSAHAAN'),
            "id_user" => $user_id,
            "auth_sp" => $authsp,
            "version" => env('VERSION'),
            "nama_api" => env('NAMA_API_EXPEDITION'),
            "locale" => env('LOCALE'),   
        ];
        // First API call
        function fetchData($endpoint, $token, $params)
        {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ])->post(env('SRV_URL') . $endpoint, $params);
        
            if ($response->successful() && isset($response['data']['data'])) {
                return $response['data']['data'];
            } else {
                return response()->json([
                    'error' => 'Failed to fetch data from ' . $endpoint,
                    'details' => $response->body()
                ], $response->status());
            }
        }
        $mataUang = fetchData('/expense/get_master_mata_uang', $token, $params);
        if ($mataUang instanceof \Illuminate\Http\JsonResponse) {
            return $mataUang;
        } 

        $jenisExpense = fetchData('/expense/get_master_jenis_expense', $token, $params);
        if ($jenisExpense instanceof \Illuminate\Http\JsonResponse) {
            return $jenisExpense;
        } 
        $dataFreight =  fetchData('/expense/get_data_freight_quotation', $token, $params);
        if ($dataFreight instanceof \Illuminate\Http\JsonResponse) {
            return $dataFreight;
        } 

        $faktur = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->post(env('SRV_URL') . '/faktur/get_expense');

        // dd($faktur->body());
        if ($faktur->successful()) {
            // Jika berhasil, mengembalikan semua data dalam satu response
            return inertia('vue/FreightExpense', [
                'dataMataUang' => $mataUang,
                'dataJenisExpense' => $jenisExpense,
                'dataFreight' => $dataFreight,
                'dataFaktur' => $faktur->body(), // Menambahkan data faktur
            ]);
        } else {
            return response()->json([
                'error' => 'Failed to fetch data from ' . 'faktur/get_expense',
                'details' => $faktur->body()
            ], $faktur->status());
        }
    }

    public function comparison(){
        return inertia('vue/FreightComparison');
    }

    public function fowarding(){
        // Ke Halaman fowarding
    }


    public function confirmQuotation(){
        return inertia('vue/ConfirmQuotation');
    }

    public function detailConfirmQuotation(){
        return inertia('vue/DetailConfirmQuotation');
    }

    public function  approvalFreight(){
        return inertia('vue/ApprovalFreight');
    }

    public function tambahApprovalFreight(){
        $token = session()->get('access_token');
        $users =  session()->get('user');
        $AuthSP = $users['Auth_SP'];
        $username = $users['username'];
        $KodeSupplier = $users['Kode_Supplier'];
        $Lokasi = $users['Lokasi'];
        $params = [
            "kode_perusahaan" => env('KODE_PERUSAHAAN'),
            "id_user" => $username,
            "auth_sp" => $AuthSP,
            "version" => env('VERSION'),
            "nama_api" => env('NAMA_API_EXPEDITION'),
            "locale" => env('LOCALE'),   
        ];
        // First API call
        function fetchData($endpoint, $token, $params)
        {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ])->post(env('SRV_URL') . $endpoint, $params);
        
            if ($response->successful() && isset($response['data']['data'])) {
                return $response['data']['data'];
            } else {
                return response()->json([
                    'error' => 'Failed to fetch data from ' . $endpoint,
                    'details' => $response->body()
                ], $response->status());
            }
        }
        
        $pelabuhanAsal = fetchData('/approval_freight/get_pelabuhan_asal', $token, $params);
        if ($pelabuhanAsal instanceof \Illuminate\Http\JsonResponse) {
            return $pelabuhanAsal;
        }

        $container = fetchData('/approval_freight/get_master_container', $token, $params);
        if ($container instanceof \Illuminate\Http\JsonResponse) {
            return $container;
        }
        $tujuan = fetchData('/approval_freight/get_master_tujuan', $token, $params);
        if ($tujuan instanceof \Illuminate\Http\JsonResponse) {
            return $tujuan;
        }
        $pengiriman = fetchData('/approval_freight/get_master_pengiriman', $token, $params);
        if ($pengiriman instanceof \Illuminate\Http\JsonResponse) {
            return $pengiriman;
        }
        $quotation = fetchData('/approval_freight/get_freightquotation', $token, $params);
        if ($quotation instanceof \Illuminate\Http\JsonResponse) {
            return $quotation;
        }
        $faktur = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->post(env('SRV_URL') . '/faktur/get_approval_freight');

        if ($faktur->successful()) {
            return inertia('vue/TambahApprovalFreight', [
                'dataContainer' => $container,
                'dataAsal' => $pelabuhanAsal,
                'dataTujuan' => $tujuan,
                'dataPengiriman' => $pengiriman,
                'dataQuotation' =>$quotation,
                'Token' =>$token,
                'AuthSP' =>$AuthSP,
                'UserId' =>$username,
                'KodeSupplier' =>$KodeSupplier,
                'Lokasi' =>$Lokasi,
                'dataFaktur' => $faktur->body(), 
            ]);
        } else {
            return response()->json([
                'error' => 'Failed to fetch data from ' . 'faktur/get_bahan_baku',
                'details' => $faktur->body()
            ], $faktur->status());
        }

        // return inertia('vue/TambahApprovalFreight');
    }
   
}
