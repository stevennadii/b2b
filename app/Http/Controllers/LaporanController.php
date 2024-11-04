<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class LaporanController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware(function ($request, $next) {
    //         $role = Session::get('user.role_id');
    //         if ($role == '1' || $role == '2' || $role == '3') {
    //             return $next($request);
    //         }
    //         abort(404);
    //     });
    // }

    public function index()
    {
        $role = Session::get('user.role_id');
        if ($role == '1' || $role == '2' || $role == '3') {
            $title = 'Laporan';
            $token = Session::get('access_token');
            $bulan = [
                '01' => 'JANUARI',
                '02' => 'FEBRUARI',
                '03' => 'MARET',
                '04' => 'APRIL',
                '05' => 'MEI',
                '06' => 'JUNI',
                '07' => 'JULI',
                '08' => 'AGUSTUS',
                '09' => 'SEPTEMBER',
                '10' => 'OKTOBER',
                '11' => 'NOVEMBER',
                '12' => 'DESEMBER'
            ];

            $tahun = [];

            for ($i = 2021; $i < (int)date('Y') + 4; $i++) {
                array_push($tahun, $i);
            }

            $dataKota = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ])->post(env('SRV_URL') . 'wilayah/kota');

            $kota = $dataKota['data']['data'];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ])->post(env('SRV_URL') . 'jenis_bantuan')->json();

            $data = $response['data']['data'];

            return view('laporan.view', compact('title', 'data', 'bulan', 'tahun', 'kota'));
        }
        abort(404);
    }

    public function report(Request $request)
    {
        $role = Session::get('user.role_id');
        if ($role == '1' || $role == '2' || $role == '3') {
            $body = [
                'jenis_bantuan' => $request->jenis_bantuan,
                'kota'          => $request->kota,
                'bulan'         => $request->bulan,
                'tahun'         => $request->tahun
            ];
            //  dd($body);

            $token = Session::get('access_token');
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ])->post(env('SRV_URL') . 'report', $body)->json();
            // dd($response);
            if ($response['meta']['code'] == 200) {
                $data = $response['data']['data'];
                $total = $response['data']['total'];
                $bulan = $body['bulan'];
                $tahun = $body['tahun'];
                $kota = $body['kota'];
                $nama_bulan = [
                    '01' => 'JANUARI',
                    '02' => 'FEBRUARI',
                    '03' => 'MARET',
                    '04' => 'APRIL',
                    '05' => 'MEI',
                    '06' => 'JUNI',
                    '07' => 'JULI',
                    '08' => 'AGUSTUS',
                    '09' => 'SEPTEMBER',
                    '10' => 'OKTOBER',
                    '11' => 'NOVEMBER',
                    '12' => 'DESEMBER'
                ];

                $pdf = Pdf::loadView('laporan/report', compact('data', 'bulan', 'tahun', 'nama_bulan', 'kota', 'total'))->setPaper('a4', 'landscape');
                return $pdf->download('Report-' . Date('m-Y') . '.pdf');
            } else {
                $data = [];
                $message = $response['data']['message'];
                return back()->withInput()->with('message', $message);
            }
        }
        abort(404);
    }


    public function laporan_keuangan()
    {
        // dd("Hello ayu");
        $title = 'Laporan Keuangan';
        $role = Session::get('user.role_id');
        if ($role == '1' || $role == '4') {
            $title = 'Laporan';
            $token = Session::get('access_token');
            $bulan = [
                '01' => 'JANUARI',
                '02' => 'FEBRUARI',
                '03' => 'MARET',
                '04' => 'APRIL',
                '05' => 'MEI',
                '06' => 'JUNI',
                '07' => 'JULI',
                '08' => 'AGUSTUS',
                '09' => 'SEPTEMBER',
                '10' => 'OKTOBER',
                '11' => 'NOVEMBER',
                '12' => 'DESEMBER'
            ];

            $tahun = [];

            for ($i = 2015; $i < (int)date('Y') + 5; $i++) {
                array_push($tahun, $i);
            }

            $dataKota = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ])->post(env('SRV_URL') . 'wilayah/kota');

            $kota = $dataKota['data']['data'];

            return view('laporan_keuangan.view',compact('title', 'kota', 'bulan', 'tahun'));
        }
        abort(404);
    }

    public function cetak_laporan_keuangan(Request $request)
    {
        $body = [
            'kota'          => $request->input('kota'),
            'tgl_awal'         => $request->input('tgl_awal'),
            'tgl_akhir'         => $request->input('tgl_akhir')
        ];
    //    dd($body);
        $token = Session::get('access_token');
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->post(env('SRV_URL') . 'report/finance', $body)->json();
        // dd($response);
        if ($response['meta']['code'] == 200) {
            $data = $response['data']['data'];
            $total = $response['data']['total'];
            $kota = $body['kota'];
            $tgl_awal = $body['tgl_awal'];
            $tgl_akhir = $body['tgl_akhir'];

            $pdf = Pdf::loadView('laporan_keuangan/reportFinance', compact('data', 'kota', 'total', 'tgl_awal', 'tgl_akhir'))->setPaper('a4', 'landscape');
            return $pdf->download('ReportFinance-' . Date('m-Y') . '.pdf');
        } else {
            $data = [];
            $message = $response['data']['message'];
            return back()->withInput()->with('message', $message);
        }
    }
}
