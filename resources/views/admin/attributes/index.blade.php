@extends('layouts.app')


@section('title')
    Attributes
@endsection
@section('script')
    <script type="text/javascript">
        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `آیا از حذف مطمئن هستید؟`,
                    //  text: "If you delete this, it will be gone forever.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    buttons: {
                        confirm: {
                            text: "حذف",
                        },
                        cancel: "بستن",
                    },
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    </script>
@endsection
@section('content')
    <!-- Page Heading -->

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">ویژگی ها ({{ $attributes->total() }})</h1>
        <a class="btn btn-primary ml-3" href="{{ route('admin.attributes.create') }}">ایجاد ویژگی</a>


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
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attributes as $key => $attribute)
                                <tr>
                                    <th>
                                        {{ $attributes->firstItem() + $key }}
                                    </th>
                                    <th>
                                        <a href="{{ route('admin.attributes.show', ['attribute' => $attribute->id]) }}">
                                            {{ $attribute->name }}
                                        </a>
                                    <th>
                                        <div class="d-flex align-items-end justify-content-around">
                                            <a class="text-success"
                                                href="{{ route('admin.attributes.edit', ['attribute' => $attribute->id]) }}">
                                                <i class="fa fa-pencil-square-o fs-5" aria-hidden="true"></i>
                                            </a>

                                            <form
                                                action="{{ route('admin.attributes.destroy', ['attribute' => $attribute->id]) }}"
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
            </div>
        </div>
    </div>
@endsection
