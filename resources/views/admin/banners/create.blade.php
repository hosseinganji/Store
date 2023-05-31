@extends('layouts.app')

@section('title')
    Brand Create
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">ایجاد بنر</h1>
    </div>

    @include('layouts.errors')

    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-12 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="form-group col-md-3 my-3">
                                <label for="banner_image" class="form-label mb-1">تصویر بنر</label>
                                <input class="form-control" type="file" name="banner_image" id="banner_image"
                                    accept=".jpg , .jpeg , .png , .svg" value="{{ old('banner_image') }}">
                            </div>

                            <div class="form-group col-md-3 my-3">
                                <label for="title">عنوان</label>
                                <input class="form-control mt-1 @error('title') is-invalid @enderror" type="text"
                                    id="title" name="title" value="{{ old('title') }}">
                            </div>

                            <div class="form-group col-md-3 my-3">
                                <label for="text">متن</label>
                                <input class="form-control mt-1 @error('text') is-invalid @enderror" type="text"
                                    id="text" name="text" value="{{ old('text') }}">
                            </div>


                            <div class="form-group col-md-3 my-3">
                                <label for="priority">اولویت</label>
                                <input class="form-control mt-1 @error('priority') is-invalid @enderror" type="number"
                                    id="priority" name="priority" style="direction: rtl" value="{{ old('priority') }}">
                            </div>

                            <div class="form-group col-md-3 my-3">
                                <label for="is_active">وضعیت</label>
                                <select class="form-control mt-1" name="is_active" id="is_active">
                                    <option value="1" {{ old("is_active") == 1 ? "selected" : "" }}>فعال</option>
                                    <option value="0" {{ old("is_active") == 0 ? "selected" : "" }}>غیر فعال</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3 my-3">
                                <label for="type">نوع</label>
                                <input class="form-control mt-1 @error('type') is-invalid @enderror" type="text"
                                    id="type" name="type" value="{{ old('type') }}">
                            </div>

                            <div class="form-group col-md-3 my-3">
                                <label for="button_text">متن دکمه</label>
                                <input class="form-control mt-1 @error('button_text') is-invalid @enderror" type="text"
                                    id="button_text" name="button_text" value="{{ old('button_text') }}">
                            </div>

                            <div class="form-group col-md-3 my-3">
                                <label for="button_link">لینک دکمه</label>
                                <input class="form-control mt-1 @error('button_link') is-invalid @enderror" type="text"
                                    id="button_link" name="button_link" value="{{ old('button_link') }}">
                            </div>

                            <div class="form-group col-md-3 my-3">
                                <label for="button_icon">آیکون دکمه</label>
                                <input class="form-control mt-1 @error('button_icon') is-invalid @enderror" type="text"
                                    id="button_icon" name="button_icon" value="{{ old('button_icon') }}">
                            </div>


                        </div>
                        <div class="mt-2">
                            <button class="btn btn-primary" type="submit">ثبت</button>
                            <a class="btn btn-outline-dark mr-2" href="{{ route('admin.brands.index') }}">بازگشت</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- @include('sweetalert::alert') --}}
@endsection
