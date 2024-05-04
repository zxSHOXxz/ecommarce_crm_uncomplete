<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/dashboard.css')
    <link rel="stylesheet" href="{{ asset('css/dir-ltr.css') }}">
    <style type="text/css">
        html {
            --background-0: #eef4f5;
            --background-1: #fff;
            --background-aside: #11233b;
            --background-active-link: #141e2e;
            --background-form-control-focus: #161d26;
            --color-1: #fff;
            --color-2: #575f66;
            --border-color: #f1f1f1;
            --bs-table-hover-color: #f7f7f7 !important;
        }
    </style>
    @php
        $page_title = 'Dashboard';
    @endphp
    @include('seo.index')
    @livewireStyles
    @yield('styles')
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css">
    @if (auth()->check())
        @php
            if (session('seen_notifications') == null) {
                session(['seen_notifications' => 0]);
            }
            $notifications = auth()->user()->notifications()->orderBy('created_at', 'DESC')->limit(50)->get();
            $unreadNotifications = auth()->user()->unreadNotifications()->count();
        @endphp
    @endif
    @if ($settings['dashboard_dark_mode'] == '1')
        <style type="text/css">
            html {

                --background-0: #131923;
                --background-1: #1c222b;
                --background-aside: #11233b;
                --background-active-link: #141e2e;
                --background-form-control-focus: #161d26;

                --color-1: #fff;
                --color-2: #f1f1f1;
                --border-color: #282b2f;
                --bs-table-hover-color: #f7f7f7 !important;
            }

            .select2-dropdown,
            .select2-container--default .select2-selection--multiple,
            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                background-color: var(--background-0) !important;
            }

            td,
            th {
                border-color: var(--border-color) !important;
            }

            .aside {
                background: #171f2a !important;
            }

            .aside * {
                color: var(--color-1) !important;
            }

            .aside .item-container.active {
                background: #192230 !important;
                box-shadow: 0px 12px 17px #101d30 !important;
                border-bottom: unset !important;
            }

            .aside .item-container.active * {
                color: #38b59c !important;
            }

            .sub-item.active a.active *,
            .sub-item.active a.active {
                color: #38b59c !important;
            }

            #home-dashboard-divider {
                background: #0194fe !important;
            }

            body {
                color: var(--color-1) !important;
                background: #131923 !important;
            }

            .main-box-wedit {
                box-shadow: unset;
                border-radius: 10px 25px 10px 25px;
                background: #1c222b !important;
            }

            .main-box-wedit a {
                color: #f1f1f1 !important;
            }

            .main-box {
                background: #1c222b !important;
                box-shadow: unset !important;
            }

            .btn {
                color: var(--color-2) !important;
            }

            table {
                color: var(--color-2) !important;
                border-color: var(--border-color) !important;
            }

            thead th {
                border-color: var(--border-color) !important;
            }

            .table-hover>tbody>tr:hover {}

            *,
            .dropdown-item {
                color: var(--color-1);
            }

            .dropdown-menu {
                background-color: var(--background-1) !important;
            }

            .dropdown-item:focus,
            .dropdown-item:hover {
                color: var(--color-1);
                background-color: var(--background-2) !important;
            }

            *[class*='border-'] {
                border-color: var(--border-color) !important;
            }

            hr {
                background: var(--border-color);
            }

            .form-control {
                background: rgb(39 38 37 / 20%);
                border-color: #8c6934;
            }

            .form-control {
                background: var(--background-1);
                border-color: var(--border-color);
            }

            .form-control:focus {
                box-shadow: unset !important;
                border: 1px solid #ff9800 !important;
                background: #0e0d0c !important;
            }

            /*.form-control:focus {
            box-shadow: unset!important;
            border: 1px solid var(--border-color)!important;
            background: var(--background-form-control-focus)!important;
        } */

            .form-control,
            .form-control:focus {
                color: var(--color-1);
            }

            .settings-tab-opener.active,
            .settings-tab-opener {
                box-shadow: unset !important;
            }

            .breadcrumb-item+.breadcrumb-item:before {
                float: left !important;
            }
        </style>
    @endif

    <style>
        table.table th {
            font-family: kufi-arabic, sans-serif !important;
            text-transform: uppercase;
        }
    </style>
</head>

