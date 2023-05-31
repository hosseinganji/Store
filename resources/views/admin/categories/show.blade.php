@extends('layouts.app')


@section('title')
    Category Show
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">دسته بندی "{{ $category->name }}"</h1>
    </div>

    <div class="row">
        <div class="form-group col-md-3 mb-3">
            <img class="img-thumbnail" src="{{ url(env('CATEGORY_PATH_IMAGES') . '/' . $category->image) }}"
                alt="{{ $category->image }}">
        </div>
    </div>
    <div class="col-md-12">
        <hr>
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
                                value="{{ $category->name }}" disabled>
                        </div>


                        <div class="form-group col-md-3 my-3">
                            <label for="slug">نام انگلیسی</label>
                            <input class="form-control mt-1" type="text" id="slug" name="slug"
                                value="{{ $category->slug }}" disabled>
                        </div>




                        <div class="form-group col-md-3 my-3">
                            <label for="parent_id">والد</label>
                            <input class="form-control mt-1" type="text" id="parent_id" name="parent_id"
                                value="@if ($category->parent_id == 0) دسته اصلی@else{{ $category->parent->name }} @endif"
                                disabled>
                        </div>

                        <div class="form-group col-md-3 my-3">
                            <label for="is_active">وضعیت</label>
                            <select class="form-control mt-1" name="is_active" id="is_active" disabled>
                                <option value="1" @if ($category->is_active == 1) {{ 'selected' }} @endif>فعال
                                </option>
                                <option value="0" @if ($category->is_active == 0) {{ 'selected' }} @endif>غیر فعال
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-md-3 my-3">
                            <label for="attributes_ids">ویژگی ها</label>
                            <input class="form-control mt-1" type="text" id="attributeSelect" name="attributes_ids[]"
                                value="@foreach ($category->attributes as $attribute){{ $attribute->name }}{{ $loop->last ? '' : '،' }} @endforeach"
                                disabled>
                        </div>


                        <div class="form-group col-md-3 my-3">
                            <label for="isFilterAttributes">ویژگی های فیلتر شده</label>
                            <input class="form-control mt-1" type="text" id="isFilterAttributes"
                                name="isFilterAttributes"
                                value="@foreach ($category->attributes()->wherePivot('is_filter', 1)->get() as $attribute){{ $attribute->name }}{{ $loop->last ? '' : '،' }} @endforeach"
                                disabled>
                        </div>


                        <div class="form-group col-md-3 my-3">
                            <label for="variationAttribute">ویژگی های متغیر</label>
                            <input class="form-control mt-1" type="text" id="variationAttribute"
                                name="variationAttribute"
                                value="@foreach ($category->attributes()->wherePivot('is_variation', 1)->get() as $attribute){{ $attribute->name }}{{ $loop->last ? '' : '،' }} @endforeach"
                                disabled>
                        </div>

                        <div class="form-group col-md-3 my-3">
                            <label for="icon">آیکون</label>
                            <input class="form-control mt-1" type="text" id="icon" name="icon"
                                value="{{ $category->icon }}" disabled>
                        </div>




                        <div class="form-group col-md-3 my-3">
                            <label for="name">تاریخ ایجاد</label>
                            <input class="form-control mt-1" type="text" id="name" name="name"
                                value="{{ verta($category->created_at)->format('Y/m/d - H:i') }}" disabled>
                        </div>

                        <div class="form-group col-md-12 my-3">
                            <label for="description">توضیحات</label>
                            <textarea class="form-control mt-1" id="description" name="description" disabled>{{ $category->description }}</textarea>
                        </div>


                    </div>
                    <div class="mt-2">
                        <a class="btn btn-warning"
                            href="{{ route('admin.categories.edit', ['category' => $category->id]) }}">ویرایش</a>
                        <a class="btn btn-outline-dark mr-2" href="{{ route('admin.categories.index') }}">بازگشت</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
