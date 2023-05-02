<!DOCTYPE html>

<html lang="en" class="material-style layout-fixed">

<head>
    <title>CashewPMS</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="Empire Bootstrap admin template made using Bootstrap 4, it has tons of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
    <meta name="keywords" content="Empire, bootstrap admin template, bootstrap admin panel, bootstrap 4 admin template, admin template">
    <meta name="author" content="Srthemesvilla" />
    <link rel="icon" type="image/x-icon"  href="{{ asset('assets/img/cashew.jpeg')}}">

    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

    <!-- Icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/ionicons.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/linearicons.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/open-iconic.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/pe-icon-7-stroke.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css')}}">

    <!-- Core stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-material.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/shreerang-material.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/uikit.css')}}">

    <!-- Libs -->
    <link rel="stylesheet" href="{{ asset('assets/libs/perfect-scrollbar/perfect-scrollbar.css')}}">
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/css/pages/authentication.css')}}">
</head>

<body>
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] End -->

    <!-- [ content ] Start -->
    <div class="authentication-wrapper authentication-1 px-4">
        <div class="authentication-inner py-5">

            <!-- [ Logo ] Start -->
            <div class="d-flex justify-content-center align-items-center">
                <div class="ui-w-60">
                    <div class="w-100 position-relative">
                        <!--img src="assets/img/logo-dark.png" alt="Brand Logo" class="img-fluid"-->
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- [ Logo ] End -->

            <!-- [ Form ] Start -->
            <form class="my-6" action="{{ route('auth.registration') }}" method="POST"  enctype="multipart/form-data">
                        @csrf
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control">
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Your name</label>
                    <input type="text" name="name" class="form-control">
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Your email</label>
                    <input type="text" name="email" class="form-control">
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control">
                    <div class="clearfix"></div>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-4">Sign Up</button>
                <div class="bg-lightest text-muted small p-2 mt-4">
                    By clicking "Sign Up", you agree to our
                    <a href="javascript:void(0)">terms of service and privacy policy</a>. We’ll occasionally send you account related emails.
                </div>
            </form>
            <!-- [ Form ] End -->

            <div class="text-center text-muted">
                Already have an account?
                <a href="{{ route('auth.login') }}">Sign In</a>
            </div>

        </div>
    </div>
    <!-- [ content ] End -->

    <!-- Core scripts -->
    <script src="{{ asset('assets/js/pace.js')}}"></script>
    <script src="{{ asset('assets/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{ asset('assets/libs/popper/popper.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap.js')}}"></script>
    <script src="{{ asset('assets/js/sidenav.js')}}"></script>
    <script src="{{ asset('assets/js/layout-helpers.js')}}"></script>
    <script src="{{ asset('assets/js/material-ripple.js')}}"></script>

    <!-- Libs -->
    <script src="{{ asset('assets/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

    <!-- Demo -->
    <script src="{{ asset('assets/js/demo.js"></script><script src="assets/js/analytics.js')}}"></script>
</body>

</html>
