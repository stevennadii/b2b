<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $token = session()->get('access_token');
        $users =  session()->get('user');
        $authSP = $users['Auth_SP'];
        $username = $users['username'];
        $KodeSupplier = $users['Kode_Supplier'];
        $Lokasi = $users['Lokasi'];
  
        // dd($Lokasi);
        $params = [
            "kode_perusahaan" => env('KODE_PERUSAHAAN'),
            "id_user" => $username,
            "auth_sp" =>$authSP,
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
                // dd($response->body());
            if ($response->successful() && isset($response['data']['data'])) {
                return $response['data']['data'];
            } else {
                return response()->json([
                    'error' => 'Failed to fetch data from ' . $endpoint,
                    'details' => $response->body()
                ], $response->status());
            }
        }
        $kendaraan = fetchData('/expedition/get_kendaraan', $token, $params);
        if ($kendaraan instanceof \Illuminate\Http\JsonResponse) {
            return $kendaraan;
        }

        $faktur = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->post(env('SRV_URL') . '/faktur/get_purchase_order');
        //  dd($faktur->body());
        if ($faktur->successful()) {
            // Jika berhasil, mengembalikan semua data dalam satu response
            return inertia('vue/PurchaseOrder', [
                'dataKendaraan' => $kendaraan,
                'AuthSP' =>$authSP,
                'Token' =>$token,
                'UserId' =>$username,
                'KodeSupplier' =>$KodeSupplier,
                'Lokasi' =>$Lokasi,
                'dataFaktur' => $faktur->body(), // Menambahkan data faktur
            ]);
        } else {
            return response()->json([
                'error' => 'Failed to fetch data from ' . 'faktur/get_purchase_order',
                'details' => $faktur->body()
            ], $faktur->status());
        }
        // dd($kendaraan);
        // return inertia('vue/PurchaseOrder',['dataKendaraan'=>$kendaraan]);
    }

    public function display(){
        $token = session()->get('access_token');
        $users =  session()->get('user');
  
        // dd($token);
        $params = [
            "kode_perusahaan" => env('KODE_PERUSAHAAN'),
            "id_user" => $users['username'],
            "auth_sp" =>$users['Auth_SP'],
            "version" => env('VERSION'),
            "nama_api" => env('NAMA_API_PURCHASE_ORDER'),
            "locale" => env('LOCALE'),

        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->post(env('SRV_URL') . '/supplier/get_tracking_po', $params);
        // dd($response['data']['data']);

        if ($response->successful() && isset($response['data']['data'])) {
            return view('trackingPO', [
                'displayPO' => $response['data']['data']
            ]);
        } else {
            return response()->json([
                'error' => 'Failed to fetch data from ' . '/supplier/get_data_po',
                'details' => $response->body()
            ], $response->status());
        }
        
        return view('trackingPO');
    }
    public function showDetail()
    {
        $token = session()->get('access_token');
        $users =  session()->get('user');
        $AuthSP = $users['Auth_SP'];
        $username = $users['username'];
        $KodeSupplier = $users['Kode_Supplier'];
        $Lokasi = $users['Lokasi'];
  
        // dd($Lokasi);
        $params = [
            "kode_perusahaan" => env('KODE_PERUSAHAAN'),
            "id_user" => $username,
            "auth_sp" =>$AuthSP,
            "version" => env('VERSION'),
            "nama_api" => env('NAMA_API_EXPEDITION'),
            "locale" => env('LOCALE'),

        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->post(env('SRV_URL') . '/supplier/get_data_po', $params);

        if ($response->successful() && isset($response['data']['data'])) {
            return inertia('vue/DetailPurchaseOrder', [
                'dataPO' => $response['data']['data'],
                'AuthSP' =>$AuthSP,
                'Token' =>$token,
                'UserId' =>$username,
                'KodeSupplier' =>$KodeSupplier,
                'Lokasi' =>$Lokasi,
            ]);
        } else {
            return response()->json([
                'error' => 'Failed to fetch data from ' . '/supplier/get_data_po',
                'details' => $response->body()
            ], $response->status());
        }
    }

    public function savePurchaseOrder(Request $request)
    {
        // Ambil data yang dikirim dari frontend
        $data = $request->all();

        // Tentukan lokasi file JSON
        $filePath = storage_path('app/public/purchase_orders.json');

        // Cek apakah file sudah ada, jika belum, buat array kosong
        if (!File::exists($filePath)) {
            $existingData = [];
        } else {
            // Baca konten file JSON yang ada
            $jsonContent = File::get($filePath);
            $existingData = json_decode($jsonContent, true);
        }

        // Tambahkan data baru ke existing data
        $existingData[] = $data;

        // Simpan kembali ke file JSON
        File::put($filePath, json_encode($existingData, JSON_PRETTY_PRINT));

        // Kembalikan respons sukses
        return response()->json(['message' => 'Data berhasil disimpan']);
    }
}
