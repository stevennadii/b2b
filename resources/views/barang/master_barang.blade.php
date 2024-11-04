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
        <div class="col-md12">
            <div class="card">
                <div class="card-body">
                    {{-- @if (session()->has('message'))
                        <div class="alert alert-success alert-block">
                            <strong>{{ session('message') }}</strong>
                        </div>
                    @endif
                 
                    <h4>Master Barang</h4>
                    <form action="{{ url('/barang/master') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="kode_barang">
                                        <label>Kode Barang</label>
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="nama">
                                        <label>Nama Barang</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="satuan">
                                        <label>Satuan</label>
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="harga_beli">
                                        <label>Harga Beli</label>
                                    </div>
                                </div>

                            </div>

                            <button class="btn btn-primary mt-2">Simpan</button>
                        </div>
                    </form> --}}
                </div>
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
