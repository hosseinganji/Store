@extends('home.layouts.app')

@section('title')
    profile index Page
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
                    <span class="breadcrumb-item active">علاقه مندی ها</span>
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
                    <span class="bg-secondary pl-3 fw-bold fs-3">علاقه مندی ها</span>
                </h5>
                @if ($userWishlists->isEmpty())
                    <div class="alert alert-danger text-right">
                        محصولی در لیست علاقه مندی های شما وجود ندارد
                    </div>
                @else
                    <div class="py-3 px-4 mb-5">
                        <table class="table table-light table-borderless table-hover text-center mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>تصویر</th>
                                    <th>نام محصول</th>
                                    <th>قیمت</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @foreach ($userWishlists as $key => $userWishlist)
                                    <tr>

                                        <td class="align-middle bg-white">
                                            {{ $userWishlists->firstItem() + $key }}
                                        </td>

                                        <td class="align-middle bg-white p-1">
                                            <img src="{{ url(env('PRODUCT_PATH_IMAGES') . '/' . $userWishlist->product->primary_image) }}"
                                                alt="{{ $userWishlist->product->name }}" style="width: 90px;">
                                        </td>

                                        <td class="align-middle bg-white">
                                            <a class="text-info fw-bold"
                                                href="{{ route('home.product.show', ['product' => $userWishlist->product->slug]) }}">
                                                {{ $userWishlist->product->name }}
                                            </a>
                                        </td>

                                        <td class="align-middle bg-white">
                                            @if ($userWishlist->product->in_stock)
                                                @if ($userWishlist->product->price_check)
                                                    <h6 class="text-muted ml-2" style="font-size: 0.9rem;">
                                                        <del>
                                                            {{ number_format($userWishlist->product->price_check->price) }}
                                                            تومان
                                                        </del>
                                                    </h6>
                                                    <h6 class="fw-bold">
                                                        {{ number_format($userWishlist->product->price_check->sale_price) }}
                                                        تومان
                                                    </h6>
                                                @else
                                                    <h6 class="fw-bold mt-2">
                                                        {{ number_format($userWishlist->product->variations->first()->price) }}
                                                        <span class="fs-6">تومان</span>
                                                    </h6>
                                                @endif
                                            @else
                                                <h6 class="fw-bold mt-2 text-danger w-100">
                                                    <div>ناموجود</div>
                                                </h6>
                                            @endif
                                        </td>

                                        <td class="align-middle bg-white">

                                            @auth
                                                @if ($userWishlist->product->checkWishlist(auth()->id()))
                                                    <a class="btn btn-sm btn-danger mx-1"
                                                        href="{{ route('profile.wishlist.remove', ['product' => $userWishlist->product->id]) }}">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                @else
                                                    <a class="btn btn-sm btn-danger mx-1"
                                                        href="{{ route('profile.wishlist.add', ['product' => $userWishlist->product->id]) }}">
                                                        <i class="far fa-heart text-danger"></i>
                                                    </a>
                                                @endif
                                            @else
                                                <a class="btn btn-sm btn-danger mx-1"
                                                    href="{{ route('profile.wishlist.add', ['product' => $userWishlist->product->id]) }}">
                                                    <i class="far fa-heart text-danger"></i>
                                                </a>
                                            @endauth
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="bg-white pt-4 pb-1 mt-3">
                            {{ $userWishlists->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @include('home.layouts.footer.footer')
@endsection
