<!-- Shop Product Start -->
<div class="col-lg-9 col-md-9">
    <div class="row pb-3">
        @include('home.category.layouts.sorting-bar')
        @foreach ($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1 px-1">
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100"
                            src="{{ url(env('PRODUCT_PATH_IMAGES') . '/' . $product->primary_image) }}"
                            alt="{{ $product->name }}">
                        <div class="product-action">
                            {{-- start wishlist --}}
                            @auth
                                @if ($product->checkWishlist(auth()->id()))
                                    <a class="btn btn-outline-dark btn-square"
                                        href="{{ route('profile.wishlist.remove', ['product' => $product->id]) }}">
                                        <i class="fa fa-heart"></i>
                                    </a>
                                @else
                                    <a class="btn btn-outline-dark btn-square"
                                        href="{{ route('profile.wishlist.add', ['product' => $product->id]) }}">
                                        <i class="far fa-heart"></i>
                                    </a>
                                @endif
                            @else
                                <a class="btn btn-outline-dark btn-square"
                                    href="{{ route('profile.wishlist.add', ['product' => $product->id]) }}">
                                    <i class="far fa-heart"></i>
                                </a>
                            @endauth
                            {{-- end wishlist --}}

                            
                            {{-- start compare --}}
                            {{-- @auth
                                @if (session()->get("compareProduct"))
                                    <a class="btn btn-outline-dark btn-square"
                                        href="{{ route('profile.compare.remove', ['product' => $product->id]) }}">
                                        <i class="fa fa-random"></i>
                                    </a>
                                @else
                                    <a class="btn btn-outline-dark btn-square"
                                        href="{{ route('profile.compare.add', ['product' => $product->id]) }}">
                                        <i class="far fa-random"></i>
                                    </a>
                                @endif
                            @else
                                <a class="btn btn-outline-dark btn-square"
                                    href="{{ route('profile.compare.add', ['product' => $product->id]) }}">
                                    <i class="far fa-random"></i>
                                </a>
                            @endauth --}}
                            {{-- end compare --}}



                            <a class="btn btn-outline-dark btn-square" href="{{ route('profile.compare.add', ['product' => $product->id]) }}">
                                <i class="fa fa-random"></i>
                            </a>

                            {{-- breef product page --}}
                            <a type="button" class="btn btn-outline-dark btn-square" data-toggle="modal"
                                data-target="#productModal-{{ $product->id }}">
                                <i class="fa fa-search"></i>
                            </a>
                            {{-- start modal --}}
                            <div class="modal fade" id="productModal-{{ $product->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog text-right" role="document" style="max-width: 850px;">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">

                                                <div class="col-md-4 mx-auto">
                                                    <div class="row">
                                                        <div dir="rtl" class="swiper mySwiper">
                                                            <div class="swiper-wrapper">
                                                                <div class="swiper-slide">
                                                                    <img class="img-thumbnail" style="transform: none;"
                                                                        src="{{ url(env('PRODUCT_PATH_IMAGES') . '/' . $product->primary_image) }}"
                                                                        alt="{{ $product->name }}">
                                                                </div>

                                                                @foreach ($product->images as $image)
                                                                    <div class="swiper-slide">
                                                                        <img class="img-thumbnail"
                                                                            style="transform: none;"
                                                                            src="{{ url(env('PRODUCT_PATH_IMAGES') . '/' . $image->image) }}"
                                                                            alt="{{ $product->name }}">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <div class="swiper-button-next"></div>
                                                            <div class="swiper-button-prev"></div>
                                                            <div class="swiper-pagination"></div>
                                                        </div>
                                                    </div>
                                                    <div class="row pl-3 ml-1 pr-3">
                                                        <div class="form-group col-md-4 px-1 my-2">
                                                            <img class="img-thumbnail" style="transform: none;"
                                                                src="{{ url(env('PRODUCT_PATH_IMAGES') . '/' . $product->primary_image) }}"
                                                                alt="{{ $product->name }}">
                                                        </div>
                                                        @foreach ($product->images as $image)
                                                            <div class="form-group col-md-4 px-1 my-2">
                                                                <img class="img-thumbnail" style="transform: none;"
                                                                    src="{{ url(env('PRODUCT_PATH_IMAGES') . '/' . $image->image) }}"
                                                                    alt="{{ $product->name }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <h2>{{ $product->name }}</h2>
                                                    <div
                                                        class="d-flex flex-column justify-content-center my-3 productPriceDiv-{{ $product->id }}">
                                                        @if ($product->in_stock)
                                                            @if ($product->price_check)
                                                                <h6 class="text-muted ml-2" style="font-size: 0.9rem;">
                                                                    <del>
                                                                        {{ number_format($product->price_check->price) }}
                                                                        تومان
                                                                    </del>
                                                                </h6>
                                                                <h6 class="fw-bold">
                                                                    {{ number_format($product->price_check->sale_price) }}
                                                                    تومان
                                                                </h6>
                                                            @else
                                                                <h6 class="fw-bold mt-2">
                                                                    {{ number_format($product->variations->first()->price) }}
                                                                    <span class="fs-6">تومان</span>
                                                                </h6>
                                                            @endif
                                                        @else
                                                            <h6 class="fw-bold mt-2 text-danger w-100 text-right">
                                                                <div>ناموجود</div>
                                                            </h6>
                                                        @endif
                                                    </div>


                                                    <div class="d-flex align-items-center justify-content-center mb-3"
                                                        style="direction: ltr">
                                                        <div data-rating-stars="5" data-rating-readonly="true"
                                                            data-rating-half="true"
                                                            data-rating-value="{{ $product->rates->avg('rate') }}">
                                                        </div>
                                                        <small>({{ $product->rates->avg('rate') ?? 0 }})</small>
                                                    </div>


                                                    <div class="row mb-2">
                                                        توضیحات:
                                                    </div>
                                                    <div class="row">
                                                        {{ $product->description }}
                                                    </div>

                                                    <hr>

                                                    <div class="row">
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

                                                    <hr>

                                                    <div class="row">
                                                        <div class="form-group col-md-4 p-0">
                                                            <label for="productVariations">
                                                                {{ $product->category->attributes()->wherePivot('is_variation', 1)->first()->name }}:
                                                            </label>

                                                            <select
                                                                class="form-select form-control mt-1 rounded-2 selectProductVariation"
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


                                                        <div class="col-md-4" style="margin-top: 36px;">
                                                            <div class="input-group quantity mr-4"
                                                                style="width: 130px;">
                                                                <div class="input-group-btn">
                                                                    <button class="btn btn-primary btn-plus">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                </div>


                                                                @if ($product->in_stock)
                                                                    @if ($product->price_check)
                                                                        <input type="text"
                                                                            id="select-ideal-quantity-{{ $product->id }}"
                                                                            class="form-control bg-secondary border-0 text-center"
                                                                            value="1"
                                                                            data-max="{{ $product->price_check->quantity }}">
                                                                    @else
                                                                        <input type="text"
                                                                            id="select-ideal-quantity-{{ $product->id }}"
                                                                            class="form-control bg-secondary border-0 text-center"
                                                                            value="1"
                                                                            data-max="{{ $product->variations->min()->quantity }}">
                                                                    @endif
                                                                @else
                                                                    <input type="text"
                                                                        id="select-ideal-quantity-{{ $product->id }}"
                                                                        class="form-control bg-secondary border-0 text-center"
                                                                        value="0" data-max="0">
                                                                @endif



                                                                <div class="input-group-btn">
                                                                    <button class="btn btn-primary btn-minus">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4" style="margin-top: 36px;">
                                                            {{-- start wishlist --}}
                                                            @auth
                                                                @if ($product->checkWishlist(auth()->id()))
                                                                    <a class="btn btn-light btn-square"
                                                                        href="{{ route('profile.wishlist.remove', ['product' => $product->id]) }}">
                                                                        <i class="fa fa-heart text-danger"></i>
                                                                    </a>
                                                                @else
                                                                    <a class="btn btn-light btn-square"
                                                                        href="{{ route('profile.wishlist.add', ['product' => $product->id]) }}">
                                                                        <i class="far fa-heart text-danger"></i>
                                                                    </a>
                                                                @endif
                                                            @else
                                                                <a class="btn btn-light btn-square"
                                                                    href="{{ route('profile.wishlist.add', ['product' => $product->id]) }}">
                                                                    <i class="far fa-heart text-danger"></i>
                                                                </a>
                                                            @endauth
                                                            {{-- end wishlist --}}

                                                        </div>


                                                    </div>

                                                    <hr>

                                                    <div class="row pl-3">
                                                        <button class="btn btn-primary">
                                                            <i class="fa fa-shopping-cart mr-1"></i>
                                                            افزودن به سبد
                                                        </button>
                                                    </div>



                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- end modal --}}
                            {{-- end breef product page --}}
                        </div>
                    </div>
                    <div class="text-center pb-3 pt-4">
                        <div class="text-right px-3 py-3">
                            <a class="h6 fw-bold text-decoration-none text-truncate text-right"
                                href="{{ url('/') . '/' . $product->slug }}">
                                <span>{{ $product->name }}</span>
                            </a>
                        </div>

                        <div class="d-flex align-items-center justify-content-center mb-3" style="direction: ltr">
                            <div data-rating-stars="5" data-rating-readonly="true" data-rating-half="true"
                                data-rating-value="{{ $product->rates->avg('rate') }}">
                            </div>
                            <small>({{ $product->rates->avg('rate') ?? 0 }})</small>
                        </div>


                        <div class="d-flex flex-column align-items-end justify-content-center mt-2 mx-3">

                            @if ($product->in_stock)
                                @if ($product->price_check)
                                    <h6 class="text-muted ml-2" style="font-size: 0.9rem;">
                                        <del>
                                            {{ number_format($product->price_check->price) }}
                                            تومان
                                        </del>
                                    </h6>
                                    <h6 class="fw-bold">
                                        {{ number_format($product->price_check->sale_price) }}
                                        تومان
                                    </h6>
                                @else
                                    <h6 class="fw-bold">
                                        {{ number_format($product->variations->first()->price) }}
                                        <span class="fs-6">تومان</span>
                                    </h6>
                                @endif
                            @else
                                <h6 class="fw-bold mt-2 text-danger w-100 text-right">
                                    <div>ناموجود</div>
                                </h6>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        @endforeach







        <div class="col-12">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>
</div>
<!-- Shop Product End -->
