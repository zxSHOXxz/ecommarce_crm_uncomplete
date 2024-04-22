@extends('layouts.admin')
@section('content')
    <div class="col-12 p-3">

        <div class="col-12 col-lg-12 p-0 main-box">
            <div class="col-12 px-0">
                <div class="col-12 p-0 row">
                    <div class="col-12 col-lg-4 py-3 px-3">
                        <span class="fas fa-users"></span> {{ __('messages.Admin') }}
                    </div>
                    <div class="col-12 col-lg-4 p-0">
                    </div>
                    <div class="col-12 col-lg-4 p-2 text-lg-end" style="display: flex;justify-content: flex-end">
                        @can('users-create')
                            <a href="{{ route('admin.users.create') }}">
                                <span class="btn btn-primary"><span class="fas fa-plus"></span> {{ __('messages.Add') }}</span>
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="col-12 divider" style="min-height: 2px;"></div>
            </div>

            <div class="col-12 py-2 px-2 row">
                <div class="col-12 col-lg-4 p-2">
                    <form method="GET">
                        <input type="text" name="q" class="form-control"
                            placeholder="{{ __('messages.SEARCH ... ') }}" value="{{ request()->get('q') }}">
                    </form>
                </div>
            </div>
            <div class="col-12 p-3" style="overflow:auto">
                <div class="col-12 p-0" style="min-width:1100px;min-height: 600px;">


                    <table class="table table-bordered  table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('messages.#') }}</th>
                                <th>{{ __('messages.name') }}</th>
                                <th>{{ __('messages.email') }}</th>
                                <th>{{ __('messages.control') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    {{-- <td>{{ \Carbon::parse($user->last_activity)->diffForHumans() }}</td> --}}
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>


                                    {{-- <td>
                                        @foreach ($user->roles as $role)
                                            {{ $role->display_name }}
                                            <br>
                                        @endforeach
                                    </td> --}}


                                    <td>
                                        @can('users-read')
                                            <a href="{{ route('admin.users.show', $user) }}">
                                                <span class="btn  btn-outline-primary btn-sm font-small mx-1">
                                                    <span class="fas fa-search "></span> {{ __('messages.Show') }}
                                                </span>
                                            </a>
                                        @endcan

                                        @can('users-update')
                                            <a href="{{ route('admin.users.edit', $user) }}">
                                                <span class="btn  btn-outline-success btn-sm font-small mx-1">
                                                    <span class="fas fa-wrench "></span> {{ __('messages.Edit') }}
                                                </span>
                                            </a>
                                        @endcan


                                        @can('users-delete')
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                class="d-inline-block">@csrf @method('DELETE')
                                                <button class="btn  btn-outline-danger btn-sm font-small mx-1"
                                                    onclick="var result = confirm('Are u sure wanna delete this user ? ');if(result){}else{event.preventDefault()}">
                                                    <span class="fas fa-trash "></span> {{ __('messages.Delete') }}
                                                </button>
                                            </form>
                                        @endcan



                                        <div class="dropdown d-inline-block">
                                            <button class="py-1 px-2 btn btn-outline-primary font-small" type="button"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="true">
                                                <span class="fas fa-bars"></span>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1"
                                                data-popper-placement="bottom-start"
                                                style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate3d(0px, 29px, 0px);">
                                                @can('users-update')
                                                    <li><a class="dropdown-item font-1"
                                                            href="{{ route('admin.users.access', $user) }}"><span
                                                                class="fal fa-eye"></span> {{ __('messages.access') }}</a></li>
                                                @endcan
                                            </ul>
                                        </div>


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 p-3">
                {{ $users->appends(request()->query())->render() }}
            </div>
        </div>
    </div>
@endsection
