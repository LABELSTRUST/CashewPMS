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
    
    <link href="{{ asset('assets/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

    <!-- Core stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-material.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/shreerang-material.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/uikit.css')}}">

    <!-- Libs -->
    <link rel="stylesheet" href="{{ asset('assets/libs/perfect-scrollbar/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/libs/flot/flot.css')}}">
    
    <link rel="stylesheet" href="{{ asset('assets/css/pmanager.css')}}">
    
<style>
    .scroll::-webkit-scrollbar{
        width: 5px;
        background-color: gray;
        height:5px;
    
    }
    .scroll::-webkit-scrollbar-thumb{
        background: black;
        height:3px;
    }
    </style>

</head>

<body style="background-color: #ffebad !important;">
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] End -->

    <!-- [ Layout wrapper ] Start -->
    <div class="layout-wrapper layout-2">
        <div class="layout-inner">
            <!-- [ Layout sidenav ] Start -->
            <div id="layout-sidenav" class="layout-sidenav sidenav sidenav-vertical bg-white logo-dark">
                <!-- Brand demo (see assets/css/demo/demo.css) -->
                <div class="app-brand demo " >
                    <span class="app-brand-logo demo">
                        <img src="{{ asset('assets/img/logo_label.png')}}" alt="Brand Logo" style="height:35px;">
                        <!--img src="{{ asset('assets/img/logo.png')}}" alt="Brand Logo" class="img-fluid"-->
                    </span>
                    <a href="{{ route('dashboard') }}" class="app-brand-text demo sidenav-text font-weight-normal ml-2">CashewPMS</a>
                    <a href="javascript:" class="layout-sidenav-toggle sidenav-link text-large ml-auto">
                        <i class="ion ion-md-menu align-middle"></i>
                    </a>
                </div>
                <div class="sidenav-divider mt-0"></div>

                <!-- Links -->
                <ul class="sidenav-inner py-1">

                    <!-- Dashboards -->
                    <li class="sidenav-item active">
                        <a href="{{ route('dashboard') }}" class="sidenav-link">
                            <i class="sidenav-icon feather icon-home"></i>
                            <div>Tableau de Bord</div>
                            <div class="pl-1 ml-auto">
                                <div class="badge badge-danger">Hot</div>
                            </div>
                        </a>
                    </li>

                    <!-- Layouts -->
       
                    
                @if(Auth::check() && Auth::user()->getRole?->name === "Admin")
                    <li class="sidenav-divider mb-1"></li>
                    <!--li class="sidenav-header small font-weight-semibold">Configuration</li-->
                    <!--li class="sidenav-item">
                        <a href="" class="sidenav-link">
                            <i class="sidenav-icon feather icon-type"></i>
                            <div>Shift</div>
                        </a>
                    </li-->

                    <!-- UI elements -->
                    <li class="sidenav-item">
                        <a href="" class="sidenav-link sidenav-toggle">
                            <i class="sidenav-icon feather icon-settings"></i>
                            <div>Configuration</div>
                        </a>
                        <ul class="sidenav-menu">
                            <li class="sidenav-item">
                                <a href="{{ route('ligne.index') }}" class="sidenav-link">
                                    <div>Lignes</div>
                                </a>
                            </li>
                            <li class="sidenav-item">
                                <a href="{{ route('shift.index') }}" class="sidenav-link">
                                    <div>Shifts</div>
                                </a>
                            </li>
                            <li class="sidenav-item">
                                <a href="{{ route('produit.index') }}" class="sidenav-link">
                                    <div>Produits</div>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <!-- Forms & Tables -->
                    <li class="sidenav-divider mb-1"></li>
                    <!--li class="sidenav-header small font-weight-semibold">Planning</li-->
                    <li class="sidenav-item">
                        <a href="javascript:" class="sidenav-link sidenav-toggle">
                            {{-- <i class="sidenav-icon lnr lnr-hourglass"></i> --}} 
                            <div style="margin-right: 0.80rem;">
                                <img   style="width: 18px;" class="" src="{{ asset('assets/flaticon/plan.png')}}" alt="">
                            </div>
                            <div>Planning</div>
                        </a>
                        <ul class="sidenav-menu">
                            <li class="sidenav-item">
                                <a href="{{ route('objectif.index') }}" class="sidenav-link">
                                    <div>Objectifs</div>
                                </a>
                            </li>
                            <li class="sidenav-item">
                                <a href="{{ route('planning.index') }}" class="sidenav-link">
                                    <div>Planifications</div>
                                </a>
                            </li>
                            
                            <li class="sidenav-item">
                                <a href="{{ route('sequence.index') }}" class="sidenav-link">
                                    <div>Séquences</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!--li class="sidenav-item">
                        <a href="tables_bootstrap.html" class="sidenav-link">
                            <i class="sidenav-icon feather icon-grid"></i>
                            <div></div>
                        </a>
                    </li-->

                    <li class="sidenav-divider mb-1"></li>
                    <!--li class="sidenav-header small font-weight-semibold">Collaborateurs</li-->
                    <li class="sidenav-item">
                        <a href="javascript:" class="sidenav-link sidenav-toggle">
                            <i class="sidenav-icon lnr lnr-users"></i>
                            <div>Collaborateurs</div>
                        </a>
                        <ul class="sidenav-menu">
                            <li class="sidenav-item">
                                <a href="{{ route('poste.index') }}" class="sidenav-link">
                                    <div>Postes</div>
                                </a>
                            </li>
                            <li class="sidenav-item">
                                <a href="{{ route('operateur.list') }}" class="sidenav-link">
                                    <div>Opérateurs</div>
                                </a>
                            </li>
                            <li class="sidenav-item">
                                <a href="{{ route('assigner.index') }}" class="sidenav-link">
                                    <div>Assignations</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidenav-divider mb-1"></li>
                    <!--li class="sidenav-header small font-weight-semibold">Données</li-->
                    <li class="sidenav-item">
                        <a href="javascript:" class="sidenav-link sidenav-toggle">
                            <i class="sidenav-icon lnr lnr-pie-chart"></i>
                            <div>Données</div>
                        </a>
                        <ul class="sidenav-menu">
                            <li class="sidenav-item">
                                <a href="#" class="sidenav-link">
                                    <div>Stocks</div>
                                </a>
                            </li>
                            <li class="sidenav-item">
                                <a href="#" class="sidenav-link">
                                    <div>Productions</div>
                                </a>
                            </li>
                            <li class="sidenav-item">
                                <a href="#" class="sidenav-link">
                                    <div>Statistiques</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!--  Icons -->

                    

                    <!-- Pages -->
                    <li class="sidenav-divider mb-1"></li>
                    <li class="sidenav-header small font-weight-semibold"></li>
                    <!--li class="sidenav-item">
                        <a href="{{ route('operateur.list') }}" class="sidenav-link">
                            <i class="sidenav-icon lnr lnr-users"></i>
                            <div>Liste</div>
                        </a>
                    </li>
                    <li class="sidenav-item">
                        <a href="{{ route('create.operator') }}" class="sidenav-link">
                            <i class="sidenav-icon feather icon-user"></i>
                            <div>Créer</div>
                        </a>
                    </li-->
                    {{-- <li class="sidenav-item">
                        <a href="#" class="sidenav-link">
                            <i class="sidenav-icon feather icon-anchor"></i>
                            <div>FAQ</div>
                        </a>
                    </li>  --}}
                    
                @elseif(Auth::check() && Auth::user()->getRole?->name === "Magasinier")
                    
                    <li class="sidenav-divider mb-1"></li>
                        <!--li class="sidenav-header small font-weight-semibold">Planning</li-->
                        <li class="sidenav-item">
                            <a href="javascript:" class="sidenav-link sidenav-toggle">
                            <div style="margin-right: 0.80rem;">
                                <img style="width: 20px;"  src="{{ asset('assets/inventaire/reception.png')}}" alt="">
                            </div>
                                <div>Réception</div>
                            </a>
                            <ul class="sidenav-menu">
                                <li class="sidenav-item">
                                    <a href="{{ route('matiere.listeMatiere') }}" class="sidenav-link">
                                        <div>Entrée</div>
                                    </a>
                                </li>
                                <li class="sidenav-item">
                                    <a href="{{ route('inventaire.index') }}" class="sidenav-link">
                                        <div>Stock </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <li class="sidenav-divider mb-1"></li>
                        <!--li class="sidenav-header small font-weight-semibold">Planning</li-->
                        <li class="sidenav-item">
                            <a href="javascript:" class="sidenav-link sidenav-toggle">
                                <div style="margin-right: 0.80rem;">
                                    <img style="width: 25px;"  src="{{ asset('assets/inventaire/expedition.png')}}" alt="">
                                </div>
                                <div>Expédition</div>
                            </a>
                            <ul class="sidenav-menu">
                                <li class="sidenav-item">
                                    <a href="{{ route('commande.index') }}" class="sidenav-link">
                                        <div>Stock</div>
                                    </a>
                                </li>
                                
                                <li class="sidenav-item">
                                    <a href="{{ route('sequence.index') }}" class="sidenav-link">
                                        <div>Sortie</div>
                                    </a>
                                </li>
                            </ul>
                    </li>
                    
                    {{-- <li class="sidenav-divider mb-1"></li>
                    <li class="sidenav-item">
                        <a href="{{ route('produit_fini_index') }}" class="sidenav-link">
                            <div style="margin-right: 0.80rem;">
                                <img style="width: 25px;"  src="{{ asset('assets/flaticon/product.png')}}" alt="">
                            </div>
                            <div>Produits finis</div>
                        </a>
                    </li>  --}}
                @elseif(Auth::check() && Auth::user()->getRole?->name === "Operateur")
                    
                {{-- <li class="sidenav-divider mb-1"></li>
                        <!--li class="sidenav-header small font-weight-semibold">Planning</li-->
                        <li class="sidenav-item">
                            <a href="javascript:" class="sidenav-link sidenav-toggle">
                                <i class="sidenav-icon feather icon-settings"></i>
                                <div>Configuration</div>
                            </a>
                            <ul class="sidenav-menu">
                                <li class="sidenav-item">
                                    <a href="{{ route('calibrage.listetype') }}" class="sidenav-link">
                                        <div>Calibre</div>
                                    </a>
                                </li>
                            </ul>
                    </li> --}}
                    {{-- <li class="sidenav-divider mb-1"></li>
                        <!--li class="sidenav-header small font-weight-semibold">Planning</li-->
                        
                    <li class="sidenav-item">
                        <a href="#" class="sidenav-link">
                            <i class="sidenav-icon lnr lnr-database"></i>
                            <div>Stocks</div>
                        </a>
                    </li>
                <li class="sidenav-divider mb-1"></li>
                    <li class="sidenav-item">
                        <a href="#" class="sidenav-link">
                            <div style="margin-right: 0.80rem;">
                                <img style="width: 18px;"  src="{{ asset('assets/production/rapport.png')}}" alt="">
                            </div>
                            <div>Rapports</div>
                        </a>
                    </li>  --}}
                @endif
                </ul>
            </div>

       
            <!-- [ Layout sidenav ] End -->





            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <!-- [ Layout navbar ( Header ) ] Start -->
                <nav  class="fixed-top layout-navbar navbar navbar-expand-lg align-items-lg-center  bg-dark container-p-x  "  id="layout-navbar">

                    <!-- Brand demo (see assets/css/demo/demo.css) -->
                    <a href="{{ route('dashboard') }}" class="navbar-brand app-brand demo d-lg-none py-0 mr-4">
                        <span class="app-brand-logo demo">
                        <img src="{{ asset('assets/img/cashew.jpeg')}}" alt="Brand Logo" style="height:35px; filter: brightness(1);" >
                        </span>
                        <span class="app-brand-text demo font-weight-normal ml-2">CashewPMS</span>
                    </a>
                    <!-- Sidenav toggle (see assets/css/demo/demo.css) -->
                    <div class="layout-sidenav-toggle navbar-nav d-lg-none align-items-lg-center mr-auto">
                        <a class="nav-item nav-link px-0 mr-lg-4" href="javascript:">
                            <i class="ion ion-md-menu text-large align-middle"></i>
                        </a>
                    </div>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#layout-navbar-collapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="navbar-collapse collapse" id="layout-navbar-collapse">
                        <!-- Divider -->
                        <hr class="d-lg-none w-100 my-2">

                        <div class="navbar-nav align-items-lg-center">
                            <!-- Search -->
                            <label class="nav-item navbar-text navbar-search-box p-0 active">
                                <i class="feather icon-search navbar-icon align-middle"></i>
                                <span class="navbar-search-input pl-2">
                                    <input type="text" class="form-control navbar-text mx-2" placeholder="Search...">
                                </span>
                            </label>
                        </div>

                        <div class="navbar-nav align-items-lg-center ml-auto">
                            <div class="demo-navbar-notifications nav-item dropdown mr-lg-3">
                                <a class="nav-link dropdown-toggle hide-arrow" href="#" data-toggle="dropdown">
                                    <i class="feather icon-bell navbar-icon align-middle"></i>
                                    <span class="badge badge-danger badge-dot indicator"></span>
                                    <span class="d-lg-none align-middle">&nbsp; Notifications</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="bg-primary text-center text-white font-weight-bold p-3">
                                        4 New Notifications
                                    </div>
                                    <div class="list-group list-group-flush">
                                        <a href="javascript:" class="list-group-item list-group-item-action media d-flex align-items-center">
                                            <div class="ui-icon ui-icon-sm feather icon-home bg-secondary border-0 text-white"></div>
                                            <div class="media-body line-height-condenced ml-3">
                                                <div class="text-dark">Login from 192.168.1.1</div>
                                                <div class="text-light small mt-1">
                                                    Aliquam ex eros, imperdiet vulputate hendrerit et.
                                                </div>
                                                <div class="text-light small mt-1">12h ago</div>
                                            </div>
                                        </a>

                                        <a href="javascript:" class="list-group-item list-group-item-action media d-flex align-items-center">
                                            <div class="ui-icon ui-icon-sm feather icon-user-plus bg-info border-0 text-white"></div>
                                            <div class="media-body line-height-condenced ml-3">
                                                <div class="text-dark">You have
                                                    <strong>4</strong> new followers</div>
                                                <div class="text-light small mt-1">
                                                    Phasellus nunc nisl, posuere cursus pretium nec, dictum vehicula tellus.
                                                </div>
                                            </div>
                                        </a>

                                        <a href="javascript:" class="list-group-item list-group-item-action media d-flex align-items-center">
                                            <div class="ui-icon ui-icon-sm feather icon-power bg-danger border-0 text-white"></div>
                                            <div class="media-body line-height-condenced ml-3">
                                                <div class="text-dark">Server restarted</div>
                                                <div class="text-light small mt-1">
                                                    19h ago
                                                </div>
                                            </div>
                                        </a>

                                        <a href="javascript:" class="list-group-item list-group-item-action media d-flex align-items-center">
                                            <div class="ui-icon ui-icon-sm feather icon-alert-triangle bg-warning border-0 text-dark"></div>
                                            <div class="media-body line-height-condenced ml-3">
                                                <div class="text-dark">99% server load</div>
                                                <div class="text-light small mt-1">
                                                    Etiam nec fringilla magna. Donec mi metus.
                                                </div>
                                                <div class="text-light small mt-1">
                                                    20h ago
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <a href="javascript:" class="d-block text-center text-light small p-2 my-1">Show all notifications</a>
                                </div>
                            </div>

                            <div class="demo-navbar-messages nav-item dropdown mr-lg-3">
                                <a class="nav-link dropdown-toggle hide-arrow" href="#" data-toggle="dropdown">
                                    <i class="feather icon-mail navbar-icon align-middle"></i>
                                    <span class="badge badge-success badge-dot indicator"></span>
                                    <span class="d-lg-none align-middle">&nbsp; Messages</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="bg-primary text-center text-white font-weight-bold p-3">
                                        4 New Messages
                                    </div>
                                    <div class="list-group list-group-flush">
                                        <a href="javascript:" class="list-group-item list-group-item-action media d-flex align-items-center">
                                            <img src="{{ asset('assets/img/avatars/6-small.png')}}" class="d-block ui-w-40 rounded-circle" alt>
                                            <div class="media-body ml-3">
                                                <div class="text-dark line-height-condenced">Lorem ipsum dolor consectetuer elit.</div>
                                                <div class="text-light small mt-1">
                                                    Josephin Doe &nbsp;·&nbsp; 58m ago
                                                </div>
                                            </div>
                                        </a>

                                        <a href="javascript:" class="list-group-item list-group-item-action media d-flex align-items-center">
                                            <img src="{{ asset('assets/img/avatars/4-small.png')}}" class="d-block ui-w-40 rounded-circle" alt>
                                            <div class="media-body ml-3">
                                                <div class="text-dark line-height-condenced">Lorem ipsum dolor sit amet, consectetuer.</div>
                                                <div class="text-light small mt-1">
                                                    Lary Doe &nbsp;·&nbsp; 1h ago
                                                </div>
                                            </div>
                                        </a>

                                        <a href="javascript:" class="list-group-item list-group-item-action media d-flex align-items-center">
                                            <img src="{{ asset('assets/img/avatars/5-small.png')}}" class="d-block ui-w-40 rounded-circle" alt>
                                            <div class="media-body ml-3">
                                                <div class="text-dark line-height-condenced">Lorem ipsum dolor sit amet elit.</div>
                                                <div class="text-light small mt-1">
                                                    Alice &nbsp;·&nbsp; 2h ago
                                                </div>
                                            </div>
                                        </a>

                                        <a href="javascript:" class="list-group-item list-group-item-action media d-flex align-items-center">
                                            <img src="{{ asset('assets/img/avatars/11-small.png')}}" class="d-block ui-w-40 rounded-circle" alt>
                                            <div class="media-body ml-3">
                                                <div class="text-dark line-height-condenced">Lorem ipsum dolor sit amet consectetuer amet elit dolor sit.</div>
                                                <div class="text-light small mt-1">
                                                    Suzen &nbsp;·&nbsp; 5h ago
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <a href="javascript:" class="d-block text-center text-light small p-2 my-1">Show all messages</a>
                                </div>
                            </div>

                            <!-- Divider -->
                            <div class="nav-item d-none d-lg-block text-big font-weight-light line-height-1 opacity-25 mr-3 ml-1">|</div>
                            <div class="demo-navbar-user nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                    <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                                        <img src="{{ asset('assets/img/avatars/1.png')}}" alt class="d-block ui-w-30 rounded-circle">
                                        <span class="px-1 mr-lg-2 ml-2 ml-lg-0">Cindy Deitch</span>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:" class="dropdown-item">
                                        <i class="feather icon-user text-muted"></i> &nbsp; My profile</a>
                                    <a href="javascript:" class="dropdown-item">
                                        <i class="feather icon-mail text-muted"></i> &nbsp; Messages</a>
                                    <a href="javascript:" class="dropdown-item">
                                        <i class="feather icon-settings text-muted"></i> &nbsp; Account settings</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('signout') }}" class="dropdown-item">
                                        <i class="feather icon-power text-danger"></i> &nbsp; Se déconnecter</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
                <!-- [ Layout navbar ( Header ) ] End -->

                <!-- [ Layout content ] Start -->
                <div class="layout-content" style="margin-left: 1px;">

                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        
                            <div class="layout-content">

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
<!-- [ content ] Start -->
<div class="container-fluid flex-grow-1 container-p-y">

    <h4 class="font-weight-bold py-3 mb-0">Liste des Séquences</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Séquence</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
    <div class="row">
        <div class="row" >
            {{-- <div class="col-lg-6 col-md-6 col-sm-6 " >
                <a href="{{ route('assigner.index') }}" class="btn btn-lg btn-outline-info">Assignation</a>
            </div> --}}
        </div>

                    <div class="container-fluid flex-grow-1  shadow mb-4 pmanager d-flex justify-content-center">
                        @if (isset($sequences) && $sequences->getSequence->code)
                        <div class="card text-white bg-success  mb-3 mt-3 " style="max-width: 18rem;  ">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <div class="mr-1">
                                        Séquence : {{str_pad($sequences->getSequence?->code, 2, '0', STR_PAD_LEFT)}}
                                    </div>
                                    <div class="ml-2"> Date : {{ \Carbon\Carbon::parse($sequences->created_at)->format('d/m/Y') }} </div>

                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Id Target : {{ $sequences->getSequence?->getObjectif?->id_target }}</h5>
                                <h5 class="card-title">Shift : {{ $sequences->getSequence?->getShift?->title }}</h5>
                                <h5 class="card-title">Produit : {{ $sequences->getSequence?->getObjectif?->getProduit?->name }}</h5>
                            <p class="card-text"> 
                                <a class="btn btn-outline-info text-white " href="{{ route('sequence.OperateurConnecter',[$sequences->getSequence->id]) }} ">Connecter</a></p>
                            </div>
                        </div>
                            
                        @else
                        <div class="card text-white bg-success  mb-3 mt-3 " style="max-width: 18rem;  ">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <div class="mr-1">
                                        Séquence : 
                                    </div>
                                    <div class="ml-2"> Date : {{ \Carbon\Carbon::today()->format('d/m/Y') }} </div>

                                </div>
                            </div>
                            <div class="card-body">
                            <p class="card-text"> 
                                
                            <h1>Vous n'avez pas de séquence aujourd'hui</h1>
                            </div>
                        </div>
                        @endif
                    </div>
                
         </div>
