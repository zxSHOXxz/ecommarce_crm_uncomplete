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
        }

        * {
            direction: ltr !important;
        }
    </style>

    <div class="container p-0">
        <div class="col-12 p-0 row d-flex">
            <div class="col-12 col-lg-6 text-center p-0" style="">
                <div class="col-12 p-2 p-lg-4 align-items-center justify-content-center d-flex row" style="min-height:70vh">
                    <div class="col-12 p-3 p-lg-4" style="background:#fff;border-radius: 10px;">
                        <form method="POST" action="{{ route('login') }}" class="row m-0">
                            @csrf

                            <div class="col-12 p-0 mb-5 mt-3" style="width: 550px;max-width: 100%;margin: 0px auto;">
                                <h3 class="mb-4 font-4">{{ Str::upper(__('lang.login')) }}</h3>

                            </div>

                            <div class="nafezly-divider-right"
                                style="    background-image: linear-gradient( 90deg,transparent,rgb(0 0 0/72%));right: auto;left: 10px;opacity: .1;margin: 14px 0;min-height: 2px;">
                            </div>


                            <div class="form-group row mb-4 col-12 col-lg-6   px-0 pt-2 ">
                                <div class="col-md-12 px-2 pt-4" style="position: relative;">
                                    <label for="email"
                                        class="col-form-label text-md-right mb-1 font-small px-2 py-1 d-inline"
                                        style="background:#f4f4f4;position: absolute;top: 17px;right: 20px; border-radius: 3px!important">
                                        Email
                                    </label>
                                    <input id="email" type="email"
                                        class="form-control mt-2 d-inline-block @error('email') is-invalid @enderror"
                                        name="email" value="" required="" autocomplete="off" autofocus=""
                                        style=";height: 42px;border-color: #eaedf1;border-radius: 3px!important"
                                        value="{{ old('email') }}">
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group row mb-4 col-12 col-lg-6   px-0 pt-2 ">
                                <div class="col-md-12 px-2 pt-4" style="position: relative;">
                                    <label for="password"
                                        class="col-form-label text-md-right mb-1 font-small px-2 py-1 d-inline"
                                        style="background:#f4f4f4;position: absolute;top: 17px;right: 20px;border-radius: 3px!important">
                                        Password
                                    </label>
                                    <input id="password" type="password"
                                        class="form-control mt-2 d-inline-block @error('password') is-invalid @enderror"
                                        name="password" value="" required="" autocomplete="off" autofocus=""
                                        style=";height: 42px;border-color: #eaedf1;border-radius: 3px!important"
                                        minlength="6" aria-invalid="true">
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>






                            <div class="col-12 p-0 row d-flex align-items-center">
                                <div class="col-12 col-lg-6 p-2">
                                    <div class="form-group row ">
                                        <div class="col-12 p-0">
                                            <input class="form-check-input ms-2 me-0" type="checkbox" name="remember"
                                                id="remember"
                                                {{ old('remember') || old('remember') == null ? 'checked' : '' }}
                                                style="position:relative;height: 20px;width: 20px;cursor: pointer;">

                                            <label class="form-check-label" for="remember"
                                                style="position:relative;cursor: pointer;">
                                                {{ Str::upper(__('lang.remember_me')) }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 p-2 ">
                                    <div class="form-group row mb-0 ">
                                        <div class="col-12 p-0 d-flex justify-content-lg-end">
                                            <button type="submit" class="btn btn-success font-1">
                                                {{ Str::upper(__('lang.login')) }}
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
