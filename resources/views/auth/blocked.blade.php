    @extends('layouts.app')
    @section('content')
        <style type="text/css">
            .form-control.is-invalid,
            .was-validated .form-control:invalid {
                border-color: #dc3545 !important;
                background-color: rgb(255 184 184 / 41%) !important;
                padding-left: calc(1.5em + 0.75rem);
                background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e) !important;
                background-repeat: no-repeat;
                background-position: left calc(0.375em + 0.1875rem) center;
                background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
            }

            body {
                background: #fff !important;
                height: 100vh;
                overflow: hidden;
            }
        </style>

        <div class="container">
            <div class="text-center">
                @auth
                    <h2>Hello {{ Auth::guard('customer')->name }}</h2>

                @endauth
                <h2>Registration Successful</h2>
                <p>Your account has been registered successfully. An administrator will review your account shortly.</p>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Logout</button>
                </form>
            </div>
        </div>
    @endsection
