@extends('home.layouts.app')

@section('title')
    profile comments Page
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
    </script>
@endsection


@section('content')
    @include('home.layouts.header.topbar')
    @include('home.layouts.header.buttombar')


    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{ route('home.homepage') }}">خانه</a>
                    <span class="breadcrumb-item active">آدرس ها</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <div class="container-fluid">
        <div class="row px-xl-5">

            @include('home.profile.side_bar')

            <div class="col-lg-9">
                <h5 class="section-title position-relative text-uppercase mb-3 text-right">
                    <span class="bg-secondary pl-3 fw-bold fs-3">آدرس ها</span>
                </h5>

                @foreach ($addresses as $address)
                    <div
                        class="m-1 bg-light text-right row g-0 overflow-hidden flex-md-row mb-4 h-md-250 position-relative">
                        <div class="col p-4 d-flex flex-column position-static">
                            <div class="row">
                                <h4 class="fw-bold mb-0 col-md-6">{{ $address->title }}</h4>
                                <strong class="d-inline-block mb-2 text-success col-md-6 text-left">
                                    {{ $provinces->where('id', $address->province_id)->first()->name }}
                                    -
                                    {{ $cities->where('id', $address->city_id)->first()->name }}
                                </strong>
                            </div>
                            <div class="my-1 text-muted">شماره همراه: {{ $address->cellphone }}</div>
                            <div class="mb-1 text-muted">کد پستی: {{ $address->postal_code }}</div>
                            <p class="mb-auto">{{ $address->address }}</p>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="address-update-{{ $address->id }}">
                                <label class="custom-control-label fw-bold text-info mt-2" style="cursor: pointer" for="address-update-{{ $address->id }}"
                                    data-toggle="collapse"
                                    data-target="#shipping-address-update-{{ $address->id }}">ویرایش آدرس</label>

                                <div class="collapse mb-5 text-right" id="shipping-address-update-{{ $address->id }}">
                                    <h5 class="fw-bold mt-3">ویرایش آدرس {{ $address->title }}</h5>
                                    <hr>
                                    <form action="{{ route('home.profile.address.edit' , ["address" => $address->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="title">عنوان</label>
                                                <input class="form-control" type="text" id="title" name="edittitle"
                                                    value="{{ $address->title }}">
                                                @error('edittitle')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="address">آدرس</label>
                                                <input class="form-control" type="text" id="address" name="editaddress"
                                                    value="{{ $address->address }}">
                                                @error('editaddress')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="cellphone">شماره همراه</label>
                                                <input class="form-control" type="text" id="cellphone"
                                                    name="editcellphone" value="{{ $address->cellphone }}">
                                                @error('editcellphone')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="province_id">استان</label>
                                                <select class="custom-select province_id" id="province_id" name="editprovince_id">
                                                    <option value="select">استان خود را وارد نمایید</option>
                                                    @foreach ($provinces as $province)
                                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('editprovince_id')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="city_id">شهر</label>
                                                <select class="custom-select city_id" id="city_id" name="editcity_id">
                                                </select>
                                                @error('editcity_id')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="postal_code">کد پستی</label>
                                                <input class="form-control" type="text" id="postal_code"
                                                    name="editpostal_code" value="{{ $address->postal_code }}">
                                                @error('editpostal_code')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <button type="submit" class="btn btn-primary mt-2">ویرایش</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


                <div class="m-1 bg-light p-30 mb-5 text-right">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="shipto"
                                    @if (
                                        $errors->has('addtitle') ||
                                            $errors->has('addaddress') ||
                                            $errors->has('addcellphone') ||
                                            $errors->has('addprovince_id') ||
                                            $errors->has('addcity_id') ||
                                            $errors->has('addpostal_code')) checked @endif>
                                <label class="custom-control-label" for="shipto" data-toggle="collapse"
                                    data-target="#shipping-address">افزودن آدرس جدید</label>

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


        </div>
    </div>
    @include('home.layouts.footer.footer')
@endsection
