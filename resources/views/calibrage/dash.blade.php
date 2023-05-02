@extends('layouts.base')

@section('content')
<div style="margin-left: 50px;">
<h4 class="font-weight-bold py-3 mb-0">Calibrage</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href=""><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Library</a></li>
            <li class="breadcrumb-item active">Data</li>
        </ol>
    </div>
</div>

<div  style="margin-left: 50px;" class="row">
                          
        @if(Auth::check() && Auth::user()->getRole?->name === "Operateur")
            <div class="col-xl-10">
                <div class="row">
                    <div class="col-md-6  myDiv " style="cursor: pointer;" onclick="location.href=`{{ route('calibrage.listetype') }}`"  >
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="">
                                        <h2 class="mb-2"> Configuration</h2>
                                        <!--p class="text-muted mb-0"><span class="badge badge-primary">Revenue</span> Today</p-->
                                    </div>
                                    <div class="lnr lnr-coffee-cup display-4 text-primary"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6  myDiv " style="cursor: pointer;" onclick="location.href=`{{ route('stock_dispo_op') }}`"  >
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
                    <!--div class="col-md-6  myDiv " style="cursor: pointer;" onclick="location.href=`{{ route('ligne.index') }}`"  >
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="">
                                        <h2 class="mb-2"> Sorties </h2>
                                        <p class="text-muted mb-0"><span class="badge badge-primary">Revenue</span> Today</p>
                                    </div>
                                    <div class="lnr lnr-coffee-cup display-4 text-primary"></div>
                                </div>
                            </div>
                        </div>
                    </div-->
                </div>
            </div>
        @endif
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