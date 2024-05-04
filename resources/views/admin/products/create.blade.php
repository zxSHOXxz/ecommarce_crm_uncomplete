@extends('layouts.admin')
@section('content')
    <div class="row">

        <div class="col-12 p-3">
            <div class="col-12 col-lg-12 p-0 ">

                <form action="{{ route('importProductsFromXml') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12 col-lg-8 p-0 main-box">
                        <div class="col-12 px-0">
                            <div class="col-12 px-3 py-3">
                                <span class="fas fa-info-circle"></span> {{ __('messages.IMPORT_PRODUCTS') }}
                            </div>
                            <div class="col-12 divider" style="min-height: 2px;"></div>
                        </div>


                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                {{ __('messages.XML_FILE') }}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="file" name="file" class="form-control">
                            </div>
                            <div class="col-12 p-0">

                            </div>
                        </div>

                        <div class="col-12 p-3">
                            <button class="btn btn-success" id="submit" type="submit"> {{ __('messages.IMPORT') }}
                            </button>
                        </div>

                    </div>
                </form>

            </div>
            <div class="col-12 col-lg-12 p-0 ">

                <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12 col-lg-8 p-0 main-box">
                        <div class="col-12 px-0">
                            <div class="col-12 px-3 py-3">
                                <span class="fas fa-info-circle"></span> {{ __('messages.IMPORT_PRODUCTS') }}
                            </div>
                            <div class="col-12 divider" style="min-height: 2px;"></div>
                        </div>


                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                {{ __('messages.EXCEL_FILE') }}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="file" name="file" class="form-control">
                            </div>
                            <div class="col-12 p-0">

                            </div>
                        </div>

                        <div class="col-12 p-3">
                            <button class="btn btn-success" id="submit" type="submit"> {{ __('messages.IMPORT') }}
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
        <div class="col-12 p-3">
            <div class="col-12 col-lg-12 p-0 ">
                <form id="validate-form" class="row" enctype="multipart/form-data" method="POST"
                    action="{{ route('admin.products.store') }}">
                    @csrf
                    <div class="col-12 col-lg-8 p-0 main-box">
                        <div class="col-12 px-0">
                            <div class="col-12 px-3 py-3">
                                <span class="fas fa-info-circle"></span> {{ __('messages.CREATE_NEW_PRODUCT') }}
                            </div>
                            <div class="col-12 divider" style="min-height: 2px;"></div>
                        </div>
                        <div class="col-12 p-3 row">

                            <div class="col-12 col-lg-6 p-2">
                                <div class="col-12">
                                    {{ __('messages.TITLE') }}
                                </div>
                                <div class="col-12 pt-3">
                                    <input type="text" name="title" required minlength="3" maxlength="190"
                                        class="form-control" value="{{ old('title') }}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <div class="col-12">
                                    {{ __('messages.CODE') }}
                                </div>
                                <div class="col-12 pt-3">
                                    <input type="text" name="code" required minlength="3" maxlength="190"
                                        class="form-control" value="{{ old('code') }}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <div class="col-12">
                                    {{ __('messages.QUANTITY') }}
                                </div>
                                <div class="col-12 pt-3">
                                    <input type="number" name="quantity" required class="form-control"
                                        value="{{ old('quantity') }}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <div class="col-12">
                                    {{ __('messages.PRICE') }}
                                </div>
                                <div class="col-12 pt-3">
                                    <input type="number" name="price" required class="form-control"
                                        value="{{ old('price') }}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <div class="col-12">
                                    {{ __('messages.DISCOUNT') }}
                                </div>
                                <div class="col-12 pt-3">
                                    <input type="number" name="discount" required class="form-control"
                                        value="{{ old('discount') }}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <div class="col-12">
                                    {{ __('messages.status') }}
                                </div>
                                <div class="col-12 pt-3">
                                    <select class="form-control" name="status">
                                        <option @if (old('status') == 'draft') selected @endif value="draft">
                                            {{ __('messages.DRAFT') }}
                                        </option>
                                        <option @if (old('status') == 'published') selected @endif value="published">
                                            {{ __('messages.PUBLISHED') }}
                                        </option>
                                        <option @if (old('status') == 'deleted') selected @endif value="deleted">
                                            {{ __('messages.DELETED') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <div class="col-12">
                                    {{ __('messages.CATEGORY') }}
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
                                    {{ __('messages.DESCRIPTION') }}
                                </div>
                                <div class="col-12 pt-3">
                                    <textarea name="description" maxlength="5000" class="form-control" style="min-height:150px">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <hr class="mt-3 pt-1">

                            <div class="col-12 p-2">
                                <div class="col-12">
                                    {{ __('messages.PRODUCT_DETAILS') }}
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <div class="col-12">
                                    {{ __('messages.BROCHURE') }}
                                </div>
                                <div class="col-12 pt-3">
                                    <input type="text" name="brochure" minlength="3" maxlength="190"
                                        class="form-control" value="{{ old('brochure') }}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <div class="col-12">
                                    {{ __('messages.DRIVER') }}
                                </div>
                                <div class="col-12 pt-3">
                                    <input type="text" name="driver" minlength="3" maxlength="190"
                                        class="form-control" value="{{ old('driver') }}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <div class="col-12">
                                    {{ __('messages.CATALOG') }}
                                </div>
                                <div class="col-12 pt-3">
                                    <input type="text" name="catalog" minlength="3" maxlength="190"
                                        class="form-control" value="{{ old('catalog') }}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <div class="col-12">
                                    {{ __('messages.MAP') }}
                                </div>
                                <div class="col-12 pt-3">
                                    <input type="text" name="map" minlength="3" maxlength="190"
                                        class="form-control" value="{{ old('map') }}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <div class="col-12">
                                    {{ __('messages.VIDEO') }}
                                </div>
                                <div class="col-12 pt-3">
                                    <input type="text" name="video" minlength="3" maxlength="190"
                                        class="form-control" value="{{ old('video') }}">
                                </div>
                            </div>

                            <div class="col-12 col-lg-6 p-2">
                                <div class="col-12">
                                    {{ __('messages.MAIN_PHOTO') }}
                                </div>
                                <div class="col-12 pt-3">
                                    <input type="file" name="main_photo" class="form-control" accept="image/*">
                                </div>
                                <div class="col-12 p-0">

                                </div>
                            </div>
                            <div class="col-12 col-lg-6 p-2">
                                <div class="col-12">
                                    {{ __('messages.PHOTOS') }}
                                </div>
                                <div class="col-12 pt-3">
                                    <input type="file" name="photo[]" class="form-control" multiple accept="image/*">
                                </div>
                                <div class="col-12 p-0">

                                </div>
                            </div>
                        </div>

                        <div class="col-12 p-3">
                            <button class="btn btn-success" id="submitEvaluation"> {{ __('messages.SAVE') }}
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
