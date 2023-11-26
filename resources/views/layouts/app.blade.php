<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title') | Rental Sepeda Rysafi</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- favicon
        ============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href=" {{asset('img/favicon.ico')}}">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    
    <!-- Google Fonts
        ============================================ -->

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <!-- Bootstrap CSS
        ============================================ -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- font awesome CSS
        ============================================ -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <!-- meanmenu CSS
        ============================================ -->
    <link rel="stylesheet" href="{{asset('css/meanmenu/meanmenu.min.css')}}">
    <!-- owl.carousel CSS
        ============================================ -->
    <link rel="stylesheet" href=" {{asset('css/owl.carousel.css')}}">
    <link rel="stylesheet" href=" {{asset('css/owl.theme.css')}}">
    <link rel="stylesheet" href=" {{asset('css/owl.transitions.css')}}">
    <!-- animate CSS
        ============================================ -->
    <link rel="stylesheet" href=" {{asset('css/animate.css')}}">
    <!-- normalize CSS
        ============================================ -->
    <link rel="stylesheet" href=" {{asset('css/normalize.css')}}">
    <!-- dialog CSS
        ============================================ -->
    <link rel="stylesheet" href=" {{asset('css/dialog/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/dialog/dialog.css')}}">
    <!-- mCustomScrollbar CSS
        ============================================ -->
    <link rel="stylesheet" href=" {{asset('css/scrollbar/jquery.mCustomScrollbar.min.css')}}">
    <!-- wave CSS
        ============================================ -->
    <link rel="stylesheet" href=" {{asset('css/wave/waves.min.css')}}">
    <!-- Notika icon CSS
        ============================================ -->
    <link rel="stylesheet" href=" {{asset('css/notika-custom-icon.css')}}">
    <link rel="stylesheet" href=" {{asset('css/wave/button.css')}}">
    <!-- main CSS
        ============================================ -->
    <link rel="stylesheet" href=" {{asset('css/main.css')}}">
    <!-- style CSS
        ============================================ -->
    <link rel="stylesheet" href=" {{asset('style.css')}}">
    <!-- bootstrap select CSS
        ============================================ -->
    <link rel="stylesheet" href=" {{asset('css/bootstrap-select/bootstrap-select.css')}}">
    <!-- Data Table JS
        ============================================ -->
    <link rel="stylesheet" href=" {{asset('css/jquery.dataTables.min.css')}}">
    <!-- responsive CSS
        ============================================ -->
    <link rel="stylesheet" href=" {{asset('css/responsive.css')}}">
    <!-- datapicker CSS
        ============================================ -->
    <link rel="stylesheet" href=" {{asset('css/datapicker/datepicker3.css')}}">

    <link rel="stylesheet" href=" {{asset('css/notify/notify.css')}}">
    <!-- modernizr JS
        ============================================ -->
    <script src=" {{asset('js/vendor/modernizr-2.8.3.min.js')}}"></script>

    @notifyCss

    @stack('style')
</head>

