@extends('home.layouts.app')

@section('title')
    Category Page
@endsection

@section('script')
    <script>
        $(".selectProductVariation").change(function() {
            let productVariations = JSON.parse(this.value);
            let productPriceDiv = ".productPriceDiv-" + productVariations.product_id;
            if (productVariations.is_sale) {
                $(productPriceDiv).empty();

                let productPriceDivNew = `
            <h6 class="text-muted ml-2 fs-5" style="font-size: 0.9rem;"><del>${productVariations.price.toLocaleString("en")} تومان</del></h6>
            <h6 class="fw-bold fs-4">${productVariations.sale_price.toLocaleString("en")} تومان</h6>
        `;
                $(productPriceDiv).append(productPriceDivNew);

            } else {
                $(productPriceDiv).empty();

                let productPriceDivNew = `
            <h6 class="fw-bold mt-2 fs-4">${productVariations.price.toLocaleString("en")} تومان</h6>
        `;

                $(productPriceDiv).append(productPriceDivNew);

            }

            let productQuantityInputId = "#select-ideal-quantity-" + productVariations.product_id;
            $(productQuantityInputId).attr("data-max", productVariations.quantity);
            $(productQuantityInputId).val(1);

        });

        var swiper = new Swiper(".mySwiper", {
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    </script>
@endsection


@section('content')
    @include('home.layouts.header.topbar')
    @include('home.layouts.header.buttombar')


    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Shop Detail</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">

            {{-- start images --}}
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">

                        <div class="carousel-item active">
                            <img class="w-100 h-100"
                                src="{{ url(env('PRODUCT_PATH_IMAGES') . '/' . $product->primary_image) }}"
                                alt="{{ $product->name }}">
                        </div>


                        @foreach ($product->images as $image)
                            <div class="carousel-item">
                                <img class="w-100 h-100" src="{{ url(env('PRODUCT_PATH_IMAGES') . '/' . $image->image) }}"
                                    alt="{{ $product->name }}">
                            </div>
                        @endforeach

                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>
            {{-- end images --}}

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">

                    <h1 class="h3 fw-bold text-right mt-1 mb-4">{{ $product->name }}</h1>

                    {{-- start rates --}}
                    <div class="d-flex align-items-center justify-content-center mb-3" style="direction: ltr">
                        <div class="mr-1" data-rating-stars="5" data-rating-readonly="true" data-rating-half="true"
                            data-rating-value="{{ $product->rates->avg('rate') }}">
                        </div>
                        <small>({{ $product->rates->avg('rate') ?? 0 }})</small>
                    </div>
                    {{-- end rates --}}

                    {{-- start price --}}
                    <div
                        class="d-flex flex-column text-right justify-content-center my-3 productPriceDiv-{{ $product->id }}">
                        @if ($product->in_stock)
                            @if ($product->price_check)
                                <h6 class="text-muted ml-2 fs-5" style="font-size: 0.9rem;">
                                    <del>
                                        {{ number_format($product->price_check->price) }}
                                        تومان
                                    </del>
                                </h6>
                                <h6 class="fw-bold fs-4">
                                    {{ number_format($product->price_check->sale_price) }}
                                    تومان
                                </h6>
                            @else
                                <h6 class="fw-bold mt-2 fs-4">
                                    {{ number_format($product->variations->first()->price) }}
                                    تومان
                                </h6>
                            @endif
                        @else
                            <h6 class="fw-bold mt-2 text-danger w-100 text-right">
                                <div>ناموجود</div>
                            </h6>
                        @endif
                    </div>
                    {{-- end price --}}

                    {{-- start minimum Information --}}
                    <div class="row text-right mr-3">
                        <ul>
                            @foreach ($product->attribute->take(4) as $productAttribute)
                                <li>
                                    {{ $productAttribute->attribute->name }}
                                    :
                                    {{ $productAttribute->value }}
                                </li>
                            @endforeach
                            <li>...</li>
                        </ul>
                    </div>
                    {{-- end minimum Information --}}

                    {{-- start description --}}
                    <p class="mb-4 text-right">{{ $product->description }}</p>
                    {{-- start description --}}

                    <hr>

                    <form action="{{ route("cart.add") }}" method="POST">
                        @csrf

                        <div class="row">

                            {{-- start variation input --}}
                            <div class="form-group col-md-4 p-0 text-right">
                                <label for="productVariations">
                                    {{ $product->category->attributes()->wherePivot('is_variation', 1)->first()->name }}:
                                </label>

                                <select class="form-select form-control mt-1 rounded-2 selectProductVariation"
                                    name="productVariations" data-live-search="true">
                                    @foreach ($product->variations as $productVariations)
                                        @if ($productVariations->in_stock_variation)
                                            <option
                                                value="{{ json_encode($productVariations->only(['id', 'value', 'product_id', 'sale_price', 'price', 'is_sale', 'quantity'])) }}"
                                                class="{{ $product->price_check }}"
                                                @if ($product->price_check) {{ $product->price_check->id == $productVariations->id ? 'selected' : '' }} @endif>
                                                {{ $productVariations->value }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            {{-- end variation input --}}

                            {{-- start quantity input --}}
                            <div class="col-md-4" style="margin-top: 36px;">
                                <div class="input-group quantity mr-4" style="width: 130px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary btn-plus" type="button">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>


                                    @if ($product->in_stock)
                                        @if ($product->price_check)
                                            <input type="text" id="select-ideal-quantity-{{ $product->id }}"
                                                name="quantity" class="form-control bg-secondary border-0 text-center"
                                                value="1" data-max="{{ $product->price_check->quantity }}">
                                        @else
                                            <input type="text" id="select-ideal-quantity-{{ $product->id }}"
                                                name="quantity" class="form-control bg-secondary border-0 text-center"
                                                value="1" data-max="{{ $product->variations->min()->quantity }}">
                                        @endif
                                    @else
                                        <input type="text" id="select-ideal-quantity-{{ $product->id }}"
                                            name="quantity" class="form-control bg-secondary border-0 text-center"
                                            value="0" data-max="0">
                                    @endif



                                    <div class="input-group-btn">
                                        <button class="btn btn-primary btn-minus" type="button">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {{-- end quantity input --}}

                            <div class="col-md-4" style="margin-top: 36px;">

                                {{-- start wishlist --}}
                                @auth
                                    @if ($product->checkWishlist(auth()->id()))
                                        <a class="btn btn-outline-dark btn-square"
                                            href="{{ route('profile.wishlist.remove', ['product' => $product->id]) }}">
                                            <i class="fa fa-heart text-danger"></i>
                                        </a>
                                    @else
                                        <a class="btn btn-outline-dark btn-square"
                                            href="{{ route('profile.wishlist.add', ['product' => $product->id]) }}">
                                            <i class="far fa-heart text-danger"></i>
                                        </a>
                                    @endif
                                @else
                                    <a class="btn btn-outline-dark btn-square"
                                        href="{{ route('profile.wishlist.add', ['product' => $product->id]) }}">
                                        <i class="far fa-heart text-danger"></i>
                                    </a>
                                @endauth
                                {{-- end wishlist --}}

                            </div>

                        </div>

                        <hr>
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        {{-- start add to card --}}
                        <div class="row pl-3 mb-3">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-shopping-cart mr-1"></i>
                                افزودن به سبد
                            </button>
                        </div>
                        {{-- end add to card --}}
                    </form>

                    {{-- start share --}}
                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">اشتراک گذاری:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                    {{-- end share --}}

                </div>
            </div>
        </div>
        <div class="row px-xl-5" id="product_detail">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="nav nav-tabs mb-4">
                        <a class="nav-item nav-link text-dark {{ count($errors) > 0 ? '' : 'active' }}" data-toggle="tab"
                            href="#tab-pane-1">توضیحات</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-2">مشخصات</a>
                        <a class="nav-item nav-link text-dark {{ count($errors) > 0 ? 'active' : '' }}" data-toggle="tab"
                            href="#tab-pane-3">دیدگاه ها
                            ({{ count($product->comments->where('approved', 1)) }})</a>
                    </div>
                    <div class="tab-content">
                        {{-- start description tab --}}
                        <div class="tab-pane fade {{ count($errors) > 0 ? '' : 'show active' }}" id="tab-pane-1">
                            <h4 class="mb-3 text-right">توضیحات</h4>
                            <p class="text-right">{{ $product->description }}</p>
                        </div>
                        {{-- end description tab --}}

                        {{-- start information tab --}}
                        <div class="tab-pane fade" id="tab-pane-2">
                            <div class="row">
                                <div class="col-md-2">
                                    <ul class="list-group list-group-flush text-right">

                                        @foreach ($product->attribute as $productAttribute)
                                            <li class="list-group-item px-0">
                                                {{ $productAttribute->attribute->name }}
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                                <div class="col-md-10">
                                    <ul class="list-group list-group-flush text-right">

                                        @foreach ($product->attribute as $productAttribute)
                                            <li class="list-group-item px-0">
                                                {{ $productAttribute->value }}
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- end information tab --}}

                        {{-- start review tab --}}
                        <div class="tab-pane fade {{ count($errors) > 0 ? 'show active' : '' }}" id="tab-pane-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div>
                                        @include('home.layouts.errors')

                                        <h4 class="mb-4 text-right">یک دیدگاه بنویسید</h4>
                                        <div class="d-flex my-3">
                                            <p>امتیاز شما:</p>
                                            <div style="direction: ltr;" class="mr-2" data-rating-stars="5"
                                                data-rating-half="true" data-rating-input="#reviewInputRate">
                                            </div>
                                        </div>
                                        <form action="{{ route('home.comment.store', ['product' => $product->id]) }}"
                                            method="POST">
                                            @csrf
                                            <div class="form-group text-right">
                                                <label for="message">متن دیدگاه</label>
                                                <textarea id="message" cols="30" name="review_text" rows="5" class="form-control"></textarea>
                                            </div>
                                            <input type="hidden" name="rate" id="reviewInputRate" value="0">
                                            <button type="submit" class="btn btn-primary">ارسال دیدگاه</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-6 text-right">
                                    <h4 class="mb-4">
                                        {{ count($product->comments->where('approved', 1)) }} دیدگاه برای محصول
                                        "{{ $product->name }}"
                                    </h4>


                                    @foreach ($product->comments->where('approved', 1) as $comment)
                                        <div class="media mb-4">
                                            <div class="media-body">
                                                <hr>
                                                <h6>{{ $comment->user->name }}
                                                    <small>
                                                        <i
                                                            class="float-end">{{ verta($comment->created_at)->format('d %B Y') }}</i>
                                                    </small>
                                                </h6>
                                                <div style="direction: ltr" data-rating-stars="5"
                                                    data-rating-readonly="true" data-rating-half="true"
                                                    data-rating-value="{{ $product->rates->where('user_id', $comment->user_id)->first()->rate }}">
                                                </div>
                                                <p>{{ $comment->text }}</p>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                            </div>
                        </div>
                        {{-- end review tab --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    {{-- <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May Also Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    <div class="product-item bg-light">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="img/product-1.jpg" alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="">Product Name Goes Here</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>$123.00</h5><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small>(99)</small>
                            </div>
                        </div>
                    </div>
                    <div class="product-item bg-light">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="img/product-2.jpg" alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="">Product Name Goes Here</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>$123.00</h5><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small>(99)</small>
                            </div>
                        </div>
                    </div>
                    <div class="product-item bg-light">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="img/product-3.jpg" alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="">Product Name Goes Here</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>$123.00</h5><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small>(99)</small>
                            </div>
                        </div>
                    </div>
                    <div class="product-item bg-light">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="img/product-4.jpg" alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="">Product Name Goes Here</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>$123.00</h5><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small>(99)</small>
                            </div>
                        </div>
                    </div>
                    <div class="product-item bg-light">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="img/product-5.jpg" alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="">Product Name Goes Here</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>$123.00</h5><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small>(99)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Products End -->


    @include('home.layouts.footer.footer')
@endsection
