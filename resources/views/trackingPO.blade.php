@extends('layouts.master')

@section('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection

<style>
    table{
        font-size:10px;
    }
    .req{
        background-color: #FFF7D1 !important;
        text-align: center;
 
    }
    .prog{
        background-color: #E2F1E7 !important;
        text-align: center;
      
    }

    td{
    
        text-align: center;
    }
    .badges {
        background-color: #FFD09B;
        color: black;
        padding: 2px 5px;
        border-radius: 5px;
        display: inline-block;
        text-align: center;
        font-size: 10px;
    }
</style>

@section('content')

<div class="card mb-3">
    <div class="container-fluid mt-3">
        <div class="table-responsive">
<table class="table table-bordered dt-responsive nowrap align-middle" style="width:100%; padding:5px">
    <thead>
        <tr class="text-center">
            <th colspan="6" style="background-color: #FFF7D1;">Purchase Order</th>
            <th colspan="6" style="background-color: #E2F1E7;">Dalam Pengiriman</th>
            <th  rowspan="2" style="background-color: #E78F81; width: auto; white-space: nowrap;" class="align-middle">Out Standing</th>
            <th  rowspan="2" style="background-color: #B7E0FF; width: auto; white-space: nowrap; " class="align-middle">Status</th>
        </tr>
        <tr>   
            <th class="req" style="width: auto; white-space: nowrap;">No PO</th>
            <th class="req" style="width: auto; white-space: nowrap;">Kode Barang</th>
            <th class="req" style="width: auto; white-space: nowrap;">Nama Barang</th>
            <th class="req" style="width: auto; white-space: nowrap;">Qty</th>
            <th class="req" style="width: auto; white-space: nowrap;">Satuan</th>
            <th class="req" style="width: auto; white-space: nowrap;">Terima</th>
            <th class="prog" style="width: auto; white-space: nowrap;">No DO</th>
            <th class="prog" style="width: auto; white-space: nowrap;">Estimasi Kedatangan</th> 
            <th class="prog" style="width: auto; white-space: nowrap;">Waktu Kedatangan</th>
            <th class="prog" style="width: auto; white-space: nowrap;">Qty Kirim</th>
            <th class="prog" style="width: auto; white-space: nowrap;">Qty Terima</th>
            <th class="prog" style="width: auto; white-space: nowrap;">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($displayPO as $item)
        <tr>
            {{-- Initialize variables to store concatenated details --}}
            @php
                $noDOs = '';
                $etas = '';
                $qtyDOs = '';
                $ActualTA = '';
                $ActualQty = '';
                $statuses = ''; // Handle multiple statuses
                $outstanding = null; // Only show one outstanding value
            @endphp
    
            {{-- Concatenate all the NoDO, ETA, QtyDO, Status, and Outstanding values --}}
            @foreach ($item['details'] as $detail)
                @php
                    $noDOs .= $detail['NoDO'] . '<br>';
                    $etas .= $detail['ETA'] . '<br>';
                    $qtyDOs .= $detail['QtyDO'] . '<br>';
                    $ActualTA .= $detail['ActualTA'] . '<br>';
                    $ActualQty .= $detail['ActualQty'] . '<br>';
                    $statuses .= $detail['Status'] . '<br>';  // Concatenate statuses
                    
                    // Set the first encountered outstanding value (only once)
                    if (is_null($outstanding)) {
                        $outstanding = $detail['Outstanding'];
                    }
                @endphp
            @endforeach
    
            <td style="width: auto; white-space: nowrap;">{{$item['NoFaktur']}}</td>
            <td style="width: auto; white-space: nowrap;">{{$item['KodeBarang']}}</td>
            <td style="width: auto; white-space: nowrap;">{{$item['NamaBarang']}}</td>
            <td style="width: auto; white-space: nowrap;">{{$item['Qty']}}</td>
            <td style="width: auto; white-space: nowrap;">{{$item['Satuan']}}</td>
            <td style="width: auto; white-space: nowrap;">{!! $ActualQty !!}</td>
            <td style="width: auto; white-space: nowrap;">{!! $noDOs !!}</td>
            <td style="width: auto; white-space: nowrap;">{!! $etas !!}</td>
            <td style="width: auto; white-space: nowrap;">{!! $ActualTA !!}</td>
            <td style="width: auto; white-space: nowrap;">{!! $qtyDOs !!}</td>
            <td style="width: auto; white-space: nowrap;">{!! $ActualQty !!}</td>
    
            {{-- Status logic: handle multiple statuses --}}
            <td style="width: auto; white-space: nowrap;">
                @foreach (explode('<br>', $statuses) as $status)
                    @if (trim($status) === 'N')
                        <span class="badge bg-warning mb-1">{!! 'Dalam Pengiriman' !!}</span><br>
                    @elseif (trim($status) === 'Y')
                        <span class="badge bg-success">{!! 'Selesai' !!}</span><br>
                    @endif
                @endforeach
            </td>
    
            {{-- Display the outstanding value only once --}}
            <td style="width: auto; white-space: nowrap;">{!! $outstanding !!}</td>
    
            {{-- Check outstanding for badge logic --}}
            <td style="width: auto; white-space: nowrap;">
                @if ($outstanding > 0)
                    <span class="badge bg-warning">{!! 'On Progress' !!}</span>
                @elseif ($outstanding == 0)
                <span class="badge bg-primary">{!! 'Belum Diproses' !!}</span>
                @elseif($outstanding == null)
                <span class="badge bg-success">{!! 'Selesai' !!}</span>
                @endif
            </td>
        </tr>
    @endforeach
    
    
    </tbody>
</table>

            
        </div>
    </div>
</div>

@endsection
@section('script')
    <script></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ URL::asset('assets/libs/prismjs/prismjs.min.js') }}"></script>
    <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
    <script src="{{ URL::asset('assets/js/pages/modal.init.js') }}"></script>


    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="{{ URL::asset('assets/js/pages/form-wizard.init.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection