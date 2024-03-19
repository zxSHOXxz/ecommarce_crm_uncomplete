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
                                <span class="btn btn-primary"><span class="fas fa-plus"></span> Add Category </span>
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
                                <th>title</th>
                                <th>quantity</th>
                                <th>discount</th>
                                <th>price</th>
                                <th>code</th>
                                <th>status</th>
                                <th>category</th>
                                <th>description</th>
                                <th>product details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $product->title }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->discount }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->code }}</td>
                                <td>{{ $product->status }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>
                                    <span class="badge bg-dark"> {{ $product->product_details->brochure }} </span>
                                    <br>
                                    <span class="badge bg-dark"> {{ $product->product_details->driver }} </span>
                                    <br>
                                    <span class="badge bg-dark"> {{ $product->product_details->catalog }} </span>
                                    <br>
                                    <span class="badge bg-dark"> {{ $product->product_details->map }} </span>
                                    <br>
                                    <span class="badge bg-dark"> {{ $product->product_details->video }} </span>
                                    <br>
                                    <br>
                                    <span class="badge bg-dark"> <img
                                            src="{{ $product->product_details->getProductPhoto() }}" alt=""
                                            style="width: 50px"> </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
