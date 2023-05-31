@extends('home.layouts.app')

@section('title')
    Home Page
@endsection

@section('script')
    <script>
        $(".selectProductVariation").change(function() {
            let productVariations = JSON.parse(this.value);
            let productPriceDiv = ".productPriceDiv-" + productVariations.product_id;
            if (productVariations.is_sale) {
                $(productPriceDiv).empty();

                let productPriceDivNew = `
                <h6 class="text-muted ml-2" style="font-size: 0.9rem;"><del>${productVariations.price.toLocaleString("en")} تومان</del></h6>
                <h6 class="fw-bold">${productVariations.sale_price.toLocaleString("en")} تومان</h6>
            `;
                $(productPriceDiv).append(productPriceDivNew);

            } else {
                $(productPriceDiv).empty();

                let productPriceDivNew = `
                <h6 class="fw-bold mt-2">${productVariations.price.toLocaleString("en")} تومان</h6>
            `;

                $(productPriceDiv).append(productPriceDivNew);

            }

            let productQuantityInputId = "#select-ideal-quantity-" + productVariations.product_id;
            $(productQuantityInputId).attr("data-max", productVariations.quantity);
            $(productQuantityInputId).val(1);

        });
    </script>
@endsection

@section('content')
    <style>
        .swiper-button-next:after,
        .swiper-rtl .swiper-button-prev:after {
            font-size: 15px;
            font-weight: bold;
        }

        .swiper-button-next,
        .swiper-rtl .swiper-button-prev {
            background: #3d464d;
            height: 32px;
            top: 150px;
            border-radius: 100%;
            width: 32px;
            font-weight: bold !important;
            color: #ffd333;
        }

        span.swiper-pagination-bullet.swiper-pagination-bullet-active {
            background-color: #ffd333;
        }
    </style>
    @include('home.layouts.header.topbar')
    @include('home.layouts.header.buttombar')
    @include('home.home-page.layouts.carousel')
    @include('home.home-page.layouts.featured')
    @include('home.home-page.layouts.categories')
    @include('home.home-page.layouts.featured-products')
    @include('home.home-page.layouts.offers')
    @include('home.home-page.layouts.recent-products')
    @include('home.home-page.layouts.brands')
    @include('home.layouts.footer.footer')
@endsection
