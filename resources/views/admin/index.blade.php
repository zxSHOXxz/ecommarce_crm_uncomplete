@extends('layouts.admin')
@section('content')
    <div class="col-12 p-3 row">
        {{-- @can('users-read')
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 col-xxl-2 px-2 my-2">
                <div class="col-12 px-0 py-1 d-flex main-box-wedit">
                    <div style="width: 65px;" class="p-2">
                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                            style="background: #0194fe;color: #fff;border-radius: 50%;width: 55px;height:55px">
                            <span class="fal fa-users font-5"></span>
                        </div>
                    </div>
                    <div style="width: calc(100% - 80px)" class="px-2 py-2">
                        <a class="font-1" href="{{ route('admin.users.index') }}" style="color: #212529">
                            Users
                            <h6 class="font-3">{{ \App\Models\User::count() }}</h6>
                        </a>
                    </div>
                </div>
            </div>
        @endcan --}}
        {{-- <div class="col-12 col-sm-6 col-lg-4 col-xl-3 col-xxl-2 px-2 my-2">
            <div class="col-12 px-0 py-1 d-flex main-box-wedit">
                <div style="width: 65px;" class="p-2">
                    <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                        style="background: #0194fe;color: #fff; border-radius: 50%;width: 55px;height:55px">
                        <span class="fal fa-bells font-5"></span>
                    </div>
                </div>
                <div style="width: calc(100% - 80px)" class="px-2 py-2">
                    <a class="font-1" href="{{ route('admin.notifications.index') }}" style="color: #212529">
                        Notifications
                        <h6 class="font-3">{{ auth()->user()->unreadNotifications->count() }}</h6>
                    </a>
                </div>
            </div>
        </div> --}}
        {{-- @can('hub-files-read')
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 col-xxl-2 px-2 my-2">
                <div class="col-12 px-0 py-1 d-flex main-box-wedit">
                    <div style="width: 65px;" class="p-2">
                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                            style="background: #0194fe;color: #fff; border-radius: 50%;width: 55px;height:55px">
                            <span class="fal fa-file font-5"></span>
                        </div>
                    </div>
                    <div style="width: calc(100% - 80px)" class="px-2 py-2">
                        <a class="font-1" href="{{ route('admin.files.index') }}" style="color: #212529;">
                            Files
                            <h6 class="font-3">{{ \App\Models\HubFile::count() }}</h6>
                        </a>
                    </div>
                </div>
            </div>
        @endcan --}}
        {{-- <div class="col-12 px-2 py-2">
            <div style="height: 4px ;background: rgb(118 169 169);border-radius: 7px;transition: width .5s ease-in-out;width: 0%;"
                id="home-dashboard-divider"></div>
        </div> --}}
        {{-- <livewire:dashboard-statistics /> --}}
    </div>
@endsection
