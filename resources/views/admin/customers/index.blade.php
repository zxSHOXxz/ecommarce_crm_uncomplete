@extends('layouts.admin')
@section('content')
    <div class="col-12 p-3">
        <!-- breadcrumb -->
        <x-bread-crumb :breads="[
            ['url' => route('admin.customers.index'), 'title' => 'Customer', 'isactive' => true],
            ['url' => url('/customers'), 'title' => 'DASHBOARD', 'isactive' => false] ,
        ]">
        </x-bread-crumb>
        <!-- /breadcrumb -->
        <div class="col-12 col-lg-12 p-0 main-box">
            <div class="col-12 px-0">
                <div class="col-12 p-0 row">
                    <div class="col-12 col-lg-4 py-3 px-3">
                        <span class="fas fa-users"></span> Customers
                    </div>
                    <div class="col-12 col-lg-4 p-0">
                    </div>
                    <div class="col-12 col-lg-4 p-2 text-lg-end" style="display: flex;justify-content: flex-end">
                        @can('customers-create')
                            <a href="{{ route('admin.customers.create') }}">
                                <span class="btn btn-primary"><span class="fas fa-plus"></span> Add</span>
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="col-12 divider" style="min-height: 2px;"></div>
            </div>
            <div class="col-12 py-2 px-2 row">
                <div class="col-12 col-lg-4 p-2">
                    <form method="GET">
                        <input type="text" name="q" class="form-control" placeholder="Search ... "
                            value="{{ request()->get('q') }}">
                    </form>
                </div>
            </div>
            <div class="col-12 p-3" style="overflow:auto">
                <div class="col-12 p-0" style="min-width:1100px;min-height: 600px;">
                    <table class="table table-bordered  table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                {{-- <th>isActive</th> --}}
                                <th>Name</th>
                                <th>Email</th>
                                {{-- @if (auth()->user()->can('contacts-read'))
                                    <th>Contacts</th>
                                @endif --}}
                                {{-- @if (auth()->user()->can('traffics-read'))
                                    <th>Traffics</th>
                                @endif --}}
                                <th>Permissions</th>
                                <th>Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->id }}</td>
                                    {{-- <td>{{ \Carbon::parse($customer->last_activity)->diffForHumans() }}</td> --}}
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    {{-- @if (auth()->user()->can('contacts-read'))
                                        <td><a
                                                href="{{ route('admin.contacts.index', ['customer_id' => $customer->id]) }}">{{ $customer->contacts_count ?? null }}</a>
                                        </td>
                                    @endif --}}
                                    {{-- @if (auth()->user()->can('traffics-read'))
                                        <td><a
                                                href="{{ route('admin.traffics.logs', ['customer_id' => $customer->id]) }}">{{ $customer->logs_count ?? null }}</a>
                                        </td>
                                    @endif --}}
                                    <td>
                                        @foreach ($customer->roles as $role)
                                            {{ $role->display_name }}
                                            <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @can('customers-read')
                                            <a href="{{ route('admin.customers.show', $customer) }}">
                                                <span class="btn  btn-outline-primary btn-sm font-small mx-1">
                                                    <span class="fas fa-search "></span> Show
                                                </span>
                                            </a>
                                        @endcan
                                        {{-- @can('notifications-create')
                                            <a
                                                href="{{ route('admin.notifications.index', ['customer_id' => $customer->id]) }}">
                                                <span class="btn  btn-outline-primary btn-sm font-small mx-1">
                                                    <span class="far fa-bells">Notifications</span>
                                                </span>
                                            </a>
                                            <a
                                                href="{{ route('admin.notifications.create', ['customer_id' => $customer->id]) }}">
                                                <span class="btn  btn-outline-primary btn-sm font-small mx-1">
                                                    <span class="far fa-bell">Create Notifications</span>
                                                </span>
                                            </a>
                                        @endcan --}}
                                        @can('customer-roles-update')
                                            <a href="{{ route('admin.customers.roles.index', $customer) }}">
                                                <span class="btn btn-outline-primary btn-sm font-small mx-1">
                                                    <span class="fal fa-key "></span> Permissions
                                                </span>
                                            </a>
                                        @endcan
                                        {{-- @can('customers-update') --}}
                                            <a href="{{ route('admin.customers.edit', $customer) }}">
                                                <span class="btn  btn-outline-success btn-sm font-small mx-1">
                                                    <span class="fas fa-wrench "></span> Update
                                                </span>
                                            </a>
                                        {{-- @endcan --}}
                                        {{-- @can('customers-delete') --}}
                                            <form method="POST" action="{{ route('admin.customers.destroy', $customer) }}"
                                                class="d-inline-block">@csrf @method('DELETE')
                                                <button class="btn  btn-outline-danger btn-sm font-small mx-1"
                                                    onclick="var result = confirm('Do you need delete it ?');if(result){}else{event.preventDefault()}">
                                                    <span class="fas fa-trash "></span> Delete
                                                </button>
                                            </form>
                                        {{-- @endcan --}}
                                        <div class="dropdown d-inline-block">
                                            <button class="py-1 px-2 btn btn-outline-primary font-small" type="button"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="true">
                                                <span class="fas fa-bars"></span>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1"
                                                data-popper-placement="bottom-start"
                                                style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate3d(0px, 29px, 0px);">
                                                {{-- @can('customers-update') --}}
                                                    <li><a class="dropdown-item font-1"
                                                            href="{{ route('admin.traffics.logs', ['customer_id' => $customer->id]) }}"><span
                                                                class="fal fa-boxes"></span> Traffics <span
                                                                class="badge bg-danger">{{ $customer->logs_count }}</span></a>
                                                    </li>
                                                {{-- @endcan --}}
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
                {{ $customers->appends(request()->query())->render() }}
            </div>
        </div>
    </div>
@endsection
