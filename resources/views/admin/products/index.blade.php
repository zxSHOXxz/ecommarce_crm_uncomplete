@extends('layouts.admin')
@section('content')
    <div class="col-12 p-3">
        <div class="col-12 col-lg-12 p-0 main-box">

            <div class="col-12 px-0">
                <div class="col-12 p-0 row">
                    <div class="col-12 col-lg-4 py-3 px-3">
                        <span class="fas fa-tags"></span> products
                    </div>
                    <div class="col-12 col-lg-4 p-0">
                    </div>
                    <div class="col-12 col-lg-4 p-2 text-lg-end d-flex justify-content-end">
                        @can('products-create')
                            <a href="{{ route('admin.products.create') }}">
                                <span class="btn btn-primary"><span class="fas fa-plus"></span> Add Product </span>
                            </a>
                            <a href="{{ route('export') }}">
                                <span class="btn btn-success mx-1"><i class="fa-solid fa-file-csv p-1"></i>Export CSV</span>
                            </a>
                            <a href="{{ route('xml_export') }}">
                                <span class="btn btn-success mx-1"><i class="fa-solid fa-file-xml p-1"></i>Export XML</span>
                            </a>
                        @endcan
                    </div>
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
                                <th>title</th>
                                <th>quantity</th>
                                <th>reserved</th>
                                <th>discount</th>
                                <th>price</th>
                                <th>code</th>
                                <th>status</th>
                                <th>category</th>
                                <th>description</th>
                                <th>Control</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->title }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->reserved }}</td>
                                    <td>{{ $product->discount != null ? $product->discount : 0 }} % </td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->code }}</td>
                                    <td>{{ $product->status }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td style="width: 180px;">
                                        {{-- @can('products-update') --}}
                                        <a href="{{ route('admin.products.show', $product) }}" class="d-inline-block my-1">
                                            <span class="btn  btn-outline-success btn-sm font-1">
                                                <span class="fas fa-eye "></span> show
                                            </span>
                                        </a>

                                        <a href="{{ route('admin.products.edit', $product) }}" class="d-inline-block my-1">
                                            <span class="btn  btn-outline-success btn-sm font-1">
                                                <span class="fas fa-wrench "></span> control
                                            </span>
                                        </a>
                                        {{-- @endcan --}}
                                        {{-- @can('products-delete') --}}
                                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                            class="d-inline-block my-2">@csrf @method('DELETE')
                                            <button class="btn  btn-outline-danger btn-sm font-1"
                                                onclick="var result = confirm('Do you need delete it ?! ');if(result){}else{event.preventDefault()}">
                                                <span class="fas fa-trash "></span> delete
                                            </button>
                                        </form>
                                        {{-- @endcan --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 p-3">
                {{ $products->appends(request()->query())->render() }}
            </div>
        </div>
    </div>
@endsection
