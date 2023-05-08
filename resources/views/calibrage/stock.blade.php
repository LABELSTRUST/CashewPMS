@extends('layouts.base')

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
<div style="margin-left: 2%;">
    <h4 class="font-weight-bold py-3 mb-0">Stock</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Stock</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>

<div class="row">
    
<div class="col-lg-10" style="margin-left: 2%;">
         <div class="row d-flex justify-content-between">
            <div class="mb-2">
                <a href="{{ route('dashboard') }}" class="btn btn-lg btn-outline-info">Retour</a>
            </div>
            <div class="mb-2">
                <a href="{{ route('calibrage.create') }}" class="btn btn-lg btn-outline-info">Calibrage</a>
            </div>
         </div>
         <div class="row">
            
         <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Liste des stocks</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">{{-- id="dataTable" --}}
                                <table class="table table-bordered"  width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Id lot PMS</th>
                                            <th>Date</th>
                                            <th>Poids</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Id lot PMS</th>
                                            <th>Date</th>
                                            <th>Poids</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </tfoot>
                                    <tbody>{{-- /*  */ --}}
                                      
                                      @foreach ($stocks as $stock)
                                        @if($stock->calibrated_stock == true && $stock->updated_at->diffInHours(now()) > 24)
                                       
                                        @else
                                        <tr>
                                            <td>{{$stock->id}} </td>
                                            <td>{{$stock->getStock->getOrigin->id_lot_pms}}</td>
                                            <td>{{$stock->created_at}}</td>
                                            <td>{{$stock->net_weight}}</td>
                                            <td> {{-- --}}

                                                
                                                <a class="btn icon-btn btn-outline-info mr-2" href="{{isset($stock->id)? route('calibrage.index',[$stock->id]):"" }}"><span class="feather icon-eye"></span></a>
                                                <a class="btn btn-info" href="{{route('processusCalibrage',[$stock->id])}}">Procéder</a>
                                                {{-- @if ($stock->getStock->localisation==null)
                                               <a class="btn btn-info" href="{{route('processusCalibrage',[$stock->id])}}">Procéder</a>
                                               @else
                                               <a class="btn btn-info" disabled style="background-color: green" href="{{route('processusCalibrage',[$stock->id])}}">Procéder</a> 
                                               @endif --}}
                                              
                                            </td>
                                        </tr>
                                        @endif
                                      @endforeach
                                    </tbody>
                                  
                                </table>

                                {{ $stocks->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
         </div>
    </div>
</div>

@endsection


@section('javascript')

<script src="{{ asset('asset/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('asset/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
@endsection