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
@if(session()->has('message'))
<div class="alert alert-dark-success alert-dismissible fade show"  >
    <button type="button" class="close" data-dismiss="alert" >x</button>
    <strong> {{ session()->get('message')}}</strong>
</div>
@endif
@if(session()->has('error'))
  <div class="alert alert-dark-danger alert-dismissible fade show"  >
      <button type="button" class="close" data-dismiss="alert" >x</button>
      <strong> {{ session()->get('error')}}</strong>
  </div>
@endif
@if(session()->has('errors'))
<div class="alert alert-dark-danger alert-dismissible fade show"  >
    <button type="button" class="close" data-dismiss="alert" >x</button>
      <ul>
          @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary">
          
        </div>
    </div>
    <!-- [ Preloader ] End -->

    <!-- [ content ] Start -->
    <div class="authentication-wrapper authentication-1 px-4">
        <div class="container py-5">

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
            
      <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <h1 class="h4 text-gray-900 mb-4">Admin Général!</h1>
        </div>
        <div class="card-body">
          @if (isset($client))
          <form class="user"action="{{ route('gene_admin.register',$client->id) }}" method="POST"  enctype="multipart/form-data">
              @csrf
              <div class="form-row mb-3">
                <div class="form-group col-md-3" id="nbr_sacs">
                  <label for="">Name</label>{{-- {{ isset($origin_prod ) ? $origin_prod->date_recep : '' }} --}}
                  <input type="text" name="name" required class="form-control" value="{{ $client->name }}" id="" placeholder="Nom">
                </div>
                {{-- <div class="col-sm-3">
                    <label for="">Prénom</label>
                    <input type="text" name="first_name" value="{{ $client->first_name }}" required class="form-control " id="" placeholder="Prénom">
                </div> --}}
                <div class="form-group col-md-3" id="nbr_sacs">
                  <label for="">Email</label>
                  <input type="email" name="email" required class="form-control " value="{{ $client->email }}" id="exampleLastName"
                      placeholder=" Email">
                </div>
                <div class="col-sm-3">
                    <label for="">Password</label>
                    
                    <input type="password" required name="password" class="form-control " id="exampleInputPassword" placeholder="Password">
                </div>{{-- 
                <div class="col-sm-3">
                    <label for="">Téléphone</label>
                    <input type="tel" name="tel" required class="form-control" value="{{ $client->tel }}" id="tel"
                        placeholder="Téléphone">
                </div> --}}
            </div>
            </form>
          @else
            <form class="user"action="{{ route('gene_admin.register') }}" method="POST"  enctype="multipart/form-data">
                @csrf
                <div class="form-row mb-3">
                  <div class="form-group col-md-4" id="nbr_sacs">
                    <label for="">Username</label>{{-- {{ isset($origin_prod ) ? $origin_prod->date_recep : '' }} --}}
                    <input type="text" name="username" required class="form-control " id=""
                        placeholder="username">
                  </div>
                  <div class="form-group col-md-4" id="nbr_sacs">
                    <label for="">Name</label>{{-- {{ isset($origin_prod ) ? $origin_prod->date_recep : '' }} --}}
                    <input type="text" name="name" required class="form-control " id=""
                        placeholder="Nom">
                  </div>
                  {{-- <div class="col-sm-4">
                      <label for="">Prénom</label>
                      <input type="text" name="first_name" required class="form-control " id="" placeholder="Prénom">
                  </div> --}}
                  <div class="form-group col-md-4" id="nbr_sacs">
                    <label for="">Email</label>
                    <input type="email" name="email" required class="form-control " id="exampleLastName"
                        placeholder=" Email">
                  </div>
                  <div class="col-sm-4 mb-3 mb-sm-0">
                      <label for="">Password</label>
                      <input type="password" required name="password" class="form-control " id="exampleInputPassword" placeholder="Password">
                  </div>
                  <div class="col-sm-4">
                    
                    <label for="">Repeat Password</label>
                    <input type="password" class="form-control" name ="repeat_password"  id="exampleRepeatPassword" placeholder="Repeat Password">
                  </div>
                  <div class="form-group col-md-4">
                      <label for="">Avatar</label>
                      <input type="file" name="avatar" class="form-control">
                  </div>
                </div>
             
          
            @endif
            <!-- [ Form ] End -->
            
            <button class="btn btn-primary btn-user btn-block" type="submit">
              Enregistrer
            </button>
        </form>
          </div>
      </div>
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
