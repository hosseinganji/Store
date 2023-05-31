<div class="col-lg-3">
    <a href="{{ route('home.profile.index') }}"
        class="btn btn-block btn-{{ request()->is('profile') ? 'primary' : 'light' }} font-weight-bold py-3 mt-0 text-right">
        <i class="fa fa-user-circle-o mx-2"></i>
        پروفایل
    </a>
    <hr class="m-0">

    <a href="{{ route('home.profile.comments') }}"
        class="btn btn-block btn-{{ request()->is('profile/comments') ? 'primary' : 'light' }} font-weight-bold py-3 mt-0 text-right">
        <i class="fa fa-commenting mx-2"></i>
        نظرات
    </a>
    <hr class="m-0">

    <a href="{{ route('home.profile.address') }}"
        class="btn btn-block btn-{{ request()->is('profile/address') ? 'primary' : 'light' }} font-weight-bold py-3 mt-0 text-right">
        <i class="fa fa-address-book mx-2"></i>
        آدرس ها
    </a>
    <hr class="m-0">

    <a class="btn btn-block btn-light font-weight-bold py-3 mt-0 text-right">
        <i class="fa fa-shopping-cart mx-2"></i>
        سفارشات
    </a>
    <hr class="m-0">

    <a href="{{ route('home.profile.wishlist') }}"
        class="btn btn-block btn-{{ request()->is('profile/wishlist') ? 'primary' : 'light' }} font-weight-bold py-3 mt-0 text-right">
        <i class="fa fa-heart mx-2"></i>
        علاقه مندی ها
    </a>
    <hr class="m-0">

    <a href="{{ route('home.profile.compare') }}"
        class="btn btn-block btn-{{ request()->is('profile/compare') ? 'primary' : 'light' }} font-weight-bold py-3 mt-0 text-right">
        <i class="fa fa-random mx-2"></i>
        مقایسه ها
    </a>
    <hr class="m-0">

    <a href="{{ route('logout') }}" class="btn btn-block btn-light font-weight-bold py-3 mt-0 text-right">
        <i class="fa fa-sign-out mx-2"></i>
        خروج
    </a>

</div>

<style>
    .pagination {
        justify-content: center;
    }
</style>
