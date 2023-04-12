@extends('admin.layouts.admin')

@section('title')
افزودن نقش
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">ایجاد نقش</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام نمایشی</label>
                        <input class="form-control" name="display_name" type="text">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="name">نام انگلیسی</label>
                        <input class="form-control" id="name" name="name" type="text">
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
                                            <input type="checkbox" class="form-check-input mr-1" name="{{ $permision->name }}" value="{{ $permision->name }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
