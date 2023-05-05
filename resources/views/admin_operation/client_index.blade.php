@extends('layouts.app')

@section('css')
    <style>
.sticky {
    position: sticky;
    position: -webkit-sticky;
    left: 0;
    background-color: #fff;
}
thead {
z-index: 1;
}

    </style> 
@endsection

@section('content')


    <div class="layout-content">


        <div class="container-fluid flex-grow-1 container-p-y">

            <h4 class="font-weight-bold py-3 mb-0">Clients</h4>
                <div class="row">
                    <div class="row col-md-12 d-flex justify-content-between" style="margin-bottom: 2%;">
                        <div class="">
                            <a href="{{ route('admin_operation.create_client') }}" class="btn btn-lg btn-outline-info">Nouveau</a>
                        </div>
                        <div class="">
                            <a href="{{ route('commande.index') }}" class="btn btn-lg btn-outline-info">Commande</a>
                        </div>
                    </div>

                    <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Liste des Clients</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Code</th>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Entreprise</th>
                                            <th>Email</th>
                                            <th>Catégorie </th>
                                            <th>Adresse </th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Code</th>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Entreprise</th>
                                            <th>Email</th>
                                            <th>Catégorie </th>
                                            <th>Adresse </th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    
                                    @foreach ($clients as $client)
                                    <tr>
                                        <td>{{ $client->id }}</td>
                                        <td>{{ $client->code }}</td>
                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->first_name }}</td>
                                        <td>{{ $client->company }}</td>
                                        <td>{{ $client->email }}</td>
                                        <td>{{ $client->categorie }}</td>
                                        <td>
                                            <a class="btn icon-btn btn-outline-primary mr-2 p-2" href="{{ route('client.client_details', $client->id) }}"><i class="fa fa-eye" aria-hidden="true"></i> </a>

                                        </td>
                                        <td>

                                            <div class="dropdown mb-4">
                                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton" style="">
                                                    <a class="dropdown-item" href="{{ route('client.edit',[$client->id] ) }}">Modifier</a>
                                                    <a class="dropdown-item" href="{{ route('commande.client_order',[$client->id] ) }}">Commande</a>
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

<style>
/* .scroll::-webkit-scrollbar{
    width: 5px;
    background-color: gray;
    height:5px;

}
.scroll::-webkit-scrollbar-thumb{
    background: black;
    height:3px;
} */
</style>

@section('javascript')
<script src="{{ asset('asset/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('asset/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('asset/js/demo/datatables-demo.js')}}"></script>
@endsection