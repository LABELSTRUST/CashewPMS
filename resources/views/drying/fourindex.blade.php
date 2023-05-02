@extends('layouts.base')

@section('css')
    
<link rel="stylesheet" href="{{ asset('assets/css/pmanager.css')}}">



@endsection

@section('content')


<div class="layout-content">

<!-- [ content ] Start -->
<div class="container-fluid flex-grow-1 container-p-y">

    <h4 class="font-weight-bold py-3 mb-0" >Four</h4>
    <div  class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Four</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
    <div class="row">
        <div class="row" style="margin-bottom: 2%;">
            <div class="ml-2 " >
                <a href="{{ route('drying.createfour') }}" class="btn btn-lg btn-outline-info">Nouveau Four</a>
            </div>
        </div>

        <div class="container-fluid flex-grow-1  shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Fours</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table table-bordered mytable" id="dataTable" width="100%" cellspacing="0">
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
                                      @foreach($fours as $four)
                                      <tr>
                                        <td>{{ $four->id }}</td>
                                        <td>{{ $four->designation }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info">Action</button>
                                                <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"  href="{{ route('drying.fouredit',[$four->id]) }}">Modifier</a>
                                                    <a class="dropdown-item" onclick="return  confirm('Voulez vous supprimer ce Four ?')" href="{{ route('drying.fourdestroy',[$four->id]) }}">Supprimer</a>
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