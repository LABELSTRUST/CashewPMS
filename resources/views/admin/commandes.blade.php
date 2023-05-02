@extends('layouts.base')

@section('css')
    
<link rel="stylesheet" href="{{ asset('assets/css/pmanager.css')}}">
@endsection

@section('content')


<div class="layout-content">

<!-- [ content ] Start -->
<div class="container-fluid flex-grow-1 container-p-y">

<h4 class="font-weight-bold py-3 mb-0">Commande</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Commande</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
    <div class="row">
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <a href="{{ route('client.index') }}" class="btn btn-lg btn-outline-info">Nouvelle commande</a>
            </div>
        </div>

        <div class="container-fluid flex-grow-1  shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Liste des Commandes</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Code</th>
                                            <th>ID Order</th>
                                            <th>Client</th>
                                            <th>Produit</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Code</th>
                                            <th>ID Order</th>
                                            <th>Client</th>
                                            <th>Produit</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                      
                                      @foreach ($commandes as $commande)
                                          <tr>
                                              <td>{{ $commande->id }}</td>
                                              <td>{{ $commande->code }}</td>
                                              <td>{{ $commande->id_order }}</td>
                                              <td>{{ $commande->getClient?->name }}</td>
                                              <td>{{ $commande->getProduit?->name }}</td>
                                              <td>{{ $commande->created_at }}</td>
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
<!-- [ Layout footer ] End -->

</div>

@endsection


@section('javascript')
<script src="{{ asset('asset/js/demo/datatables-demo.js')}}"></script>
<script src="{{ asset('asset/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('asset/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
@endsection