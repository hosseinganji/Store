@extends('layouts.app')

@section('title')
    Product Edit
@endsection

@section('script')
    <link rel="stylesheet"
        href="http://babakhani.github.io/PersianWebToolkit/beta/lib/persian-datepicker/dist/css/persian-datepicker.css" />
    {{-- <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script> --}}
    <script src="http://babakhani.github.io/PersianWebToolkit/beta/lib/persian-date/dist/persian-date.js"></script>
    <script src="http://babakhani.github.io/PersianWebToolkit/beta/lib/persian-datepicker/dist/js/persian-datepicker.js">
    </script>
{{-- <link rel="stylesheet" href="/css/persian-datepicker.min.css" />
    <script src="/js/persian-date.min.js"></script>
    <script src="/js/persian-datepicker.min.js"></script> --}}

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css">
    <script type="text/javascript" src="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.js"></script>

    <script src="/js/jquery.czMore-latest.js"></script>
    <script>
        $("#czContainer").czMore();

        $('.multiple-with-search-select').select2();

        $(".multiple-without-search-select").select2({
            minimumResultsForSearch: Infinity
        });

            $(".date-picker").persianDatepicker({
                observer: false,
                initialValue: false,
                autoClose: true,
                minDate: 1678696971399,
                calendarType: "persian",
                format: 'YYYY-MM-DD HH:mm:ss',
                persianDigit: false,
                timePicker: {
                    enabled: true,
                    meridiem: {
                        enabled: false
                    }
                },
                navigator: {
                    text: {
                        btnNextText: ">",
                        btnPrevText: "<"
                    }
                },
            });
            
        $("#category-information").hide();

        // product_category_id = '<?php echo $product->category->id; ?>';
        // console.log(categoryId);
        $("#categorySelect").change(function() {

            categoryIdSelected = $(this).val();

            // if (categoryIdSelected == product_category_id) {

            // } else {
            let remove = $("#variationPart").remove();

            $.get(`{{ url('admin-panel/management/category-attributes-get/${categoryIdSelected}') }}`,
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
            // }
        });
    </script>
@endsection


@section('content')
    <!-- Page Heading -->

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">ویرایش محصول "{{ $product->name }}"</h1>
    </div>

    @include('layouts.errors')


    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form id="edit-form" action="{{ route('admin.products.update', ['product' => $product->id]) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row">

                                <div class="form-group col-md-3 my-3">
                                    <label for="name">نام</label>
                                    <input class="form-control mt-1" type="text" id="name" name="name"
                                        value="{{ $product->name }}">
                                </div>

                                <div class="form-group col-md-3 my-3">
                                    <label for="brand_id">برند</label>
                                    <select
                                        class="multiple-with-search-select form-control mt-1 @error('brand_id') is-invalid @enderror"
                                        name="brand_id">
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ $brand->id == $product->brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3 my-3">
                                    <label for="is_active">وضعیت</label>
                                    <select class="form-control mt-1" name="is_active" id="is_active">
                                        <option value="1" @if ($product->is_active == 1) {{ 'selected' }} @endif>
                                            فعال</option>
                                        <option value="0" @if ($product->is_active == 0) {{ 'selected' }} @endif>
                                            غیر فعال</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-3 my-3">
                                    <label for="tag_ids">تگ</label>
                                    <select
                                        class="multiple-with-search-select form-control mt-1 @error('tag_ids') is-invalid @enderror"
                                        name="tag_ids[]" multiple>
                                        @php
                                            $productTag = $product
                                                ->tags()
                                                ->pluck('id')
                                                ->toArray();
                                        @endphp
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}"
                                                {{ in_array($tag->id, $productTag) ? 'selected' : '' }}>
                                                {{ $tag->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3 my-3">
                                    <label for="sku">شناسه محصول (SKU)</label>
                                    <input class="form-control mt-1" type="text" id="sku" name="sku"
                                        value="{{ $product->slug }}">
                                </div>

                                <div class="form-group col-md-12 my-3">
                                    <label for="description">توضیحات</label>
                                    <textarea class="form-control mt-1" id="description" name="description">{{ $product->description }}</textarea>
                                </div>

                                <div class="form-group col-md-12">
                                    <hr>
                                    <p>هزینه ارسال:</p>
                                </div>

                                <div class="form-group col-md-3 my-3">
                                    <label for="sendPrice">هزینه ارسال</label>
                                    <input class="form-control mt-1 @error('sendPrice') is-invalid @enderror" type="text"
                                        id="sendPrice" name="sendPrice" value="{{ $product->delivery_amount }}">
                                </div>

                                <div class="form-group col-md-3 my-3">
                                    <label for="sendPricePerExtraProduct">هزینه ارسال به ازای محصول اضافی</label>
                                    <input class="form-control mt-1 @error('sendPricePerExtraProduct') is-invalid @enderror"
                                        type="text" id="sendPricePerExtraProduct" name="sendPricePerExtraProduct"
                                        value="{{ $product->delivery_amount_per_product }}">
                                </div>

                                <div class="form-group col-md-12">
                                    <hr>
                                    <p>دسته بندی و ویژگی ها:</p>
                                </div>

                                <div class="form-group col-md-5 mx-auto my-3">
                                    <label for="category_id">دسته بندی</label>
                                    <select id="categorySelect" class="form-control multiple-with-search-select mt-1"
                                        name="category_id">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $product->category->id == $category->id ? 'selected' : '' }}>
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
                                                            <input class="form-control mt-1" type="text"
                                                                id="price" name="variation_value[price][]">
                                                        </div>
                                                        <div class="form-group col-md-3 my-3">
                                                            <label for="quantity">تعداد</label>
                                                            <input class="form-control mt-1" type="text"
                                                                id="quantity" name="variation_value[quantity][]">
                                                        </div>
                                                        <div class="form-group col-md-3 my-3">
                                                            <label for="sku">شناسه انبار (sku)</label>
                                                            <input class="form-control mt-1" type="text"
                                                                id="sku" name="variation_value[sku][]">
                                                        </div>
                                                        <div class="form-group col-md-3 my-3">
                                                            <label for="sale_price">قیمت تخفیفی</label>
                                                            <input class="form-control mt-1" type="text"
                                                                id="sale_price" name="variation_value[sale_price][]">
                                                        </div>
                                                        <div class="form-group col-md-3 my-3">
                                                            <label for="date_on_sale_from">تاریخ شروع تخفیف</label>
                                                            <input class="date-picker form-control mt-1" type="text"
                                                                id="date_on_sale_from"
                                                                name="variation_value[date_on_sale_from][]">
                                                        </div>
                                                        <div class="form-group col-md-3 my-3">
                                                            <label for="date_on_sale_to">تاریخ پایان تخفیف</label>
                                                            <input class="date-picker form-control mt-1" type="text"
                                                                id="date_on_sale_to"
                                                                name="variation_value[date_on_sale_to][]">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="variationPart">
                                    <div class="row">
                                        @foreach ($product->attribute as $productAttribute)
                                            <div class="form-group col-md-3 my-3">
                                                <label
                                                    for="attribute_values">{{ $productAttribute->attribute->name }}</label>
                                                <input class="form-control mt-1" type="text"
                                                    id="paattribute_valuesrent_id"
                                                    name="attribute_values[{{ $productAttribute->id }}]"
                                                    value="{{ $productAttribute->value }}">
                                            </div>
                                        @endforeach
                                    </div>

                                    @foreach ($product->variations as $variation)
                                        <hr>
                                        <div class="row d-flex mb-3">
                                            <div class="w-auto my-auto">
                                                <span>ویژگی برای متغیر {{ $variation->value }}:</span>
                                            </div>
                                            <div class="w-auto my-auto">
                                                <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse_name_{{ $variation->id }}"
                                                    aria-expanded="false"
                                                    aria-controls="collapse_name_{{ $variation->id }}">
                                                    نمایش
                                                </button>
                                            </div>
                                        </div>
                                        <div class="collapse" id="collapse_name_{{ $variation->id }}">
                                            <div class="card card-body mb-3">
                                                <div class="row">
                                                    <div class="form-group col-md-3 my-3">
                                                        <label for="value">نام</label>
                                                        <input
                                                            class="form-control mt-1 @error('variation_values') is-invalid @enderror"
                                                            type="text" id="value"
                                                            name="variation_values[{{ $variation->id }}][value]"
                                                            value="{{ $variation->value }}">
                                                    </div>
                                                    <div class="form-group col-md-3 my-3">
                                                        <label for="price">قیمت</label>
                                                        <input class="form-control mt-1" type="number"
                                                            style="direction: rtl" id="price"
                                                            name="variation_values[{{ $variation->id }}][price]"
                                                            value="{{ $variation->price }}">
                                                    </div>
                                                    <div class="form-group col-md-3 my-3">
                                                        <label for="quantity">تعداد</label>
                                                        <input class="form-control mt-1" type="number" id="quantity"
                                                            style="direction: rtl"
                                                            name="variation_values[{{ $variation->id }}][quantity]"
                                                            value="{{ $variation->quantity }}">
                                                    </div>
                                                    <div class="form-group col-md-3 my-3">
                                                        <label for="sku">شناسه ویژگی (SKU)</label>
                                                        <input class="form-control mt-1" type="text" id="sku"
                                                            name="variation_values[{{ $variation->id }}][sku]"
                                                            value="{{ $variation->sku }}">
                                                    </div>
                                                    <div class="form-group col-md-3 my-3">
                                                        <label for="sale_price">قیمت تخفیفی</label>
                                                        <input class="form-control mt-1" type="text" id="sale_price"
                                                            name="variation_values[{{ $variation->id }}][sale_price]"
                                                            value="{{ $variation->sale_price }}">
                                                    </div>

                                                    <div class="form-group col-md-3 my-3">
                                                        <label for="date_on_sale_from">تاریخ شروع تخفیف</label>
                                                        <input class="date-picker form-control mt-1" type="text"
                                                            id="date_on_sale_from"
                                                            name="variation_values[{{ $variation->id }}][date_on_sale_from]"
                                                            value="{{ $variation->date_on_sale_from == null ? null : verta($variation->date_on_sale_from) }}">
                                                    </div>
                                                    <div class="form-group col-md-3 my-3">
                                                        <label for="date_on_sale_to">تاریخ پایان تخفیف</label>
                                                        <input class="date-picker form-control mt-1" type="text"
                                                            id="date_on_sale_to"
                                                            name="variation_values[{{ $variation->id }}][date_on_sale_to]"
                                                            value="{{ $variation->date_on_sale_from == null ? null : verta($variation->date_on_sale_to) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="form-group col-md-12">
                                    <hr class="mt-0">
                                    <p>تصویر اصلی محصول:</p>
                                </div>
                                {{-- Show Main Picture Products --}}
                                <div class="row">
                                    <div class="form-group col-md-3 mb-3 product-other-picture">
                                        <img class="img-thumbnail"
                                            src="{{ url(env('PRODUCT_PATH_IMAGES') . '/' . $product->primary_image) }}"
                                            alt="{{ $product->name }}">
                                    </div>
                                </div>
                                {{-- Add Main Picture Products --}}
                                <div class="row">
                                    <div class="form-group col-md-3 my-3">
                                        <input class="form-control" type="file" name="primary_image"
                                            id="primary_image" accept=".jpg , .jpeg , .png , .svg">
                                    </div>
                                </div>
                    </form>


                    <div class="form-group col-md-12">
                        <hr>
                        <p>تصاویر محصول:</p>
                    </div>
                    {{-- Show Other Picture Product --}}
                    <div class="row">
                        @foreach ($product->images as $image)
                            <div class="form-group mb-3 product-other-picture">
                                <div>
                                    <img class="img-thumbnail"
                                        src="{{ url(env('PRODUCT_PATH_IMAGES') . '/' . $image->image) }}"
                                        alt="{{ $product->name }}">

                                    <div class="d-flex justify-content-around" style="margin-top: 13px">

                                        {{-- Delete Picture --}}
                                        <form
                                            action="{{ route('admin.products.delete_images', ['imageId' => $image->id]) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger text-white">حذف</button>
                                        </form>

                                        {{-- Select Picture Instead Of Main Picture --}}
                                        <form action="{{ route('admin.products.main_image', ['imageId' => $image->id]) }}"
                                            method="post">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="product_id" id=""
                                                value="{{ $product->id }}">
                                            <button type="submit" class="btn btn-sm btn-primary">جایگزین با تصویر
                                                اصلی</button>
                                        </form>

                                    </div>

                                </div>

                            </div>
                        @endforeach
                    </div>
                    {{-- Add Other Picture Product --}}
                    <div class="row">
                        <div class="form-group col-md-3 my-3">
                            <input class="form-control" type="file" name="images[]" id="images" multiple
                                accept=".jpg , .jpeg , .png , .svg">
                        </div>
                    </div>
                </div>


                <hr>
                <div class="mt-2">
                    <button id="submit-edit-form" class="btn btn-warning" type="submit">ویرایش</button>
                    <a class="btn btn-outline-dark mr-2" href="{{ route('admin.products.index') }}">بازگشت</a>
                </div>
                <script>
                    $("#submit-edit-form").click(function() {
                        $("#edit-form").submit();
                    });
                </script>

            </div>
        </div>
    </div>
    </div>
@endsection
