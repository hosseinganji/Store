@extends('home.layouts.app')

@section('title')
    profile comments Page
@endsection

@section('script')
@endsection


@section('content')
    @include('home.layouts.header.topbar')
    @include('home.layouts.header.buttombar')


    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{ route('home.homepage') }}">خانه</a>
                    <span class="breadcrumb-item active">نظرات</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <div class="container-fluid">
        <div class="row px-xl-5">

            @include('home.profile.side_bar')

            <div class="col-lg-9">
                <h5 class="section-title position-relative text-uppercase mb-3 text-right">
                    <span class="bg-secondary pl-3 fw-bold fs-3">نظرات</span>
                </h5>
                @if ($comments->isEmpty())
                    <div class="alert alert-danger text-right">
                        شما هنوز برای هیچ محصولی نظر ثبت نکرده اید
                    </div>
                @else
                    <div class="bg-light p-30 mb-5">
                        <div class="col-md-12 text-right">
                            @foreach ($comments as $comment)
                                <div class="media mb-4">
                                    <div class="media-body">
                                        <h6>
                                            <div class="mb-3">
                                                @if ($comment->approved == 1)
                                                    <span class="bg-success text-white px-2 py-1">تایید شده</span>
                                                @else
                                                    <span class="bg-danger text-white px-2 py-1">تایید نشده</span>
                                                @endif
                                            </div>
                                            <small>
                                                <i
                                                    class="float-end my-2">{{ verta($comment->created_at)->format('d %B Y') }}</i>
                                            </small>
                                        </h6>
                                        <div style="direction: ltr" data-rating-stars="5" data-rating-readonly="true"
                                            data-rating-half="true"
                                            data-rating-value="{{ $comment->product->rates->where('user_id', $comment->user_id)->first()->rate }}">
                                        </div>
                                        <div class="py-2">
                                            محصول:
                                            <a href="{{ route('home.product.show', ['product' => $comment->product->slug]) }}"
                                                class="fw-bold text-info">
                                                {{ $comment->product->name }}
                                            </a>
                                        </div>
                                        <p>{{ $comment->text }}</p>
                                        <hr>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center m-auto">
                            {{ $comments->links() }}
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
    @include('home.layouts.footer.footer')
@endsection
