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
    <h4 class="font-weight-bold py-3 mb-0">Poste</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin_dash') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Poste</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>

<div class="row">
    
<div class="col-lg-10" style="margin-left: 2%;">
         <div class="row d-flex justify-content-between mb-3">
            <div class="col-lg-6 col-md-6 col-sm-6 " >
                 <a class="btn btn-info" href="{{route('admin_dash')}}">Retour</a>
            </div>
         </div>
         <div class="row">
            
         <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Postes</h6>
                        </div>
                        <div class="card-body ">
                            <div class="table-responsive">{{-- id="dataTable" --}}
                                <table class="table table-hover table-bordered"  width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Désignation</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Désignation</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                      
                                        @foreach($roles as $role)
                                        <tr>
                                          <td> {{ $role->id }}</td>
                                          <td>
                                            {{ $role->designation }}
                                          </td>
                                          <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info">Action</button>
                                                <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"  href="{{ route('admin_role.edit',[$role->id]) }}">Modifier</a>
                                                    {{-- <a class="dropdown-item" onclick="return  confirm('Voulez vous supprimer ce role?')" href="{{ route('calibrage.delete',[$role->id]) }}">Supprimer</a> --}}
                                                </div>
                                            </div>
                                          </td>
  
                                        </tr>
                                        @endforeach
                                      </tbody>
                                  
                                {{ $roles->links('pagination::bootstrap-4') }}
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