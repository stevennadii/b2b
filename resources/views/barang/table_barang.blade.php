@extends('layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <!--datatable responsive css-->
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Table Customers</h4>
                  
                </div>
                <div class="card-body">
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-block">
                            <strong>{{ session('message') }}</strong>
                        </div>
                    @endif

                    <h4>Master Barang</h4>
                   <div class="mb-3">
                     <form action="{{ url('/barang/master') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="kode_barang">
                                        <label>Kode Barang</label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="nama">
                                        <label>Nama Barang</label>
                                    </div>
                                </div>
                                 <div class="col-lg-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="satuan">
                                        <label>Satuan</label>
                                    </div>
                                </div>
                                  <div class="col-lg-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="harga_beli">
                                        <label>Harga Beli</label>
                                    </div>
                                </div>
                            </div>
                        

                            <button class="btn btn-primary mt-2">Simpan</button>
                        </div>
                    </form>
                   </div>

                    <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Kode Barang</th>
                                <th>Nama</th>
                                <th>Satuan</th>
                                <th>Harga Beli</th>
                                <th>Stok</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stok as $item)
                                <tr>
                                    <td><a href="#" class="btn btn-info btn-sm">Update</a></td>
                                    <td>{{ $item['Kode_Barang'] ?? '-' }}</td>
                                    <td>{{ $item['Nama'] ?? '-' }}</td>
                                    <td>{{ $item['Satuan'] ?? '-' }}</td>
                                    <td>{{ $item['Harga_Beli'] ?? 0 }}</td>
                                    <td>{{ $item['Stok'] ?? 0 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('script')
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
