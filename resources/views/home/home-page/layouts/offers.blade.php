<div class="container-fluid pt-5 pb-3" style="direction: ltr;">
    <div class="row px-xl-5">
        <div class="col-md-6">
            <div class="product-offer mb-30" style="height: 300px;">
                <img class="img-fluid" src="{{ url(env('BANNER_PATH_IMAGES')) . "/" . $offerLeft->image }}" alt="{{ $offerLeft->title }}">
                <div class="offer-text">
                    <h6 class="text-white text-uppercase">{{ $offerLeft->text }}</h6>
                    <h3 class="text-white mb-3">{{ $offerLeft->title }}</h3>
                    <a href="{{ $offerLeft->button_link }}" class="btn btn-primary">
                        <i class="{{ $offerLeft->button_icon }}"></i>
                        {{ $offerLeft->button_text }}
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="product-offer mb-30" style="height: 300px;">
                <img class="img-fluid" src="{{ url(env('BANNER_PATH_IMAGES')) . "/" . $offerRight->image }}" alt="{{ $offerRight->title }}">
                <div class="offer-text">
                    <h6 class="text-white text-uppercase">{{ $offerRight->text }}</h6>
                    <h3 class="text-white mb-3">{{ $offerRight->title }}</h3>
                    <a href="{{ $offerRight->button_link }}" class="btn btn-primary">
                        <i class="{{ $offerRight->button_icon }}"></i>
                        {{ $offerRight->button_text }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>