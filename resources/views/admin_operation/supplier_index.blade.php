@extends('layouts.app')

@section('css')
    
{{-- <link rel="stylesheet" href="{{ asset('assets/css/pmanager.css')}}"> --}}
@endsection

@section('content')


<div class="layout-content">

<!-- [ content ] Start -->
<div class="container-fluid flex-grow-1 container-p-y">

<h4 class="font-weight-bold py-3 mb-0">Fournisseurs</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Fournisseurs</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
    <div class="row">
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <a href="{{ route('supplier.create') }}" class="btn btn-lg btn-outline-info">Nouveau</a>
            </div>
        </div>

        <div class="container-fluid flex-grow-1  shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Liste des Fournisseurs </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Code</th>
                                            <th>Nom</th>
                                            <th>Email</th>
                                            <th>Adresse</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Code</th>
                                            <th>Nom</th>
                                            <th>Email</th>
                                            <th>Adresse</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                      
                                      @foreach ($suppliers as $supplier)
                                          <tr>
                                              <td>{{ $supplier->id }}</td>
                                              <td>{{ $supplier->code }}</td>
                                              <td>{{ $supplier->first_name }}</td>
                                              <td>{{ $supplier->email }}</td>
                                              <td>
                                                <a class="btn icon-btn btn-outline-info mr-2 p-2" href="{{ route('supplier.supplier_details', $supplier->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                              </td>
                                              <td>
                                                
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info">Action</button>
                                                    <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('supplier.edit',[$supplier->id] ) }}">Modifier</a>
                                                        {{-- <a class="dropdown-item" onclick="return  confirm('Voulez vous supprimer cette ligne?')" href="{{ route('ligne.delete',[$ligne->id]) }}">Supprimer</a> --}}
                                                    </div>
                                                </div>
                                              </td>
                                             {{--  <td style=" width: 25%;">
                                                <a class="btn btn-outline-info" href="{{route('commande.create', [$client->id])}}">Passer une commande</a>
                                            </td> --}}
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

<style>
.scroll::-webkit-scrollbar{
    width: 5px;
    background-color: gray;
    height:5px;

}
.scroll::-webkit-scrollbar-thumb{
    background: black;
    height:3px;
}
</style>

@section('javascript')
<script src="{{ asset('asset/js/demo/datatables-demo.js')}}"></script>
<script src="{{ asset('asset/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('asset/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
@endsection