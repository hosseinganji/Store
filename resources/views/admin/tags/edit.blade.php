@extends('layouts.app')

@section('title')
    Tag Edit
@endsection


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">ویرایش تگ "{{ $tag->name }}"</h1>
    </div>

    <div class="row">

      <!-- Content Column -->
      <div class="col-lg-12 mb-4">

          <!-- Project Card Example -->
          <div class="card shadow mb-4">
              <div class="card-body">
                 @error('name')
                     
                 @enderror
                  <form action="{{ route("admin.tags.update" , ["tag" => $tag->id]) }}" method="POST">
                    @csrf
                    @method("put")
                    <div class="row">

                      <div class="form-group col-md-3 my-3">
                        <label for="name">نام</label>
                        <input class="form-control mt-1 @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ $tag->name }}">
                        @error('name')
                          <div class="invalid-feedback d-block">
                            {{ $message }}
                          </div>
                        @enderror
                      </div>

                    </div>
                    <div class="form-row mt-2">
                      <button class="btn btn-warning" type="submit">ویرایش</button>
                      <a class="btn btn-outline-dark mr-2" href="{{ route("admin.tags.index") }}">بازگشت</a>
                    </div>
                </form>
              </div>
          </div>
      </div>
    </div>


@endsection
