@extends('layouts.app')

@section('title')
    Categories
@endsection


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">دسته بندی ({{ $categories->total() }})</h1>
        <a class="btn btn-primary ml-3" href="{{ route('admin.categories.create') }}">ایجاد دسته بندی</a>
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
                                <th>نام انگلیسی</th>
                                <th>والد</th>
                                <th>ویژگی ها</th>
                                <th>ویژگی های قابل فیلتر</th>
                                <th>ویژگی های متغیر</th>
                                <th>وضعیت</th>
                                <th>تاریخ ایجاد</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $key => $category)
                                <div>
                                    <tr>
                                        <td>
                                            {{ $categories->firstItem() + $key }}
                                        </td>
                                        </a>
                                        <td>
                                            <a class="fw-bold"
                                                href="{{ route('admin.categories.show', ['category' => $category->id]) }}">
                                                {{ $category->name }}
                                            </a>
                                        </td>

                                        <td>
                                            {{ $category->slug }}
                                        </td>

                                        <td>
                                            @if ($category->parent_id == 0 || $category->parent == null)
                                                دسته اصلی
                                            @else
                                                {{ $category->parent->name }}
                                            @endif
                                        </td>


                                        <td>
                                            @foreach ($category->attributes as $attribute)
                                                {{ $attribute->name }}{{ $loop->last ? '' : '،' }}
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($category->attributes()->wherePivot('is_filter', 1)->get() as $attribute)
                                                {{ $attribute->name }}{{ $loop->last ? '' : '،' }}
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($category->attributes()->wherePivot('is_variation', 1)->get() as $attribute)
                                                {{ $attribute->name }}{{ $loop->last ? '' : '،' }}
                                            @endforeach
                                        </td>

                                        <th>
                                            @if ($category->is_active == 1)
                                                <span style="color: green;">فعال</span>
                                            @else
                                                <span style="color: red;">غیر فعال</span>
                                            @endif
                                        </th>

                                        <th>
                                            {{ verta($category->created_at)->format('Y/m/d - H:i') }}</th>
                                        <th>
                                            <div class="d-flex align-items-end justify-content-around">
                                                <a class="text-success"
                                                    href="{{ route('admin.categories.edit', ['category' => $category->id]) }}">
                                                    <i class="fa fa-pencil-square-o fs-5" aria-hidden="true"></i>
                                                </a>

                                                <form
                                                    action="{{ route('admin.categories.destroy', ['category' => $category->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button
                                                        onclick="return confirm('آیا از حذف کردن این آیتم مطمئن هستید؟');"
                                                        class="border-0 bg-transparent" type="submit">
                                                        <i class="fa fa-trash fs-5 text-danger" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </th>
                                    </tr>
                                </div>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection
