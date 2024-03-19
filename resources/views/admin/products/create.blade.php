@extends('layouts.admin')
@section('content')
    <div class="col-12 p-3">
        <div class="col-12 col-lg-12 p-0 ">


            <form id="validate-form" class="row" enctype="multipart/form-data" method="POST"
                action="{{ route('admin.products.store') }}">
                @csrf
                <div class="col-12 col-lg-8 p-0 main-box">
                    <div class="col-12 px-0">
                        <div class="col-12 px-3 py-3">
                            <span class="fas fa-info-circle"></span> CREATE NEW PRODUCT
                        </div>
                        <div class="col-12 divider" style="min-height: 2px;"></div>
                    </div>
                    <div class="col-12 p-3 row">

                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                title
                            </div>
                            <div class="col-12 pt-3">
                                <input type="text" name="title" required minlength="3" maxlength="190"
                                    class="form-control" value="{{ old('title') }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                code
                            </div>
                            <div class="col-12 pt-3">
                                <input type="text" name="code" required minlength="3" maxlength="190"
                                    class="form-control" value="{{ old('code') }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                quantity
                            </div>
                            <div class="col-12 pt-3">
                                <input type="number" name="quantity" required class="form-control"
                                    value="{{ old('quantity') }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                price
                            </div>
                            <div class="col-12 pt-3">
                                <input type="number" name="price" required class="form-control"
                                    value="{{ old('price') }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                discount
                            </div>
                            <div class="col-12 pt-3">
                                <input type="number" name="discount" required class="form-control"
                                    value="{{ old('discount') }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                status
                            </div>
                            <div class="col-12 pt-3">
                                <select class="form-control" name="status">
                                    <option @if (old('status') == 'draft') selected @endif value="draft">draft</option>
                                    <option @if (old('status') == 'published') selected @endif value="published">published
                                    </option>
                                    <option @if (old('status') == 'deleted') selected @endif value="deleted">deleted
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                category
                            </div>
                            <div class="col-12 pt-3">
                                <select class="form-control" name="category_id">
                                    @foreach ($categories as $category)
                                        <option @if (old('category_id') == $category->id) selected @endif
                                            value="{{ $category->id }}"> {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                description
                            </div>
                            <div class="col-12 pt-3">
                                <textarea name="description" maxlength="5000" class="form-control" style="min-height:150px">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <hr class="mt-3 pt-1">

                        <div class="col-12 p-2">
                            <div class="col-12">
                                Product Details
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                brochure
                            </div>
                            <div class="col-12 pt-3">
                                <input type="text" name="brochure" required minlength="3" maxlength="190"
                                    class="form-control" value="{{ old('brochure') }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                driver
                            </div>
                            <div class="col-12 pt-3">
                                <input type="text" name="driver" required minlength="3" maxlength="190"
                                    class="form-control" value="{{ old('driver') }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                catalog
                            </div>
                            <div class="col-12 pt-3">
                                <input type="text" name="catalog" required minlength="3" maxlength="190"
                                    class="form-control" value="{{ old('catalog') }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                map
                            </div>
                            <div class="col-12 pt-3">
                                <input type="text" name="map" required minlength="3" maxlength="190"
                                    class="form-control" value="{{ old('map') }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                video
                            </div>
                            <div class="col-12 pt-3">
                                <input type="text" name="video" required minlength="3" maxlength="190"
                                    class="form-control" value="{{ old('video') }}">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                photo
                            </div>
                            <div class="col-12 pt-3">
                                <input type="file" name="photo" class="form-control" accept="image/*">
                            </div>
                            <div class="col-12 p-0">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 p-3">
                    <button class="btn btn-success" id="submitEvaluation">حفظ</button>
                </div>
            </form>
        </div>
    </div>
@endsection
