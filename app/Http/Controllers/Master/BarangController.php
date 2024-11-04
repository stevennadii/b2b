<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class BarangController extends Controller
{
    public function view_stok()
    {
        $title = "Stok Barang";
        $token = Session::get("access_token");
        
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->post(env('SRV_URL') . 'barang/stok');

        $stok = $response->json()['data']['data'];
        // dd($stok);

        return view('barang.table_barang', compact('title','stok'));
    }

    public function master_tambah_data()
    {
        $title = "Master Barang";

        return view('barang.master_barang', compact('title'));
    }



    public function tambah_data(Request $request) 
    {
        $kode_barang = $request->input('kode_barang');
        $nama = $request->input('nama');
        $satuan = $request->input('satuan');
        $harga_beli = $request->input('harga_beli');

        $request->all();

        $data = [
            "kode_barang" => $kode_barang,
            "nama" => $nama,
            "satuan" => $satuan,
            "harga_beli" => $harga_beli
        ];

        $token = Session::get("access_token");
        $response = Http::withHeaders([
            'Accept' => "application/json",
            "Authorization" => 'Bearer ' . $token
        ])->post(env("SRV_URL") . "barang/store", $data);

        if ($response->status() == "200" ) {
          return back()->with([
            'message' => $response->json()['meta']['message']
          ]);
        } elseif ($response->status() == "422") {
            return back()->with([
                'message' => $response->json()['message']
            ]);
        } else {
            return back()->with([
                'message' => $response->json()['meta']['message']
            ]);
        }

        
      

    }
}
