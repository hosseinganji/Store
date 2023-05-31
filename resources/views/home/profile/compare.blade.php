@extends('home.layouts.app')

@section('title')
    profile comments Page
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
                    <span class="breadcrumb-item active">مقایسه ها</span>
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
                    <span class="bg-secondary pl-3 fw-bold fs-3">مقایسه ها</span>
                </h5>
                @if (!session()->get('compareProduct'))
                    <div class="alert alert-danger text-right">
                        شما هنوز هیچ محصولی را به لیست مقایسه اضافه نکرده اید
                    </div>
                @else
                    <div class="bg-light p-4 mb-5">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="align-middle text-center">تصاویر</th>
                                    @foreach ($products as $product)
                                        <th class="align-middle text-center">
                                            <img class="img-thumbnail" style="transform: none;"
                                                src="{{ url(env('PRODUCT_PATH_IMAGES') . '/' . $product->primary_image) }}"
                                                alt="{{ $product->name }}" width="100px">
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th class="align-middle text-center">نام محصول</th>
                                    @foreach ($products as $product)
                                        <th class="align-middle text-center">{{ $product->name }}</th>
                                    @endforeach
                                </tr>

                                <tr>
                                    <th class="align-middle text-center">دسته بندی</th>
                                    @foreach ($products as $product)
                                        <th class="align-middle text-center">{{ $product->category->name }}</th>
                                    @endforeach
                                </tr>


                                <tr>
                                    <th class="align-middle text-center">توضیحات</th>
                                    @foreach ($products as $product)
                                        <th class="align-middle text-center">{{ $product->description }}</th>
                                    @endforeach
                                </tr>


                                <tr>
                                    <th class="align-middle text-center">ویژگی ها</th>
                                    @foreach ($products as $product)
                                        <th class="align-middle text-center">
                                            <ul>
                                                @foreach ($product->attribute as $productAttribute)
                                                    <li>
                                                        {{ App\Models\Attribute::where('id', $productAttribute->attribute_id)->first()->name }}:
                                                        {{ $productAttribute->value }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </th>
                                    @endforeach
                                </tr>



                                <tr>
                                    <th class="align-middle text-center">ویژگی های متغیر</th>
                                    @foreach ($products as $product)
                                        <th class="align-middle text-right">
                                            <ul>
                                                {{ App\Models\Attribute::where('id', $product->variations->first()->attribute_id)->first()->name }}:
                                                @foreach ($product->variations as $productVariation)
                                                    <li>
                                                        {{ $productVariation->value }}
                                                        <ul>
                                                            <li>{{ $productVariation->price }} تومان</li>
                                                            <li>{{ $productVariation->quantity }} عدد</li>
                                                        </ul>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </th>
                                    @endforeach
                                </tr>

                                <tr>
                                    <th class="align-middle text-center">هزینه ارسال</th>
                                    @foreach ($products as $product)
                                        <th class="align-middle text-center">{{ $product->delivery_amount }}</th>
                                    @endforeach
                                </tr>

                                <tr>
                                    <th class="align-middle text-center">
                                        هزینه ارسال به ازای محصول اضافی</th>
                                    @foreach ($products as $product)
                                        <th class="align-middle text-center">{{ $product->delivery_amount_per_product ?? "ندارد" }}</th>
                                    @endforeach
                                </tr>

                                <tr>
                                    <th class="align-middle text-center">امتیاز</th>
                                    @foreach ($products as $product)
                                        <th class="align-middle text-center">
                                            <div class="d-flex align-items-center justify-content-center"
                                                style="direction: ltr">
                                                <div data-rating-stars="5" data-rating-readonly="true"
                                                    data-rating-half="true"
                                                    data-rating-value="{{ $product->rates->avg('rate') }}">
                                                </div>
                                                <small>({{ $product->rates->avg('rate') ?? 0 }})</small>
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>

                                <tr>
                                    <th class="align-middle text-center">عملیات</th>
                                    @foreach ($products as $product)
                                        <th class="align-middle text-center">
                                            <form
                                                action="{{ route('profile.compare.remove', ['product' => $product->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('delete')
                                                <button
                                                    onclick="return confirm('آیا از حذف کردن این محصول از لیست مقایسه ها مطمئن هستید؟');"
                                                    class="border-0 bg-transparent" type="submit">
                                                    <i class="fa fa-trash fs-5 text-danger" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </th>
                                    @endforeach
                                </tr>

                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
    @include('home.layouts.footer.footer')
@endsection
