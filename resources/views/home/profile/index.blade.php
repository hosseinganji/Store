@extends('home.layouts.app')

@section('title')
    profile index Page
@endsection

@section('script')
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
                    <span class="breadcrumb-item active">پروفایل</span>
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
                    <span class="bg-secondary pl-3 fw-bold fs-3">پروفایل</span>
                </h5>

                <div class="bg-light p-30 mb-5">

                    @if ($user_name && $user_email)
                        <div class="row">
                            <div class="form-group col-md-6 form-group text-right">
                                <label>نام و نام خانوادگی</label>
                                <input class="form-control" disabled type="text" placeholder="نام و نام خانوادگی"
                                    value="{{ $user_name }}"
                                    >
                            </div>

                            <div class="form-group col-md-6 form-group text-right">
                                <label>ایمیل</label>
                                <input class="form-control" type="email" disabled placeholder="example@email.com"
                                    value="{{ $user_email }}"
                                    >
                            </div>
                        </div>
                    @else
                        <form action="{{ route('home.profile.store', ['id' => $user_id]) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6 form-group text-right">
                                    <label for="name">نام و نام خانوادگی</label>
                                    <input class="form-control" id="name" type="text" name="name" placeholder="نام و نام خانوادگی">
                                </div>

                                <div class="form-group col-md-6 form-group text-right">
                                    <label for="email">ایمیل</label>
                                    <input class="form-control" id="email" type="email" name="email" placeholder="example@email.com">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">ثبت</button>
                        </form>
                    @endif
                </div>


            </div>

        </div>
    </div>
    @include('home.layouts.footer.footer')
@endsection
