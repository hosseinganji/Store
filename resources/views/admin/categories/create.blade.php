@extends('layouts.app')


@section('title')
    Category Create
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

        $(".multiple-without-search-select").select2({
            minimumResultsForSearch: Infinity,
        });

        $("#attributeSelect").select2({
            placeholder: "یک یا چند گزینه را انتخاب کنید",
        });

        $("#isFilterAttributes").select2({
            placeholder: "یک یا چند گزینه را انتخاب کنید",
        });

    </script>
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">ایجاد دسته بندی</h1>
    </div>

    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-12 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    @error('name')
                    @enderror
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="form-group col-md-3 my-3">
                                <label for="name">نام</label>
                                <input class="form-control mt-1 @error('name') is-invalid @enderror" type="text"
                                    id="name" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-3 my-3">
                                <label for="slug">نام انگلیسی</label>
                                <input class="form-control mt-1 @error('slug') is-invalid @enderror" type="text"
                                    id="slug" name="slug" value="{{ old('slug') }}">
                                @error('slug')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>



                            <div class="form-group col-md-3 my-3">
                                <label for="parent_id">والد</label>
                                <select class="multiple-without-search-select form-control mt-1" name="parent_id"
                                    id="parent_id">
                                    <option value="0" selected>بدون والد</option>
                                    @foreach ($parentCategories as $parentCategory)
                                        <option value="{{ $parentCategory->id }}">{{ $parentCategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group col-md-3 my-3">
                                <label for="is_active">وضعیت</label>
                                <select class="multiple-without-search-select form-control mt-1" name="is_active"
                                    id="is_active">
                                    <option value="1" selected>فعال</option>
                                    <option value="0">غیر فعال</option>
                                </select>
                            </div>


                            <div class="form-group col-md-3 my-3">
                                <label for="attributes_ids">ویژگی ها</label>
                                <select id="attributeSelect"
                                    class="form-control multiple-without-search-select mt-1 @error('attributes_ids') is-invalid @enderror"
                                    name="attributes_ids[]" multiple data-live-search="true">
                                    @foreach ($attributes as $attribute)
                                        <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
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
                                    class="form-control multiple-without-search-select mt-1 @error('isFilterAttributes') is-invalid @enderror"
                                    name="isFilterAttributes[]" multiple data-live-search="true">
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
                                    class="multiple-without-search-select form-control mt-1 @error('variationAttribute') is-invalid @enderror"
                                    name="variationAttribute" data-live-search="true">
                                </select>
                                @error('variationAttribute')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group col-md-3 my-3">
                                <label for="category_image" class="form-label mb-1">تصویر دسته بندی</label>
                                <input class="form-control" type="file" name="category_image" id="category_image"
                                    accept=".jpg , .jpeg , .png , .svg" >
                            </div>

                            <div class="form-group col-md-3 my-3">
                                <label for="icon">آیکون</label>
                                <input class="form-control mt-1 @error('icon') is-invalid @enderror" type="text"
                                    id="icon" name="icon" value="{{ old('icon') }}">
                                @error('icon')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <div class="form-group col-md-12 my-3">
                                <label for="description">توضیحات</label>
                                <textarea class="form-control mt-1 @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>
                        <div class="mt-2">
                            <button class="btn btn-primary" type="submit">ثبت</button>
                            <a class="btn btn-outline-dark mr-2" href="{{ route('admin.categories.index') }}">بازگشت</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        // console.log("isFilterAttributes");

        //   console.log(document.getElementById("attributeSelect").onchange);

        // // $("#attributeSelect").change(function() {
        // //   alert( "Handler for .change() called." );
        // // });

        // // $( "#attributeSelect" ).click(function() {
        // //   alert( "Handler for .change() called." );
        // // });

        // function preferedBrowser() {
        //   // prefer = document.forms[4].browsers.value;
        //   let p = document.getElementById("attributeSelect").value;
        //   console.log(p);
        //   // alert("You prefer browsing internet with " + prefer);
        // }
    </script>
@endsection
