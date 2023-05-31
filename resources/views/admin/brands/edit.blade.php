@extends('layouts.app')

@section('title')
    Brand Edit
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">ویرایش برند "{{ $brand->name }}"</h1>
    </div>

    <div class="row">

      <!-- Content Column -->
      <div class="col-lg-12 mb-4">

          <!-- Project Card Example -->
          <div class="card shadow mb-4">
              <div class="card-body">
                 @error('name')
                     
                 @enderror
                  <form action="{{ route("admin.brands.update" , ["brand" => $brand->id]) }}" method="POST">
                    @csrf
                    @method("put")
                    <div class="row">

                      <div class="form-group col-md-3 my-3">
                        <label for="name">نام</label>
                        <input class="form-control mt-1 @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ $brand->name }}">
                        @error('name')
                          <div class="invalid-feedback d-block">
                            {{ $message }}
                          </div>
                        @enderror
                      </div>

                      <div class="form-group col-md-3 my-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control mt-1" name="is_active" id="is_active">
                          <option value="1" @if ($brand->is_active == 1) {{"selected"}} @endif>فعال</option>
                          <option value="0" @if ($brand->is_active == 0) {{"selected"}} @endif>غیر فعال</option>
                        </select>
                      </div>


                    </div>
                    <div class="mt-2">
                      <button class="btn btn-warning" type="submit">ویرایش</button>
                      <a class="btn btn-outline-dark mr-2" href="{{ route("admin.brands.index") }}">بازگشت</a>
                    </div>
                </form>
              </div>
          </div>
      </div>
    </div>


@endsection
