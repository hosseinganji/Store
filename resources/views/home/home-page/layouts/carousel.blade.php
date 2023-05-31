<style>
    .carousel-indicators .active {
        width: 15px;
        border-radius: 100%;
    }

    .carousel-indicators li {
        width: 15px;
        height: 15px;
        border-radius: 100%;
        margin: 0 3px 12px 3px;
        background: transparent;
        border: 3px solid #FFFFFF;
        transition: .5s;
    }
</style>

<div class="container-fluid mb-3" dir="ltr">
    <div class="row px-xl-5">
        <div class="col-lg-4">
            <div class="product-offer mb-30" style="height: 200px;">
                <img class="img-fluid" src="{{ url(env('BANNER_PATH_IMAGES')) . "/" . $topLeftBannerNextSlider->image }}" alt="{{ $topLeftBannerNextSlider->title }}">
                <div class="offer-text">
                    <h6 class="text-white text-uppercase">{{ $topLeftBannerNextSlider->text }}</h6>
                    <h3 class="text-white mb-3">{{ $topLeftBannerNextSlider->title }}</h3>
                    <a href="{{ $topLeftBannerNextSlider->button_link }}" class="btn btn-primary">
                        <i class="{{ $topLeftBannerNextSlider->button_icon }}"></i>
                        {{ $topLeftBannerNextSlider->button_text }}
                    </a>
                </div>
            </div>
            <div class="product-offer mb-30" style="height: 200px;">
                <img class="img-fluid" src="{{ url(env('BANNER_PATH_IMAGES')) . "/" . $buttomLeftBannerNextSlider->image }}" alt="{{ $buttomLeftBannerNextSlider->title }}">
                <div class="offer-text">
                    <h6 class="text-white text-uppercase">{{ $buttomLeftBannerNextSlider->text }}</h6>
                    <h3 class="text-white mb-3">{{ $buttomLeftBannerNextSlider->title }}</h3>
                    <a href="{{ $buttomLeftBannerNextSlider->button_link }}" class="btn btn-primary">
                        <i class="{{ $buttomLeftBannerNextSlider->button_icon }}"></i>
                        {{ $buttomLeftBannerNextSlider->button_text }}
                    </a>
                </div>
            </div>
            
        </div>

        <div class="col-lg-8">
            <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                <ol class="carousel-indicators">
                    @for ($i = 0; $i < count($sliders); $i++)
                        <li data-target="#header-carousel" data-slide-to="{{ $i }}"
                            class="@if ($i == 0) active @endif"></li>
                    @endfor
                </ol>
                <div class="carousel-inner">
                    {{ $i = 1 }}
                    @foreach ($sliders as $slider)
                        <div class="carousel-item position-relative @if ($i == 1) active @endif"
                            style="height: 430px;">
                            <img class="position-absolute w-100 h-100"
                                src="{{ url(env('BANNER_PATH_IMAGES')) . '/' . $slider->image }}"
                                style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">
                                        {{ $slider->title }}
                                    </h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">
                                        {{ $slider->text }}
                                    </p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp"
                                        href="{{ $slider->button_link }}">
                                        <i class="{{ $slider->button_icon }}"></i>
                                        {{ $slider->button_text }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        {{ $i++ }}
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
