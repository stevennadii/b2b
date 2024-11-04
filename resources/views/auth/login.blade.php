@extends('layouts.master-without-nav')
@section('title')
    @lang('translation.signin')
@endsection
@section('content')
<div class="auth-page-wrapper pt-5">
    <!-- auth page bg -->
    <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
        <div class="bg-overlay"></div>

        <div class="shape">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 0 1440 120">
                <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
            </svg>
        </div>
    </div>

    <!-- auth page content -->
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center  text-white-50">
                        <div>
                            <a class="d-inline-block auth-logo">
                                <img style="border-radius: 10px !important" src="" alt="" height="100">
                            </a>
                        </div>
                        <p class="mt-3 fs-15 fw-medium">B2B - Dashboard</p>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-12 col-xl-12">
                    <div class="card mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                {{-- <img src="..public\assets\images\evolemari.jpg" alt=""> --}}
                            </div>
                            <div class="col-md-6">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-end">
                                        <img src="https://evopet.id/images/6e87bfd5a36792ce4e956d5165c852f4.jpg" width="70px">
                                    </div>
                                    <div class=" mt-2">
                                        <h5 class="text-primary">Selamat Datang</h5>
                                        <p class="text-muted">Silakan Login</p>
                                    </div>
                                    <div class="p-2 mt-4">
                                        @if (session()->has('message'))
                                            <div class="alert alert-success alert-block">
                                                <strong>{{ session('message') }}</strong>
                                            </div>
                                        @endif
    
                                        <!-- Form login dikirim ke route proses_login -->
                                        <form method="POST" action="{{ route('proses_login') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                <label for="username" class="form-label">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" >
                                            </div>
    
                                            <div class="mb-3">
                                                <label class="form-label" for="password-input">Password</label>
                                                <div class="position-relative auth-pass-inputgroup mb-3">
                                                    <input type="password" class="form-control pe-5" name="password" placeholder="Enter password" id="password-input">
                                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <button class="btn btn-success w-100" type="submit">Sign In</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->

    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="mb-0 text-muted">&copy;
                            <script>
                                document.write(new Date().getFullYear())
                            </script> B2B - Dashboard. Crafted with <i class="mdi mdi-heart text-danger"></i> by
                            Evo Nusa
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->
</div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/particles.js/particles.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/particles.app.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/password-addon.init.js') }}"></script>
@endsection
