@extends('layouts.admin')
@section('content')
    <div class="col-12 p-3">
        <div class="col-12 col-lg-12 p-0 main-box">

            <div class="col-12 px-0">
                <div class="col-12 p-0 row">
                    <div class="col-12 col-lg-4 py-3 px-3">
                        <span class="fas fa-tags"></span> {{ __('messages.PRODUCTS') }}
                    </div>
                    <div class="col-12 col-lg-4 p-0">
                    </div>
                    <div class="col-12 col-lg-4 p-2 text-lg-end d-flex justify-content-end">
                        @can('products-create')
                            <a href="{{ route('admin.products.create') }}">
                                <span class="btn btn-primary"><span class="fas fa-plus"></span> {{ __('messages.ADD_PRODUCT') }}
                                </span>
                            </a>
                            <a href="{{ route('export') }}">
                                <span class="btn btn-success mx-1"><i
                                        class="fa-solid fa-file-csv p-1"></i>{{ __('messages.EXPORT_CSV') }}</span>
                            </a>
                            <a href="{{ route('xml_export') }}">
                                <span class="btn btn-success mx-1"><i
                                        class="fa-solid fa-file-xml p-1"></i>{{ __('messages.EXPORT_XML') }}</span>
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
                            placeholder="{{ __('messages.SEARCH') }} ... " value="{{ request()->get('q') }}">
                    </form>
                </div>
            </div>
            <div class="col-12 p-3" style="overflow:auto">
                <div class="col-12 p-0" style="min-width:1100px;">


                    <table class="table table-bordered  table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('messages.TITLE') }}</th>
                                <th>{{ __('messages.QUANTITY') }}</th>
                                <th>{{ __('messages.RESERVED') }}</th>
                                <th>{{ __('messages.DISCOUNT') }}</th>
                                <th>{{ __('messages.PRICE') }}</th>
                                <th>{{ __('messages.CODE') }}</th>
                                <th>{{ __('messages.STATUS') }}</th>
                                <th>{{ __('messages.CATEGORY') }}</th>
                                <th>{{ __('messages.DESCRIPTION') }}</th>
                                <th>{{ __('messages.CONTROL') }}</th>
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
                                                <span class="fas fa-eye "></span> {{ __('messages.SHOW') }}
                                            </span>
                                        </a>

                                        <a href="{{ route('admin.products.edit', $product) }}" class="d-inline-block my-1">
                                            <span class="btn  btn-outline-success btn-sm font-1">
                                                <span class="fas fa-wrench "></span> {{ __('messages.CONTROL') }}
                                            </span>
                                        </a>
                                        {{-- @endcan --}}
                                        {{-- @can('products-delete') --}}
                                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                            class="d-inline-block my-2">@csrf @method('DELETE')
                                            <button class="btn  btn-outline-danger btn-sm font-1"
                                                onclick="var result = confirm('{{ __('messages.DELETE_CONFIRM') }}');if(result){}else{event.preventDefault()}">
                                                <span class="fas fa-trash "></span> {{ __('messages.DELETE') }}
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
