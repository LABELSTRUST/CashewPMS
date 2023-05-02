@extends('layouts.base')

@section('css')
    
<link rel="stylesheet" href="{{ asset('assets/css/pmanager.css')}}">



@endsection

@section('content')


<div class="layout-content">


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
    
    @if(session()->has('errors'))
      <div class="alert alert-dark-danger alert-dismissible fade show"  >
          <button type="button" class="close" data-dismiss="alert" >x</button>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<!-- [ content ] Start -->
<div class="container-fluid flex-grow-1 container-p-y">

    <h4 class="font-weight-bold py-3 mb-0" >Calibre</h4>
    <div  class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Calibre</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
    <div class="row">
        <div class="row" style="margin-bottom: 2%;">
            <div class="ml-2 " >
                <a href="{{ route('calibrage.create') }}" class="btn btn-lg btn-outline-info">Nouveau Calibre</a>
            </div>
        </div>

        <div class="container-fluid flex-grow-1  shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Liste des Calibres</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                {{-- id="dataTable" --}}
                                <table class="table table-hover table table-bordered mytable"  width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Code</th>
                                            <th>Désignation</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Code</th>
                                            <th>Désignation</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                      @foreach($calibres as $calibre)
                                      <tr>
                                        <td>{{ $calibre->id }}</td>
                                        <td>{{ $calibre->code_calibre }}</td>
                                        <td>{{ $calibre->designation }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info">Action</button>
                                                <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"  href="{{ route('calibrage.edit',[$calibre->id]) }}">Modifier</a>
                                                    <a class="dropdown-item" onclick="return  confirm('Voulez vous supprimer ce calibre?')" href="{{ route('calibrage.delete',[$calibre->id]) }}">Supprimer</a>
                                                </div>
                                            </div>
                                        </td>

                                      </tr>
                                      @endforeach
                                    </tbody>
                                  
                                </table>
                                {{ $calibres->links('pagination::bootstrap-4') }}
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

<script src="{{ asset('asset/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('asset/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
@endsection