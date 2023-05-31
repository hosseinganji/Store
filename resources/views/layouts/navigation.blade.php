<ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
    <li class="nav-item">
        <a class="nav-link" href="{{ route("admin.dashboard") }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-speedometer') }}"></use>
            </svg>
            داشبورد
        </a>
    </li>






    <li class="nav-group" aria-expanded="false">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-star') }}"></use>
            </svg>
            فروشگاه
        </a>
        <ul class="nav-group-items" style="height: 0px;">
            <li class="nav-item">
                <a class="nav-link" href="{{ route("admin.brands.index") }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    برند ها
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route("admin.attributes.index") }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    ویژگی ها
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route("admin.categories.index") }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    دسته بندی ها
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route("admin.tags.index") }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    تگ ها
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route("admin.products.index") }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    محصولات
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route("admin.banners.index") }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    بنر ها
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route("admin.comments.index") }}" target="_top">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('icons/coreui.svg#cil-bug') }}"></use>
                    </svg>
                    کامنت ها
                </a>
            </li>
        </ul>
    </li>




    <li class="nav-item">
        <a class="nav-link" href="{{ route('users.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
            </svg>
            کاربران
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('about') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-speedometer') }}"></use>
            </svg>
            درباره ما
        </a>
    </li>

    
</ul>

@include('sweetalert::alert')