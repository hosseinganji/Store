@extends('layouts.app')


@section('title')
    Product Create
@endsection

@section('script')
    <script>
        $("#czContainer").czMore();

        $('.multiple-with-search-select').select2();

        $(".multiple-without-search-select").select2({
            minimumResultsForSearch: Infinity
        });

        $("#category-information").hide();

        if ($("#categorySelect").val() != "select") {
            let categoryId = $("#categorySelect").val();

            if (categoryId == "select") {
                $("#category-information").hide();
            }

            // categoryId.forEach(categoryId => {
            $.get(`{{ url('admin-panel/management/category-attributes-get/${categoryId}') }}`,
                function(response, status) {
                    if (status == "success") {

                        $("#category-information").fadeIn();

                        $("#attributes_div").find("div").remove();

                        response.attributes.forEach(attribute => {
                            inputAttr = `
                            <div class="form-group col-md-3 my-3">
                                <label for="${attribute.name}">${attribute.name}</label>
                                <input type="text" name="attribute_ids[${attribute.id}]" class="form-control mt-1" id="${attribute.name}">
                            </div>`;

                            $("#attributes_div").append(inputAttr);
                        });
                        $("#variationAttribute").text(response.variation.name);
                    } else {
                        // alert("مشکل در دریافت اطلاعات دسته بندی");
                    }
                }).fail(function() {
                /* alert("مشکل در دریافت اطلاعات دسته بندی");*/
            });
        }



        $("#categorySelect").change(function() {
            let categoryId = $(this).val();
            console.log(categoryId);

            if (categoryId == "select") {
                $("#category-information").hide();
            }

            // categoryId.forEach(categoryId => {
            $.get(`{{ url('admin-panel/management/category-attributes-get/${categoryId}') }}`,
                function(response, status) {
                    if (status == "success") {

                        $("#category-information").fadeIn();

                        $("#attributes_div").find("div").remove();

                        response.attributes.forEach(attribute => {
                            inputAttr = `
                            <div class="form-group col-md-3 my-3">
                                <label for="${attribute.name}">${attribute.name}</label>
                                <input type="text" name="attribute_ids[${attribute.id}]" class="form-control mt-1" id="${attribute.name}">
                            </div>`;

                            $("#attributes_div").append(inputAttr);
                        });
                        $("#variationAttribute").text(response.variation.name);
                    } else {
                        // alert("مشکل در دریافت اطلاعات دسته بندی");
                    }
                }).fail(function() {
                /* alert("مشکل در دریافت اطلاعات دسته بندی");*/
            });
            // });

        });
    </script>
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">ایجاد محصول</h1>
    </div>

    @include('layouts.errors')

    <div class="row">
        <!-- Content Column -->
        <div class="col-lg-12 mb-4">
            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-body">

                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="form-group col-md-3 my-3">
                                <label for="name">نام</label>
                                <input class="form-control mt-1 @error('name') is-invalid @enderror" type="text"
                                    id="name" name="name" value="{{ old('name') }}">
                            </div>

                            <div class="form-group col-md-3 my-3">
                                <label for="brand_id">برند</label>
                                <select
                                    class="multiple-with-search-select form-control mt-1 @error('brand_id') is-invalid @enderror"
                                    name="brand_id">
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group col-md-3 my-3">
                                <label for="is_active">وضعیت</label>
                                <select class="multiple-without-search-select form-control mt-1" name="is_active"
                                    id="is_active">
                                    <option value="1" {{ old('is_active') == 1 ? 'selected' : '' }}>فعال</option>
                                    <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>غیر فعال</option>
                                </select>
                            </div>


                            <div class="form-group col-md-3 my-3">
                                <label for="tag_ids">تگ</label>
                                <select
                                    class="multiple-with-search-select form-control mt-1 @error('tag_ids') is-invalid @enderror"
                                    name="tag_ids[]" multiple>
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->id }}"> {{ $tag->name }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3 my-3">
                                <label for="sku">شناسه محصول (SKU)</label>
                                <input class="form-control mt-1 @error('sku') is-invalid @enderror" type="text"
                                    id="sku" name="sku" value="{{ old('sku') }}">
                            </div>


                            <div class="form-group col-md-12 my-3">
                                <label for="description">توضیحات</label>
                                <textarea class="form-control mt-1 @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <hr>
                                <p>تصاویر محصولات:</p>

                                <div class="row">
                                    <div class="form-group col-md-3 my-3">
                                        <label for="primary_image" class="form-label">تصویر اصلی</label>
                                        <input class="form-control" type="file" name="primary_image" id="primary_image"
                                            accept=".jpg , .jpeg , .png , .svg">
                                    </div>

                                    <div class="form-group col-md-3 my-3">
                                        <label for="images" class="form-label">تصاویر</label>
                                        <input class="form-control" type="file" name="images[]" id="images" multiple
                                            accept=".jpg , .jpeg , .png , .svg">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <hr>
                                <p>دسته بندی محصولات:</p>

                                <div class="form-group col-md-5 mx-auto my-3">
                                    <label for="category_id">دسته بندی</label>
                                    <select id="categorySelect" class="form-control multiple-with-search-select mt-1"
                                        name="category_id">
                                        <option value="select">دسته بندی را انتخاب کنید</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }} -
                                                {{ $category->parent->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="category-information" class="form-group col-md-12">
                                    <div class="row" id="attributes_div"></div>
                                    <div class="form-group col-md-12">
                                        <hr>
                                        <p>انتخاب ویژگی های متغیر <span class="fw-bold" id="variationAttribute"></span>:
                                        </p>

                                        <div id="czContainer">
                                            <div id="first">
                                                <div class="recordset">
                                                    <div class="row">
                                                        <div class="form-group col-md-3 my-3">
                                                            <label for="value">نام</label>
                                                            <input class="form-control mt-1" type="text" id="value"
                                                                name="variation_value[value][]">
                                                        </div>
                                                        <div class="form-group col-md-3 my-3">
                                                            <label for="price">قیمت</label>
                                                            <input class="form-control mt-1" type="text" id="price"
                                                                name="variation_value[price][]">
                                                        </div>
                                                        <div class="form-group col-md-3 my-3">
                                                            <label for="quantity">تعداد</label>
                                                            <input class="form-control mt-1" type="text" id="quantity"
                                                                name="variation_value[quantity][]">
                                                        </div>
                                                        <div class="form-group col-md-3 my-3">
                                                            <label for="sku">شناسه انبار (sku)</label>
                                                            <input class="form-control mt-1" type="text"
                                                                id="sku" name="variation_value[sku][]">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <hr>
                                <p>هزینه ارسال:</p>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-3 my-3">
                                    <label for="sendPrice">هزینه ارسال</label>
                                    <input class="form-control mt-1 @error('sendPrice') is-invalid @enderror"
                                        type="text" id="sendPrice" name="sendPrice" value="{{ old('sendPrice') }}">
                                </div>
                                <div class="form-group col-md-3 my-3">
                                    <label for="sendPricePerExtraProduct">هزینه ارسال به ازای محصول اضافی</label>
                                    <input
                                        class="form-control mt-1 @error('sendPricePerExtraProduct') is-invalid @enderror"
                                        type="text" id="sendPricePerExtraProduct" name="sendPricePerExtraProduct"
                                        value="{{ old('sendPricePerExtraProduct') }}">
                                </div>
                            </div>


                        </div>
                        <div class="mt-2">
                            <button class="btn btn-primary" type="submit">ثبت</button>
                            <a class="btn btn-outline-dark mr-2" href="{{ route('admin.products.index') }}">بازگشت</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
