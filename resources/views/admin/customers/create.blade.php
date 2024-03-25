@extends('layouts.admin')
@section('content')
    <div class="col-12 p-3">
        <!-- breadcrumb -->
        <x-bread-crumb :breads="[
            ['url' => url('/admin'), 'title' => __('admin.dashboard'), 'isactive' => false],
            ['url' => route('admin.customers.index'), 'title' => __('admin.customers'), 'isactive' => false],
            ['url' => '#', 'title' => __('admin.addCustomers'), 'isactive' => true],
        ]">
        </x-bread-crumb>
        <!-- /breadcrumb -->
        <div class="col-12 col-lg-12 p-0 ">


            <form id="validate-form" class="row" enctype="multipart/form-data" method="POST"
                action="{{ route('admin.customers.store') }}">
                @csrf

                <div class="col-12 col-lg-8 p-0 main-box">
                    <div class="col-12 px-0">
                        <div class="col-12 px-3 py-3">
                            <span class="fas fa-info-circle"></span> {{ __('admin.createNewCustomer') }}
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
                                    class="form-control" value="{{ old('name') }}">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                {{ __('admin.email') }}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                {{ __('admin.password') }}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="password" name="password" class="form-control" required minlength="8">
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
                                    value="{{ old('phone') }}">
                            </div>
                        </div>
                        @if (auth()->user()->can('user-roles-update'))
                            <div class="col-12 col-lg-6 p-2">
                                <div class="col-12">
                                    {{ __('admin.permission') }}
                                </div>
                                <div class="col-12 pt-3">
                                    <select class="form-control select2-select" name="roles[]" multiple required>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                {{ __('admin.customerType') }}
                            </div>
                            <div class="col-12 pt-3">
                                <select class="form-control" name="customer_type">
                                    <option @if (old('customer_type') == 'b2c') selected @endif value="b2c">
                                        {{ __('admin.b2c') }}</option>
                                    <option @if (old('customer_type') == 'b2b') selected @endif value="b2b">
                                        {{ __('admin.b2b') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 p-2 b2b d-none">
                            <div class="col-12">
                                {{ __('admin.companyName') }}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="text" name="company_name" maxlength="190" class="form-control"
                                    value="{{ old('company_name') }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 p-2 b2b d-none">
                            <div class="col-12">
                                {{ __('admin.companyAddress') }}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="text" name="company_address" maxlength="190" class="form-control"
                                    value="{{ old('company_address') }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 p-2 b2b d-none">
                            <div class="col-12">
                                {{ __('admin.companyCountry') }}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="text" name="company_country" maxlength="190" class="form-control"
                                    value="{{ old('company_country') }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 p-2 b2b d-none">
                            <div class="col-12">
                                {{ __('admin.vatNumber') }}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="text" name="vat_number" maxlength="190" class="form-control"
                                    value="{{ old('vat_number') }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                {{ __('admin.blocked') }}
                            </div>
                            <div class="col-12 pt-3">
                                <select class="form-control" name="blocked">
                                    <option @if (old('blocked') == '0') selected @endif value="0">
                                        {{ __('admin.no') }}</option>
                                    <option @if (old('blocked') == '1') selected @endif value="1">
                                        {{ __('admin.yes') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                {{ __('admin.description') }}
                            </div>
                            <div class="col-12 pt-3">
                                <textarea name="bio" maxlength="5000" class="form-control" style="min-height:150px">{{ old('bio') }}</textarea>
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
