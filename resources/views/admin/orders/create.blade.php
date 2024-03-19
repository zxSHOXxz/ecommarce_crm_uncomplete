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
                            <span class="fas fa-info-circle"></span> CREATE NEW OEDER
                        </div>
                        <div class="col-12 divider" style="min-height: 2px;"></div>
                    </div>
                    <div class="col-12 p-3 row">
                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                Customer :
                            </div>
                            <div class="col-12 pt-3">
                                <select class="form-control" name="customer_id">
                                    @foreach ($customers as $customer)
                                        <option @if (old('customer_id') == $customer->id) selected @endif
                                            value="{{ $customer->id }}"> {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="product-container">
                            <div class="col-12 col-lg-6">
                                <div class="col-12">
                                    Products :
                                </div>
                                <div class="col-12 pt-3">
                                    <button type="button" class="btn btn-primary" id="add-product">Add Product</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 p-3">
                    <button class="btn btn-success" id="submitEvaluation">SAVE</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('add-product').addEventListener('click', function() {
            var container = document.querySelector('.product-container');
            var productCount = container.querySelectorAll('.product-row').length;

            var productRow = document.createElement('div');
            productRow.classList.add('col-12', 'col-lg-6', 'p-2', 'product-row');

            var productSelect = document.createElement('div');
            productSelect.classList.add('col-12');

            var select = document.createElement('select');
            select.classList.add('form-control');
            select.setAttribute('name', 'products[' + productCount + '][id]');

            @foreach ($products as $product)
                var option = document.createElement('option');
                option.setAttribute('value', '{{ $product->id }}');
                option.textContent = '{{ $product->title }}';
                select.appendChild(option);
            @endforeach

            productSelect.appendChild(select);
            productRow.appendChild(productSelect);

            var quantityInput = document.createElement('div');
            quantityInput.classList.add('col-12', 'pt-3');

            var input = document.createElement('input');
            input.setAttribute('type', 'text');
            input.setAttribute('name', 'products[' + productCount + '][quantity]');
            input.classList.add('form-control');
            input.setAttribute('placeholder', 'Quantity');

            quantityInput.appendChild(input);
            productRow.appendChild(quantityInput);

            container.appendChild(productRow);
        });
    </script>
@endsection
