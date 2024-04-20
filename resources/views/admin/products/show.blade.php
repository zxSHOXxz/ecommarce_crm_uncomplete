@extends('layouts.admin')
@section('content')
    <div class="col-12 py-0 px-3 row">
        <div class="col-12  pt-2" style="min-height: 80vh">
            <div class="col-12 col-lg-9 px-3 py-5 d-flex mx-auto justify-content-center align-items-center">
                <div class="col-12 p-0 row justify-content-center">
                    <div class="col-12 row row-cols-1 p-0">

                        <div class="col-12 px-2 mb-3">
                            <a href="#" style="color:inherit;">
                                <div class="col-12 px-2 py-2 d-flex rounded-3 main-box-wedit" style="background: #ffffff;">
                                    <div class="p-2">
                                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                                            style="background-image: linear-gradient(rgba(0,0,0,.04),rgba(0,0,0,.04))!important;height: 64px;border-radius: 50%;">
                                            <span class="fal fa-traffic-light font-5"></span>
                                        </div>
                                    </div>
                                    <div class="px-2 py-2">
                                        <h6 class="font-1">{{ __('messages.title') }}</h6>
                                        <h6 class="font-3">{{ $product->title }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-12 px-2 mb-3">
                            <a href="#" style="color:inherit;">
                                <div class="col-12 px-2 py-2 d-flex rounded-3 main-box-wedit" style="background: #ffffff;">
                                    <div class="p-2">
                                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                                            style="background-image: linear-gradient(rgba(0,0,0,.04),rgba(0,0,0,.04))!important;height: 64px;border-radius: 50%;">
                                            <span class="fal fa-traffic-light font-5"></span>
                                        </div>
                                    </div>
                                    <div class="px-2 py-2">
                                        <h6 class="font-1">{{ __('messages.quantity') }}</h6>
                                        <h6 class="font-3">{{ $product->quantity }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>


                        <div class="col-12 px-2 mb-3">
                            <a href="#" style="color:inherit;">
                                <div class="col-12 px-2 py-2 d-flex rounded-3 main-box-wedit" style="background: #ffffff;">
                                    <div class="p-2">
                                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                                            style="background-image: linear-gradient(rgba(0,0,0,.04),rgba(0,0,0,.04))!important;height: 64px;border-radius: 50%;">
                                            <span class="fal fa-traffic-light font-5"></span>
                                        </div>
                                    </div>
                                    <div class="px-2 py-2">
                                        <h6 class="font-1">{{ __('messages.price') }}</h6>
                                        <h6 class="font-3">{{ $product->price }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-12 px-2 mb-3">
                            <a href="#" style="color:inherit;">
                                <div class="col-12 px-2 py-2 d-flex rounded-3 main-box-wedit" style="background: #ffffff;">
                                    <div class="p-2">
                                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                                            style="background-image: linear-gradient(rgba(0,0,0,.04),rgba(0,0,0,.04))!important;height: 64px;border-radius: 50%;">
                                            <span class="fal fa-traffic-light font-5"></span>
                                        </div>
                                    </div>
                                    <div class="px-2 py-2">
                                        <h6 class="font-1">{{ __('messages.code') }}</h6>
                                        <h6 class="font-3">{{ $product->code }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>


                        <div class="col-12 px-2 mb-3">
                            <a href="#" style="color:inherit;">
                                <div class="col-12 px-2 py-2 d-flex rounded-3 main-box-wedit" style="background: #ffffff;">
                                    <div class="p-2">
                                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                                            style="background-image: linear-gradient(rgba(0,0,0,.04),rgba(0,0,0,.04))!important;height: 64px;border-radius: 50%;">
                                            <span class="fal fa-traffic-light font-5"></span>
                                        </div>
                                    </div>
                                    <div class="px-2 py-2">
                                        <h6 class="font-1"> {{ __('messages.status') }} </h6>
                                        <h6 class="font-3">{{ $product->status }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>


                        <div class="col-12 px-2 mb-3">
                            <a href="#" style="color:inherit;">
                                <div class="col-12 px-2 py-2 d-flex rounded-3 main-box-wedit" style="background: #ffffff;">
                                    <div class="p-2">
                                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                                            style="background-image: linear-gradient(rgba(0,0,0,.04),rgba(0,0,0,.04))!important;height: 64px;border-radius: 50%;">
                                            <span class="fal fa-traffic-light font-5"></span>
                                        </div>
                                    </div>
                                    <div class="px-2 py-2">
                                        <h6 class="font-1"> {{ trans('messages.category') }} </h6>
                                        <h6 class="font-3">{{ $product->category->name }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-12 px-2 mb-3">
                            <a href="#" style="color:inherit;">
                                <div class="col-12 px-2 py-2 d-flex rounded-3 main-box-wedit" style="background: #ffffff;">
                                    <div class="p-2">
                                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                                            style="background-image: linear-gradient(rgba(0,0,0,.04),rgba(0,0,0,.04))!important;height: 64px;border-radius: 50%;">
                                            <span class="fal fa-traffic-light font-5"></span>
                                        </div>
                                    </div>
                                    <div class="px-2 py-2">
                                        <h6 class="font-1">{{ trans('messages.brochure') }}</h6>
                                        <h6 class="font-3">{{ $product->product_details->brochure }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-12 px-2 mb-3">
                            <a href="#" style="color:inherit;">
                                <div class="col-12 px-2 py-2 d-flex rounded-3 main-box-wedit" style="background: #ffffff;">
                                    <div class="p-2">
                                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                                            style="background-image: linear-gradient(rgba(0,0,0,.04),rgba(0,0,0,.04))!important;height: 64px;border-radius: 50%;">
                                            <span class="fal fa-traffic-light font-5"></span>
                                        </div>
                                    </div>
                                    <div class="px-2 py-2">
                                        <h6 class="font-1">{{ trans('messages.driver') }}</h6>
                                        <h6 class="font-3">{{ $product->product_details->driver }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-12 px-2 mb-3">
                            <a href="#" style="color:inherit;">
                                <div class="col-12 px-2 py-2 d-flex rounded-3 main-box-wedit"
                                    style="background: #ffffff;">
                                    <div class="p-2">
                                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                                            style="background-image: linear-gradient(rgba(0,0,0,.04),rgba(0,0,0,.04))!important;height: 64px;border-radius: 50%;">
                                            <span class="fal fa-traffic-light font-5"></span>
                                        </div>
                                    </div>
                                    <div class="px-2 py-2">
                                        <h6 class="font-1">{{ trans('messages.catalog') }}</h6>
                                        <h6 class="font-3">{{ $product->product_details->catalog }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-12 px-2 mb-3">
                            <a href="#" style="color:inherit;">
                                <div class="col-12 px-2 py-2 d-flex rounded-3 main-box-wedit"
                                    style="background: #ffffff;">
                                    <div class="p-2">
                                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                                            style="background-image: linear-gradient(rgba(0,0,0,.04),rgba(0,0,0,.04))!important;height: 64px;border-radius: 50%;">
                                            <span class="fal fa-traffic-light font-5"></span>
                                        </div>
                                    </div>
                                    <div class="px-2 py-2">
                                        <h6 class="font-1">{{ trans('messages.map') }}</h6>
                                        <h6 class="font-3">{{ $product->product_details->map }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>


                        <div class="col-12 px-2 mb-3">
                            <a href="#" style="color:inherit;">
                                <div class="col-12 px-2 py-2 d-flex rounded-3 main-box-wedit"
                                    style="background: #ffffff;">
                                    <div class="p-2">
                                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                                            style="background-image: linear-gradient(rgba(0,0,0,.04),rgba(0,0,0,.04))!important;height: 64px;border-radius: 50%;">
                                            <span class="fal fa-traffic-light font-5"></span>
                                        </div>
                                    </div>
                                    <div class="px-2 py-2">
                                        <h6 class="font-1">{{ trans('messages.description') }}</h6>
                                        <h6 class="font-3">{{ $product->description }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>



                        <div class="col-12 px-2 mb-3">
                            <a href="#" style="color:inherit;">
                                <div class="col-12 px-2 py-2 d-flex rounded-3 main-box-wedit"
                                    style="background: #ffffff;">
                                    <div class="p-2">
                                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                                            style="background-image: linear-gradient(rgba(0,0,0,.04),rgba(0,0,0,.04))!important;height: 64px;border-radius: 50%;">
                                            <span class="fal fa-traffic-light font-5"></span>
                                        </div>
                                    </div>
                                    <div class="px-2 py-2">
                                        <h6 class="font-1">{{ trans('messages.video') }}</h6>
                                        <h6 class="font-3">{{ $product->product_details->video }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-12 px-2 mb-3">
                            <a href="#" style="color:inherit;">
                                <div class="col-12 px-2 py-2 d-flex rounded-3 main-box-wedit"
                                    style="background: #ffffff;">
                                    <div class="p-2">
                                        <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                                            style="background-image: linear-gradient(rgba(0,0,0,.04),rgba(0,0,0,.04))!important;height: 64px;border-radius: 50%;">
                                            <span class="fal fa-traffic-light font-5"></span>
                                        </div>
                                    </div>
                                    <div class="px-2 py-2">
                                        <h6 class="font-1">{{ trans('messages.photo') }}</h6>
                                        <h6 class="font-3">{{ $product->product_details->photo }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
