@extends('layouts.app')


@section('title')
    Banner Show
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">بنر "{{ $banner->title }}"</h1>
    </div>

    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-12 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-3 mb-3">
                            <img class="img-thumbnail" src="{{ url(env('BANNER_PATH_IMAGES') . '/' . $banner->image) }}"
                                alt="{{ $banner->image }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3 my-3">
                            <label>عنوان</label>
                            <input disabled class="form-control mt-1" value="{{ $banner->title }}">
                        </div>

                        <div class="form-group col-md-3 my-3">
                            <label>متن</label>
                            <input disabled class="form-control mt-1" value="{{ $banner->text }}">
                        </div>


                        <div class="form-group col-md-3 my-3">
                            <label>اولویت</label>
                            <input disabled class="form-control mt-1" style="direction: rtl"
                                value="{{ $banner->priority }}">
                        </div>

                        <div class="form-group col-md-3 my-3">
                            <label>وضعیت</label>
                            <select class="form-control mt-1" name="is_active" id="is_active" disabled>
                                <option value="1" {{ $banner->is_active == 1 ? 'selected' : '' }}>فعال</option>
                                <option value="0" {{ $banner->is_active == 0 ? 'selected' : '' }}>غیر فعال</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3 my-3">
                            <label>نوع</label>
                            <input disabled disabled class="form-control mt-1" value="{{ $banner->type }}">
                        </div>

                        <div class="form-group col-md-3 my-3">
                            <label>متن دکمه</label>
                            <input disabled class="form-control mt-1" value="{{ $banner->button_text }}">
                        </div>

                        <div class="form-group col-md-3 my-3">
                            <label>لینک دکمه</label>
                            <input disabled class="form-control mt-1" value="{{ $banner->button_link }}">
                        </div>

                        <div class="form-group col-md-3 my-3">
                            <label>آیکون دکمه</label>
                            <input disabled class="form-control mt-1" value="{{ $banner->button_icon }}">
                        </div>


                        <div class="form-group col-md-3 my-3">
                            <label>تاریخ ایجاد</label>
                            <input class="form-control mt-1" disabled
                                value="{{ verta($banner->created_at)->format('Y/m/d - H:i') }}" disabled>
                        </div>


                    </div>
                    <div class="mt-2">
                        <a class="btn btn-warning"
                            href="{{ route('admin.banners.edit', ['banner' => $banner->id]) }}">ویرایش</a>
                        <a class="btn btn-outline-dark mr-2" href="{{ route('admin.banners.index') }}">بازگشت</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
