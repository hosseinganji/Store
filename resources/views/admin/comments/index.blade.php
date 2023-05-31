@extends('layouts.app')


@section('title')
    Comments
@endsection
@section('script')
    <script type="text/javascript">
        // $('.show_confirm').click(function(event) {
        //     var form = $(this).closest("form");
        //     var name = $(this).data("name");
        //     event.preventDefault();
        //     swal({
        //             title: `آیا از حذف مطمئن هستید؟`,
        //             //  text: "If you delete this, it will be gone forever.",
        //             icon: "warning",
        //             buttons: true,
        //             dangerMode: true,
        //             buttons: {
        //                 confirm: {
        //                     text: "حذف",
        //                 },
        //                 cancel: "بستن",
        //             },
        //         })
        //         .then((willDelete) => {
        //             if (willDelete) {
        //                 form.submit();
        //             }
        //         });
        // });
    </script>
@endsection
@section('content')
    <!-- Page Heading -->

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">کامنت ها ({{ $comments->total() }})</h1>

    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام</th>
                                <th>نام محصول</th>
                                <th>متن کامنت</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comments as $key => $comment)
                                <tr>
                                    <th>
                                        {{ $comments->firstItem() + $key }}
                                    </th>
                                    <th>
                                        <a href="{{ route('admin.comments.show', ['comment' => $comment->id]) }}">
                                            {{ $comment->user->name }}
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('admin.products.show', ['product' => $comment->product->id]) }}">
                                            {{ $comment->product->name }}
                                        </a>
                                    </th>
                                    <th>
                                        {{ $comment->text }}
                                    </th>
                                    <th>
                                        @if ($comment->approved == 1)
                                            <span style="color: green;">تایید شده</span>
                                        @else
                                            <span style="color: red;">عدم تایید</span>
                                        @endif
                                    </th>


                                    <th>
                                        <div class="d-flex align-items-end justify-content-around">

                                            <form
                                                action="{{ route('admin.comments.destroy', ['comment' => $comment->id]) }}"
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
