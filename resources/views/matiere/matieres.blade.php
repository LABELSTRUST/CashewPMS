
@extends('layouts.base')


@section('content')


<div >
<h4 class="font-weight-bold py-3 mb-0">Matières</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Matières</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>

<div class="row">
    
    <div class="col-lg-10" >
         <div class="row d-flex justify-content-between mb-2" >
            <div class="mb-2">
                <a href="{{ route('matiere.create') }}" class="btn btn-lg btn-outline-info">Ajouter</a>
            </div>{{-- 
            <div class="mb-2 ">
                <a href="{{ route('inventaire.index') }}" class="btn btn-lg btn-outline-info">Contrôle qualité</a>
            </div>
            <div class="col-lg-6" style="display: flex; justify-content: flex-end;">
                <a href="{{ route('client.index') }}" class="btn btn-xl btn-outline-info">Gestion des clients</a>
            </div> --}}
         </div>
         <div class="row">
            
         <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Liste des Matières</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered sourced-data dataTable" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Code_MP</th>
                                            <th>Nom</th>
                                            <th>Action</th>
                                            
                                            <!--th>Salary</th-->
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Code_MP</th>
                                            <th>Nom</th>
                                            <th>Action</th>
                                            
                                            <!--th>Salary</th-->
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($produits as $produit)
                                        <tr>
                                          <td>{{ $produit->id }}</td>
                                            <td>{{ $produit->code_mat }}</td>
                                            <td>{{ $produit->name }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info">Action</button>
                                                    <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('inventaire.create',[$produit->id]) }}">Réception</a>
                                                        <a class="dropdown-item" href="{{ route('stock_receptionner',[$produit->id]) }}">Stock</a>
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