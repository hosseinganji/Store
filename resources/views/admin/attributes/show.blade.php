@extends('layouts.app')

@section('title')
    Attribute Show
@endsection


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">ویژگی "{{ $attribute->name }}"</h1>
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
                        <input class="form-control mt-1" type="text" id="name" name="name" value="{{ $attribute->name }}" disabled>
                      </div>


                      <div class="form-group col-md-3 my-3">
                        <label for="name">تاریخ ایجاد</label>
                        <input class="form-control mt-1" type="text" id="name" name="name" value="{{ verta($attribute->created_at)->format("Y/m/d - H:i") }}" disabled>
                      </div>


                    </div>
                    <div class="form-row mt-2">
                      <a class="btn btn-warning" href="{{ route("admin.attributes.edit" , ["attribute" => $attribute->id]) }}">ویرایش</a>
                      <a class="btn btn-outline-dark mr-2" href="{{ route("admin.attributes.index") }}">بازگشت</a>
                    </div>
              </div>
          </div>
      </div>
    </div>


@endsection
