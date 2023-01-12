@extends('layouts.base')

@section('content')
<div style="margin-left: 50px;">
<h4 class="font-weight-bold py-3 mb-0">Dashboard</h4>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Library</a></li>
                                <li class="breadcrumb-item active">Data</li>
                            </ol>
                        </div>

</div>

<div class="row">
                            <!-- 1st row Start -->
                        
        @if(Auth::user()->getRole->name === "Admin")
                        <div class="col-lg-10" style="margin-left: 50px;">
                            <div class="row">
                                <div class="col-md-6  myDiv " style="cursor: pointer;" onclick="location.href=`{{ route('ligne.index') }}`"  >
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <h2 class="mb-2"> Configuration </h2>
                                                    <p class="text-muted mb-0"><span class="badge badge-primary">Revenue</span> Today</p>
                                                </div>
                                                <div class="lnr feather icon-settings display-4 text-primary"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6  myDiv " style="cursor: pointer;" onclick="location.href=`{{ route('planning.index') }}`" >
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <h2 class="mb-2">Plannification</h2>
                                                    <p class="text-muted mb-0"><span class="badge badge-success">20%</span> Stock</p>
                                                </div>
                                                <div class="lnr lnr-hourglass display-4 text-success"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6  myDiv " style="cursor: pointer;" onclick="location.href=`{{ route('assiger.index') }}`" >
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <h2 class="mb-2"> Assignation <small></small></h2>
                                                    <p class="text-muted mb-0">New <span class="badge badge-danger">20%</span> Customer</p>
                                                </div>
                                                <div class="lnr feather icon-user-check display-4 text-danger"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6  myDiv " style="cursor: pointer;" onclick="location.href=`{{ route('operateur.list') }}`" >
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <h2 class="mb-2">Données</h2>
                                                    <p class="text-muted mb-0"><span class="badge badge-warning">$143.45</span> Profit</p>
                                                </div>
                                                <div class="lnr lnr-pie-chart display-4 text-warning"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6  myDiv " style="cursor: pointer;" onclick="location.href=`{{ route('poste.index') }}`" >
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <h2 class="mb-2">Poste</h2>
                                                    <p class="text-muted mb-0"><span class="badge badge-warning">$143.45</span> Profit</p>
                                                </div>
                                                <div class="lnr lnr-briefcase display-4 text-warning"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6  myDiv " style="cursor: pointer;" onclick="location.href=`{{ route('operateur.list') }}`" >
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <h2 class="mb-2">Opérateurs</h2>
                                                    <p class="text-muted mb-0"><span class="badge badge-warning">.</span> .</p>
                                                </div>
                                                <div class="lnr lnr-users display-4 text-warning"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6  myDiv" style=" cursor: pointer;" onclick="location.href=`{{ route('produit.index') }}`" >
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <h2 class="mb-2">Produits</h2>
                                                    <p class="text-muted mb-0"><span class="badge badge-warning">.</span> .</p>
                                                </div>
                                                <div class="lnr lnr-coffee-cup display-4 text-warning"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6  myDiv" style=" cursor: pointer;" onclick="location.href=`{{ route('commande.index') }}`" >
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <h2 class="mb-2">Commande</h2>
                                                    <p class="text-muted mb-0"><span class="badge badge-warning">.</span> .</p>
                                                </div>
                                                <div class="lnr lnr-cart display-4 text-warning"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    @endif
                        <!--div class="col-lg-5">
                            <div class="card mb-4">
                                <div class="card-header with-elements">
                                    <h6 class="card-header-title mb-0">Statistics</h6>
                                    <div class="card-header-elements ml-auto">
                                        <label class="text m-0">
                                            <span class="text-light text-tiny font-weight-semibold align-middle">SHOW STATS</span>
                                            <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2"><input type="checkbox" class="switcher-input" checked><span class="switcher-indicator"><span class="switcher-yes"></span><span
                                                        class="switcher-no"></span></span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="statistics-chart-1" style="height:300px"></div>
                                </div>
                            </div>
                        </div-->
                        <!-- 1st row Start -->
                    </div>

    <style>
        .myDiv{
            transition: all 0.5s ease;
        }
        .myDiv:hover{
            transform: scale(1.2);
            z-index: 1;
        }
    </style>

@endsection