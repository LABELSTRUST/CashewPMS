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

<div >
<h4 class="font-weight-bold py-3 mb-0">Objectifs</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Objectif</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>

<div class="row">
    
    <div class="col-lg-10" >
         <div class="row d-flex justify-content-between mb-2" >
            <div class="mb-2">
                <a href="{{ route('objectif.create') }}" class="btn btn-lg btn-outline-info">Nouvel Objectif</a>
            </div>
            <div class="mb-2" >
                <a href="{{ route('planning.index') }}" class="btn btn-lg btn-outline-info">Planification</a>
            </div>
         </div>
         <div class="row">
            
         <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Liste des Objectifs</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Id Taget</th>
                                            <th>Période</th>
                                            <th>Quantité</th>
                                            <th>Produit</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Id Taget</th>
                                            <th>Période</th>
                                            <th>Quantité</th>
                                            <th>Produit</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($objectifs as $objectif)
                                        <tr>
                                          <td>{{ $objectif->id }}</td>
                                            <td>{{ $objectif->id_target }}</td>
                                            <td>{{ $objectif->formatted_date }}</td>
                                            <td>{{ $objectif->qte_totale }} {{$objectif->unit_measure}}</td>
                                            <td>{{ $objectif->getProduit->name }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info">Action</button>
                                                    <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('objectif.edit',[$objectif->id] ) }}">Modifier</a>
                                                        <a class="dropdown-item" onclick="return  confirm('Voulez vous supprimer cette ligne?')" href="{{ route('objectif.destroy',[$objectif->id]) }}">Supprimer</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                  
                                </table>
                            </div>
                        </div>
                    </div>
         </div>
    </div>
</div>

@endsection

@section('javascript')
<script src="{{ asset('asset/js/demo/datatables-demo.js')}}"></script>
<script src="{{ asset('asset/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('asset/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
@endsection