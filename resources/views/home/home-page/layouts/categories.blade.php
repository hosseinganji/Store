<div class="container-fluid pt-5">
    <h2 class="section-title position-relative text-uppercase text-right mx-xl-5 mb-4">
        <span class="bg-secondary pl-3">دسته بندی ها</span>
    </h2>
    <div class="row px-xl-5 pb-3">
        @foreach ($categories as $category)
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1 text-right">
                <a class="text-decoration-none" href="">
                    <div class="cat-item d-flex align-items-center mb-4">
                        <div class="overflow-hidden" style="width: 100px; height: 100px;">
                            <img class="img-fluid" 
                                src="{{ url(env('CATEGORY_PATH_IMAGES') . '/' . $category->image) }}"
                                alt="{{ $category->name }}">
                        </div>
                        <div class="flex-fill pr-3">
                            <h6 class="fw-bold">{{ $category->name }}</h6>
                            <small class="text-body">{{ count($category->product) }} محصول</small>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
