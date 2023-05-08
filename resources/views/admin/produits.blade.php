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

@if(Auth::check() && Auth::user()->getRole?->name === "Magasinier")
    <div >
        <h4 class="font-weight-bold py-3 mb-0">Matière Première</h4>
        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inventaire.index') }}"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="#">Matière Première</a></li>
                <li class="breadcrumb-item active">Liste</li>
            </ol>
        </div>
    </div>

    <div class="row">
        
        <div class="col-md-12" >
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <a href="{{ route('matierepremiere.create') }}" class="btn btn-lg btn-outline-info">Ajouter Matière Première</a>
                </div>
            </div>
            <div class="row">
                
            <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-info">Liste des Matières Premières</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Code_PMS</th>
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                                <!--th>Salary</th-->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Code_PMS</th>
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                                <!--th>Salary</th-->
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        
                                        @foreach ($produits as $produit)
                                            <tr style="cursor: pointer;" onclick="location.href=`{{ route('produit.production', [$produit->id]) }}`">
                                                <td>{{ $produit->id }}</td>
                                                <td>{{ $produit->code_prod }}</td>
                                                <td>{{ $produit->name }}</td>
                                                <td>{{ $produit->created_at }}</td>
                                                <td style=" width: 25%;">
                                                    <a class="btn btn-outline-info" href="">Modifier</a>
                                                </td>
                                                <!--td>$320,800</td-->
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
@elseif(Auth::check() && Auth::user()->getRole?->name === "Admin")
    <div >
        <h4 class="font-weight-bold py-3 mb-0">Produits</h4>
        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="#">Produits</a></li>
                <li class="breadcrumb-item active">Liste</li>
            </ol>
        </div>
    </div>

    <div class="row">
        
        <div class="col-md-12" >
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-lg-6 col-md-6 col-sm-6 ">
                    <a href="{{ route('produit.create') }}" class="btn btn-lg btn-outline-info">Nouveau Produit</a>
                </div>
            </div>
            <div class="row">
                
            <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-info">Liste des Produits</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" >
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Code_PMS</th>
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                                <!--th>Salary</th-->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Code_PMS</th>
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                                <!--th>Salary</th-->
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        
                                        @foreach ($produits as $produit)
                                            <tr >
                                                <td>{{ $produit->id }}</td>
                                                <td>{{ $produit->code_prod }}</td>
                                                <td>{{ $produit->name }}</td>
                                                <td>{{ $produit->created_at }}</td>
                                                <td style=" width: 25%;">
                                                    
                                                <div class="btn-group">
                                                        <button type="button" class="btn btn-info">Action</button>
                                                        <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="{{ route('produit.edit',[$produit->id] ) }}">Modifier</a>
                                                            <a class="dropdown-item" onclick="return  confirm('Voulez vous supprimer ce produit?')" href="{{ route('produit.destroy',[$produit->id]) }}">Supprimer</a>
                                                            <a class="dropdown-item" href="{{ route('produit.createposte', [$produit->id]) }}">Créer un poste</a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <!--td>$320,800</td-->
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
@endif
@endsection


@section('javascript')
<script src="{{ asset('asset/js/demo/datatables-demo.js')}}"></script>
<script src="{{ asset('asset/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('asset/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
@endsection