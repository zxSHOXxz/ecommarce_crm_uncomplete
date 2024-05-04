@extends('layouts.admin')
@section('content')
    <div class="col-12 p-3 row">
        @can('users-read')
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 col-xxl-2 px-2 my-2">
                <div class="col-12 px-0 py-1 d-flex main-box-wedit">
                    <div style="width: 65px;" class="p-2">
                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                            style="background: #0194fe;color: #fff;border-radius: 50%;width: 55px;height:55px">
                            <span class="fal fa-users font-5"></span>
                        </div>
                    </div>
                    <div style="width: calc(100% - 80px)" class="px-2 py-2">
                        <a class="font-1" href="{{ route('admin.customers.index') }}" style="color: #212529">
                            Customers
                            <h6 class="font-3">{{ \App\Models\Customer::count() }}</h6>
                        </a>
                    </div>
                </div>
            </div>
        @endcan
        @can('categories-read')
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 col-xxl-2 px-2 my-2">
                <div class="col-12 px-0 py-1 d-flex main-box-wedit">
                    <div style="width: 65px;" class="p-2">
                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                            style="background: #0194fe;color: #fff;border-radius: 50%;width: 55px;height:55px">
                            <span class="fal fa-tags font-5"></span>
                        </div>
                    </div>
                    <div style="width: calc(100% - 80px)" class="px-2 py-2">
                        <a class="font-1" href="{{ route('admin.categories.index') }}" style="color: #212529">
                            Categories
                            <h6 class="font-3">{{ \App\Models\Category::count() }}</h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 col-xxl-2 px-2 my-2">
                <div class="col-12 px-0 py-1 d-flex main-box-wedit">
                    <div style="width: 65px;" class="p-2">
                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                            style="background: #0194fe;color: #fff;border-radius: 50%;width: 55px;height:55px">
                            <span class="fa-solid fa-cart-flatbed-boxes font-5"></span>
                        </div>
                    </div>
                    <div style="width: calc(100% - 80px)" class="px-2 py-2">
                        <a class="font-1" href="{{ route('admin.products.index') }}" style="color: #212529">
                            Products
                            <h6 class="font-3">{{ \App\Models\Product::count() }}</h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 col-xxl-2 px-2 my-2">
                <div class="col-12 px-0 py-1 d-flex main-box-wedit">
                    <div style="width: 65px;" class="p-2">
                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                            style="background: #0194fe;color: #fff;border-radius: 50%;width: 55px;height:55px">
                            <span class="fa-solid fa-user font-5"></span>
                        </div>
                    </div>
                    <div style="width: calc(100% - 80px)" class="px-2 py-2">
                        <a class="font-1" href="{{ route('admin.users.index') }}" style="color: #212529">
                            Admins
                            <h6 class="font-3">{{ \App\Models\User::count() }}</h6>
                        </a>
                    </div>
                </div>
            </div>
        @endcan
        @can('orders-read')
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 col-xxl-2 px-2 my-2">
                <div class="col-12 px-0 py-1 d-flex main-box-wedit">
                    <div style="width: 65px;" class="p-2">
                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                            style="background: #0194fe;color: #fff;border-radius: 50%;width: 55px;height:55px">
                            <span class="fa-solid fa-cart-arrow-down font-4"></span>
                        </div>
                    </div>
                    <div style="width: calc(100% - 80px)" class="px-2 py-2">
                        <a class="font-1" href="{{ route('admin.orders.index') }}" style="color: #212529">
                            {{ __('admin.orders') }}
                            @if (auth('customer')->user() != null)
                                <h6 class="font-3">
                                    {{ \App\Models\Order::where('customer_id', auth('customer')->id())->count() }}</h6>
                            @else
                                <h6 class="font-3">{{ \App\Models\Order::count() }}</h6>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        @endcan


        <div class="row">
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 col-xxl-2 px-2 my-2">
                <div class="col-12 px-0 py-1 d-flex main-box-wedit" style="background: #ffc107;">
                    <div style="width: 65px;" class="p-2">
                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                            style="background: #ffc107;color: #fff;border-radius: 50%;width: 55px;height:55px">
                            <span class="fa-solid fa-bell font-4"></span>
                        </div>
                    </div>
                    <div style="width: calc(100% - 80px)" class="px-2 py-2">
                        <a class="font-1" href="{{ route('admin.orders.index') }}" style="color: #ffffff">
                            {{-- {{ __('admin.orders') }} --}}
                            Pending Orders
                            <h6 class="font-3">
                                {{ \App\Models\Order::where('status', 'pending')->count() }}</h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 col-xxl-2 px-2 my-2">
                <div class="col-12 px-0 py-1 d-flex main-box-wedit" style="background: #ff0707;">
                    <div style="width: 65px;" class="p-2">
                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                            style="background: #ff0707;color: #fff;border-radius: 50%;width: 55px;height:55px">
                            <span class="fa-solid fa-ban font-4"></span>
                        </div>
                    </div>
                    <div style="width: calc(100% - 80px)" class="px-2 py-2">
                        <a class="font-1" href="{{ route('admin.orders.index') }}" style="color: #ffffff">
                            {{-- {{ __('admin.orders') }} --}}
                            Failed Orders
                            <h6 class="font-3">
                                {{ \App\Models\Order::where('status', 'failed')->count() }}</h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 col-xxl-2 px-2 my-2">
                <div class="col-12 px-0 py-1 d-flex main-box-wedit" style="background: #6610f2;">
                    <div style="width: 65px;" class="p-2">
                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                            style="background: #6610f2;color: #fff;border-radius: 50%;width: 55px;height:55px">
                            <span class="fa-solid fa-users-gear font-4"></span>
                        </div>
                    </div>
                    <div style="width: calc(100% - 80px)" class="px-2 py-2">
                        <a class="font-1" href="{{ route('admin.customers.index') }}" style="color: #ffffff">
                            {{-- {{ __('admin.orders') }} --}}
                            Pending Customers
                            <h6 class="font-3">
                                {{ \App\Models\Customer::where('blocked', true)->count() }}</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 col-xxl-2 px-2 my-2">
                <div class="col-12 px-0 py-1 d-flex main-box-wedit" style="background: #6f42c1;">
                    <div style="width: 65px;" class="p-2">
                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                            style="background: #6f42c1;color: #fff;border-radius: 50%;width: 55px;height:55px">
                            <span class="fa-solid fa-dollar-sign font-4"></span>
                        </div>
                    </div>
                    <div style="width: calc(100% - 80px)" class="px-2 py-2">
                        <a class="font-1" href="{{ route('admin.orders.index') }}" style="color: #ffffff">
                            This Week Orders
                            <h6 class="font-3">
                                {{ \App\Models\Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count() }}
                            </h6>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 col-xxl-2 px-2 my-2">
                <div class="col-12 px-0 py-1 d-flex main-box-wedit" style="background: #07a8ff;">
                    <div style="width: 65px;" class="p-2">
                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                            style="background: #07a8ff;color: #fff;border-radius: 50%;width: 55px;height:55px">
                            <span class="fa-solid fa-boombox font-4"></span>
                        </div>
                    </div>
                    <div style="width: calc(100% - 80px)" class="px-2 py-2">
                        <a class="font-1" href="{{ route('admin.orders.index') }}" style="color: #ffffff">
                            {{-- {{ __('admin.orders') }} --}}
                            Waiting Orders
                            <h6 class="font-3">
                                {{ \App\Models\Order::where('status', 'waiting')->count() }}</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12 row p-0 d-flex">
            <div class="col-12 col-lg-4 p-2">
                <div class="col-12 p-0 main-box">
                    <div class="col-12 px-0">
                        <div class="col-12 px-3 py-3">
                            Quick Links
                        </div>
                        <div class="col-12 " style="min-height: 1px;background: var(--border-color);"></div>
                    </div>
                    <div class="col-12 p-3 row d-flex">
                        <div class="col-4 d-flex justify-content-center align-items-center mb-3 py-2">
                            <a href="{{ route('admin.profile.index') }}" style="color:inherit;">
                                <div class="col-12 p-0 text-center">
                                    <img src="/images/icons/man.png" style="width:30px;height: 30px">
                                    {{-- <span class="fal fa-user font-5" ></span> --}}
                                    <div class="col-12 p-0 text-center">
                                        Profile
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-4 d-flex justify-content-center align-items-center mb-3 py-2">
                            <a href="{{ route('admin.profile.edit') }}" style="color:inherit;">
                                <div class="col-12 p-0 text-center">
                                    <img src="/images/icons/edit.png" style="width:30px;height: 30px">
                                    {{-- <span class="fal fa-user-edit font-5" ></span> --}}
                                    <div class="col-12 p-0 text-center">
                                        Edit Profile
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-4 d-flex justify-content-center align-items-center mb-3 py-2">
                            <a href="#"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                style="color:inherit;">
                                <div class="col-12 p-0 text-center">

                                    <img src="/images/icons/logout.png" style="width:30px;height: 30px">
                                    {{-- <span class="fal fa-sign-out-alt font-5" ></span> --}}
                                    <div class="col-12 p-0 text-center">
                                        Exit
                                    </div>
                                </div>
                            </a>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
