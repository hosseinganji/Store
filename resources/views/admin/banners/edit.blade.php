@extends('layouts.app')

@section('title')
    Banner Edit
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">ویرایش بنر "{{ $banner->title }}"</h1>
    </div>

    @include('layouts.errors')

    <div class="row">
        <!-- Content Column -->
        <div class="col-lg-12 mb-4">
            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.banners.update', ['banner' => $banner->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="form-group col-md-3 mb-3">
                                <img class="img-thumbnail" src="{{ url(env('BANNER_PATH_IMAGES') . '/' . $banner->image) }}"
                                    alt="{{ $banner->image }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3 my-3">
                                <label for="banner_image" class="form-label mb-1">تصویر بنر</label>
                                <input class="form-control" type="file" name="banner_image" id="banner_image"
                                    accept=".jpg , .jpeg , .png , .svg" value="{{ old('banner_image') }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3 my-3">
                                <label>عنوان</label>
                                <input class="form-control mt-1 @error('title') is-invalid @enderror" type="text"
                                id="title" name="title" value="{{ $banner->title }}">
                            </div>

                            <div class="form-group col-md-3 my-3">
                                <label>متن</label>
                                <input class="form-control mt-1 @error('text') is-invalid @enderror" type="text"
                                id="text" name="text" value="{{ $banner->text }}">
                            </div>


                            <div class="form-group col-md-3 my-3">
                                <label>اولویت</label>
                                <input class="form-control mt-1 @error('priority') is-invalid @enderror" type="number"
                                id="priority" name="priority" style="direction: rtl" value="{{ $banner->priority }}">
                            </div>

                            <div class="form-group col-md-3 my-3">
                                <label>وضعیت</label>
                                <select class="form-control mt-1" name="is_active" id="is_active">
                                    <option value="1" {{ $banner->is_active == 1 ? 'selected' : '' }}>فعال</option>
                                    <option value="0" {{ $banner->is_active == 0 ? 'selected' : '' }}>غیر فعال</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3 my-3">
                                <label>نوع</label>
                                <input class="form-control mt-1 @error('type') is-invalid @enderror" type="text"
                                id="type" name="type" value="{{ $banner->type }}">
                            </div>

                            <div class="form-group col-md-3 my-3">
                                <label>متن دکمه</label>
                                <input class="form-control mt-1 @error('button_text') is-invalid @enderror" type="text"
                                id="button_text" name="button_text" value="{{ $banner->button_text }}">
                            </div>

                            <div class="form-group col-md-3 my-3">
                                <label>لینک دکمه</label>
                                <input class="form-control mt-1 @error('button_link') is-invalid @enderror" type="text"
                                id="button_link" name="button_link" value="{{ $banner->button_link }}">
                            </div>

                            <div class="form-group col-md-3 my-3">
                                <label>آیکون دکمه</label>
                                <input class="form-control mt-1 @error('button_icon') is-invalid @enderror" type="text"
                                id="button_icon" name="button_icon" value="{{ $banner->button_icon }}">
                            </div>

                        </div>
                        <div class="mt-3">
                            <button class="btn btn-warning" type="submit">ویرایش</button>
                            <a class="btn btn-outline-dark mr-2" href="{{ route('admin.banners.index') }}">بازگشت</a>
                        </div>

                    </form>

                </div>


            </div>
        </div>
    </div>
@endsection
