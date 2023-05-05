@extends('layouts.app')
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
        
    <div class="col-xl" >
        <div class="row">
          <div class="col-sm-4 col-md-4 col-lg-4  myDiv" style=" cursor: pointer;" onclick="location.href=`{{ route('objectif.index') }}`" >
              <div class="card mb-4">
                  <div class="card-body">
                      <div class="d-flex align-items-center justify-content-between">
                          <div class="">
                              <h4 class="mb-2">Direction Générale</h4>
                              <!--p class="text-muted mb-0"><span class="badge badge-warning">.</span> .</p-->
                          </div>
                          <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/flaticon/objectifs.png')}}" alt=""> </div>
                      </div>
                  </div>
              </div>
          </div>
            <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('ligne.index') }}`"  >
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="">
                                <h4 class="mb-2"> Finance </h4>
                                <!--p class="text-muted mb-0"><span class="badge badge-primary">Revenue</span> Today</p-->
                            </div>
                            {{-- <div class="lnr feather icon-settings ></div> --}}
                            <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/flaticon/lignes.png')}}" alt=""> </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 myDiv" style="cursor: pointer;" onclick="location.href=`{{ route('gene_admin.create_operator') }}`"  >
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="">
                                <h4 class="mb-2"> Opérations </h4>
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
                                <h4 class="mb-2">Ressources Humaines</h4>
                                <!--p class="text-muted mb-0"><span class="badge badge-warning">.</span> .</p-->
                            </div>
                            <div class="display-4 text-primary"><img  width="35px" src="{{ asset('assets/flaticon/produits.png')}}" alt=""> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
        
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