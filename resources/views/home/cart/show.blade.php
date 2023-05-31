@extends('home.layouts.app')

@section('title')
    Cart Page
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
                    <span class="breadcrumb-item active">سبد خرید</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
    <div class="container-fluid">
        @if (\Cart::isEmpty())
        <div class="row px-xl-5 mx-2">
            <div class="alert alert-danger text-right ">
                    سبد خرید شما خالی می باشد
                </div>
            </div>
        @else
            <div class="row px-xl-5">
                <div class="col-lg-9 table-responsive mb-5">
                    <form action="{{ route('cart.update') }}" method="post">
                        @csrf
                        @method('PUT')
                        <table class="table table-light table-borderless table-hover text-center mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>محصولات</th>
                                    <th>قیمت واحد</th>
                                    <th>تعداد</th>
                                    <th>قیمت</th>
                                    <th>حذف</th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @foreach (\Cart::getContent() as $item)
                                    <tr>
                                        <td class="align-middle bg-white">
                                            <img src="{{ url(env('PRODUCT_PATH_IMAGES') . '/' . $item->associatedModel->primary_image) }}"
                                                alt="" style="width: 50px;">
                                            <a class="fw-bold mr-2 text-info"
                                                href="{{ route('home.product.show', ['product' => $item->associatedModel->slug]) }}">
                                                {{ $item->name }}
                                            </a>
                                        </td>
                                        <td class="align-middle bg-white">
                                            <p class="mb-1">{{ number_format($item->price) }} تومان</p>
                                            @if ($item->attributes->is_sale)
                                                <span style="font-size: 13px;"
                                                    class="text-success fw-bold">%{{ round((1 - $item->attributes->sale_price / $item->attributes->price) * 100) }}
                                                    تخفیف</span>
                                            @endif
                                        </td>
                                        <td class="align-middle bg-white">
                                            <div class="input-group quantity mr-4" style="width: 130px;">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-primary btn-plus" type="button">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>


                                                @if ($item->associatedModel->in_stock)
                                                    @if ($item->associatedModel->price_check)
                                                        <input type="text"
                                                            id="select-ideal-quantity-{{ $item->associatedModel->id }}"
                                                            name="quantity[{{ $item->id }}]"
                                                            class="form-control bg-secondary border-0 text-center"
                                                            value="{{ $item->quantity }}"
                                                            data-max="{{ $item->attributes->quantity }}">
                                                    @else
                                                        <input type="text"
                                                            id="select-ideal-quantity-{{ $item->associatedModel->id }}"
                                                            name="quantity[{{ $item->id }}]"
                                                            class="form-control bg-secondary border-0 text-center"
                                                            value="{{ $item->quantity }}"
                                                            data-max="{{ $item->attributes->quantity }}">
                                                    @endif
                                                @else
                                                    <input type="text"
                                                        id="select-ideal-quantity-{{ $item->associatedModel->id }}"
                                                        name="quantity[{{ $item->id }}]"
                                                        class="form-control bg-secondary border-0 text-center"
                                                        value="{{ $item->quantity }}" data-max="0">
                                                @endif



                                                <div class="input-group-btn">
                                                    <button class="btn btn-primary btn-minus" type="button">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle bg-white">
                                            {{ number_format($item->price * $item->quantity) }}
                                            تومان</td>
                                        <td class="align-middle bg-white">
                                            <a href="{{ route('cart.remove', ['rowId' => $item->id]) }}"
                                                class="btn btn-sm btn-danger">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <a href="{{ route('cart.clear') }}" class="btn btn-light mt-3 py-2 px-3">پاک کردن سبد خرید</a>
                        <button type="submit" class="btn btn-primary mt-3 py-2 px-3 mr-3">به روز رسانی سبد خرید</button>
                    </form>
                </div>
                <div class="col-lg-3">
                    <form class="mb-30" action="">
                        <div class="input-group">
                            <input type="text" class="form-control border-0 p-4" placeholder="کد تخفیف...">
                            <div class="input-group-append">
                                <button class="btn btn-primary fw-bold">اعمال</button>
                            </div>
                        </div>
                    </form>
                    <h5 class="section-title position-relative text-uppercase mb-3 text-right">
                        <span class="bg-secondary pl-3">
                            خلاصه سبد خرید
                        </span>
                    </h5>
                    <div class="bg-light p-4 mb-5">
                        <div class="border-bottom pb-2">
                            <div class="d-flex justify-content-between mb-3">
                                <h6>مجموع سبد خرید</h6>
                                <h6>{{ number_format(\Cart::getTotal() + discountAmountTotalInCart()) }} تومان</h6>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <h6 class="font-weight-medium">هزینه ارسال</h6>
                                <h6 class="font-weight-medium">{{ number_format(sendAmountTotalInCart()) }} تومان</h6>
                            </div>


                            @if (discountAmountTotalInCart() > 0)
                                <div class="d-flex justify-content-between">
                                    <h6 class="font-weight-medium">تخفیف ها</h6>
                                    <h6 class="font-weight-medium">{{ number_format(discountAmountTotalInCart()) }} تومان
                                    </h6>
                                </div>
                            @endif

                        </div>
                        <div class="pt-2">
                            <div class="d-flex justify-content-between mt-2">
                                <h6 class="fw-bold">قابل پرداخت</h6>
                                <h6 class="fw-bold">{{ number_format(\Cart::getTotal() + sendAmountTotalInCart()) }}
                                    تومان</h6>
                            </div>
                            <button class="btn btn-block btn-primary font-weight-bold mt-3 py-3">
                                نهایی کردن سفارش
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!-- Cart End -->

    @include('home.layouts.footer.footer')
@endsection
