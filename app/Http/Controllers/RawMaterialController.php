<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RawMaterialController extends Controller
{
    public function rawMaterial()
    {
        $jenis = 'RAW MATERIAL';
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

        $perusahaan = fetchData('/raw_material/get_perusahaan', $token, $params);
        if ($perusahaan instanceof \Illuminate\Http\JsonResponse) {
            return $perusahaan;
        }
        
        $jenis_pengiriman = fetchData('/raw_material/get_jenis_pengiriman', $token, $params);
        if ($jenis_pengiriman instanceof \Illuminate\Http\JsonResponse) {
            return $jenis_pengiriman;
        }
        
        $satuan = fetchData('/raw_material/get_satuan', $token, $params);
        if ($satuan instanceof \Illuminate\Http\JsonResponse) {
            return $satuan;
        }

        $cara_kirim = fetchData('/raw_material/get_cara_kirim', $token, $params);
        if ($cara_kirim instanceof \Illuminate\Http\JsonResponse) {
            return $cara_kirim;
        }

         // Mengambil data faktur
        // dd(env('SRV_URL') . 'faktur/get_bahan_baku');
         $faktur = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->post(env('SRV_URL') . '/faktur/get_bahan_baku');
        //  dd($faktur->body());
        if ($faktur->successful()) {
            // Jika berhasil, mengembalikan semua data dalam satu response
            return inertia('vue/RawMaterial', [
                'dataPerusahaan' => $perusahaan,
                'dataJenisPengiriman' => $jenis_pengiriman,
                'dataSatuan' => $satuan,
                'dataCaraKirim' => $cara_kirim,
             
                'Token' =>$token,
                'AuthSP' =>$AuthSP,
                'UserId' =>$username,
                'KodeSupplier' =>$KodeSupplier,
                'Lokasi' =>$Lokasi,
                'dataFaktur' => $faktur->body(), // Menambahkan data faktur
            ]);
        } else {
            return response()->json([
                'error' => 'Failed to fetch data from ' . 'faktur/get_bahan_baku',
                'details' => $faktur->body()
            ], $faktur->status());
        }
    }

    public function approvalRawMaterial()
    {
        $token = session()->get('access_token');
        $users =  session()->get('user');
        $AuthSP = $users['Auth_SP'];
        $username = $users['username'];
        $KodeSupplier = $users['Kode_Supplier'];
        $Lokasi = $users['Lokasi'];
        $role =$users['role_id'];
        
        if (!$username || $role !== '1') {
            abort(404);
        }
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

        $approval = fetchData('/approval_rawmaterial/get_approval_admin', $token, $params);
        if ($approval instanceof \Illuminate\Http\JsonResponse) {
            return $approval;
        }
        // dd($approval);
        return inertia('vue/ApprovalRawMaterial',['dataApproval' =>$approval]);
    }

    public function approvalRawMaterialUser()
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

        $approval = fetchData('/approval_rawmaterial/get_approval_user', $token, $params);
        if ($approval instanceof \Illuminate\Http\JsonResponse) {
            return $approval;
        }
        return inertia('vue/ApprovalRawMaterialUser',['dataApproval' =>$approval]);
    }

    public function tambahApprovalRawMaterial()
    {
        $token = session()->get('access_token');
        $users =  session()->get('user');
        $AuthSP = $users['Auth_SP'];
        $username = $users['username'];
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

        $faktur = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->post(env('SRV_URL') . '/faktur/get_approval_rawMaterial');

        $filterBarang = fetchData('/approval_rawmaterial/get_filter_barang', $token, $params);
        if ($filterBarang instanceof \Illuminate\Http\JsonResponse) {
            return $filterBarang;
        }
        $status = fetchData('/approval_rawmaterial/get_status', $token, $params);
        if ($status instanceof \Illuminate\Http\JsonResponse) {
            return $status;
        }

        $approval_compare = fetchData('/approval_rawmaterial/get_approval_compare', $token, $params);
        if ($approval_compare instanceof \Illuminate\Http\JsonResponse) {
            return $approval_compare;
        }
        if ($faktur->successful()) {
            return inertia('vue/TambahApprovalRawMaterial', [
                'dataApproval' => $approval_compare,
                'dataStatus' => $status,
                'dataFilterBarang' => $filterBarang,
                'Token' =>$token,
                'AuthSP' =>$AuthSP,
                'UserId' =>$username,
                'Lokasi' =>$Lokasi,
                'dataFaktur' => $faktur->body(), 
            ]);
        } else {
            return response()->json([
                'error' => 'Failed to fetch data from ' . 'faktur/get_rawMaterial',
                'details' => $faktur->body()
            ], $faktur->status());
        }

    }

    public function detailApprovalRawMaterial()
    {
        $token = session()->get('access_token');
        $users =  session()->get('user');
        $AuthSP = $users['Auth_SP'];
        $username = $users['username'];
        $Lokasi = $users['Lokasi'];
        $role = $users['role_id'];
        // dd($users);
    
            if (!$username || $username !== 'evo') {
                abort(404);
            }
       

        
        return inertia('vue/DetailApprovalRawMaterial', [
            'Token' =>$token,
            'AuthSP' =>$AuthSP,
            'UserId' =>$username,
            'Lokasi' =>$Lokasi,

        ]);
    }

    public function detailApprovalRawMaterialUser(Request $request)
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

        $detailData = fetchData('/approval_rawmaterial/get_approval_detail_user', $token, $params);
        if ($detailData instanceof \Illuminate\Http\JsonResponse) {
            return $detailData;
        }
        foreach ($detailData as $item) {
            if (!isset($item['Supplier']) || $item['Supplier'] !== $username) {
                abort(404);
            }
        }

        return inertia('vue/DetailApprovalRawMaterialUser', [
            'dataDetail' =>$detailData,
            'Token' =>$token,
            'AuthSP' =>$AuthSP,
            'UserId' =>$username,
            'Lokasi' =>$Lokasi,

        ]);
    }
}
