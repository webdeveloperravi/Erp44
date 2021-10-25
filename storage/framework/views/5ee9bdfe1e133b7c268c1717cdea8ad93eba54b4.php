<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title class="text-capitalize"><?php echo $__env->yieldContent('page_title'); ?></title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="<?php echo $__env->yieldContent('page_description'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('assets/front/img/favicon.ico')); ?>">

    <!-- CSS
 ============================================ -->
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,900" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('public/front/assets/front/css/vendor/bootstrap.min.css')); ?>">
    <!-- Pe-icon-7-stroke CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('public/front/assets/front/css/vendor/pe-icon-7-stroke.css')); ?>">
    <!-- Font-awesome CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('public/front/assets/front/css/vendor/font-awesome.min.css')); ?>">
    <!-- Slick slider css -->
    <link rel="stylesheet" href="<?php echo e(asset('public/front/assets/front/css/plugins/slick.min.css')); ?>">
    <!-- animate css -->
    <link rel="stylesheet" href="<?php echo e(asset('public/front/assets/front/css/plugins/animate.css')); ?>">
    <!-- Nice Select css -->
    <link rel="stylesheet" href="<?php echo e(asset('public/front/assets/front/css/plugins/nice-select.css')); ?>">
    <!-- jquery UI css -->
    <link rel="stylesheet" href="<?php echo e(asset('public/front/assets/front/css/plugins/jqueryui.min.css')); ?>">
    <!-- main style css -->
    <link rel="stylesheet" href="<?php echo e(asset('public/front/assets/front/css/style.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('public/front/css/custom.css')); ?>">
    <style>
        .filterLoader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: 99999999;
        }

        .loader {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100px;
            height: 100px;
            margin: 40px auto;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 0;
            line-height: 0;
            animation: rotate-loader 5s infinite;
            padding: 25px;
            border: 1px solid #c29958;
        }

        .loader .loader-inner {
            position: relative;
            display: inline-block;
            width: 50%;
            height: 50%;
        }

        .loader .loading {
            position: absolute;
            background: #c29958;
        }

        .loader .one {
            width: 100%;
            bottom: 0;
            height: 0;
            animation: loading-one 1s infinite;
        }

        .loader .two {
            width: 0;
            height: 100%;
            left: 0;
            animation: loading-two 1s infinite;
            animation-delay: 0.25s;
        }

        .loader .three {
            width: 0;
            height: 100%;
            right: 0;
            animation: loading-two 1s infinite;
            animation-delay: 0.75s;
        }

        .loader .four {
            width: 100%;
            top: 0;
            height: 0;
            animation: loading-one 1s infinite;
            animation-delay: 0.5s;
        }

        @keyframes  loading-one {
            0% {
                height: 0;
                opacity: 1;
            }

            12.5% {
                height: 100%;
                opacity: 1;
            }

            50% {
                opacity: 1;
            }

            100% {
                height: 100%;
                opacity: 0;
            }
        }

        @keyframes  loading-two {
            0% {
                width: 0;
                opacity: 1;
            }

            12.5% {
                width: 100%;
                opacity: 1;
            }

            50% {
                opacity: 1;
            }

            100% {
                width: 100%;
                opacity: 0;
            }
        }

        @keyframes  rotate-loader {
            0% {
                transform: translate(-50%, -50%) rotate(-45deg);
            }

            20% {
                transform: translate(-50%, -50%) rotate(-45deg);
            }

            25% {
                transform: translate(-50%, -50%) rotate(-135deg);
            }

            45% {
                transform: translate(-50%, -50%) rotate(-135deg);
            }

            50% {
                transform: translate(-50%, -50%) rotate(-225deg);
            }

            70% {
                transform: translate(-50%, -50%) rotate(-225deg);
            }

            75% {
                transform: translate(-50%, -50%) rotate(-315deg);
            }

            95% {
                transform: translate(-50%, -50%) rotate(-315deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(-405deg);
            }
        }

    </style>

    <style>
        /*
*
* ==========================================
* CUSTOM UTIL CLASSES
* ==========================================
*
*/

        .form-control:focus {
            box-shadow: none;
        }

        .form-control-underlined {
            border-width: 0;
            border-bottom-width: 1px;
            border-radius: 0;
            padding-left: 0;
        }

        /*
    *
    * ==========================================
    * FOR DEMO PURPOSE
    * ==========================================
    *
    */



        .form-control::placeholder {
            font-size: 0.95rem;
            color: #aaa;
            font-style: italic;
        }

    </style>

    

    <?php echo $__env->yieldContent('styles'); ?>

    <?php echo \Livewire\Livewire::styles(); ?>


</head>

<body>

    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('pop', [])->html();
} elseif ($_instance->childHasBeenRendered('clxrR53')) {
    $componentId = $_instance->getRenderedChildComponentId('clxrR53');
    $componentTag = $_instance->getRenderedChildComponentTagName('clxrR53');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('clxrR53');
} else {
    $response = \Livewire\Livewire::mount('pop', []);
    $html = $response->html();
    $_instance->logRenderedChild('clxrR53', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>


    
    


    <!--preloader-->

    <div class="filterLoader preloader">

        <div class="loader">
            <div class="loader-inner">
                <div class="loading one"></div>
            </div>
            <div class="loader-inner">
                <div class="loading two"></div>
            </div>
            <div class="loader-inner">
                <div class="loading three"></div>
            </div>
            <div class="loader-inner">
                <div class="loading four"></div>
            </div>
        </div>
    </div>
    <!--end preloader-->


    <?php
        
        $proCategories = getProductCategories();
        $blogCats = getBlogCategories();
        $products = getProducts();
        $store = \App\Model\Guard\UserStore::find(session('account_id'));
        
    ?>






    <!-- Start Header Area -->
    <header class="header-area hover:ring-">
        <!-- main header start -->
        <div class="main-header d-none d-lg-block">
            <!-- header top start -->
            <div class="header-top bg-gray">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-8 ">

                            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('main-search-bar', [])->html();
} elseif ($_instance->childHasBeenRendered('AvBB3zg')) {
    $componentId = $_instance->getRenderedChildComponentId('AvBB3zg');
    $componentTag = $_instance->getRenderedChildComponentTagName('AvBB3zg');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('AvBB3zg');
} else {
    $response = \Livewire\Livewire::mount('main-search-bar', []);
    $html = $response->html();
    $_instance->logRenderedChild('AvBB3zg', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>


                        </div>
                        <div class="col-lg-4 text-right">
                            <div class="header-top-settings">
                                <ul class="nav align-items-center justify-content-end">
                                    <li class="curreny-wrap">
                                        Currency
                                        <i class="fa fa-angle-down"></i>
                                        <ul class="dropdown-list curreny-list">
                                            <li><a href="#">$ USD</a></li>
                                            <li><a href="#">€ EURO</a></li>
                                        </ul>
                                    </li>
                                    <li class="language">
                                        Language
                                        <i class="fa fa-angle-down"></i>
                                        <ul class="dropdown-list">
                                            <li>
                                                <div id="google_translate_element"></div>
                                            </li>

                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- header middle area start -->
            <div class="header-main-area sticky">
                <div class="container">
                    <div class="row align-items-center position-relative" style="
                    height: 55px;
                ">

                        <!-- start logo area -->
                        <div class="col-lg-2">
                            <div class="logo" style="height: 79px;">
                                <a href="<?php echo e(route('9gemhome')); ?>">
                                    <h6 class="text-uppercase mt-2"><?php echo e($store->company_name); ?></h6>
                                </a>
                            </div>
                        </div>
                        <!-- start logo area -->

                        <!-- main menu area start -->
                        <div class="col-lg-6 position-static">
                            <div class="main-menu-area">
                                <div class="main-menu">
                                    <!-- main menu navbar start -->
                                    <nav class="desktop-menu">
                                        <ul style="height: 95px">
                                            <li class="active"><a href="<?php echo e(route('9gemhome')); ?>">Home</a>

                                            </li>
                                            <li class="position-static"><a href="#">Products <i
                                                        class="fa fa-angle-down"></i></a>
                                                <ul class="megamenu dropdown">

                                                    <?php $__currentLoopData = $proCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li class="mega-title mr-4">
                                                            <span class="text-center "
                                                                style="width: 100%"><?php echo e($category->name); ?></span>
                                                            <div class="d-flex align-items-start">


                                                                <?php $__currentLoopData = $category->Product->sortBy('name')->chunk(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <ul>

                                                                        <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <li><a
                                                                                    href="<?php echo e(route('9gem_product_items_list', $product->name)); ?>"><?php echo e($product->name ?? ''); ?></a>


                                                                            </li>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                                                    </ul>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </div>

                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>





                                                    <li class="megamenu-banners d-none d-lg-block">
                                                        <a href="product-details.html">
                                                            <img src="<?php echo e(asset('assets/front/img/banner/img1-static-menu.jpg')); ?>"
                                                                alt="">
                                                        </a>
                                                    </li>
                                                    <li class="megamenu-banners d-none d-lg-block">
                                                        <a href="product-details.html">
                                                            <img src="<?php echo e(asset('assets/front/img/banner/img2-static-menu.jpg')); ?>"
                                                                alt="">
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>


                                            <li><a href="javascript:void(0)">Blogs <i class="fa fa-angle-down"></i></a>
                                                <ul class="dropdown" id="headdrop">
                                                    <?php $__currentLoopData = $blogCats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li style="position:relative">
                                                            <a
                                                                href="<?php echo e(route('9gem_allblogs', $category['id'])); ?>"><?php echo e($category['name']); ?></a>


                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </ul>

                                            </li>




                                            <li><a href="contact-us.html">Contact us</a></li>
                                            <li><a href="contact-us.html">About us</a></li>
                                        </ul>
                                    </nav>
                                    <!-- main menu navbar end -->
                                </div>
                            </div>
                        </div>
                        <!-- main menu area end -->


                        <!-- mini cart area start -->
                        <div class="col-lg-4">
                            <div class="header-right d-flex align-items-center justify-content-end">
                                <div class="header-configure-area">
                                    <ul class="nav justify-content-end" style="height: 65px;">
                                        


                                        <li class="user-hover">
                                            <a href="#">
                                                <i class="pe-7s-user"></i>
                                            </a>
                                            <ul class="dropdown-list">
                                                <?php if(session('user_login')): ?>
                                                    <li><a href="<?php echo e(route('9gem_user_account')); ?>">My Account</a>
                                                    </li>
                                                    
                                                    
                                                    <li><a href="<?php echo e(route('9gem_user_logout')); ?>">Logout
                                                        </a>
                                                    </li>
                                                <?php else: ?>
                                                    <li><a href="<?php echo e(route('9gem_user_login')); ?>">
                                                            Login</a>
                                                    </li>
                                                    <li><a href="<?php echo e(route('9gem_user_register')); ?>">
                                                            Register</a>
                                                    </li>


                                                <?php endif; ?>
                                            </ul>

                                        </li>


                                        <li>
                                            <a href="<?php echo e(route('9gem_user_wishlist')); ?>">
                                                <i class="pe-7s-like"></i>
                                                <div class="notification">0</div>
                                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user-wish-list-noty', [])->html();
} elseif ($_instance->childHasBeenRendered('pHrma29')) {
    $componentId = $_instance->getRenderedChildComponentId('pHrma29');
    $componentTag = $_instance->getRenderedChildComponentTagName('pHrma29');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('pHrma29');
} else {
    $response = \Livewire\Livewire::mount('user-wish-list-noty', []);
    $html = $response->html();
    $_instance->logRenderedChild('pHrma29', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="minicart-btn">
                                                <i class="pe-7s-shopbag"></i>
                                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('shopping-bag', [])->html();
} elseif ($_instance->childHasBeenRendered('bnygXOH')) {
    $componentId = $_instance->getRenderedChildComponentId('bnygXOH');
    $componentTag = $_instance->getRenderedChildComponentTagName('bnygXOH');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('bnygXOH');
} else {
    $response = \Livewire\Livewire::mount('shopping-bag', []);
    $html = $response->html();
    $_instance->logRenderedChild('bnygXOH', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- mini cart area end -->

                    </div>
                </div>
            </div>
            <!-- header middle area end -->
        </div>
        <!-- main header start -->


        <!-- mobile header start -->
        <!-- mobile header start -->
        <div class="mobile-header d-lg-none d-md-block sticky">
            <!--mobile header top start -->
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="mobile-main-header">
                            <div class="mobile-logo">
                                <a href="index.html">
                                    <?php echo e($store->company_name); ?>


                                </a>
                            </div>
                            <div class="mobile-menu-toggler">
                                <div class="mini-cart-wrap">
                                    <a href="<?php echo e(route('9gem_user_cart')); ?>">
                                        <i class="pe-7s-shopbag"></i>
                                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('shopping-bag', [])->html();
} elseif ($_instance->childHasBeenRendered('XxJa31X')) {
    $componentId = $_instance->getRenderedChildComponentId('XxJa31X');
    $componentTag = $_instance->getRenderedChildComponentTagName('XxJa31X');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('XxJa31X');
} else {
    $response = \Livewire\Livewire::mount('shopping-bag', []);
    $html = $response->html();
    $_instance->logRenderedChild('XxJa31X', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                    </a>
                                </div>
                                <button class="mobile-menu-btn">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- mobile header top start -->
        </div>
        <!-- mobile header end -->
        <!-- mobile header end -->

        <!-- offcanvas mobile menu start -->
        <!-- off-canvas menu start -->
        <aside class="off-canvas-wrapper">
            <div class="off-canvas-overlay"></div>
            <div class="off-canvas-inner-content">
                <div class="btn-close-off-canvas">
                    <i class="pe-7s-close"></i>
                </div>

                <div class="off-canvas-inner">
                    <!-- search box start -->
                    <div class="search-box-offcanvas">
                        <form action="<?php echo e(route('9gem_search_results')); ?>" method="get">
                            <?php echo csrf_field(); ?>
                            <input type="text" placeholder="Search Here..." name="query" autocomplete="off">
                            <button class="search-btn" type="submit"><i class="pe-7s-search"></i></button>
                        </form>

                    </div>
                    <!-- search box end -->

                    <!-- mobile menu start -->
                    <div class="mobile-navigation">

                        <!-- mobile menu navigation start -->
                        <nav>
                            <ul class="mobile-menu">

                                <li class="menu-item-has-children"><a href="index.html">Home</a>

                                </li>

                                <li class="menu-item-has-children"><a href="#">Products</a>


                                    <ul class="megamenu dropdown">
                                        <!---ProductCategories----->
                                        <?php $__currentLoopData = $proCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="mega-title menu-item-has-children"><a
                                                    href="#"><?php echo e($category->name); ?></a>
                                                <ul class="dropdown">
                                                    <?php $__currentLoopData = $category->Product->sortBy('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li>
                                                            <a href="shop.html"> <?php echo e($product->name ?? ''); ?>

                                                            </a>



                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </ul>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </li>





                                <li class="menu-item-has-children "><a href="#">Blogs</a>
                                    <ul class="dropdown">
                                        <?php $__currentLoopData = $blogCats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <li><a
                                                    href="<?php echo e(route('9gem_allblogs', $category['id'])); ?>"><?php echo e($category['name']); ?></a>
                                            </li>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </ul>
                                </li>

                                <li><a href="contact-us.html">Contact us</a></li>
                                <li><a href="contact-us.html">About us</a></li>
                            </ul>
                        </nav>
                        <!-- mobile menu navigation end -->
                    </div>
                    <!-- mobile menu end -->

                    <div class="mobile-settings">
                        <ul class="nav">
                            <li>
                                <div class="dropdown mobile-top-dropdown">
                                    <a href="#" class="dropdown-toggle" id="currency" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Currency
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="currency">
                                        <a class="dropdown-item" href="#">$ USD</a>
                                        <a class="dropdown-item" href="#">$ EURO</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown mobile-top-dropdown">
                                    <a href="#" class="dropdown-toggle" id="myaccount" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        My Account
                                        <i class="fa fa-angle-down"></i>
                                    </a>


                                    <div class="dropdown-menu" aria-labelledby="myaccount">
                                        <?php if(session('user_login')): ?>
                                            <a class="dropdown-item"
                                                href="<?php echo e(route('9gem_user_account')); ?>">MyAccount</a>

                                            

                                            
                                            <a class="dropdown-item" href="<?php echo e(route('9gem_user_logout')); ?>">Logout
                                            </a>

                                        <?php else: ?>
                                            <a class="dropdown-item" href="<?php echo e(route('9gem_user_login')); ?>">
                                                Login</a>

                                            <a class="dropdown-item" href="<?php echo e(route('9gem_user_register')); ?>">
                                                Register</a>
                                        <?php endif; ?>



                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- offcanvas widget area start -->
                    <div class="offcanvas-widget-area">
                        <div class="off-canvas-contact-widget">
                            <ul>
                                <li><i class="fa fa-mobile"></i>
                                    <a href="#">0123456789</a>
                                </li>
                                <li><i class="fa fa-envelope-o"></i>
                                    <a href="#">demo@example.com</a>
                                </li>
                            </ul>
                        </div>
                        <div class="off-canvas-social-widget">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-pinterest-p"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                        </div>
                    </div>
                    <!-- offcanvas widget area end -->
                </div>
            </div>
        </aside>
        <!-- off-canvas menu end -->
        <!-- offcanvas mobile menu end -->
    </header>
    <!-- end Header Area -->


    <?php echo $__env->yieldContent('content'); ?>




    <!-- footer area start -->
    <footer class="footer-widget-area">
        <div class="footer-top section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="widget-item">
                            <div class="widget-title">
                                <div class="widget-logo">
                                    <a href="index.html">
                                        <?php echo e($store->company_name); ?>

                                    </a>
                                </div>
                            </div>
                            <div class="widget-body">
                                <p>We are a team of designers and developers that create high quality wordpress,
                                    shopify, Opencart </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="widget-item">
                            <h6 class="widget-title">Contact Us</h6>
                            <div class="widget-body">
                                <address class="contact-block">
                                    <ul>
                                        <li><i class="pe-7s-home"></i> Your address goes here.</li>
                                        <li><i class="pe-7s-mail"></i> <a
                                                href="mailto:demo@plazathemes.com">demo@example.com </a></li>
                                        <li><i class="pe-7s-call"></i> <a href="tel:0123456789">0123456789</a>
                                        </li>
                                    </ul>
                                </address>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="widget-item">
                            <h6 class="widget-title">Quick Links</h6>
                            <div class="widget-body">
                                <ul class="info-list">
                                    <li><a href="#">about us</a></li>
                                    <li><a href="#">Delivery Information</a></li>
                                    <li><a href="#">privet policy</a></li>
                                    <li><a href="#">Terms & Conditions</a></li>
                                    <li><a href="#">contact us</a></li>
                                    <li><a href="#">site map</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="widget-item">
                            <h6 class="widget-title">Follow Us</h6>
                            <div class="widget-body social-link">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-20">
                    <div class="col-md-6">
                        <div class="newsletter-wrapper">
                            <h6 class="widget-title-text">Signup for newsletter</h6>
                            <form class="newsletter-inner" id="mc-form">
                                <input type="email" class="news-field" id="mc-email" autocomplete="off"
                                    placeholder="Enter your email address">
                                <button class="news-btn" id="mc-submit">Subscribe</button>
                            </form>
                            <!-- mailchimp-alerts Start -->
                            <div class="mailchimp-alerts">
                                <div class="mailchimp-submitting"></div><!-- mailchimp-submitting end -->
                                <div class="mailchimp-success"></div><!-- mailchimp-success end -->
                                <div class="mailchimp-error"></div><!-- mailchimp-error end -->
                            </div>
                            <!-- mailchimp-alerts end -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="footer-payment">
                            <img src="<?php echo e(asset('assets/front/img/payment.png')); ?>" alt="payment method">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="copyright-text text-center">
                            <p class="copyright-text">&copy; 2021 <a href="index.html">Corano</a>. Made with <i
                                    class="fa fa-heart text-danger"></i> by <a class="" href="
                                    https://hasthemes.com/" target="_blank">HasThemes</a> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer area end -->



    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('mini-cart', [])->html();
} elseif ($_instance->childHasBeenRendered('mGyWdmu')) {
    $componentId = $_instance->getRenderedChildComponentId('mGyWdmu');
    $componentTag = $_instance->getRenderedChildComponentTagName('mGyWdmu');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('mGyWdmu');
} else {
    $response = \Livewire\Livewire::mount('mini-cart', []);
    $html = $response->html();
    $_instance->logRenderedChild('mGyWdmu', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

    <!-- Scroll to top start -->
    <div class=" scroll-top not-visible">
        <i class="fa fa-angle-up"></i>
    </div>
    <!-- Scroll to Top End -->



    <!-- JS
============================================ -->

    <!-- Modernizer JS -->
    <script src="<?php echo e(asset('public/front/assets/front/js/vendor/modernizr-3.6.0.min.js')); ?>"></script>
    <!-- jQuery JS -->
    <script src="<?php echo e(asset('public/front/assets/front/js/vendor/jquery-3.3.1.min.js')); ?>"></script>
    <!-- Popper JS -->
    <script src="<?php echo e(asset('public/front/assets/front/js/vendor/popper.min.js')); ?>"></script>
    <!-- Bootstrap JS -->
    <script src="<?php echo e(asset('public/front/assets/front/js/vendor/bootstrap.min.js')); ?>"></script>
    <!-- slick Slider JS -->
    <script src="<?php echo e(asset('public/front/assets/front/js/plugins/slick.min.js')); ?>"></script>
    <!-- Countdown JS -->
    <script src="<?php echo e(asset('public/front/assets/front/js/plugins/countdown.min.js')); ?>"></script>

    <!-- Nice Select JS -->
    <script src="<?php echo e(asset('public/front/assets/front/js/plugins/nice-select.min.js')); ?>"></script>
    <!-- jquery UI JS -->
    <script src="<?php echo e(asset('public/front/assets/front/js/plugins/jqueryui.min.js')); ?>"></script>
    <!-- Image zoom JS -->
    <script src="<?php echo e(asset('public/front/assets/front/js/plugins/image-zoom.min.js')); ?>"></script>
    <!-- Imagesloaded JS -->
    <script src="<?php echo e(asset('public/front/assets/front/js/plugins/imagesloaded.pkgd.min.js')); ?>"></script>
    <!-- Instagram feed JS -->
    <script src="<?php echo e(asset('public/front/assets/front/js/plugins/instagramfeed.min.js')); ?>"></script>
    <!-- mailchimp active js -->
    <script src="<?php echo e(asset('public/front/assets/front/js/plugins/ajaxchimp.js')); ?>"></script>
    <!-- contact form dynamic js -->
    <script src="<?php echo e(asset('public/front/assets/front/js/plugins/ajax-mail.js')); ?>"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfmCVTjRI007pC1Yk2o2d_EhgkjTsFVN8"></script>
    <!-- google map active js -->
    <script src="<?php echo e(asset('public/front/assets/front/js/plugins/google-map.js')); ?>"></script>

    <!-- Main JS -->
    <script src="<?php echo e(asset('public/front/assets/front/js/main.js')); ?>" defer></script>


    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>
    <script type="module" src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine-ie11.min.js" defer></script>

    <script>
        function demo(value) {
            if (value) {
                pop_title = 'Item Successfully Added To Cart !',
                    pop_message = 'message',
                    pop_show_btns = true,
                    show_pop = true,
            } else {
                pop_title = 'Item removed from Cart !',
                    pop_message = 'message removed',
                    pop_show_btns = false,
                    show_pop = true,
            }
        }
    </script>


    <script type="text/javascript" defer>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                    pageLanguage: 'en'
                },
                'google_translate_element'
            );
        }
    </script>


    <script>
        $(window).on('load', function() {
            $('.preloader').fadeOut();
            // alert('done');
        });
    </script>

    <?php echo $__env->yieldContent('scripts'); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
    <?php echo \Livewire\Livewire::scripts(); ?>

</body>

</html>
<?php /**PATH E:\newxampp\htdocs\erp2\resources\views/layouts/front/app.blade.php ENDPATH**/ ?>