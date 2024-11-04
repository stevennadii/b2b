<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PackagingController extends Controller
{
    public function packaging()
    {
        $token = session()->get('access_token');
        $users =  session()->get('user');
        $AuthSP = $users['Auth_SP'];
        $username = $users['username'];
        $KodeSupplier = $users['Kode_Supplier'];
        $Lokasi = $users['Lokasi'];
        // dd($authSP);
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
        $perusahaan = fetchData('/packaging/get_perusahaan', $token, $params);
        if ($perusahaan instanceof \Illuminate\Http\JsonResponse) {
            return $perusahaan;
        }
        $caraKirim = fetchData('/packaging/get_cara_kirim', $token, $params);
        if ($caraKirim instanceof \Illuminate\Http\JsonResponse) {
            return $caraKirim;
        }
        
        $satuan = fetchData('/packaging/get_satuan', $token, $params);
        if ($satuan instanceof \Illuminate\Http\JsonResponse) {
            return $satuan;
        }
        // dd($barang);
         $faktur = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->post(env('SRV_URL') . '/faktur/get_packaging');

        if ($faktur->successful()) {
       
            return inertia('vue/Packaging', [
                'dataPerusahaan' => $perusahaan,
                'dataSatuan' => $satuan,
                'dataCaraKirim' => $caraKirim,
                'Token' =>$token,
                'AuthSP' =>$AuthSP,
                'UserId' =>$username,
                'KodeSupplier' =>$KodeSupplier,
                'Lokasi' =>$Lokasi,
                'dataFaktur' => $faktur->body(), 
            ]);
        } else {
            return response()->json([
                'error' => 'Failed to fetch data from ' . 'faktur/get_packaging',
                'details' => $faktur->body()
            ], $faktur->status());
        }
        // return inertia('vue/Packaging');
    }
    
    public function approvalPackaging()
    {
        $token = session()->get('access_token');
        $users =  session()->get('user');
        $AuthSP = $users['Auth_SP'];
        $username = $users['username'];
        $Lokasi = $users['Lokasi'];
        $role = $users['role_id'];
        
        if (!$username || $role !== '1') {
            abort(404);
        }

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

        $approval = fetchData('/approval_packaging/get_approval_admin', $token, $params);
        if ($approval instanceof \Illuminate\Http\JsonResponse) {
            return $approval;
        }


        return inertia('vue/ApprovalPackaging',['dataApproval' =>$approval]);
    }
    
    public function approvalPackagingUser()
    {
        $token = session()->get('access_token');
        $users =  session()->get('user');
        $AuthSP = $users['Auth_SP'];
        $username = $users['username'];
        $KodeSupplier = $users['Kode_Supplier'];
        $Lokasi = $users['Lokasi'];
        
        // dd($authSP);
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

        $approval = fetchData('/approval_packaging/get_approval_user', $token, $params);
        if ($approval instanceof \Illuminate\Http\JsonResponse) {
            return $approval;
        }
        return inertia('vue/ApprovalPackagingUser',['dataApproval' =>$approval]);
    }
    public function tambahApprovalPackaging()
    {
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
        $status = fetchData('/approval_packaging/get_status', $token, $params);
        if ($status instanceof \Illuminate\Http\JsonResponse) {
            return $status;
        }
        $filterBarang = fetchData('/approval_packaging/get_filter_barang', $token, $params);
        if ($filterBarang instanceof \Illuminate\Http\JsonResponse) {
            return $filterBarang;
        }
        $approval_compare = fetchData('/approval_packaging/get_approval_compare', $token, $params);
        if ($approval_compare instanceof \Illuminate\Http\JsonResponse) {
            return $approval_compare;
        }
        $faktur = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->post(env('SRV_URL') . '/faktur/get_approval_packaging');

        if ($faktur->successful()) {
            return inertia('vue/TambahApprovalPackaging', [
                'dataBarang' => $filterBarang,
                'dataApproval' => $approval_compare,
                'dataStatus' =>$status,
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
        // return inertia('vue/TambahApprovalPackaging');
    }

    public function detailApprovalPackaging()
    {
        $token = session()->get('access_token');
        $users =  session()->get('user');
        $AuthSP = $users['Auth_SP'];
        $username = $users['username'];
        $Lokasi = $users['Lokasi'];
        
        return inertia('vue/DetailApprovalPackaging', [
            'Token' =>$token,
            'AuthSP' =>$AuthSP,
            'UserId' =>$username,
            'Lokasi' =>$Lokasi,

        ]);
    }

    public function detailApprovalPackagingUser(Request $request)
    {
        $nomorPenawaran = $request->input('NoPenawaran'); 
        $noPenawaran = str_replace('@', '/', $nomorPenawaran);
        $token = session()->get('access_token');
        $users =  session()->get('user');
        $AuthSP = $users['Auth_SP'];
        $username = $users['username'];
        $Lokasi = $users['Lokasi'];
        // dd($username);

        $params = [
            "kode_perusahaan" => env('KODE_PERUSAHAAN'),
            "id_user" => $username,
            "auth_sp" => $AuthSP,
            "version" => env('VERSION'),
            "nama_api" => env('NAMA_API_EXPEDITION'),
            "locale" => env('LOCALE'),
            "noPenawaran" => $noPenawaran,
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

        $detailData = fetchData('/approval_packaging/get_approval_detail_user', $token, $params);
        if ($detailData instanceof \Illuminate\Http\JsonResponse) {
            return $detailData;
        }
        foreach ($detailData as $item) {
            if (!isset($item['Supplier']) || $item['Supplier'] !== $username) {
                abort(404);
            }
        }

        return inertia('vue/DetailApprovalPackagingUser', [
            'dataDetail' =>$detailData,
            'Token' =>$token,
            'AuthSP' =>$AuthSP,
            'UserId' =>$username,
            'Lokasi' =>$Lokasi,

        ]);
    }
}