</div>
<!-- [ Layout footer ] End -->

</div>
                        
                    </div>
                    <!-- [ content ] End -->

                    <!-- [ Layout footer ] Start -->
                    <nav class="layout-footer footer bg-white">
                        <div class="container-fluid d-flex flex-wrap justify-content-between text-center container-p-x pb-3">
                            <div class="pt-3">
                                <span class="footer-text font-weight-semibold">&copy; <a href="#" class="footer-link" target="_blank">LABELS TRUST</a></span>
                            </div>
                            <div>
                                <!--a href="javascript:" class="footer-link pt-3">About Us</a>
                                <a href="javascript:" class="footer-link pt-3 ml-4">Help</a>
                                <a href="javascript:" class="footer-link pt-3 ml-4">Contact</a>
                                <a href="javascript:" class="footer-link pt-3 ml-4">Terms &amp; Conditions</a-->
                            </div>
                        </div>
                    </nav>
                    <!-- [ Layout footer ] End -->
                </div>
                <!-- [ Layout content ] Start -->
            </div>
            <!-- [ Layout container ] End -->
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-sidenav-toggle"></div>
    </div>
    <!-- [ Layout wrapper] End -->

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
    <script src="{{ asset('assets/libs/eve/eve.js')}}"></script>
    <script src="{{ asset('assets/libs/flot/flot.js')}}"></script>
    <script src="{{ asset('assets/libs/flot/curvedLines.js')}}"></script>
    <script src="{{ asset('assets/libs/chart-am4/core.js')}}"></script>
    <script src="{{ asset('assets/libs/chart-am4/charts.js')}}"></script>
    <script src="{{ asset('assets/libs/chart-am4/animated.js')}}"></script>

    <!-- Demo -->
    <script src="{{ asset('assets/js/demo.js')}}"></script><script src="{{ asset('assets/js/analytics.js')}}"></script>
    <script src="{{ asset('assets/js/pages/dashboards_index.js')}}"></script>
    

        <!-- Page level custom scripts -->
    <script src="{{ asset('asset/js/demo/datatables-demo.js')}}"></script>
    

        <!-- Page level custom scripts -->
    @yield('javascript')
</body>

</html>
