@extends('home.layouts.app')

@section('title')
    Checkout Page
@endsection

@section('script')
    <script>
        $(".province_id").change(function() {
            var province_id = this.value;
            $.get(`{{ url('get-city-from-province/${province_id}') }}`,
                function(response, status) {
                    if (status == "success") {
                        $(".city_id").find("option").remove();
                        response.forEach(city => {
                            citiesOption = `<option value="${city.id}">${city.name}</option>`;
                            $(".city_id").append(citiesOption);
                        });
                    } else {
                        // alert("مشکل در دریافت اطلاعات دسته بندی");
                        console.log("doslhfoihfoew");
                    }
                }).fail(function() {
                /* alert("مشکل در دریافت اطلاعات دسته بندی");*/
            });
        });


        $("#address_send").val($("#address_select").val());
        $("#address_select").change(function() {
            $("#address_send").val($(this).val());
        });
    </script>
@endsection


@section('content')
    @include('home.layouts.header.topbar')
    @include('home.layouts.header.buttombar')

    <div class="mx-5">
        @include('home.layouts.errors')
    </div>


    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{ route('home.homepage') }}">خانه</a>
                    <span class="breadcrumb-item active">ثبت سفارش</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Checkout Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8">

                <h5 class="section-title position-relative text-uppercase mb-3 text-right">
                    <span class="bg-secondary pl-3 fw-bold">
                        انتخاب آدرس
                    </span>
                </h5>
                <div class="m-1 bg-light p-30 mb-5 text-right">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="address_checkout">آدرس</label>
                                    <select id="address_select" class="custom-select address_checkout" id="address_checkout"
                                        name="address_checkout">
                                        <option value="select">آدرس خود را انتخاب کنید</option>
                                        @foreach ($addresses as $address)
                                            <option value="{{ $address->id }}">{{ $address->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('address_checkout')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div
                                    class="col-md-6 form-group custom-control custom-checkbox m-auto text-center text-info fw-bold">
                                    <input type="checkbox" class="custom-control-input" id="shipto"
                                        @if (
                                            $errors->has('addtitle') ||
                                                $errors->has('addaddress') ||
                                                $errors->has('addcellphone') ||
                                                $errors->has('addprovince_id') ||
                                                $errors->has('addcity_id') ||
                                                $errors->has('addpostal_code')) checked @endif>
                                    <label class="custom-control-label" for="shipto" data-toggle="collapse"
                                        style="cursor: pointer" data-target="#shipping-address">افزودن آدرس جدید</label>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ route('home.profile.address.add') }}" method="POST">
                    @csrf

                    <div class="collapse mb-5 text-right @if (
                        $errors->has('addtitle') ||
                            $errors->has('addaddress') ||
                            $errors->has('addcellphone') ||
                            $errors->has('addprovince_id') ||
                            $errors->has('addcity_id') ||
                            $errors->has('addpostal_code')) show @endif"
                        id="shipping-address">
                        <h5 class="section-title position-relative text-uppercase mb-3 text-right">
                            <span class="bg-secondary pl-3 fw-bold fs-4">افزودن آدرس جدید</span>
                        </h5>
                        <div class="bg-light p-30">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="title">عنوان</label>
                                    <input class="form-control" type="text" id="title" name="addtitle"
                                        value="{{ old('addtitle') }}">
                                    @error('addtitle')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="address">آدرس</label>
                                    <input class="form-control" type="text" id="address" name="addaddress"
                                        value="{{ old('addaddress') }}">
                                    @error('addaddress')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="cellphone">شماره همراه</label>
                                    <input class="form-control" type="text" id="cellphone" name="addcellphone"
                                        value="{{ old('addcellphone') }}">
                                    @error('addcellphone')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="province_id">استان</label>
                                    <select class="custom-select province_id" id="province_id" name="addprovince_id">
                                        <option value="select">استان خود را وارد نمایید</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('addprovince_id')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="city_id">شهر</label>
                                    <select class="custom-select city_id" id="city_id" name="addcity_id">
                                    </select>
                                    @error('addcity_id')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="postal_code">کد پستی</label>
                                    <input class="form-control" type="text" id="postal_code" name="addpostal_code"
                                        value="{{ old('addpostal_code') }}">
                                    @error('addpostal_code')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary mt-2">افزودن</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3 text-right">
                    <span class="bg-secondary pl-3 fw-bold">
                        مجموع سفارش
                    </span>
                </h5>
                <div class="bg-light p-4 mb-5">
                    <div class="border-bottom pb-2 mb-3">
                        <div class="border-bottom text-right">
                            <h5 class="mb-3 fw-bold">محصولات:</h5>
                            @foreach (\Cart::getContent() as $item)
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="align-middle text-right">
                                        <p class="mb-0">
                                            <span class="fw-bold">{{ $item->name }}</span>
                                            <span style="font-size: 14px;">
                                                ({{ $item->quantity }} عدد)
                                            </span>
                                        </p>
                                        <span class="mt-0" style="font-size: 14px;">
                                            {{ App\Models\Attribute::find($item->attributes->attribute_id)->name }}:
                                            {{ $item->attributes->value }}
                                        </span>
                                    </div>
                                    <div class="align-middle text-left">
                                        <p class="mb-0">{{ number_format($item->price) }} تومان</p>
                                        @if ($item->attributes->is_sale)
                                            <span style="font-size: 13px;"
                                                class="text-success fw-bold">%{{ round((1 - $item->attributes->sale_price / $item->attributes->price) * 100) }}
                                                تخفیف</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-between my-3">
                            <h6>مجموع سبد خرید</h6>
                            <h6>{{ number_format(\Cart::getTotal() + discountAmountTotalInCart()) }} تومان</h6>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="font-weight-medium">هزینه ارسال</h6>
                            <h6 class="font-weight-medium">{{ number_format(sendAmountTotalInCart()) }} تومان</h6>
                        </div>
                        @if (discountAmountTotalInCart() > 0)
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">تخفیف ها</h6>
                                <h6 class="font-weight-medium">{{ number_format(discountAmountTotalInCart()) }} تومان
                                </h6>
                            </div>
                        @endif
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="fw-bold">قابل پرداخت</h5>
                            <h5 class="fw-bold">
                                {{ number_format(\Cart::getTotal() + sendAmountTotalInCart()) }} تومان
                            </h5>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h5 class="section-title position-relative text-uppercase mb-3 text-right">
                        <span class="bg-secondary pl-3 fw-bold">
                            روش پرداخت
                        </span>
                    </h5>
                    <form action="{{ route('home.payment') }}" method="post">
                        @csrf
                        <div class="bg-light p-30 text-right">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment" value="zarinpal"
                                        id="zarinpal">
                                    <label class="custom-control-label" for="zarinpal">زرین پال</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment" value="pay"
                                        id="pay">
                                    <label class="custom-control-label" for="pay">پی</label>
                                </div>
                            </div>

                            <button class="btn btn-block btn-primary font-weight-bold py-3">ثبت سفارش</button>
                        </div>
                        <input type="hidden" name="address_id" id="address_send">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout End -->




    @include('home.layouts.footer.footer')
@endsection
