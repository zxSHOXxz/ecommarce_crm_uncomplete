@extends('layouts.admin')
@section('content')
    <div class="col-12 p-3">
        <div class="col-12 col-lg-12 p-0 main-box">

            <div class="col-12 px-0">
                <div class="col-12 p-0 row">
                    <div class="col-12 col-lg-4 py-3 px-3">
                        <span class="fas fa-tags"></span> orders
                    </div>
                    <div class="col-12 col-lg-4 p-0">
                    </div>
                    @can('orders-update')
                        <div class="col-12 col-lg-4 p-2 text-lg-end d-flex justify-content-end">
                            <a href="{{ route('export') }}">
                                <span class="btn btn-success mx-1"><i class="fa-solid fa-file-csv p-1"></i>Export CSV</span>
                            </a>
                            <a href="{{ route('export_xml') }}">
                                <span class="btn btn-secondary mx-1"><i class="fa-solid fa-file-xml p-1"></i>Export XML</span>
                            </a>
                            <form action="{{ route('uploadXml.file') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="xml_file">
                                <button type="submit">Upload</button>
                            </form>
                        </div>
                    @endcan
                </div>
                <div class="col-12 divider" style="min-height: 2px;"></div>
            </div>

            <div class="col-12 py-2 px-2 row">
                <div class="col-12 col-lg-4 p-2">
                    <form method="GET">
                        <input type="text" name="q" class="form-control" placeholder="search ... "
                            value="{{ request()->get('q') }}">
                    </form>
                </div>
            </div>
            <div class="col-12 p-3" style="overflow:auto">
                <div class="col-12 p-0" style="min-width:1100px;">
                    <table class="table table-bordered  table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>customer</th>
                                <th>total amount</th>
                                <th>products</th>
                                <th>status</th>
                                @can('orders-update')
                                    <th>Control</th>
                                @endcan

                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->customer->name ?? 'null' }}</td>
                                    <td>{{ $order->total_amount ?? 'null' }}</td>
                                    <td>
                                        @foreach ($order->products as $productDetail)
                                            <h6>
                                                <span
                                                    class="badge bg-dark text-white rounded-pill">{{ Str::limit(Str::upper($productDetail->product->title ?? 'null'), 45, '...') }}
                                                </span>
                                                <span class="badge bg-danger text-white rounded-pill">
                                                    {{ $productDetail->quantity ?? 'null' }}
                                                </span>
                                            </h6>
                                        @endforeach
                                    </td>
                                    <td>{{ $order->status ?? 'null' }}</td>
                                    @can('orders_update')
                                        <td>
                                            <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-select" required>
                                                    <option value="faild" @if ($order->status === 'faild') selected @endif>
                                                        faild</option>
                                                    <option value="sucsses" @if ($order->status === 'sucsses') selected @endif>
                                                        sucsses</option>
                                                    <option value="waiting" @if ($order->status === 'waiting') selected @endif>
                                                        waiting</option>
                                                    <option value="pending" @if ($order->status === 'pending') selected @endif>
                                                        pending</option>
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-success ml-2">Update</button>
                                            </form>
                                        </td>
                                        <td style="width: 180px;">
                                            @can('orders-update')
                                                <a href="{{ route('admin.orders.show', $order) }}">
                                                    <span class="btn  btn-outline-success btn-sm font-1 m-1">
                                                        <span class="fas fa-eye "></span> show
                                                    </span>
                                                </a>
                                            @endcan

                                            @can('orders-delete')
                                                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                                                    class="d-inline-block">@csrf @method('DELETE')
                                                    <button class="btn  btn-outline-danger btn-sm font-1 mx-1"
                                                        onclick="var result = confirm('Do you need delete it ?! ');if(result){}else{event.preventDefault()}">
                                                        <span class="fas fa-trash "></span> delete
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
