@extends('dashboard.layouts.header')
@section('content')
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar  ">
        <div class="layout-container">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo ">
                    <a href="" class="app-brand-link">
                        <span class="app-brand-logo demo"><img src="/backend/storage/app/public/{{ $loginUser->avatar }}"  alt="{{ $loginUser->name }}"  class="w-px-40 h-auto rounded-circle"></span><span class="app-brand-text demo menu-text ms-2" style="font-size: 100%;font-weight: bold;font-family: sans-serif;color: #364f50;">{{ $loginUser->name }}</span></a>
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i></a>
                </div>

                <div class="menu-inner-shadow"></div>
                <ul class="menu-inner py-1">
                    <!-- Dashboards -->
                    {{-- @can('view-dashboard') --}}
                    <li class="menu-item" data-path="{{ route('dashboard.index') }}">
                        <a href="{{ route('dashboard.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div class="text-truncate" data-i18n="Dashboard">Dashboard</div>
                        </a>
                    </li>

                    <li class="menu-item" data-path="{{ route('gallery.index') }}">
                        <a href="{{ route('gallery.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-gallery"></i>
                            <div class="text-truncate" data-i18n="gallery">gallery</div>
                        </a>
                    </li>

                <li class="menu-item" data-path="{{ route('pages.index') }}">
                    <a href="{{ route('pages.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-page"></i>
                        <div class="text-truncate" data-i18n="Pages">Pages</div>
                    </a>
                </li>


                <li class="menu-item" data-path="{{ route('contacts.index') }}">
                        <a href="{{ route('contacts.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-phone"></i>
                            <div class="text-truncate" data-i18n="Contacts">Contacts</div>
                        </a>
                    </li>

                    <li class="menu-item" data-path="{{ route('settings.index') }}">
                        <a href="{{ route('settings.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-cog"></i>
                            <div class="text-truncate" data-i18n="Settings">Settings</div>
                        </a>
                    </li>


                    <!-- Category -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-category"></i>
                            <div class="text-truncate" data-i18n="Category">Category</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('category.index') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="View">View</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('category.create') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="Add">Add</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-briefcase"></i>
                            <div class="text-truncate" data-i18n="project">project</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('project.index') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="View">View</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('project.create') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="Add">Add</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="{{ route('success_partners.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-party"></i>
                            <div class="text-truncate" data-i18n="Success Partners">Success Partners </div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ route('blog.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-image"></i>
                            <div class="text-truncate" data-i18n="Blogs ">Blogs </div>
                        </a>
                    </li>



                    <!-- FAQ -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-question-mark"></i>
                            <div class="text-truncate" data-i18n="FAQ">FAQ</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('faq.index') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="View">View</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('faq.create') }}" class="menu-link">
                                    <div class="text-truncate" data-i18n="Add">Add</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </aside>
            <!-- / Menu -->
            <!-- Layout container -->
            <div class="layout-page">
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0   d-xl-none ">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item navbar-search-wrapper mb-0">
                                <a class="nav-item nav-link search-toggler px-0" href="javascript:void(0);">
                                    <i class="bx bx-search bx-sm"></i>
                                    <span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span>
                                </a>
                            </div>
                        </div>
                        <!-- /Search -->
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Quick links -->
                            <!-- Style Switcher -->
                            <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <i class='bx bx-sm'></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                                            <span class="align-middle"><i class='bx bx-sun me-2'></i>Light</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                                            <span class="align-middle"><i class="bx bx-moon me-2"></i>Dark</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                                            <span class="align-middle"><i class="bx bx-desktop me-2"></i>System</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="https://ui-avatars.com/api/?name={{ $loginUser->name }}" alt="{{ $loginUser->name }}"
                                            class="w-px-40 h-auto rounded-circle">
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="https://ui-avatars.com/api/?name={{ $loginUser->name }}" alt="{{ $loginUser->name }}"
                                                            class="w-px-40 h-auto rounded-circle">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-medium d-block">{{ $loginUser->name }}</span>
                                                    <small class="text-muted">{{ $loginUser->email }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('login.logout') }}" >
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>
                <!-- / Navbar -->
                @yield('body')

                @yield('footer')
            @endsection
