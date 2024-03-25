@extends('layouts.admin')
@section('content')
    <div class="col-12 p-3">
        <div class="col-12 col-lg-12 p-0 main-box">

            <div class="col-12 px-0">
                <div class="col-12 p-0 row">
                    <div class="col-12 col-lg-4 py-3 px-3">
                        <span class="fas fa-tags"></span> {{ __('admin.categories') }}
                    </div>
                    <div class="col-12 col-lg-4 p-0">
                    </div>
                    <div class="col-12 col-lg-4 p-2 text-lg-end d-flex justify-content-end">
                        @can('categories-create')
                            <a href="{{ route('admin.categories.create') }}">
                                <span class="btn btn-primary"><span class="fas fa-plus"></span> {{ __('admin.createCategory') }} </span>
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="col-12 divider" style="min-height: 2px;"></div>
            </div>

            <div class="col-12 py-2 px-2 row">
                <div class="col-12 col-lg-4 p-2">
                    <form method="GET">
                        <input type="text" name="q" class="form-control" placeholder="{{ __('admin.search') }} ... "
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
                                <th>{{ __('admin.image') }}</th>
                                <th>{{ __('admin.name') }}</th>
                                <th>{{ __('admin.control') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>
                                        <img class="img" style="width: 80px" src="{{ $category->getCategoryCover() }}" alt="">
                                    </td>
                                    <td>{{ $category->name }}</td>
                                    <td style="width: 180px;">
                                        @can('categories-update')
                                            <a href="{{ route('admin.categories.edit', $category) }}">
                                                <span class="btn  btn-outline-success btn-sm font-1 mx-1">
                                                    <span class="fas fa-wrench "></span> {{ __('admin.control') }}
                                                </span>
                                            </a>
                                        @endcan
                                        @can('categories-delete')
                                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                                class="d-inline-block">@csrf @method('DELETE')
                                                <button class="btn  btn-outline-danger btn-sm font-1 mx-1"
                                                    onclick="var result = confirm('{{ __('admin.confirmDelete') }}');if(result){}else{event.preventDefault()}">
                                                    <span class="fas fa-trash "></span> {{ __('admin.delete') }}
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 p-3">
                {{ $categories->appends(request()->query())->render() }}
            </div>
        </div>
    </div>
@endsection
