@extends('layouts.app')

@section('css')
    
<link rel="stylesheet" href="{{ asset('assets/css/pmanager.css')}}">
@endsection

@section('content')


<div class="layout-content">

<!-- [ content ] Start -->
<div class="container-fluid flex-grow-1 container-p-y">

<h4 class="font-weight-bold py-3 mb-0">Commande</h4>
    <div class="row">
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <a href="{{ route('commande.create') }}" class="btn btn-lg btn-outline-info">Nouvelle commande</a>
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
                                            <th>ID Order</th>
                                            <th>Client</th>
                                            <th>Produit</th>
                                            <th>Date</th>
                                            <th>Production</th>
                                            <th>Livraison</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>ID Order</th>
                                            <th>Client</th>
                                            <th>Produit</th>
                                            <th>Date</th>
                                            <th>Production</th>
                                            <th>Livraison</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                      
                                      @foreach ($commandes as $commande)
                                          <tr>
                                                <td>{{ $commande->id }}</td>
                                                <td>{{ $commande->id_order }}</td>
                                                <td>{{ $commande->getClient?->name }}</td>
                                                <td>{{ $commande->getProduit?->name }}</td>
                                                <td>{{ $commande->created_at }}</td>commande.begin
                                                <td>
                                                    @if ($commande->production == false)
                                                        <a href="{{ route('commande.begin',$commande->id ) }}" class="btn btn-primary"> En cours</a>
                                                        
                                                    @elseif($commande->production == true)
                                                        <button class="btn btn-success"> Terminer</button>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($commande->livraison == false)
                                                        <a href="" class="btn btn-primary"> Valider</a>
                                                        
                                                    @elseif($commande->production == true)
                                                        <button class="btn btn-success"> Valider</button>
                                                    @endif
                                                </td>
                                                <td>
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