@extends('layouts.app')

@section('title')
    Brand Create
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">ایجاد برند</h1>
    </div>

    <div class="row">
      
      <!-- Content Column -->
      <div class="col-lg-12 mb-4">

          <!-- Project Card Example -->
          <div class="card shadow mb-4">
              <div class="card-body">
                  <form action="{{ route("admin.brands.store") }}" method="POST">
                    @csrf
                    <div class="row">

                      <div class="form-group col-md-3 my-3">
                        <label for="name">نام</label>
                        <input class="form-control mt-1 @error('name') is-invalid @enderror" type="text" id="name" name="name">
                        @error('name')
                          <div class="invalid-feedback d-block">
                            {{ $message }}
                          </div>
                        @enderror
                      </div>

                      <div class="form-group col-md-3 my-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control mt-1" name="is_active" id="is_active">
                          <option value="1" selected>فعال</option>
                          <option value="0">غیر فعال</option>
                        </select>
                      </div>


                    </div>
                    <div class="mt-2">
                      <button class="btn btn-primary" type="submit">ثبت</button>
                      <a class="btn btn-outline-dark mr-2" href="{{ route("admin.brands.index") }}">بازگشت</a>
                    </div>
                </form>
              </div>
          </div>
      </div>
    </div>

    {{-- @include('sweetalert::alert') --}}

@endsection
