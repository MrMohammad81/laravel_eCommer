@extends('admin.layouts.admin')

@section('title')
    نمایش نقش
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">نمایش نقش {{ $role->display_name }}</h5>
            </div>
            <hr>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام نمایشی</label>
                        <input disabled class="form-control" name="display_name" type="text" value="{{ $role->display_name }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="name">نام انگلیسی</label>
                        <input disabled class="form-control" id="name" name="name" type="text" value="{{ $role->name }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="name">تاریخ ایجاد</label>
                        <input disabled class="form-control" id="name" name="name" type="text" value="{{ verta($role->created_at)->format('%d %B %Y   H:i') }}">
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

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionPermision">
                                <div class="card-body row">
                                    @foreach($role->permissions as $permision)
                                        <div class="form-group form-check">
                                            <span>{{ $permision->display_name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             <a href="{{ route('admin.roles.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
        </div>

    </div>

@endsection
