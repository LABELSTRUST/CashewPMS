@extends('layouts.base')
@section('css')
    <style>
       table td {
            width: 1% !important;
        }
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
         <div class="row d-flex justify-content-between mb-3">
            <div class="col-lg-6 col-md-6 col-sm-6 " >
                 <a class="btn btn-info" href="{{route('processusCalibrage',[$stock])}}">Retour</a>
            </div>
         </div>
         <div class="row">
            
         <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Stocks</h6>
                        </div>
                        <div class="card-body ">
                            <div class="table-responsive">{{-- id="dataTable" --}}
                                <table class="table table-hover table-bordered"  width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Lot</th>
                                            <th>Poids</th>
                                            <th>Localisation</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Lot</th>
                                            <th>Poids</th>
                                            <th>Localisation</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                      
                                        @foreach($calibrages as $calibre)
                                        <tr>
                                          <td> {{ $calibre->id }}</td>
                                          <td>
                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $calibre->created_at)->format('d/m/Y') }}
                                          </td>
                                          <td>
                                            {{ $calibre->id_lot_calibre }}
                                          </td>
                                          <td>
                                            {{ $calibre->caliber_weight }}
                                          </td>
                                          <td>
                                            {{ $calibre->localisation }}
                                          </td>
                                          <td>
                                              <a class="btn  btn-outline-info mr-2" href="{{isset($calibre->id)? route('calibrage.show',[$calibre->id]):"" }}">Contrôle qualité</a>
                                              @if ($calibre->transfert)
                                                  <button class="btn btn-success">Transférer</button>
                                              @else
                                                <a class="btn btn-info"  href="{{route('calibrage.calibrageTransfert',[$calibre->id])}} ">Transférer</a>
                                                  
                                              @endif
                                          </td>
  
                                        </tr>
                                        @endforeach
                                      </tbody>
                                  
                                {{ $calibrages->links('pagination::bootstrap-4') }}
                                </table>
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