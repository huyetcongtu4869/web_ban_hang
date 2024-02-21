<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Fashi Template">
    <meta name="keywords" content="Fashi, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thực tập</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        .nav-item {
            background-color: blue;
        }

        .logo-carousel {
            margin: 0 auto;
        }
#p-footer{
    width: 200px;
    margin: 0 auto;
}
        .p-footer {
            text-align: center !important;
            color: white;
        }
    </style>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="header-top">
            <div class="container">
                <div class="ht-right">
                    <?php if (auth()->check()) : ?>
                        <a href="#" class="login-panel">
                            <i class="fa fa-user"></i> Hello, <?php echo auth()->user()->name; ?>
                        </a>
                        <a href="{{ route('logout') }}" class="login-panel">
                            <i class="fa fa-sign-out"></i> Logout
                        </a>
                    <?php else : ?>
                        <a href="<?php echo route('login'); ?>" class="login-panel">
                            <i class="fa fa-user"></i> Login
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="inner-header">
                <div class="row">
                    <div class="col-lg-2 col-md-2">
                        <div class="logo">
                            <a href="#">
                                <img src="{{ asset('assets/img/logo.png') }}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <div class="advanced-search">
                            <button type="button" class="category-btn">All Categories</button>
                            <form action="#" class="input-group">
                                <input type="text" placeholder="What do you need?">
                                <button type="button"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-3 text-right col-md-3">
                        <ul class="nav-right">
                            <li class="heart-icon"><a href="#">
                                    <i class="icon_heart_alt"></i>
                                    <span>1</span>
                                </a>
                            </li>
                            <li class="cart-icon"><a href="{{ route('route_cart') }}">
                                    <i class="icon_bag_alt"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav-item">
            <div class="container">
                <div class="nav-depart">
                    <div class="depart-btn">
                        <i class="ti-menu"></i>
                        <span>Danh mục</span>
                        <ul class="depart-hover">
                            <li class="active"><a href="/">Tất cả sản phẩm</a></li>
                            @foreach($category as $cate)
                            <li class="active"><a href="{{route('view',['slug'=>$cate->slug])}}">{{$cate->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <nav class="nav-menu mobile-menu">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="{{route('route_invoices')}}">Hóa đơn</a></li>
                        <li><a href="#">Collection</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Pages</a></li>
                    </ul>
                </nav>
                <div id="mobile-menu-wrap"></div>
            </div>
        </div>
    </header>
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="#"><i class="fa fa-home"></i> Home</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="product-shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 order-1 order-lg-2">
                    <div class="product-list">

                        @include('template.error')

                        @yield('content')

                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="partner-logo">
        <div class="container">
            <div class="logo-carousel owl-carousel">
                <div id="p-footer">
                    <p class="p-footer">huynmph26141@fpt.edu.vn</p>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{ asset('assets/js/quantity.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.j')}}"></script>
    <script src="{{ asset('assets/js/jquery.countdown.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.zoom.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.dd.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.slicknav.js')}}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('assets/js/main.js')}}"></script>
    <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
@yield('script')
</body>

</html>