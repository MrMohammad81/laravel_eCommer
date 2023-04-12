@extends('admin.layouts.admin')

@section('title')
    ویرایش کاربر
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">بروزرسانی کاربر {{ $user->name }}</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.users.update' , $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" name="name" type="text" value="{{ $user->name }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="name">شماره تلفن</label>
                        <input class="form-control" name="cellphone" type="text" value="{{ $user->cellphone }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="exampleFormControlSelect1">نقش کاربر</label>
                        <select class="form-control" name="role">
                            <option></option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ in_array($role->id , $user->roles->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $role->display_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="name">ایمیل</label>
                        <input class="form-control" name="email" type="text" value="{{ $user->email }}">
                    </div>

                    <div class="accordion col-md-12 mt-3" id="accordionPermision">
                        <div class="card">
                            <div class="card-header p-1" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-right" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        مجوزهای دسترسی
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionPermision">
                                <div class="card-body row">
                                    @foreach($permissions as $permision)
                                        <div class="form-group form-check">
                                            <label class="form-check-label mr-3" for="permision-{{ $permision->id }}">{{ $permision->display_name }}</label>
                                            <input type="checkbox" class="form-check-input mr-1" name="{{ $permision->name }}" value="{{ $permision->name }}"
                                                {{ in_array($permision->id , $user->permissions->pluck('id')->toArray()) ? 'checked' : '' }}>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <button class="btn btn-success mt-5" type="submit">بروزرسانی</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>
    </div>

@endsection