<body>

    <!-- Start Header Top Area -->
    <div class="header-top-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="logo-area">
                        <a href="#"><img src=" {{asset('img/logo/logo.png')}}" alt="" /></a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="header-top-menu">
                        <ul class="nav navbar-nav notika-top-nav">
                            <li class="nav-item dropdown">
                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><span><i class="notika-icon notika-menu"></i></span></a>

                                <div role="menu" class="dropdown-menu message-dd task-dd animated fadeIn">

                                    <div class="hd-message-info">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img chat-img">

                                                @if(isset(Auth::user()->pfp))
                                                    <img src="{{ asset(Auth::user()->pfp) }}" alt="" style="width: 50px; height: 50px" />
                                                @else
                                                    <img src="{{ asset('uploads/pfp/default_pfp.png') }}" alt="" style="width: 50px; height: 50px" />
                                                @endif

                                                </div>
                                                <div class="hd-mg-ctn">
                                                    <h3>{{Auth::user()->name}}</h3>
                                                    <p>{{Auth::user()->level->name}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="hd-mg-tt">
                                        <h2>Notification</h2>
                                    </div> -->
                                    <hr>
                                    <div class="hd-mg-va">
                                        <a href="{{url('/profile')}}">Profil</a>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Top Area -->
    <!-- Main Menu area start-->
    <div class="main-menu-area mg-tb-40">
        <div class="container">
            <div class="row">

                @if(Auth::user()->level_id != '3')
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro">
                        <li class="{{ (request()->is('home*')) ? 'active' : '' }}"><a  href="/"><i class="notika-icon notika-house"></i> Home</a>
                        </li>
                        <li class="{{ (request()->is('user*')) ? 'active' : '' }}"><a data-toggle="tab" href="#mailbox"><i class="notika-icon notika-mail"></i> User</a>
                        </li>
                        <li class="{{ (request()->is('sepeda*')) ? 'active' : '' }}"><a data-toggle="tab" href="#Interface"><i class="notika-icon notika-edit"></i> Sepeda</a>
                        </li>
                        <li class="{{ (request()->is('transaksi*')) ? 'active' : '' }}"><a data-toggle="tab" href="#Charts"><i class="notika-icon notika-bar-chart"></i> Transaksi</a>
                        </li>
                    </ul>
                    <div class="tab-content custom-menu-content">
                        <div id="mailbox" class="tab-pane notika-tab-menu-bg animated flipInX
                        {{ (request()->is('user*')) ? 'active' : '' }}">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{route('users.index')}}">Owner</a>
                                </li>
                                <li><a href="{{route('admins.index')}}">Admin</a>
                                </li>
                                <li><a href="{{route('members.index')}}">Member</a>
                                </li>
                            </ul>
                        </div>
                        <div id="Interface" class="tab-pane notika-tab-menu-bg animated flipInX
                        {{ (request()->is('sepeda*')) ? 'active' : '' }}">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{route('products.index')}}">Data Sepeda</a>
                                </li>
                                <li><a href="{{route('mereks.index')}}">Data Merk</a>
                                </li>
                                <li><a href="{{route('kategori.index')}}">Data Kategori</a>
                                </li>
                                <li><a href="{{route('product.restore_sepeda')}}">Sepeda Rusak</a>
                                </li>
                                <li><a href="{{route('product.hilang')}}">Sepeda Hilang</a>
                                </li>
                            </ul>
                        </div>
                        <div id="Charts" class="tab-pane notika-tab-menu-bg animated flipInX
                        {{ (request()->is('transaksi*')) ? 'active' : '' }}">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{url('/transaksi/onprocess')}}">Transaksi Berjalan</a>
                                </li>
                                <li><a href="{{url('/transaksi/history')}}">Riwayat Transaksi</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @else
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro">
                        <li class="{{ (request()->is('home*')) ? 'active' : '' }}"><a  href="/"><i class="notika-icon notika-house"></i> Home</a>
                        </li>
                        <li class="{{ (request()->is('transcation*')) ? 'active' : '' }}"><a  href="{{url('transcation')}}"><i class="notika-icon notika-windows"></i> Order</a>
                        </li>
                        <li class="{{ (request()->is('transaksi*')) ? 'active' : '' }}"><a data-toggle="tab" href="#Charts"><i class="notika-icon notika-bar-chart"></i> Transaksi</a>
                        </li>
                    </ul>
                    <div class="tab-content custom-menu-content">
                        <div id="Charts" class="tab-pane notika-tab-menu-bg animated flipInX
                        {{ (request()->is('transaksi*')) ? 'active' : '' }}">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{url('/transaksi/onprocess')}}">Transaksi Berjalan</a>
                                </li>
                                <li><a href="{{url('/transaksi/history')}}">Riwayat Transaksi</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
    <!-- Main Menu area End-->

        @yield('content')

    <!-- Start Footer area-->
    <div class="footer-copyright-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="footer-copy-right">
                        <p>Copyright © 2018 
                        Rysafi Rental Sepeda. Template by <a href="https://colorlib.com">Colorlib</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jquery
        ============================================ -->
    <script src=" {{asset('js/vendor/jquery-1.12.4.min.js')}}"></script>
    <!-- bootstrap JS
        ============================================ -->
    <script src=" {{asset('js/bootstrap.min.js')}}"></script>
    <!-- wow JS
        ============================================ -->
    <script src=" {{asset('js/wow.min.js')}}"></script>
    <!-- price-slider JS
        ============================================ -->
    <script src=" {{asset('js/jquery-price-slider.js')}}"></script>
    <!-- owl.carousel JS
        ============================================ -->
    <script src=" {{asset('js/owl.carousel.min.js')}}"></script>
    <!-- scrollUp JS
        ============================================ -->
    <script src=" {{asset('js/jquery.scrollUp.min.js')}}"></script>
    <!-- meanmenu JS
        ============================================ -->
    <script src=" {{asset('js/meanmenu/jquery.meanmenu.js')}}"></script>
    <!-- counterup JS
        ============================================ -->
    <script src=" {{asset('js/counterup/jquery.counterup.min.js')}}"></script>
    <script src=" {{asset('js/counterup/waypoints.min.js')}}"></script>
    <script src=" {{asset('js/counterup/counterup-active.js')}}"></script>
    <!-- mCustomScrollbar JS
        ============================================ -->
    <script src=" {{asset('js/scrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <!-- sparkline JS
        ============================================ -->
    <script src=" {{asset('js/sparkline/jquery.sparkline.min.js')}}"></script>
    <script src=" {{asset('js/sparkline/sparkline-active.js')}}"></script>
    <!-- flot JS
        ============================================ -->
    <script src=" {{asset('js/flot/jquery.flot.js')}}"></script>
    <script src=" {{asset('js/flot/jquery.flot.resize.js')}}"></script>
    <script src=" {{asset('js/flot/flot-active.js')}}"></script>
    <script src=" {{asset('js/notify/notify.js')}}"></script>
    <!-- knob JS
        ============================================ -->
    <script src=" {{asset('js/knob/jquery.knob.js')}}"></script>
    <script src=" {{asset('js/knob/jquery.appear.js')}}"></script>
    <script src=" {{asset('js/knob/knob-active.js')}}"></script>
    <!--  Chat JS
        ============================================ -->
    <script src=" {{asset('js/chat/jquery.chat.js')}}"></script>
    <!--  wave JS
        ============================================ -->
    <script src=" {{asset('js/wave/waves.min.js')}}"></script>
    <script src=" {{asset('js/wave/wave-active.js')}}"></script>
    <!-- icheck JS
        ============================================ -->
    <script src=" {{asset('js/icheck/icheck.min.js')}}"></script>
    <script src=" {{asset('js/icheck/icheck-active.js')}}"></script>
    <!--  todo JS
        ============================================ -->
    <script src=" {{asset('js/todo/jquery.todo.js')}}"></script>
    <!-- bootstrap select JS
        ============================================ -->
    <script src=" {{asset('js/bootstrap-select/bootstrap-select.js')}}"></script>
    <!-- Login JS
        ============================================ -->
    <script src=" {{asset('js/login/login-action.js')}}"></script>
    <!-- plugins JS
        ============================================ -->
    <script src=" {{asset('js/plugins.js')}}"></script>

    <script src=" {{asset('js/dialog/sweetalert2.min.js')}}"></script>
    <script src=" {{asset('js/dialog/dialog-active.js')}}"></script>
    <!-- main JS
        ============================================ -->
    <script src=" {{asset('js/main.js')}}"></script>
    <!-- datapicker JS
        ============================================ -->
    <script src=" {{asset('js/datapicker/bootstrap-datepicker.js')}}"></script>
    <script src=" {{asset('js/datapicker/datepicker-active.js')}}"></script>
    <!-- Data Table JS
        ============================================ -->
    <script src=" {{asset('js/data-table/jquery.dataTables.min.js')}}"></script>
    <script src=" {{asset('js/data-table/data-table-act.js')}}"></script>
</body>

    @stack('script')
</html>

