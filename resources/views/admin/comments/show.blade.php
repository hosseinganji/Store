@extends('layouts.app')

@section('title')
    Comment Show
@endsection


@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">کامنت</h1>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-body">

                    <div class="row">
                        <div class="form-group col-md-3 my-3">
                            <label for="name">نام</label>
                            <input class="form-control mt-1" type="text" id="name" name="name"
                                value="{{ $comment->user->name }}" disabled>
                        </div>
                        <div class="form-group col-md-3 my-3">
                            <label for="name">نام محصول</label>
                            <input class="form-control mt-1" type="text" id="name" name="name"
                                value="{{ $comment->product->name }}" disabled>
                        </div>

                        <div class="form-group col-md-3 my-3">
                            <label for="name">وضعیت</label>
                            <input class="form-control mt-1" type="text" id="name" name="name"
                                value="@if ($comment->approved == 1) تایید شده @else عدم تایید @endif" disabled>
                        </div>


                        <div class="form-group col-md-3 my-3">
                            <label for="name">تاریخ ایجاد</label>
                            <input class="form-control mt-1" type="text" id="name" name="name"
                                value="{{ verta($comment->created_at)->format('Y/m/d - H:i') }}" disabled>
                        </div>

                        <div class="form-group col-md-12 my-3">
                            <label for="name">متن کامنت</label>
                            <textarea class="form-control mt-1" id="description" name="description" disabled>{{ $comment->text }}</textarea>
                        </div>


                    </div>
                    <div class="form-row mt-2">
                        @if ($comment->approved == 1)
                            <a class="btn btn-danger"
                                href="{{ route('admin.comments.changeStatus', ['comment' => $comment->id]) }}">
                                عدم تایید
                            </a>
                        @else
                            <a class="btn btn-success"
                                href="{{ route('admin.comments.changeStatus', ['comment' => $comment->id]) }}">
                                تایید
                            </a>
                        @endif
                        <a class="btn btn-outline-dark mr-2" href="{{ route('admin.comments.index') }}">بازگشت</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
