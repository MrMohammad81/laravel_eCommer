@extends('admin.layouts.admin')

@section('title')
    ویرایش دسته بندی
@endsection


@section('script')
    <script type="text/javascript">
        $('#attributeSelect').selectpicker();

        $('#attributeSelect').on('changed.bs.select' , function (){
            var attributeSelected = $('#attributeSelect').val();
            var attributes = @json($attributes);

            var attributeForFilter = [];

            attributes.map((attribute) => {
                $.each(attributeSelected , function (i,element) {
                    if (attribute.id == element) {
                        attributeForFilter.push(attribute);
                    }
                });
            });

            $('#attributeIsFilterSelect , #variationSelect').html('');

            attributeForFilter.forEach((element) => {
                $("<option/>" , {
                    value : element.id,
                    text : element.name
                }).appendTo('#attributeIsFilterSelect , #variationSelect')
            });
            $('#attributeIsFilterSelect , #variationSelect').selectpicker('refresh');
        });
    </script>
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">
            <div class="mb-4">
                <h5 class="font-weight-bold">بروزرسانی دسته بندی :  {{ $category->name }}</h5>
            </div>
            <hr>
            @include('admin.sections.errors')
            <form action="{{ route('admin.categories.update' , $category->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" name="name" type="text" value="{{ $category->name }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="slug">نام انگلیسی</label>
                        <input class="form-control" id="slug" name="slug" type="text" value="{{ $category->slug }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="parent_id">والد</label>
                        <select class="form-control" id="parent_id" name="parent_id">
                            <option value="0">بدون والد</option>
                            @foreach ($parentCategories as $parentCategory)
                                <option value="{{ $parentCategory->id }}"
                                    {{ $category->parent_id == $parentCategory->id ? 'selected' : '' }} >
                                    {{ $parentCategory->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1" {{ $category->getRawOriginal('is_active') ? 'selected' : '' }}>فعال</option>
                            <option value="0" {{ $category->getRawOriginal('is_active') ? '' : 'selected' }}>غیرفعال</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="attribute_ids">ویژگی</label>
                        <select id="attributeSelect" name="attribute_ids[]" class="selectpicker form-control " multiple data-live-search="true" title="انتخاب ویژگی">
                            @foreach($attributes as $attribute)
                                <option value="{{ $attribute->id }}"
                                 {{ in_array($attribute->id , $category->attributes()->pluck('id')->toArray() ) ? 'selected' : '' }}>{{ $attribute->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="attribute_is_filter_ids">انتخاب ویژگی های قابل فیلتر</label>
                        <select id="attributeIsFilterSelect" name="attribute_is_filter_ids[]" class="form-control selectpicker" title="انتخاب ویژگی" multiple data-live-search="true">
                            @foreach ($category->attributes()->wherePivot('is_filter' , 1)->get() as $attribute)
                                <option value="{{ $attribute->id }}" selected>{{ $attribute->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="attribute_is_filter_ids">انتخاب ویژگی متغیر</label>
                        <select id="variationSelect" name="variation_id" class="form-control selectpicker" data-live-search="true" title="انتخاب ویژگی">
                                <option value="{{ $category->attributes()->wherePivot('is_variation' , 1)->first()->id }}" selected>{{ $category->attributes()->wherePivot('is_variation' , 1)->first()->name }}</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="icon">آیکون</label>
                        <input class="form-control" id="icon" name="icon" type="text" value="{{ $category->icon }}">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" id="description" name="description">{{ $category->description }}</textarea>
                    </div>

                </div>

                <button class="btn  mt-5 btn-success" type="submit">بروزرسانی</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-dark mt-5 mr-3">بازگشت</a>
            </form>
        </div>

    </div>

@endsection
