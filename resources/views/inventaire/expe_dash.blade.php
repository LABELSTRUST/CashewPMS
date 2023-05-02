@extends('layouts.base')

@section('content')
<div style="margin-left: 50px;">
<h4 class="font-weight-bold py-3 mb-0">Réception</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href=""><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Library</a></li>
            <li class="breadcrumb-item active">Data</li>
        </ol>
    </div>
</div>

<div class="row">
                          
        @if(Auth::check() && Auth::user()->getRole?->name === "Magasinier")
            
                <div class="col-lg-10">
                    <div class="row">
                        <div class="col-md-6  myDiv " style="cursor: pointer;" onclick="location.href=`{{ route('inventaire.index') }}`"  >
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="">
                                            <h2 class="mb-2"> Stocks</h2>
                                            <!--p class="text-muted mb-0"><span class="badge badge-primary">Revenue</span> Today</p-->
                                        </div>
                                        <div class="lnr lnr-coffee-cup display-4 text-primary"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6  myDiv " style="cursor: pointer;" onclick="location.href=`{{ route('matiere.listeMatiere') }}`"  >
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="">
                                            <h2 class="mb-2"> Sorties </h2>
                                            <!--p class="text-muted mb-0"><span class="badge badge-primary">Revenue</span> Today</p-->
                                        </div>
                                        <div class="lnr lnr-coffee-cup display-4 text-primary"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--div class="col-md-6  myDiv " style="cursor: pointer;" onclick="location.href=`{{ route('ligne.index') }}`"  >
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="">
                                            <h2 class="mb-2"> Stock Final </h2>
                                        </div>
                                        <div class="lnr lnr-coffee-cup display-4 text-primary"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div-->
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