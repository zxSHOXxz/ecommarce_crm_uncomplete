@extends('layouts.admin')
@section('content')
    <div class="col-12 p-3">
        <div class="col-12 col-lg-12 p-0 ">


            <form id="validate-form" class="row" enctype="multipart/form-data" method="POST"
                action="{{ route('admin.categories.update', ['category' => $category]) }}">
                @csrf
                @method("PUT")

                <div class="col-12 col-lg-8 p-0 main-box">
                    <div class="col-12 px-0">
                        <div class="col-12 px-3 py-3">
                            <span class="fas fa-info-circle"></span> {{ __('admin.updateCategory') }}
                        </div>
                        <div class="col-12 divider" style="min-height: 2px;"></div>
                    </div>
                    <div class="col-12 p-3 row">

                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                {{ __('admin.name') }}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="text" name="name" required minlength="3" maxlength="190"
                                    class="form-control" value="{{ $category->name }}">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                {{ __('admin.cover') }}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="file" name="cover" class="form-control" accept="image/*">
                            </div>
                            <div class="col-12 p-0">
                                <img src="{{ $category->getCategoryCover() }}" style="width:100px;margin-top:20px">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-12 p-3">
                    <button class="btn btn-success" id="submitEvaluation">{{ __('admin.save') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
