@extends('layouts.app')

@section('title')
    Category Edit
@endsection

@section('script')
    <script>
        $("#attributeSelect").change(function() {
            let attributeSelected = $(this).val();
            let inStockAttributes = @json($attributes);


            let isFilter = [];

            inStockAttributes.map((attribute) => {
                $.each(attributeSelected, function(i, element) {
                    if (attribute.id == element) {
                        isFilter.push(attribute);
                    }
                });
            });

            $("#isFilterAttributes").find("option").remove();
            $("#variationAttribute").find("option").remove();

            isFilter.forEach((element) => {
                let attributeOptionForFilter = $("<option/>", {
                    value: element.id,
                    text: element.name
                });
                let attributeOptionForVar = $("<option/>", {
                    value: element.id,
                    text: element.name
                });
                $("#isFilterAttributes").append(attributeOptionForFilter);
                $("#variationAttribute").append(attributeOptionForVar);
            });

        });


        $('.multiple-select').select2();

        $('.multiple-select').on('select2:opening select2:closing', function(event) {
            var $searchfield = $(this).parent().find('.select2-search__field');
            $searchfield.prop('disabled', true);
        });
    </script>
@endsection


@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">ویرایش دسته بندی "{{ $category->name }}"</h1>
    </div>

    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-12 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-body">

                    <form action="{{ route('admin.categories.update', ['category' => $category->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row">

                            <div class="row">
                                <div class="form-group col-md-3 mb-3">
                                    <img class="img-thumbnail"
                                        src="{{ url(env('CATEGORY_PATH_IMAGES') . '/' . $category->image) }}"
                                        alt="{{ $category->image }}">
                                </div>
                            </div>

                            <div class="row">

                                <div class="form-group col-md-3 my-3">
                                    <label for="category_image" class="form-label mb-1">تصویر دسته بندی</label>
                                    <input class="form-control" type="file" name="category_image" id="category_image"
                                        accept=".jpg , .jpeg , .png , .svg">
                                </div>

                                <div class="form-group col-md-3 my-3">
                                    <label for="name">نام</label>
                                    <input class="form-control mt-1" type="text" id="name" name="name"
                                        value="{{ $category->name }}">
                                    @error('name')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


                                <div class="form-group col-md-3 my-3">
                                    <label for="slug">نام انگلیسی</label>
                                    <input class="form-control mt-1" type="text" id="slug" name="slug"
                                        value="{{ $category->slug }}">
                                    @error('slug')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


                                <div class="form-group col-md-3 my-3">
                                    <label for="parent_id">والد</label>
                                    <select class="form-control mt-1" name="parent_id" id="parent_id">
                                        <option value="0">بدون والد</option>
                                        @foreach ($parentCategories as $parentCategory)
                                            <option value="{{ $parentCategory->id }}"
                                                {{ $parentCategory->id == $category->parent_id ? 'selected' : '' }}>
                                                {{ $parentCategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>



                                <div class="form-group col-md-3 my-3">
                                    <label for="is_active">وضعیت</label>
                                    <select class="form-control mt-1" name="is_active" id="is_active">
                                        <option value="1"
                                            @if ($category->is_active == 1) {{ 'selected' }} @endif>فعال</option>
                                        <option value="0"
                                            @if ($category->is_active == 0) {{ 'selected' }} @endif>غیر فعال</option>
                                    </select>
                                </div>


                                <div class="form-group col-md-3 my-3">
                                    <label for="attributes_ids">ویژگی ها</label>
                                    <select id="attributeSelect"
                                        class="form-control multiple-select mt-1 @error('attributes_ids') is-invalid @enderror"
                                        name="attributes_ids[]" multiple data-live-search="true">
                                        @foreach ($attributes as $attribute)
                                            <option value="{{ $attribute->id }}"
                                                {{ in_array($attribute->id,$category->attributes()->pluck('id')->toArray())? 'selected': '' }}>
                                                {{ $attribute->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('attributes_ids')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


                                <div class="form-group col-md-3 my-3">
                                    <label for="isFilterAttributes">ویژگی های قابل فیلتر</label>
                                    <select id="isFilterAttributes"
                                        class="form-control multiple-select mt-1 @error('isFilterAttributes') is-invalid @enderror"
                                        name="isFilterAttributes[]" multiple data-live-search="true">
                                        @foreach ($category->attributes()->wherePivot('is_filter', 1)->get() as $attribute)
                                            <option value="{{ $attribute->id }}" selected>{{ $attribute->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('isFilterAttributes')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


                                <div class="form-group col-md-3 my-3">
                                    <label for="variationAttribute">ویژگی های متغیر</label>
                                    <select id="variationAttribute"
                                        class="form-control mt-1 @error('variationAttribute') is-invalid @enderror"
                                        name="variationAttribute" data-live-search="true">
                                        <option
                                            value="{{ $category->attributes()->wherePivot('is_variation', 1)->first()->id }}">
                                            {{ $category->attributes()->wherePivot('is_variation', 1)->first()->name }}
                                        </option>
                                    </select>
                                    @error('variationAttribute')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3 my-3">
                                    <label for="icon">آیکون</label>
                                    <input class="form-control mt-1" type="text" id="icon" name="icon"
                                        value="{{ $category->icon }}">
                                    @error('icon')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>



                                <div class="form-group col-md-12 my-3">
                                    <label for="description">توضیحات</label>
                                    <textarea class="form-control mt-1" id="description" name="description">{{ $category->description }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


                            </div>
                            <div class="mt-2">
                                <button class="btn btn-warning" type="submit">ویرایش</button>
                                <a class="btn btn-outline-dark mr-2"
                                    href="{{ route('admin.categories.index') }}">بازگشت</a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
