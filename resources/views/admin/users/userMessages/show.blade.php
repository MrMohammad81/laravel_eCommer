@extends('admin.layouts.admin')

@section('title')
     پیام {{ $contactUs->name }}
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="form-row">
                    <label for="name">متن پیام</label>
                    <textarea class="form-control" id="description" disabled name="description">{{ $contactUs->text }}</textarea>
                </div>
            </div>
                <a href="{{ route('admin.user-messages.index') }}" class="btn btn-dark mt-5">بازگشت</a>
        </div>

@endsection
