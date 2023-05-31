@section('title')
    Banners
@endsection


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">بنرها ({{ $banners->total() }})</h1>
        <a class="btn btn-primary ml-3" href="{{ route('admin.banners.create') }}">ایجاد بنر</a>
    </div>

    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-12 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-body overflow-scroll">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>تصویر</th>
                                <th>عنوان</th>
                                <th>متن</th>
                                <th>اولویت</th>
                                <th>وضعیت</th>
                                <th>نوع بنر</th>
                                <th>متن دکمه</th>
                                <th>لینک دکمه</th>
                                <th>آیکون دکمه</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banners as $key => $banner)
                                <tr>
                                    {{-- # --}}
                                    <th>
                                        {{ $banners->firstItem() + $key }}
                                    </th>
                                    {{-- image --}}
                                    <th>
                                        <a href="{{ route('admin.banners.show', ['banner' => $banner->id]) }}">
                                            {{ $banner->image }}
                                        </a>
                                    </th>
                                    {{-- title --}}
                                    <th>
                                        {{ $banner->title }}
                                    </th>
                                    {{-- text --}}
                                    <th>
                                        {{ $banner->text }}
                                    </th>
                                    {{-- priority --}}
                                    <th>
                                        {{ $banner->priority }}
                                    </th>
                                    {{-- status --}}
                                    <th>
                                        @if ($banner->is_active == 1)
                                            <span style="color: green;">فعال</span>
                                        @else
                                            <span style="color: red;">غیر فعال</span>
                                        @endif
                                    </th>
                                    {{-- type --}}
                                    <th>
                                        {{ $banner->type }}
                                    </th>
                                    {{-- button_text --}}
                                    <th>
                                        {{ $banner->button_text }}
                                    </th>
                                    {{-- button_link --}}
                                    <th>
                                        {{ $banner->button_link }}
                                    </th>
                                    {{-- button_icon --}}
                                    <th>
                                        {{ $banner->button_icon }}
                                    </th>
                                    


                                    {{-- action --}}
                                    <th>
                                        <div class="d-flex align-items-end justify-content-around">
                                            <a class="text-success"
                                                href="{{ route('admin.banners.edit', ['banner' => $banner->id]) }}">
                                                <i class="fa fa-pencil-square-o fs-5" aria-hidden="true"></i>
                                            </a>

                                            <form action="{{ route('admin.banners.destroy', ['banner' => $banner->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('delete')
                                                <button onclick="return confirm('آیا از حذف کردن این آیتم مطمئن هستید؟');"
                                                    class="border-0 bg-transparent" type="submit">
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
                <div class="d-flex justify-content-center">{{ $banners->links() }}</div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')
