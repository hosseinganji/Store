<div class="container-fluid pt-5 pb-3">
    <h2 class="section-title position-relative text-uppercase text-right mx-xl-5 mb-4"><span
            class="bg-secondary pl-3">محصولات اخیر</span></h2>
    <div class="row px-xl-5">

        @foreach ($recent_products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100"
                            src="{{ url(env('PRODUCT_PATH_IMAGES') . '/' . $product->primary_image) }}"
                            alt="{{ $product->name }}">
                        <div class="product-action">
                            <a class="btn btn-outline-dark btn-square" href=""><i
                                    class="fa fa-shopping-cart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="text-center pb-3 pt-4">
                        <div class="text-right px-3 py-3">
                            <a class="h6 fw-bold text-decoration-none text-truncate text-right"
                                href="{{ url('/') . '/' . $product->slug }}">
                                <span>{{ $product->name }}</span>
                            </a>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small>(99)</small>
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
                                            {{ number_format($product->variations->min()->price) }}
                                            <span class="fs-6">تومان</span>
                                        </h6>
                                    @endif
                                @else
                                    <h6 class="fw-bold mt-2 text-danger w-100 text-right" >
                                        <div>ناموجود</div>
                                    </h6>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
