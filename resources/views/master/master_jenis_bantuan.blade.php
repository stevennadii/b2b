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
                    <h4>Form Tambah Data Jenis Bantuan</h4>
                </div>
                <div class="card-body">
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-block">
                            <strong>{{ session('message') }}</strong>
                        </div>
                    @endif

                    <form action="{{ url('master-jenis-bantuan/store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="kode_bantuan">
                                    <label>Kode Bantuan</label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="jenis_bantuan">
                                    <label>Jenis Bantuan</label>
                                </div>
                            </div>

                            <div class="col-lg-4">

                                <div class="form-floating">
                                    <select name="flag_rp" class="form-select" id="floatingSelect"
                                        aria-label="Floating label select example">
                                        <option value="Y">Y</option>
                                        <option value="T">T</option>
                                    </select>
                                    <label for="floatingSelect">Flag Rp</label>
                                </div>
                            </div>

                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary w-100">Simpan Jenis Bantuan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Table Jenis Bantuan</h4>
                </div>
                <div class="card-body">
                    <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>Kode Jenis</th>
                                <th>Jenis Bantuan</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item['kode_jenis'] }}</td>
                                    <td>{{ $item['nama_jenis'] }}</td>
                                    <td><button onclick="hapusData({{ $item['id_jenis'] }})"
                                            class="btn btn-danger btn-sm">Hapus</button></td>
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
    <script>
        function hapusData(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "http://192.168.11.9:8000/api/jenis_bantuan/delete/"+id,
                        type: 'post',
                        dataType: 'JSON',
                        headers: {
                            'Content-Type' : 'application/json',
                            'Authorization' : "Bearer {{ $user }}"
                        },
                        data: {
                            'id': id
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            )
                            setTimeout(() => {
                                location.reload();
                            }, 700);
                        }
                    })
                }
            })
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="{{ URL::asset('assets/js/pages/form-wizard.init.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
