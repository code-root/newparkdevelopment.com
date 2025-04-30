<?php $__env->startSection('content'); ?>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar  ">
        <div class="layout-container">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo ">
                    <a href="" class="app-brand-link">
                        <span class="app-brand-text demo menu-text ms-2" style="font-size: 100%;font-weight: bold;font-family: sans-serif;color: #364f50;"><?php echo e($loginUser->name); ?></span></a>
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i></a>
                </div>

                <div class="menu-inner-shadow"></div>
                <ul class="menu-inner py-1">
                    <!-- Dashboards -->
                    
                    <li class="menu-item" data-path="<?php echo e(route('dashboard.index')); ?>">
                        <a href="<?php echo e(route('dashboard.index')); ?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div class="text-truncate" data-i18n="Dashboard">Dashboard</div>
                        </a>
                    </li>


                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-file"></i>
                            <div class="text-truncate" data-i18n="Pages">Pages</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="<?php echo e(route('pages.index', ['type' => 'regular'])); ?>" class="menu-link">
                                    <i class="bx bx-file-blank me-1"></i>
                                    <div class="text-truncate">Regular Pages</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="<?php echo e(route('pages.index', ['type' => 'section'])); ?>" class="menu-link">
                                    <i class="bx bx-layout me-1"></i>
                                    <div class="text-truncate">Sections</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="<?php echo e(route('pages.index', ['type' => 'article'])); ?>" class="menu-link">
                                    <i class="bx bx-news me-1"></i>
                                    <div class="text-truncate">Articles</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="<?php echo e(route('pages.create')); ?>" class="menu-link">
                                    <i class="bx bx-plus-circle me-1"></i>
                                    <div class="text-truncate">Add New Page</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item" data-path="<?php echo e(route('settings.index')); ?>">
                        <a href="<?php echo e(route('settings.index')); ?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-cog"></i>
                            <div class="text-truncate" data-i18n="Settings">Settings</div>
                        </a>
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
                                        <img src="https://ui-avatars.com/api/?name=<?php echo e($loginUser->name); ?>" alt="<?php echo e($loginUser->name); ?>"
                                            class="w-px-40 h-auto rounded-circle">
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="<?php echo e(route('admin.profile')); ?>">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="https://ui-avatars.com/api/?name=<?php echo e($loginUser->name); ?>" alt="<?php echo e($loginUser->name); ?>"
                                                            class="w-px-40 h-auto rounded-circle">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-medium d-block"><?php echo e($loginUser->name); ?></span>
                                                    <small class="text-muted"><?php echo e($loginUser->email); ?></small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo e(route('login.logout')); ?>" >
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
                <?php echo $__env->yieldContent('body'); ?>

                <?php echo $__env->yieldContent('footer'); ?>
            <?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/macstoreegypt/Documents/Projects/sadaadd.com/resources/views/dashboard/layouts/navbar.blade.php ENDPATH**/ ?>