<body style="background: #eef4f5" class="dash">
    <style type="text/css">
        #toast-container>div {
            opacity: 1;
        }

        .phpdebugbar * {
            direction: ltr !important
        }
    </style>
    @yield('after-body')
    <div class="col-12 justify-content-end d-flex">
        @if ($errors->any())
            <div class="col-12" style="position: absolute;top: 80px;right: 10px;">
                {!! implode(
                    '',
                    $errors->all(
                        '<div class="alert-click-hide alert alert-danger alert alert-danger col-9 col-xl-3 rounded-0 mb-1" style="position: fixed!important;z-index: 901;opacity:.9;right:25px;top:120px;cursor:pointer;" onclick="$(this).fadeOut();">:message</div>',
                    ),
                ) !!}
            </div>
        @endif
    </div>


    <form method="POST" action="{{ route('logout') }}" id="logout-form" class="d-none">@csrf</form>
    <div class="col-12 d-flex">
        <div style="width: 260px;background: #ddeaea;min-height: 100vh;position: fixed;z-index: 900"
            class="aside active">
            <div class="col-12 px-0 d-flex" style="height: 55px">
                <div class="col-12 p-1" style="color: var(--background-1)">
                    <div class="col-12 p-0 row">
                        <div class="col-3 py-1 px-1">
                            {{-- <span class="fas fa-chart-bar font-4 d-flex justify-content-center align-items-center" style="background: #38b59c;height: 40px;width: 40px;border-radius: 50%;color: var(--background-1);"></span> --}}
                        </div>
                        <div class="col-9 ">
                            <span class="d-inline-block px-2 font-3 pt-1"></span>
                            <span
                                style="width: 55px;height: 55px;position: absolute;left: 0px;top: 0px;align-items: center;justify-content: center;cursor: pointer;"
                                class="asideToggle d-flex d-md-none rounded-0">
                                <span class="fal fa-bars font-4 "></span>
                            </span>
                        </div>
                    </div>
                    <div class="d-none d-md-none justify-content-center align-items-center px-0   asideToggle"
                        style="width: 40px;height: 40px;">
                        <span class="fal fa-bars font-4 cursor-pointer"></span>
                    </div>
                </div>
            </div>
            <div class="col-12 px-0 pb-4 text-center justify-content-center align-items-center ">
                <a href="{{ route('admin.profile.edit') }}">

                    <img src="{{ auth()->user()->getUserAvatar() }}"
                        style="width: 80px;height: 80px;color: var(--background-1);border-radius: 50%"
                        class="d-inline-block">
                </a>
                <div class="col-12 px-0 mt-2 text-center" style="color: #232323;">
                    {{ __('admin.hello') }} {{ auth()->user()->name }}
                </div>
            </div>
            <div class="col-12 px-0">
                <div class="col-12 px-3 aside-menu" style="height: calc(100vh - 260px);overflow: auto;">

                    <a href="{{ route('admin.index') }}" class="col-12 px-0">
                        <div class="col-12 item-container px-0 d-flex">
                            <div style="width: 50px" class="px-3 text-center">
                                <span class="fal fa-home font-2"> </span>
                            </div>
                            <div style="width: calc(100% - 50px)" class="px-2 item-container-title">
                                {{ __('admin.home') }}
                            </div>
                        </div>
                    </a>
                    @if (Auth::guard('customer')->user() != null)
                        {{-- @can('orders-read', 'App\\Models\Customer') --}}
                        <a href="{{ route('admin.customer_orders') }}" class="col-12 px-0">
                            <div class="col-12 item-container px-0 d-flex ">
                                <div style="width: 50px" class="px-3 text-center">
                                    <span class="fa-solid fa-cart-arrow-down"></span>
                                </div>
                                <div style="width: calc(100% - 50px)" class="px-2 item-container-title">
                                    {{ __('admin.orders') }}
                                </div>
                            </div>
                        </a>
                        {{-- @endcan --}}
                    @endif
                    @if (Auth::guard('web')->user() != null)
                        {{-- @can('roles-read')
                            <a href="{{ route('admin.roles.index') }}" class="col-12 px-0">
                                <div class="col-12 item-container px-0 d-flex ">
                                    <div style="width: 50px" class="px-3 text-center">
                                        <span class="fal fa-key font-2"> </span>
                                    </div>
                                    <div style="width: calc(100% - 50px)" class="px-2 item-container-title">
                                        {{ __('admin.permissions') }}
                                    </div>
                                </div>
                            </a>
                        @endcan --}}

                        @can('users-read')
                            <a href="{{ route('admin.users.index') }}" class="col-12 px-0">
                                <div class="col-12 item-container px-0 d-flex ">
                                    <div style="width: 50px" class="px-3 text-center">
                                        <span class="fal fa-user font-2"> </span>
                                    </div>
                                    <div style="width: calc(100% - 50px)" class="px-2 item-container-title">
                                        {{ __('admin.admin') }}
                                    </div>
                                </div>
                            </a>
                        @endcan

                        <style>
                            .item-container .item-container-title.has-sub-menu:after {
                                content: "\f107";
                                font-family: "Font Awesome 5 Pro";
                                width: 20px;
                                height: 20px;
                                display: flex;
                                left: 85%;
                                top: 4px;
                                position: absolute;
                                align-items: center;
                                justify-content: center;
                                justify-items: center;
                                font-size: 12px
                            }
                        </style>
                        @can('customers-read')
                            <div class="col-12 px-0" style="cursor: pointer;">
                                <div class="col-12 item px-0 d-flex row ">
                                    <div class="col-12 d-flex px-0 item-container">
                                        <div style="width: 50px" class="px-3 text-center">
                                            <span class="fal fa-users font-2"> </span>
                                        </div>
                                        <div style="width: calc(100% - 50px)"
                                            class="px-2 item-container-title has-sub-menu">
                                            {{ __('admin.customers') }}
                                        </div>
                                    </div>
                                    <div class="col-12 px-0">
                                        <ul class="sub-item font-1" style="list-style:none;">
                                            <li><a href="{{ route('admin.customers.index') }}"
                                                    style="font-size: 16px;"><span class="fal fa-eye px-2"
                                                        style="width: 28px;font-size: 15px;"></span>
                                                    {{ __('admin.showCustomers') }}
                                                </a></li>
                                            <li><a href="{{ route('admin.customers.create') }}"
                                                    style="font-size: 16px;"><span class="fal fa-plus px-2"
                                                        style="width: 28px;font-size: 15px;"></span>
                                                    {{ __('admin.addCustomers') }}
                                                </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endcan
                        @can('categories-read')
                            <div class="col-12 px-0" style="cursor: pointer;">
                                <div class="col-12 item px-0 d-flex row ">
                                    <div class="col-12 d-flex px-0 item-container">
                                        <div style="width: 50px" class="px-3 text-center">
                                            <span class="fal fa-tags font-2"> </span>
                                        </div>
                                        <div style="width: calc(100% - 50px)"
                                            class="px-2 item-container-title has-sub-menu">
                                            {{ __('admin.categories') }}
                                        </div>
                                    </div>
                                    <div class="col-12 px-0">
                                        <ul class="sub-item font-1" style="list-style:none;">
                                            <li><a href="{{ route('admin.categories.index') }}"
                                                    style="font-size: 16px;"><span class="fal fa-eye px-2"
                                                        style="width: 28px;font-size: 15px;"></span>
                                                    {{ __('admin.showCategory') }}
                                                </a></li>
                                            <li><a href="{{ route('admin.categories.create') }}"
                                                    style="font-size: 16px;"><span class="fal fa-plus px-2"
                                                        style="width: 28px;font-size: 15px;"></span>
                                                    {{ __('admin.addCategory') }}
                                                </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endcan
                        @can('products-read')
                            <div class="col-12 px-0" style="cursor: pointer;">
                                <div class="col-12 item px-0 d-flex row ">
                                    <div class="col-12 d-flex px-0 item-container">
                                        <div style="width: 50px" class="px-3 text-center">
                                            <i class="fa-solid fa-cart-flatbed-boxes"></i>
                                        </div>
                                        <div style="width: calc(100% - 50px)"
                                            class="px-2 item-container-title has-sub-menu">
                                            {{ __('admin.products') }}
                                        </div>
                                    </div>
                                    <div class="col-12 px-0">
                                        <ul class="sub-item font-1" style="list-style:none;">
                                            <li><a href="{{ route('admin.products.index') }}"
                                                    style="font-size: 16px;"><span class="fal fa-eye px-2"
                                                        style="width: 28px;font-size: 15px;"></span>
                                                    {{ __('admin.showProducts') }}
                                                </a></li>
                                            <li><a href="{{ route('admin.products.create') }}"
                                                    style="font-size: 16px;"><span class="fal fa-plus px-2"
                                                        style="width: 28px;font-size: 15px;"></span>
                                                    {{ __('admin.addProducts') }}
                                                </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endcan

                        @can('orders-read')
                            <div class="col-12 px-0" style="cursor: pointer;">
                                <div class="col-12 item px-0 d-flex row ">
                                    <div class="col-12 d-flex px-0 item-container">
                                        <div style="width: 50px" class="px-3 text-center">
                                            <span class="fa-solid fa-cart-arrow-down"></span>
                                        </div>
                                        <div style="width: calc(100% - 50px)"
                                            class="px-2 item-container-title has-sub-menu">
                                            {{ __('admin.orders') }}
                                        </div>
                                    </div>
                                    <div class="col-12 px-0">
                                        <ul class="sub-item font-1" style="list-style:none;">
                                            <li><a href="{{ route('admin.orders.index') }}"
                                                    style="font-size: 16px;"><span class="fal fa-eye px-2"
                                                        style="width: 28px;font-size: 15px;"></span>
                                                    {{ __('admin.showOrders') }}
                                                </a></li>
                                            <li><a href="{{ route('admin.orders.create') }}"
                                                    style="font-size: 16px;"><span class="fal fa-eye px-2"
                                                        style="width: 28px;font-size: 15px;"></span>
                                                    {{ __('admin.createOrder') }}
                                                </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endcan
                    @endif

                    {{-- @can('settings-update')
                        <a href="{{ route('admin.settings.index') }}" class="col-12 px-0">
                            <div class="col-12 item-container px-0 d-flex ">
                                <div style="width: 50px" class="px-3 text-center">
                                    <span class="fal fa-wrench font-2"> </span>
                                </div>
                                <div style="width: calc(100% - 50px)" class="px-2 item-container-title">
                                    {{ __('admin.settings') }}
                                </div>
                            </div>
                        </a>
                    @endcan --}}

                    <a href="#" class="col-12 px-0" onclick="document.getElementById('logout-form').submit();">
                        <div class="col-12 item-container px-0 d-flex ">
                            <div style="width: 50px" class="px-3 text-center">
                                <span class="fal fa-sign-out-alt font-2"> </span>
                            </div>
                            <div style="width: calc(100% - 50px)" class="px-2 item-container-title">
                                {{ __('admin.logout') }}
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
        <div class="main-content in-active" style="overflow: hidden;">
            <div class="col-12 px-0 d-flex justify-content-between top-nav"
                style="height: 55px;background: var(--background-1);position: fixed;width: 100%;width: calc(100% - 260px);z-index: 99;border-bottom: 1px solid var(--border-color);">
                <div class="col-12 px-0 d-flex justify-content-center align-items-center btn  asideToggle"
                    style="width: 55px;height: 55px;">
                    <span class="fal fa-bars font-4"></span>
                </div>
                <div class="col-12 px-0 d-flex justify-content-end  " style="height: 60px;">

                    {{-- <div class="btn-group" id="notificationDropdown">

                        <div class="col-12 px-0 d-flex justify-content-center align-items-center btn  "
                            style="width: 55px;height: 55px;" data-bs-toggle="dropdown" aria-expanded="false"
                            id="dropdown-notifications">
                            <span class="fal fa-bell font-3 d-inline-block"
                                style="color: var(--color-2);transform: rotate(15deg)"></span>
                            <span
                                style="position: absolute;min-width: 25px;min-height: 25px;
                                                                @if ($unreadNotifications != 0) display: inline-block;
                                                                @else
                                                                display: none; @endif
                                                                right: 0px;top: 0px;border-radius: 20px;background: #c00;color:#fff;font-size: 14px;"
                                class="text-center"
                                id="dropdown-notifications-icon">{{ $unreadNotifications }}</span>

                        </div>
                        <div class="dropdown-menu py-0 rounded-0 border-0 shadow "
                            style="cursor: auto!important;z-index: 20000;width: 350px;height: 450px;top: -3px!important;">
                            <div class="col-12 notifications-container" style="height:406px;overflow: auto;">
                                <x-notifications :notifications="$notifications" />
                            </div>
                            <div class="col-12 d-flex border-top">
                                <a href="{{ route('admin.notifications.index') }}" class="d-block py-2 px-3 ">
                                    <div class="col-12 align-items-center">
                                        <span class="fal fa-bells"></span> {{ __('admin.showAllNotifications') }}
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-12 px-0 d-flex justify-content-center align-items-center  dropdown"
                        style="width: 55px;height: 55px;">
                        <div style="width: 55px;height: 55px;cursor: pointer;" data-bs-toggle="dropdown"
                            aria-expanded="false"
                            class="d-flex justify-content-center align-items-center cursor-pointer">
                            <img src="{{ auth()->user()->getUserAvatar() }}"
                                style="padding: 10px;border-radius: 50%;width: 55px;height: 55px;">
                        </div>
                        <ul class="dropdown-menu shadow border-0" aria-labelledby="dropdownMenuButton1"
                            style="top: -3px;">
                            <li><a class="dropdown-item font-1" href="/" target="_blank"><span
                                        class="fal fa-desktop font-1"></span> {{ __('admin.viewWebsite') }}</a></li>
                            <li><a class="dropdown-item font-1" href="{{ route('admin.profile.index') }}"><span
                                        class="fal fa-user font-1"></span> {{ __('admin.myProfile') }}</a></li>

                            <li><a class="dropdown-item font-1" href="{{ route('admin.profile.edit') }}"><span
                                        class="fal fa-edit font-1"></span> {{ __('admin.editMyProfile') }}</a></li>




                            @can('hub-files-read')
                                <li><a class="dropdown-item font-1" href="{{ route('admin.files.index') }}"><span
                                            class="fal fa-file font-1"></span> {{ __('admin.files') }}</a></li>
                            @endcan


                            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <li>
                                    <a class="dropdown-item font-1" rel="alternate" hreflang="{{ $localeCode }}"
                                        href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                        @if ($localeCode == 'en')
                                            <img src="{{ asset('flags/1x1/gb-eng.svg') }}" alt=""
                                                style="width: 15px;">
                                        @else
                                            <img src="{{ asset('flags/1x1/it.svg') }}" alt=""
                                                style="width: 15px;">
                                        @endif
                                        {{ Str::upper($properties['native']) }}
                                    </a>
                                </li>
                            @endforeach




                            <li>
                                <hr style="height: 1px;margin: 10px 0px 5px;">
                            </li>
                            <li><a class="dropdown-item font-1" href="#"
                                    onclick="document.getElementById('logout-form').submit();"><span
                                        class="fal fa-sign-out-alt font-1"></span> {{ __('admin.logout') }}</a></li>
                        </ul>

                    </div>

                    <div class="dropdown" style="width: 55px;height: 55px;background: #2381c6">
                        <span class="d-inline-block fal fa-user"></span>
                    </div>

                </div>
            </div>
            <div class="col-12 px-0  " style="margin-top: 55px;position: relative;">
                <div style="position:fixed;display: flex;align-items: center;justify-content: center;height: 100vh;background: var(--background-1);z-index: 10;margin-top: -15px;"
                    id="loading-image-container">
                    <img src="/images/loading.gif"
                        style="position:fixed;width: 120px;max-width: 80%;margin-top: -60px;" id="loading-image">
                </div>
                @yield('content')
            </div>
        </div>
    </div>

    @vite('resources/js/dashboard.js')
    @livewireScripts
    @include('layouts.scripts')
    @yield('scripts')
    @stack('scripts')
    {{-- <link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.js"
        integrity="sha512-ZHzbWDQKpcZxIT9l5KhcnwQTidZFzwK/c7gpUUsFvGjEsxPusdUCyFxjjpc7e/Wj7vLhfMujNx7COwOmzbn+2w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    {{-- <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('a78629fb47c1698dccf1', {
            cluster: 'eu'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', function(data) {
            var toastHTML = '<img src="' + data.image + '" width="50" height="50" />' +
                '<h4>' + data.greeting + '</h4>' +
                '<h5>' + data.subject + '</h5>' +
                '<p>' + data.content + '</p>';

            Toastify({
                text: toastHTML,
                duration: 3200,
                gravity: "bottom", // Display the toast from the top
                position: "right", // Display the toast on the right
                backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)", // Set the background color
                stopOnFocus: true, // Stops the toast from auto hiding on focus
                className: "info-toast",
                escapeMarkup: false,
            }).showToast();
        });
    </script> --}}
</body>

</html>
