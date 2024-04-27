@extends('layouts.admin')
@section('content')
    <div class="col-12 p-3">
        <div class="col-12 col-lg-12 p-0 ">
            <form id="validate-form" class="row" enctype="multipart/form-data" method="POST"
                action="{{ route('admin.orders.store') }}">
                @csrf
                <div class="col-12 col-lg-8 p-0 main-box">
                    <div class="col-12 px-0">
                        <div class="col-12 px-3 py-3">
                            <span class="fas fa-info-circle"></span> {{ __('messages.create_order') }}
                        </div>
                        <div class="col-12 divider" style="min-height: 2px;"></div>
                    </div>

                    <div class="col-12 col-lg-6 p-2">
                        <div class="col-12">
                            {{ __('messages.customer') }}
                        </div>
                        <div class="col-12 pt-3">
                            <select class="form-control" name="customer_id">
                                @foreach ($customers as $customer)
                                    <option @if (old('customer_id') == $customer->id) selected @endif value="{{ $customer->id }}">
                                        {{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 p-2">
                        <div class="col-12">
                            {{ __('messages.products') }}
                        </div>
                        <div class="col-12 pt-3">
                            <select class="form-control" name="products[0][id]">
                                @foreach ($products as $product)
                                    <option @if (old('product_id') == $product->id) selected @endif value="{{ $product->id }}">
                                        {{ $product->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            {{ __('messages.quantity') }}
                        </div>
                        <div class="col-12 pt-3">
                            <input type="number" class="form-control" name="products[0][quantity]">
                        </div>
                    </div>

                    <div id="productsContainer" class="col-12 col-lg-6 p-2">
                    </div>
                    <button type="button" id="AddProduct">Add another product</button>
                </div>
                <div class="col-12 p-3">
                    <button class="btn btn-success" id="submitEvaluation">{{ __('messages.SAVE') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let productIndex = 1;

        let addProductButton = document.getElementById('AddProduct');
        addProductButton.addEventListener('click', function() {
            let productsContainer = document.getElementById('productsContainer');
            let productDiv = document.createElement('div');
            productDiv.classList.add('col-12');
            productDiv.classList.add('p-2');
            productDiv.innerHTML = `
                <div class="col-12">
                    {{ __('messages.products') }}
                </div>
                <div class="col-12 pt-3">
                    <select class="form-control" name="products[${productIndex}][id]">
                        @foreach ($products as $product)
                            <option @if (old('product_id') == $product->id) selected @endif value="{{ $product->id }}">
                                {{ $product->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    {{ __('messages.quantity') }}
                </div>
                <div class="col-12 pt-3">
                    <input type="number" class="form-control" name="products[${productIndex}][quantity]">
                </div>
            `;
            productsContainer.appendChild(productDiv);
            productIndex++;
        });
    </script>
@endsection
