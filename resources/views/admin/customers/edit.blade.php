@extends('layouts.admin')
@section('content')
<div class="col-12 p-3">
    <!-- breadcrumb -->
        <x-bread-crumb :breads="[
            ['url' => url('/admin') , 'title' => __('admin.dashboard') , 'isactive' => false],
            ['url' => route('admin.customers.index') , 'title' => __('admin.users') , 'isactive' => false],
            ['url' => route('admin.customers.show', $customer->id) , 'title' =>  $customer->name, 'isactive' => false],
            ['url' => '#' , 'title' => __('admin.edit') , 'isactive' => true],
        ]">
        </x-bread-crumb>
    <!-- /breadcrumb -->
    <div class="col-12 col-lg-12 p-0 ">


        <form id="validate-form" class="row" enctype="multipart/form-data" method="POST" action="{{route('admin.customers.update',$customer)}}">
        @csrf
        @method("PUT")
        <div class="col-12 col-lg-8 p-0 main-box">
            <div class="col-12 px-0">
                <div class="col-12 px-3 py-3">
                 	<span class="fas fa-info-circle"></span> {{__('admin.editUser')}}
                </div>
                <div class="col-12 divider" style="min-height: 2px;"></div>
            </div>
            <div class="col-12 p-3 row">


            <div class="col-12 col-lg-6 p-2">
                <div class="col-12">
                    {{__('admin.name')}}
                </div>
                <div class="col-12 pt-3">
                    <input type="text" name="name" required minlength="3"  maxlength="190" class="form-control" value="{{$customer->name}}" >
                </div>
            </div>
            <div class="col-12 col-lg-6 p-2">
                <div class="col-12">
                    {{__('admin.email')}}
                </div>
                <div class="col-12 pt-3">
                    <input type="email" name="email"  class="form-control"  value="{{$customer->email}}" >
                </div>
            </div>
            <div class="col-12 col-lg-6 p-2">
                <div class="col-12">
                    {{__('admin.password')}}
                </div>
                <div class="col-12 pt-3">
                    <input type="password" name="password"  class="form-control"  minlength="8" >
                </div>
            </div>

            <div class="col-12 col-lg-6 p-2">
                <div class="col-12">
                    {{__('admin.avatar')}}
                </div>
                <div class="col-12 pt-3">
                    <input type="file" name="avatar"  class="form-control"  accept="image/*" >
                </div>
                <div class="col-12 p-0">
                    <img src="{{$customer->getUserAvatar()}}" style="width:100px;margin-top:20px">
                </div>
            </div>

            <div class="col-12 col-lg-6 p-2">
                <div class="col-12">
                    {{__('admin.phone')}}
                </div>
                <div class="col-12 pt-3">
                    <input type="text" name="phone"   maxlength="190" class="form-control"  value="{{$customer->phone}}" >
                </div>
            </div>
            {{-- @if(auth()->user()->can('customer-roles-update')) --}}
            <div class="col-12 col-lg-6 p-2">
                <div class="col-12">
                    {{__('admin.roles')}}
                </div>
                <div class="col-12 pt-3">
                    <select class="form-control select2-select" name="roles[]" multiple required>
                        @foreach($roles as $role)
                            <option value="{{$role->id}}" @if($customer->hasRole($role->name)) selected @endif>{{$role->display_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- @endif --}}
            <div class="col-12 col-lg-6 p-2">
                <div class="col-12">
                    {{__('admin.bio')}}
                </div>
                <div class="col-12 pt-3">
                    <textarea  name="bio" maxlength="5000" class="form-control" style="min-height:150px">{{$customer->bio}}</textarea>
                </div>
            </div>
            <div class="col-12 col-lg-6 p-2">
                <div class="col-12">
                    {{__('admin.blocked')}}
                </div>
                <div class="col-12 pt-3">
                    <select class="form-control" name="blocked">
                        <option @if($customer->blocked=="0") selected @endif value="0">{{__('admin.no')}}</option>
                        <option @if($customer->blocked=="1") selected @endif value="1">{{__('admin.yes')}}</option>
                    </select>
                </div>
            </div>
            </div>

        </div>

        <div class="col-12 p-3">
            <button class="btn btn-success" id="submitEvaluation">{{__('admin.save')}}</button>
        </div>
        </form>
    </div>
</div>
@endsection
