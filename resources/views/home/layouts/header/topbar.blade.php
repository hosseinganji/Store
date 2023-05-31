<div class="container-fluid">
    <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
        <div class="col-lg-4 text-right">
            <a href="" class="text-decoration-none">
                <span class="h2 fw-bold text-uppercase text-primary bg-dark px-2">استند</span>
                <span class="h2 fw-bold text-uppercase text-dark bg-primary px-2" style="margin-right: -5px;">گردان</span>
            </a>
        </div>

        <div class="col-lg-4 col-6 text-left">
            <form action="">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="جستجو محصولات...">
                    <div class="input-group-append">
                        <span class="input-group-text bg-transparent text-primary rounded-0">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-4 col-6 d-flex flex-row-reverse">
            @auth
                <form action="{{ route('logout') }}">
                    <button class="btn btn-danger mr-2" type="submit">خروج</button>
                </form>
                <a href="{{ route('home.profile.index') }}" class="btn btn-success mr-2" type="submit">پروفایل</a>
            @else
                <form action="{{ route('home.OTPlogin') }}">
                    <button class="btn btn-success mr-2" type="submit">ثبت نام / ورود</button>
                </form>
            @endauth
        </div>
    </div>
</div>
