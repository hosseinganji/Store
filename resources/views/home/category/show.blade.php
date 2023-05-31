@extends('home.layouts.app')

@section('title')
    Category Page
@endsection

@section('script')
    <script>
        function filter_slidbar() {

            let attributesJson = @json($attributes);
            attributesJson.map(attribute => {
                let attributes = $(`.attribute_input_original_${attribute.id}:checked`).map(function() {
                    return this.value;
                }).get().join("-");

                if (attributes == "") {
                    $(`#attribute_input_hidden_${attribute.id}`).prop("disabled", true);
                } else {
                    $(`#attribute_input_hidden_${attribute.id}`).val(attributes);
                }
            });


            let variations = $(".filter_input_original:checked").map(function() {
                return this.value;
            }).get().join("-");

            if (variations == "") {
                $("#filter_input_hidden").prop("disabled", true);
            } else {
                $("#filter_input_hidden").val(variations);
            }



            let sorting = $("#sort-select").map(function() {
                return this.value;
            }).get();
            if (sorting == "delete") {
                console.log(sorting);
                $("#sort-input").prop("disabled", true);
            } else {
                $("#sort-input").val(sorting);
            }


            $("#form-filter").submit();
        }


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
    @include('home.category.layouts.breadcrumb')

    <div class="container-fluid">
        <div class="row px-xl-5">
            @include('home.category.layouts.shop-sliders')
            @include('home.category.layouts.shop-products')
        </div>
    </div>

    @include('home.layouts.footer.footer')

    <style>
        .swiper {
            width: 100%;
            height: 100%;
        }
    
        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    
        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
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
        .pagination{
            justify-content: center;
        }
    </style>
@endsection
