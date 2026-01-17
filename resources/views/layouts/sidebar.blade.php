 <!-- BEGIN: Main Menu-->
 <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ asset('html/rtl/vertical-menu-template-dark/index.html')}}"><span class="brand-logo">
                      </span>
                    <h2 class="brand-text">لوحة التحكم</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">


            {{-- <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('dashboard.students') }}"><i data-feather="mail"></i><span class="menu-title text-truncate" data-i18n="Email">الطلاب</span></a></li> --}}

            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('dashboard.categories') }}"><i data-feather="layers"></i><span class="menu-title text-truncate" data-i18n="">الأقسام</span></a></li>

            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('dashboard.subcategories') }}"><i data-feather="list"></i><span class="menu-title text-truncate" data-i18n="">الأقسام الفرعية</span></a></li>

            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('dashboard.products') }}"><i data-feather="shopping-cart"></i><span class="menu-title text-truncate" data-i18n="">المنتجات</span></a></li>


            <li class=" nav-item {{ Route::is('dashboard.inventory')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('dashboard.inventory') }}"><i data-feather="archive"></i><span class="menu-title text-truncate" data-i18n="">المخزون</span></a></li>

            @can('الأدوار')
                 <li class=" nav-item {{ Route::is('dashboard.roles.index')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('dashboard.roles.index') }}"><i data-feather="shield"></i><span class="menu-title "> الأدوار</span></a></li>
            @endcan

            @can('فريق النظام')
                <li class=" nav-item {{ Route::is('dashboard.admins')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('dashboard.admins') }}"><i data-feather="users"></i><span class="menu-title ">فريق النظام</span></a></li>
            @endcan

            {{-- <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Invoice">صفحات</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="app-invoice-list.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">صفحة 1</span></a></li>

                    <li><a class="d-flex align-items-center" href="app-invoice-preview.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">صفحة 2</span></a></li>

                    <li><a class="d-flex align-items-center" href="app-invoice-edit.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Edit">صفحة 3</span></a> </li>
                    </li>
                </ul>
            </li> --}}

        </ul>
    </div>
</div>
<!-- END: Main Menu-->
