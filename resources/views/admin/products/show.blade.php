@extends('layouts.app')


@section('title')
    product Show
@endsection

@section('script')
    <script>
        $(".multiple-without-search-select").select2({
            minimumResultsForSearch: Infinity,
        });
    </script>
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">محصول "{{ $product->name }}"</h1>
    </div>

    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-12 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-body">

                    <div class="row">
                        <div class="form-group col-md-3 my-3">
                            <label for="name">نام</label>
                            <input class="form-control mt-1" type="text" id="name" name="name"
                                value="{{ $product->name }}" disabled>
                        </div>


                        <div class="form-group col-md-3 my-3">
                            <label for="brand">برند</label>
                            <input class="form-control mt-1" type="text" id="brand" name="brand"
                                value="{{ $product->brand->name }}" disabled>
                        </div>

                        <div class="form-group col-md-3 my-3">
                            <label for="is_active">وضعیت</label>
                            <select class="form-control mt-1" name="is_active" id="is_active" disabled>
                                <option value="1" @if ($product->is_active == 1) {{ 'selected' }} @endif>فعال
                                </option>
                                <option value="0" @if ($product->is_active == 0) {{ 'selected' }} @endif>غیر فعال
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-md-3 my-3">
                            <label for="tag">تگ</label>
                            <select class="form-control mt-1 multiple-without-search-select" name="tag" id="tag"
                                multiple disabled>
                                @foreach ($product->tags as $tag)
                                    <option value="{{ $tag->id }}" selected>{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group col-md-3 my-3">
                            <label for="slug">شناسه محصول (SKU)</label>
                            <input class="form-control mt-1" type="text" id="slug" name="slug"
                                value="{{ $product->slug }}" disabled>
                        </div>

                        <div class="form-group col-md-3 my-3">
                            <label for="name">تاریخ ایجاد</label>
                            <input class="form-control mt-1" type="text" id="name" name="name"
                                value="{{ verta($product->created_at)->format('Y/m/d - H:i') }}" disabled>
                        </div>

                        <div class="form-group col-md-3 my-3">
                            <label for="parent_id">دسته بندی</label>
                            <input class="form-control mt-1" type="text" id="parent_id" name="parent_id"
                                value="{{ $product->category->name }}" disabled>
                        </div>

                        <div class="form-group col-md-12 my-3">
                            <label for="description">توضیحات</label>
                            <textarea class="form-control mt-1" id="description" name="description" disabled>{{ $product->description }}</textarea>
                        </div>


                        <div class="form-group col-md-12">
                            <hr>
                            <p>هزینه ارسال:</p>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3 my-3">
                                <label for="sendPrice">هزینه ارسال</label>
                                <input class="form-control mt-1" type="text" id="sendPrice" name="sendPrice"
                                    value="{{ $product->delivery_amount }}" disabled>
                            </div>
                            <div class="form-group col-md-3 my-3">
                                <label for="sendPricePerExtraProduct">هزینه ارسال به ازای محصول اضافی</label>
                                <input class="form-control mt-1 @error('sendPricePerExtraProduct') is-invalid @enderror"
                                    type="text" id="sendPricePerExtraProduct" name="sendPricePerExtraProduct"
                                    value="{{ $product->delivery_amount_per_product == null ? 'رایگان' : $product->delivery_amount_per_product }}"
                                    disabled>
                            </div>
                        </div>


                    </div>

                    <div class="form-group col-md-12">
                        <hr>
                        <p>ویژگی ها:</p>
                    </div>

                    <div class="row">
                        @foreach ($product->attribute as $productAttribute)
                            <div class="form-group col-md-3 my-3">
                                <label for="parent_id">{{ $productAttribute->attribute->name }}</label>
                                <input class="form-control mt-1" type="text" id="parent_id" name="parent_id"
                                    value="{{ $productAttribute->value }}" disabled>
                            </div>
                        @endforeach
                    </div>

                    @foreach ($product->variations as $variation)
                        <hr>
                        <span>ویژگی برای متغیر {{ $variation->value }}:</span>
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse_name_{{ $variation->id }}" aria-expanded="false"
                            aria-controls="collapse_name_{{ $variation->id }}">
                            نمایش
                        </button>
                        </p>
                        <div class="collapse" id="collapse_name_{{ $variation->id }}">
                            <div class="card card-body">
                                <div class="row">
                                    <div class="form-group col-md-3 my-3">
                                        <label for="price">قیمت</label>
                                        <input class="form-control mt-1" type="text" id="price" name="price"
                                            value="{{ $variation->price }}" disabled>
                                    </div>
                                    <div class="form-group col-md-3 my-3">
                                        <label for="quantity">تعداد</label>
                                        <input class="form-control mt-1" type="text" id="quantity" name="quantity"
                                            value="{{ $variation->quantity }}" disabled>
                                    </div>
                                    <div class="form-group col-md-3 my-3">
                                        <label for="sku">شناسه ویژگی (SKU)</label>
                                        <input class="form-control mt-1" type="text" id="sku" name="sku"
                                            value="{{ $variation->sku }}" disabled>
                                    </div>
                                    <div class="form-group col-md-3 my-3">
                                        <label for="sale_price">قیمت تخفیفی</label>
                                        <input class="form-control mt-1" type="text" id="sale_price"
                                            name="sale_price" value="{{ $variation->sale_price }}" disabled>
                                    </div>
                                    <div class="form-group col-md-3 my-3">
                                        <label for="date_on_sale_from">تاریخ شروع تخفیف</label>
                                        <input class="form-control mt-1" type="text" id="date_on_sale_from"
                                            name="date_on_sale_from"
                                            value="{{ $variation->date_on_sale_from == null ? null : verta($variation->date_on_sale_from) }}"
                                            disabled>
                                    </div>
                                    <div class="form-group col-md-3 my-3">
                                        <label for="date_on_sale_to">تاریخ پایان تخفیف</label>
                                        <input class="form-control mt-1" type="text" id="date_on_sale_to"
                                            name="date_on_sale_to"
                                            value="{{ $variation->date_on_sale_from == null ? null : verta($variation->date_on_sale_to) }}"
                                            disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="form-group col-md-12">
                        <hr>
                        <p>تصویر اصلی محصول:</p>
                    </div>


                    <div class="row">
                        <div class="form-group col-md-3 mb-3">
                            <img class="img-thumbnail"
                                src="{{ url(env('PRODUCT_PATH_IMAGES') . '/' . $product->primary_image) }}"
                                alt="{{ $product->name }}">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <hr>
                        <p>تصاویر محصول:</p>
                    </div>
                    <div class="row">
                        @foreach ($product->images as $image)
                            <div class="form-group col-md-3 mb-3">
                                <img class="img-thumbnail"
                                    src="{{ url(env('PRODUCT_PATH_IMAGES') . '/' . $image->image) }}"
                                    alt="{{ $product->name }}">
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-2">
                        <a class="btn btn-warning"
                            href="{{ route('admin.products.edit', ['product' => $product->id]) }}">ویرایش</a>
                        <a class="btn btn-outline-dark mr-2" href="{{ route('admin.products.index') }}">بازگشت</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
