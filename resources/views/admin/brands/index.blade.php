@section('title')
    Brands
@endsection


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">برندها ({{ $brands->total() }})</h1>
        <a class="btn btn-primary ml-3" href="{{ route('admin.brands.create') }}">ایجاد برند</a>
    </div>

    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-12 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brands as $key => $brand)
                                <tr>
                                    <th>
                                        {{ $brands->firstItem() + $key }}
                                    </th>
                                    <th>
                                        <a class=""
                                                href="{{ route('admin.brands.show', ['brand' => $brand->id]) }}">
                                        {{ $brand->name }}</th>
                                        </a>
                                    <th>
                                        @if ($brand->is_active == 1)
                                            <span style="color: green;">فعال</span>
                                        @else
                                            <span style="color: red;">غیر فعال</span>
                                        @endif
                                    </th>
                                    <th>

                                        <div class="d-flex align-items-end justify-content-around">
                                            <a class="text-success"
                                                href="{{ route('admin.brands.edit', ['brand' => $brand->id]) }}">
                                                <i class="fa fa-pencil-square-o fs-5" aria-hidden="true"></i>
                                            </a>

                                            <form
                                                action="{{ route('admin.brands.destroy', ['brand' => $brand->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('delete')
                                                <button onclick="return confirm('آیا از حذف کردن این آیتم مطمئن هستید؟');" class="border-0 bg-transparent" type="submit">
                                                    <i class="fa fa-trash fs-5 text-danger" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </div>

                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')
