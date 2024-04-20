@extends('layouts.admin')
@section('content')
    <div class="col-12 p-3">
        <div class="col-12 col-lg-12 p-0 main-box">

            <div class="col-12 px-0">
                <div class="col-12 p-0 row">
                    <div class="col-12 col-lg-4 py-3 px-3">
                        <span class="fas fa-tags"></span> {{ __('messages.ORDER_DETAILS') }}
                    </div>
                    <div class="col-12 col-lg-4 p-0">
                    </div>
                    <div class="col-12 col-lg-4 p-2 text-lg-end d-flex justify-content-end">
                        {{-- @can('orders-create')
                            <a href="{{ route('admin.orders.create') }}">
                                <span class="btn btn-primary"><span class="fas fa-plus"></span> {{ __('messages.ADD_ORDER') }} </span>
                            </a>
                        @endcan --}}
                    </div>
                </div>
                <div class="col-12 divider" style="min-height: 2px;"></div>
            </div>

            <div class="col-12 py-2 px-2 row">
                <div class="col-12 col-lg-4 p-2">
                    <form method="GET">
                        <input type="text" name="q" class="form-control" placeholder="{{ __('messages.SEARCH') }} ... "
                            value="{{ request()->get('q') }}">
                    </form>
                </div>
            </div>
            <div class="col-12 p-3" style="overflow:auto">
                <div class="col-12 p-0" style="min-width:1100px;">


                    <table class="table table-bordered  table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('messages.PRODUCT') }}</th>
                                <th>{{ __('messages.TOTAL_PRICE') }}</th>
                                <th>{{ __('messages.UNIT_PRICE') }}</th>
                                <th>{{ __('messages.QUANTITY') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($productOrderDetails as $productOrderDetail)
                                <tr>
                                    <td>{{ $productOrderDetail->product->title }}</td>
                                    <td>{{ $productOrderDetail->total_price }}</td>
                                    <td>{{ $productOrderDetail->unit_price }}</td>
                                    <td>{{ $productOrderDetail->quantity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
