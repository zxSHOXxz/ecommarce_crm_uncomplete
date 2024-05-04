@extends('layouts.admin')
@section('content')
    <div class="col-12 p-3">

        <div class="col-12 col-lg-12 p-0 ">

            <form id="validate-form" class="row" enctype="multipart/form-data" method="POST"
                action="{{ route('admin.customers.update', $customer->id) }}">
                @method('PUT')
                @csrf

                <div class="col-12 col-lg-8 p-0 main-box">
                    <div class="col-12 px-0">
                        <div class="col-12 px-3 py-3">
                            <span class="fas fa-info-circle"></span> {{ __('admin.editCustomer') }}
                        </div>
                        <div class="col-12 divider" style="min-height: 2px;"></div>
                    </div>
                    <div class="col-12 p-3 row">

                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                {{ __('admin.name') }}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="text" name="name" minlength="3" maxlength="190" class="form-control"
                                    value="{{ $customer->name }}">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                {{ __('admin.email') }}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="email" name="email" class="form-control" value="{{ $customer->email }}">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                {{ __('admin.password') }}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="password" name="password" class="form-control" minlength="8" value="">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                {{ __('admin.image') }}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="file" name="avatar" class="form-control" accept="image/*">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                {{ __('admin.phone') }}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="text" name="phone" maxlength="190" class="form-control"
                                    value="{{ $customer->phone }}">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                {{ __('admin.customer_discount') }}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="number" name="customer_discount" class="form-control"
                                    value="{{ $customer->customer_discount }}">
                            </div>
                        </div>


                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                {{ __('admin.customerType') }}
                            </div>
                            <div class="col-12 pt-3">
                                <select class="form-control" name="customer_type">
                                    <option @if ($customer->customer_type == 'b2c') selected @endif value="b2c">
                                        {{ __('admin.b2c') }}</option>
                                    <option @if ($customer->customer_type == 'b2b') selected @endif value="b2b">
                                        {{ __('admin.b2b') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 p-2 b2b @if ($customer->customer_type == 'b2c') return d-none ; @endif">
                            <div class="col-12">
                                Files
                            </div>
                            <div class="col-12 pt-3">
                                <input type="file" name="b2b_files[]" class="form-control" multiple
                                    accept=".pdf,.jpg,.jpeg,.png">
                            </div>
                            <div class="col-12 pt-3">
                                @if ($customer->b2b_files)
                                    <ul>
                                        @foreach (json_decode($customer->b2b_files) as $filePath)
                                            <li>
                                                <a href="{{ asset('storage/' . $filePath) }}" target="_blank"><span
                                                        class="badge bg-danger">
                                                        {{ basename($filePath) }}</span></a>

                                            </li>
                                        @endforeach
                                    </ul>
                                @endif

                            </div>
                        </div>

                        <div class="col-12 col-lg-6 p-2 b2b @if ($customer->customer_type == 'b2c') return d-none ; @endif">
                            <div class="col-12">
                                {{ __('admin.companyName') }}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="text" name="company_name" maxlength="190" class="form-control"
                                    value="{{ $customer->company_name }}">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 p-2 b2b @if ($customer->customer_type == 'b2c') return d-none ; @endif">
                            <div class="col-12">
                                {{ __('admin.companyAddress') }}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="text" name="company_address" maxlength="190" class="form-control"
                                    value="{{ $customer->company_address }}">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 p-2 b2b @if ($customer->customer_type == 'b2c') return d-none ; @endif">
                            <div class="col-12">
                                {{ __('admin.companyCountry') }}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="text" name="company_country" maxlength="190" class="form-control"
                                    value="{{ $customer->company_country }}">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 p-2 b2b @if ($customer->customer_type == 'b2c') return d-none ; @endif">
                            <div class="col-12">
                                {{ __('admin.vatNumber') }}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="text" name="vat_number" maxlength="190" class="form-control"
                                    value="{{ $customer->vat_number }}">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                {{ __('admin.blocked') }}
                            </div>
                            <div class="col-12 pt-3">
                                <select class="form-control" name="blocked">
                                    <option @if ($customer->blocked == '0') selected @endif value="0">
                                        {{ __('admin.no') }}</option>
                                    <option @if ($customer->blocked == '1') selected @endif value="1">
                                        {{ __('admin.yes') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                {{ __('admin.description') }}
                            </div>
                            <div class="col-12 pt-3">
                                <textarea name="bio" maxlength="5000" class="form-control" style="min-height:150px">{{ $customer->bio }}</textarea>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                {{ __('admin.shiping_data') }}
                            </div>
                            <div class="col-12 pt-3">
                                <textarea name="shiping_data" maxlength="5000" class="form-control" style="min-height:150px">{{ $customer->shiping_data }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 p-3">
                        <button class="btn btn-success" id="submitEvaluation">{{ __('admin.save') }}</button>
                    </div>
            </form>
        </div>
    </div>

    <script>
        let select = document.querySelector("select[name=customer_type]");
        select.addEventListener("change", function() {
            if (this.value === "b2b") {
                console.log("b2b");
                var inputs_b2b = document.querySelectorAll(".b2b")
                inputs_b2b.forEach(element => {
                    element.classList.remove('d-none');
                });
            }
            if (this.value === "b2c") {
                console.log("b2c");
                var inputs_b2b = document.querySelectorAll(".b2b")
                inputs_b2b.forEach(element => {
                    element.classList.add('d-none');
                });

            }
        });
    </script>
@endsection
