@extends('layouts.base')
@section('css')

<style>
    .mydropdown {
    position: relative;
    display: inline-block;
    }

    .mydropdown-content {
    display: none;
    position: absolute;
    z-index: 1;
    top: -200%;
    white-space: nowrap;
    }

    .mydropdown-content a {
    display: block;
    }
    .mydropdown-content div {
    display: flex;
    align-items: center;
    }
    .mydropdown-content span {
    margin-left: 20px;
    }
    .mydropdown:hover .mydropdown-content {
    display: block;
    }

    .mydropbtn {
    background-color: #0f5ca6;
    color: white;
    padding: 8px;
    font-size: 16px;
    
    border: none;
    cursor: pointer;
    }

    .mydropbtn:hover {
    background-color: #0f5ca6;
    }
    @media (max-width: 1000px){
        .myDiv {
            max-width: 50%;
        }
    }
    @media (max-width: 1022px){
        .myDiv {
            max-width: 50%;
        }
    }
    @media (max-width: 474px){
        .myDiv {
            max-width: 100%;
        }
    }
     /*@media (max-width: 1050px){
        .myDiv {
            max-width: 50%;
        }
    }
    @media (max-width: 1062px){
        .myDiv {
            max-width: 50%;
        }
    }
    @media (max-width: 1076px){
        .myDiv {
            max-width: 50%;
        }
    }
    
    */

</style>
    
@endsection

@section('content')


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
<div >
<h4 class="font-weight-bold py-3 mb-0">Menu</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href=""><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Menu</a></li>
            <li class="breadcrumb-item active"><a href="#">Menu</a></li>
        </ol>
    </div>
