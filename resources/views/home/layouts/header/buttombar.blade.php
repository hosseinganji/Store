<div class="container-fluid bg-dark mb-30">
    <div class="row px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse"
                href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                <h6 class="text-dark fw-bold m-0"><i class="fa fa-bars ml-2 "></i>دسته بندی ها</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light"
                id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                @php
                    $parentCategories = App\Models\Category::where('parent_id', 0)->get();
                @endphp
                <div class="navbar-nav w-100 text-right">
                    @foreach ($parentCategories as $parentCategory)
                        @if (count($parentCategory->children) > 0)
                            <div class="nav-item dropdown dropright">
                                <a href="{{ route('home.category.show', ['category' => $parentCategory]) }}"
                                    class="nav-link dropdown-toggle" data-toggle="dropdown">
                                    {{ $parentCategory->name }}
                                    <i class="fa fa-angle-left float-left mt-1"></i>
                                    <div
                                        class="dropdown-menu position-absolute rounded-0 border-0 m-0 end-100 text-right">
                                        @foreach ($parentCategory->children as $childCategory)
                                            <a href="{{ route('home.category.show', ['category' => $childCategory]) }}"
                                                class="dropdown-item">
                                                {{ $childCategory->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </a>
                            </div>
                        @else
                            <div class="nav-item dropdown dropright">
                                <a href="/{{ $parentCategory->slug }}" class="nav-item nav-link dropdown-toggle">
                                    {{ $parentCategory->name }}
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </nav>






        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <span class="h2 fw-bold text-uppercase text-dark bg-light px-2">استند</span>
                    <span class="h2 fw-bold text-uppercase text-light bg-primary px-2 ml-n1">گردان</span>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav ml-auto py-0">
                        <a href="index.html" class="nav-item nav-link active">خانه</a>
                        <a href="shop.html" class="nav-item nav-link">فروشگاه</a>
                        <a href="detail.html" class="nav-item nav-link">جزئیات فروشگاه</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">صفحه ها<i
                                    class="fa fa-angle-down mt-1 mr-1"></i></a>
                            <div class="dropdown-menu bg-primary rounded-0 border-0 m-0 end-0">
                                <a href="{{ route("cart.show") }}" class="dropdown-item text-right">سبد خرید</a>
                                <a href="{{ route("home.checkout") }}" class="dropdown-item text-right">ثبت سفارش</a>
                            </div>
                        </div>
                        <a href="contact.html" class="nav-item nav-link">تماس با ما</a>
                    </div>
                    <div class="navbar-nav mr-auto py-0 d-none d-lg-block">
                        <a href="@auth{{ route('home.profile.wishlist') }}@endauth" class="btn px-0">
                            <i class="fas fa-heart text-primary"></i>
                            @auth
                                <span class="badge text-secondary border border-secondary rounded-circle"
                                    style="padding-bottom: 2px;">
                                    {{ App\Models\Wishlist::where("user_id" , auth()->id())->count() }}
                                </span>
                            @endauth
                        </a>
                        <a data-toggle="collapse" href="#shopping-cart" class="">
                            <i class="fas fa-shopping-cart text-primary mr-3"></i>
                            <span class="badge text-secondary border border-secondary rounded-circle"
                                style="padding-bottom: 2px;">
                                {{ count(\Cart::getContent()) }}
                            </span>
                            {{-- start shopping cart --}}
                            <nav class="collapse position-absolute  align-items-start p-0 bg-light" id="shopping-cart"
                                style="z-index: 999; width: 300px; left: 10px; hight: 100%; box-shadow: 0 0 10px #ccc;">
                                @if (\Cart::isEmpty())
                                    <div class="m-2 text-center fw-bold text-black">
                                        سبد خرید شما خالی می باشد
                                    </div>
                                @else
                                    <div class="pt-3 px-3 pb-1">
                                        @foreach (\Cart::getContent() as $item)
                                            <div class="d-flex w-100">
                                                <div>
                                                    <img width="70px"
                                                        src="{{ url(env('PRODUCT_PATH_IMAGES') . '/' . $item->associatedModel->primary_image) }}"
                                                        alt="">
                                                </div>
                                                <div class="w-75 text-right mr-2">
                                                    <p class="m-0">
                                                        <a href="{{ route('home.product.show', ['product' => $item->associatedModel->slug]) }}"
                                                            class="text-info fw-bold">{{ $item->name }}</a>
                                                    </p>
                                                    <div class="row">
                                                        <p class="mx-0 my-1 w-100" style="font-size: 14px;">
                                                            <span class="float-start">{{ number_format($item->price) }}
                                                                تومان</span>
                                                            @if ($item->attributes->is_sale)
                                                                <span style="font-size: 13px;"
                                                                    class="text-success fw-bold float-end">%{{ round((1 - $item->attributes->sale_price / $item->attributes->price) * 100) }}
                                                                    تخفیف</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="row">

                                                        <p class="m-0" style="font-size: 14px;">
                                                            <span
                                                                class="float-start">{{ App\Models\Attribute::find($item->attributes->attribute_id)->name }}:
                                                                {{ $item->attributes->value }}</span>
                                                            <span class="float-end">{{ $item->quantity }} عدد</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="my-2">
                                        @endforeach

                                    </div>
                                    <div class="pb-5 px-3 pt-0">
                                        <span class="float-start fw-bold">مجموع:</span>
                                        <span class="float-end fw-bold">{{ number_format(\Cart::getTotal()) }}
                                            تومان</span>
                                    </div>

                                    <div class="p-3">
                                        <a href="{{ route("cart.show") }}" class="btn btn-primary w-100 mb-2">مشاهده سبد خرید</a>
                                        <a href="{{ route("home.checkout") }}" class="btn btn-success w-100">نهایی کردن سفارش</a>
                                    </div>
                                @endif

                            </nav>
                            {{-- end shopping cart --}}
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