</div>
<div class="container mb-5">

    
</div>
<div class="row mt-1">
                            <!-- 1st row Start
                     -->
                        
        @if(Auth::check() && Auth::user()->getRole?->name === "Admin")
                        <div class="col-xl" >
                            <div class="row">
                                <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('ligne.index') }}`"  >
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <h4 class="mb-2"> Lignes </h4>
                                                    <!--p class="text-muted mb-0"><span class="badge badge-primary">Revenue</span> Today</p-->
                                                </div>
                                                {{-- <div class="lnr feather icon-settings ></div> --}}
                                                <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/flaticon/lignes.png')}}" alt=""> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('shift.index') }}`"  >
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <h4 class="mb-2"> Shifts </h4>
                                                    <!--p class="text-muted mb-0"><span class="badge badge-primary">Revenue</span> Today</p-->
                                                </div>
                                                
                                                <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/flaticon/shift.png')}}" alt=""> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 myDiv" style=" cursor: pointer;" onclick="location.href=`{{ route('produit.index') }}`" >
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <h4 class="mb-2">Produits</h4>
                                                    <!--p class="text-muted mb-0"><span class="badge badge-warning">.</span> .</p-->
                                                </div>
                                                <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/flaticon/produits.png')}}" alt=""> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4  myDiv" style=" cursor: pointer;" onclick="location.href=`{{ route('objectif.index') }}`" >
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <h4 class="mb-2">Objectifs</h4>
                                                    <!--p class="text-muted mb-0"><span class="badge badge-warning">.</span> .</p-->
                                                </div>
                                                <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/flaticon/objectifs.png')}}" alt=""> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('planning.index') }}`" >
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <h4 class="mb-2">Planifications</h4>
                                                    <!--p class="text-muted mb-0"><span class="badge badge-success">20%</span> Stock</p-->
                                                </div>
                                                <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/flaticon/planification.png')}}" alt=""> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('sequence.index') }}`" >
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <h4 class="mb-2">Séquences</h4>
                                                    <!--p class="text-muted mb-0"><span class="badge badge-warning">$143.45</span> Profit</p-->
                                                </div>
                                                <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/flaticon/sequence.png')}}" alt=""> </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('poste.index') }}`" >
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <h4 class="mb-2">Postes</h4>
                                                    <!--p class="text-muted mb-0"><span class="badge badge-warning">$143.45</span> Profit</p-->
                                                </div>
                                                <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/flaticon/postess.png')}}" alt=""> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('operateur.list') }}`" >
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <h4 class="mb-2">Opérateurs</h4>
                                                    <!--p class="text-muted mb-0"><span class="badge badge-warning">.</span> .</p-->
                                                </div>
                                                <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/flaticon/lignes2.png ')}}" alt=""> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('assigner.index') }}`" >
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <h4 class="mb-2"> Assignations </h4>
                                                    <!--p class="text-muted mb-0">New <span class="badge badge-danger">20%</span> Customer</p-->
                                                </div>
                                                <div class="lnr feather icon-user-check display-4 text-dark"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 myDiv" style="cursor: pointer;">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <h4 class="mb-2">Stocks </h4>
                                                    <!--p class="text-muted mb-0"><span class="badge badge-warning">$143.45</span> Profit</p onclick="location.href=`{{ route('operateur.list') }}`" -->
                                                </div>
                                                <div class="lnr lnr-database display-4 text-dark"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 myDiv" style=" cursor: pointer;" onclick="location.href=`{{ route('produit.index') }}`" >
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <h4 class="mb-2">Production</h4>
                                                    <!--p class="text-muted mb-0"><span class="badge badge-warning">.</span> .</p-->
                                                </div>
                                                <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/flaticon/production.png ')}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('operateur.list') }}`" >
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <h4 class="mb-2">Rapports</h4>
                                                    <!--p class="text-muted mb-0"><span class="badge badge-warning">$143.45</span> Profit</p 
                                <img style="width: 18px;"  src="{{ asset('assets/production/rapport.png')}}" alt=""> -->
                                                </div>
                                                <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/production/rapport.png')}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        @elseif(Auth::check() && Auth::user()->getRole?->name === "Magasinier")
            <div class="col-lg-12 row mb-1  d-flex justify-content-end">
                <div class="mydropdown mr-3">
                    <button class="mydropbtn">Légende <i class="fas fa-info-circle"></i></button>
                    <div class="mydropdown-content mr-3 p-1 bg-white">
                    <div>
                        <button type="button" class="btn btn-primary btn-sm" style="background-color:#FF4961"></button>
                        <span class="ml-2">Stock Disponible</span>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary" style="background-color:#0f5ca6;"></button>
                        <span class="ml-2">Stock Transféré</span>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary" style="background-color: #158806;"></button>
                        <span class="ml-2">Stock Vendu</span>
                    </div>
                    </div>
                </div>
                
            </div>
                <div class="col-lg-12">
                    <div class="row">{{--  --}}
                        @if (isset($matieres))
                            @foreach ($matieres as $matiere)
                            <div class="col-sm-4">
                                <div class="card border-primary mb-3" style="max-width: 35rem;">
                                    <div class="card-header text-center d-flex justify-content-between" style="background-color: #0f5ca6; color: white;"><a class="  mr-2 " href="{{ route('stock_receptionner',[$matiere->id]) }}"><span class="feather icon-eye text-white"></span></a><span>Matières Premières</span> </div>
                                    <div class="card-body ">
                                        <div class="d-flex justify-content-around">
                                        <h5 class="card-title ">{{ $matiere->name }}</h5>
                                        <h5 class="card-title">{{ $matiere->code_mat }}</h5>

                                        </div>
                                        
                                        <div class="d-flex justify-content-around">
                                            <div>
                                                <button style="border:#FF4961 solid 1px; color: #FF4961;" type="button" class="btn btn-round  py-4 px-4 mb-2">{{ $matiere->net_weight }}</button>{{-- 
                                            <span class=" "> </span> --}}

                                            </div>
                                            <div>
                                            {{-- <span class="badge badge-primary"
                                            "></span> --}}<button  type="button" class="btn btn-round  py-4 px-4 mb-2"style="border-radius: 50%; border: #0f5ca6 solid 1px; color: #0f5ca6;">{{ $matiere->transfert_weight }} </button>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div> 
                                
                            @endforeach

                        @else
                        <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('matiere.index',['inventconfig'=>'matiere']) }}`"  >
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="">
                                            <h4 class="mb-2"> Réception </h4>
                                            <!--p class="text-muted mb-0"><span class="badge badge-primary">Revenue</span> Today</p-->
                                        </div>
                                        <div class="lnr lnr-coffee-cup display-4 text-primary"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('matiere.expedition_inv') }}`"  >
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="">
                                            <h4 class="mb-2"> Expédition </h4>
                                            <!--p class="text-muted mb-0"><span class="badge badge-primary">Revenue</span> Today</p-->
                                        </div>
                                        <div class="lnr lnr-coffee-cup display-4 text-primary"></div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                            
                        @endif


                    </div>
                    <div class="row mt-5">{{-- --}}
                            <div class="col-sm-4">
                            <div class="card border-primary mb-3" style="max-width: 35rem;">
                                <div class="card-header text-center d-flex justify-content-between" style=" background-color:  #0f5ca6; color: white;"><a class="  mr-2 " href=""><span class="feather icon-eye text-white"></span></a><span>Produits Finis</span> </div>
                                <div class="card-body ">
                                    <div class="">
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title ">Amandes</h5>
                                            <h5 class="col-6 card-title">P001 </h5>
                                        </div>
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title "> WW180 </h5>
                                            <h5 class="col-6 card-title "> PG001 </h5>
                                        </div>
            
                                    </div>
                                    
                                    <div class="d-flex ">
                                        <div class="col-6 ">
                                            <div > 
                                                <button style="border:#FF4961 solid 1px !important; " type="button" class="btn btn-sm  py-3 px-3 mb-2"></button>
                                            </div>
            
                                        </div>
                                        <div class=" col-6">
                                        <div >
                                            <button style="border:#158806 solid 1px !important; " type="button" class="btn btn-sm   py-3 px-3 mb-2"></button>
                                        </div>
            
                                        </div>
                                    </div>
            
                                </div>
                            </div>
                            </div>
                            <div class="col-sm-4">
                            <div class="card border-primary mb-3" style="max-width: 35rem;">
                                <div class="card-header text-center d-flex justify-content-between" style=" background-color:  #0f5ca6; color: white;"><a class="  mr-2 " href=""><span class="feather icon-eye text-white"></span></a><span>Produits Finis</span> </div>
                                <div class="card-body ">
                                    <div class="">
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title ">Amandes</h5>
                                            <h5 class="col-6 card-title">P001 </h5>
                                        </div>
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title "> WW210</h5>
                                            <h5 class="col-6 card-title ">PG002 </h5>
                                        </div>
            
                                    </div>
                                    
                                    <div class="d-flex ">
                                        <div class="col-6 ">
                                            <div > 
                                                <button style="border:#FF4961 solid 1px !important; " type="button" class="btn btn-sm  py-3 px-3 mb-2"></button>
                                            </div>
            
                                        </div>
                                        <div class=" col-6">
                                        <div >
                                            <button style="border:#158806 solid 1px !important; " type="button" class="btn btn-sm   py-3 px-3 mb-2"></button>
                                        </div>
            
                                        </div>
                                    </div>
            
                                </div>
                            </div>
                            </div>
                            
                            <div class="col-sm-4">
                            <div class="card border-primary mb-3" style="max-width: 35rem;">
                                <div class="card-header text-center d-flex justify-content-between" style=" background-color:  #0f5ca6; color: white;"><a class="  mr-2 " href=""><span class="feather icon-eye text-white"></span></a><span>Produits Finis</span> </div>
                                <div class="card-body ">
                                    <div class="">
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title ">Amandes</h5>
                                            <h5 class="col-6 card-title">P001 </h5>
                                        </div>
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title "> WW240 </h5>
                                            <h5 class="col-6 card-title "> PG003 </h5>
                                        </div>
            
                                    </div>
                                    
                                    <div class="d-flex ">
                                        <div class="col-6 ">
                                            <div > 
                                                <button style="border:#FF4961 solid 1px !important; " type="button" class="btn btn-sm  py-3 px-3 mb-2"></button>
                                            </div>
            
                                        </div>
                                        <div class=" col-6">
                                        <div >
                                            <button style="border:#158806 solid 1px !important; " type="button" class="btn btn-sm   py-3 px-3 mb-2"></button>
                                        </div>
            
                                        </div>
                                    </div>
            
                                </div>
                            </div>
                            </div>
                            
                            
                            <div class="col-sm-4">
                                <div class="card border-primary mb-3" style="max-width: 35rem;">
                                    <div class="card-header text-center d-flex justify-content-between" style=" background-color:  #0f5ca6; color: white;"><a class="  mr-2 " href=""><span class="feather icon-eye text-white"></span></a><span>Produits Finis</span> </div>
                                    <div class="card-body ">
                                        <div class="">
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title ">Amandes</h5>
                                            <h5 class="col-6 card-title">P001 </h5>
                                        </div>
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title "> WW320 </h5>
                                            <h5 class="col-6 card-title "> PG004 </h5>
                                        </div>
                
                                        </div>
                                        
                                    <div class="d-flex ">
                                        <div class="col-6 ">
                                            <div > 
                                                <button style="border:#FF4961 solid 1px !important; " type="button" class="btn btn-sm  py-3 px-3 mb-2"></button>
                                            </div>
            
                                        </div>
                                        <div class=" col-6">
                                        <div >
                                            <button style="border:#158806 solid 1px !important; " type="button" class="btn btn-sm   py-3 px-3 mb-2"></button>
                                        </div>
            
                                        </div>
                                    </div>
                
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card border-primary mb-3" style="max-width: 35rem;">
                                    <div class="card-header text-center d-flex justify-content-between" style=" background-color:  #0f5ca6; color: white;"><a class="  mr-2 " href=""><span class="feather icon-eye text-white"></span></a><span>Produits Finis</span> </div>
                                    <div class="card-body ">
                                        <div class="">
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title ">Amandes</h5>
                                            <h5 class="col-6 card-title">P001 </h5>
                                        </div>
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title "> WW450 </h5>
                                            <h5 class="col-6 card-title "> PG005 </h5>
                                        </div>
                
                                        </div>
                                        
                                    <div class="d-flex ">
                                        <div class="col-6 ">
                                            <div > 
                                                <button style="border:#FF4961 solid 1px !important; " type="button" class="btn btn-sm  py-3 px-3 mb-2"></button>
                                            </div>
            
                                        </div>
                                        <div class=" col-6">
                                        <div >
                                            <button style="border:#158806 solid 1px !important; " type="button" class="btn btn-sm   py-3 px-3 mb-2"></button>
                                        </div>
            
                                        </div>
                                    </div>
                
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card border-primary mb-3" style="max-width: 35rem;">
                                    <div class="card-header text-center d-flex justify-content-between" style=" background-color:  #0f5ca6; color: white;"><a class="  mr-2 " href=""><span class="feather icon-eye text-white"></span></a><span>Produits Finis</span> </div>
                                    <div class="card-body ">
                                        <div class="">
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title ">Amandes</h5>
                                            <h5 class="col-6 card-title">P001 </h5>
                                        </div>
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title "> SW </h5>
                                            <h5 class="col-6 card-title "> PG006 </h5>
                                        </div>
                
                                        </div>
                                        
                                    <div class="d-flex ">
                                        <div class="col-6 ">
                                            <div > 
                                                <button style="border:#FF4961 solid 1px !important; " type="button" class="btn btn-sm  py-3 px-3 mb-2"></button>
                                            </div>
            
                                        </div>
                                        <div class=" col-6">
                                        <div >
                                            <button style="border:#158806 solid 1px !important; " type="button" class="btn btn-sm   py-3 px-3 mb-2"></button>
                                        </div>
            
                                        </div>
                                    </div>
                
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card border-primary mb-3" style="max-width: 35rem;">
                                    <div class="card-header text-center d-flex justify-content-between" style=" background-color:  #0f5ca6; color: white;"><a class="  mr-2 " href=""><span class="feather icon-eye text-white"></span></a><span>Produits Finis</span> </div>
                                    <div class="card-body ">
                                        <div class="">
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title ">Amandes</h5>
                                            <h5 class="col-6 card-title">P001 </h5>
                                        </div>
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title "> SW </h5>
                                            <h5 class="col-6 card-title "> PG007 </h5>
                                        </div>
                
                                        </div>
                                        
                                    <div class="d-flex ">
                                        <div class="col-6 ">
                                            <div > 
                                                <button style="border:#FF4961 solid 1px !important; " type="button" class="btn btn-sm  py-3 px-3 mb-2"></button>
                                            </div>
            
                                        </div>
                                        <div class=" col-6">
                                        <div >
                                            <button style="border:#158806 solid 1px !important; " type="button" class="btn btn-sm   py-3 px-3 mb-2"></button>
                                        </div>
            
                                        </div>
                                    </div>
                
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card border-primary mb-3" style="max-width: 35rem;">
                                    <div class="card-header text-center d-flex justify-content-between" style=" background-color:  #0f5ca6; color: white;"><a class="  mr-2 " href=""><span class="feather icon-eye text-white"></span></a><span>Produits Finis</span> </div>
                                    <div class="card-body ">
                                        <div class="">
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title ">Amandes</h5>
                                            <h5 class="col-6 card-title">P001 </h5>
                                        </div>
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title "> SW </h5>
                                            <h5 class="col-6 card-title "> PG008 </h5>
                                        </div>
                
                                        </div>
                                        
                                    <div class="d-flex ">
                                        <div class="col-6 ">
                                            <div > 
                                                <button style="border:#FF4961 solid 1px !important; " type="button" class="btn btn-sm  py-3 px-3 mb-2"></button>
                                            </div>
            
                                        </div>
                                        <div class=" col-6">
                                        <div >
                                            <button style="border:#158806 solid 1px !important; " type="button" class="btn btn-sm   py-3 px-3 mb-2"></button>
                                        </div>
            
                                        </div>
                                    </div>
                
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card border-primary mb-3" style="max-width: 35rem;">
                                    <div class="card-header text-center d-flex justify-content-between" style=" background-color:  #0f5ca6; color: white;"><a class="  mr-2 " href=""><span class="feather icon-eye text-white"></span></a><span>Produits Finis</span> </div>
                                    <div class="card-body ">
                                        <div class="">
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title ">Amandes</h5>
                                            <h5 class="col-6 card-title">P001 </h5>
                                        </div>
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title "> SW </h5>
                                            <h5 class="col-6 card-title "> PG009 </h5>
                                        </div>
                
                                        </div>
                                        
                                    <div class="d-flex ">
                                        <div class="col-6 ">
                                            <div > 
                                                <button style="border:#FF4961 solid 1px !important; " type="button" class="btn btn-sm  py-3 px-3 mb-2"></button>
                                            </div>
            
                                        </div>
                                        <div class=" col-6">
                                        <div >
                                            <button style="border:#158806 solid 1px !important; " type="button" class="btn btn-sm   py-3 px-3 mb-2"></button>
                                        </div>
            
                                        </div>
                                    </div>
                
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card border-primary mb-3" style="max-width: 35rem;">
                                    <div class="card-header text-center d-flex justify-content-between" style=" background-color:  #0f5ca6; color: white;"><a class="  mr-2 " href=""><span class="feather icon-eye text-white"></span></a><span>Produits Finis</span> </div>
                                    <div class="card-body ">
                                        <div class="">
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title ">Amandes</h5>
                                            <h5 class="col-6 card-title">P001 </h5>
                                        </div>
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title "> SW </h5>
                                            <h5 class="col-6 card-title "> PG010 </h5>
                                        </div>
                
                                        </div>
                                        
                                    <div class="d-flex ">
                                        <div class="col-6 ">
                                            <div > 
                                                <button style="border:#FF4961 solid 1px !important; " type="button" class="btn btn-sm  py-3 px-3 mb-2"></button>
                                            </div>
            
                                        </div>
                                        <div class=" col-6">
                                        <div >
                                            <button style="border:#158806 solid 1px !important; " type="button" class="btn btn-sm   py-3 px-3 mb-2"></button>
                                        </div>
            
                                        </div>
                                    </div>
                
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card border-primary mb-3" style="max-width: 35rem;">
                                    <div class="card-header text-center d-flex justify-content-between" style=" background-color:  #0f5ca6; color: white;"><a class="  mr-2 " href=""><span class="feather icon-eye text-white"></span></a><span>Produits Finis</span> </div>
                                    <div class="card-body ">
                                        <div class="">
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title ">Amandes</h5>
                                            <h5 class="col-6 card-title">P001 </h5>
                                        </div>
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title "> SW </h5>
                                            <h5 class="col-6 card-title "> PG011 </h5>
                                        </div>
                
                                        </div>
                                        
                                    <div class="d-flex ">
                                        <div class="col-6 ">
                                            <div > 
                                                <button style="border:#FF4961 solid 1px !important; " type="button" class="btn btn-sm  py-3 px-3 mb-2"></button>
                                            </div>
            
                                        </div>
                                        <div class=" col-6">
                                        <div >
                                            <button style="border:#158806 solid 1px !important; " type="button" class="btn btn-sm   py-3 px-3 mb-2"></button>
                                        </div>
            
                                        </div>
                                    </div>
                
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card border-primary mb-3" style="max-width: 35rem;">
                                    <div class="card-header text-center d-flex justify-content-between" style=" background-color:  #0f5ca6; color: white;"><a class="  mr-2 " href=""><span class="feather icon-eye text-white"></span></a><span>Produits Finis</span> </div>
                                    <div class="card-body ">
                                        <div class="">
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title ">Amandes</h5>
                                            <h5 class="col-6 card-title">P001 </h5>
                                        </div>
                                        <div class=" d-flex">
                                            <h5 class="col-6 card-title "> SW </h5>
                                            <h5 class="col-6 card-title "> PG012 </h5>
                                        </div>
                
                                        </div>
                                        
                                    <div class="d-flex ">
                                        <div class="col-6 ">
                                            <div > 
                                                <button style="border:#FF4961 solid 1px !important; " type="button" class="btn btn-sm  py-3 px-3 mb-2"></button>
                                            </div>
            
                                        </div>
                                        <div class=" col-6">
                                        <div >
                                            <button style="border:#158806 solid 1px !important; " type="button" class="btn btn-sm   py-3 px-3 mb-2"></button>
                                        </div>
            
                                        </div>
                                    </div>
                
                                    </div>
                                </div>
                            </div>
                            
                        </div> 
                    </div>

                </div>
        @elseif (Auth::check() && Auth::user()->getRole?->name === "Operateur")
        
        <div class="col-xl">
                <div class="row">
                    
                    <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('stock_dispo_op') }}`"  >
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="text-justify text-sm">
                                        <h4 class="mb-1 ">Calibrage </h4>
                                        <!--p class="text-muted mb-0"><span class="badge badge-primary">Revenue</span> Today</p-->
                                    </div>
                                    <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/production/calibration.png')}}" alt=""> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('fragilisation.stock_calib_liste') }}`"  >
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="">
                                        <h4 class="mb-2">Cuisson  </h4>
                                        <!--p class="text-muted mb-0"><span class="badge badge-primary">Revenue</span> Today</p-->
                                    </div>
                                    <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/production/fragilisation.png')}}" alt=""> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('cooling.stock_fragil_liste') }}`"  >
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="">
                                        <h4 class="mb-2">Refroidissement  </h4>
                                        <!--p class="text-muted mb-0"><span class="badge badge-primary">Revenue</span> Today</p-->
                                    </div>
                                    <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/production/sechage.png')}}" alt=""> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('shelling.stock_cooling_liste') }}`"  >
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="">
                                        <h4 class="mb-2">Décorticage  </h4>
                                        <!--p class="text-muted mb-0"><span class="badge badge-primary">Revenue</span> Today</p-->
                                    </div>
                                    <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/production/decorticage.png')}}" alt=""> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('drying.stock_drying_liste') }}`"  >
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="">
                                        <h4 class="mb-2"> Séchage  </h4
                                            >
                                        <!--p class="text-muted mb-0"><span class="badge badge-primary">Revenue</span> Today</p-->
                                    </div>
                                    <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/production/sechage2.png')}}" alt=""> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('drying.stock_unskinning_liste') }}`"  >
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="">
                                        <h4 class="mb-2">Dépelliculage  </h4>
                                        <!--p class="text-muted mb-0"><span class="badge badge-primary">Revenue</span> Today</p-->
                                    </div>
                                    <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/production/depelliculage.png')}}" alt=""> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('classification.stock_classification_liste') }}`"  >
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="">
                                        <h4 class="mb-2">Classification  </h4>
                                        <!--p class="text-muted mb-0"><span class="badge badge-primary">Revenue</span> Today</p-->
                                    </div>
                                    <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/production/classification.png')}}" alt=""></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('conditioning.stocks') }}`"  >
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="">
                                        <h4 class="mb-2">Conditionnement  </h4>
                                        <!--p class="text-muted mb-0"><span class="badge badge-primary">Revenue</span> Today</p-->
                                    </div>
                                    <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/production/conditionnement.png')}}" alt=""></div>
                                </div>
                            </div>
                        </div>
                    </div>{{-- 
                    <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('matiere.index',['inventconfig'=>'produit']) }}`"  >
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="">
                                        <h4 class="mb-2">Stockage   </h4>
                                        <!--p class="text-muted mb-0"><span class="badge badge-primary">Revenue</span> Today</p-->
                                    </div>
                                    <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/production/stockage.png')}}" alt=""></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('matiere.index',['inventconfig'=>'produit']) }}`"  >
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="">
                                        <h4 class="mb-2">Sanitation  </h4>
                                        <!--p class="text-muted mb-0"><span class="badge badge-primary">Revenue</span> Today</p-->
                                    </div>
                                    <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/production/sanitation.png')}}" alt=""></div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('calibrage.issue') }}`"  >
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="">
                                        <h4 class="mb-2">Vérification </h4>
                                        <!--p class="text-muted mb-0"><span class="badge badge-primary">Revenue</span> Today</p-->
                                    </div>
                                    <div class="display-4 text-primary"><img   src="{{ asset('assets/flaticon/search.png')}}" alt=""></div>
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