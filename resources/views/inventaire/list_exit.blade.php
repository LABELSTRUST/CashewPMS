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

    <h4 class="font-weight-bold py-3 mb-0" >Sortie</h4>
    <div  class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Sortie</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
    <div class="row">
        <div class="row" style="margin-bottom: 2%;">
            <div class="ml-2 " >
                <a href="{{ route('calibrage.create') }}" class="btn btn-lg btn-outline-info">Nouveau Sortie</a>
            </div>
        </div>

        <div class="container-fluid flex-grow-1  shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Liste des Sorties</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                {{-- id="dataTable" --}}
                                <table class="table table-hover table table-bordered mytable"  width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID Order</th>
                                            <th>Lot</th>
                                            <th>Quantité</th>
                                            <th>Action</th>
                                            <th>Poids sorti</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID Order</th>
                                            <th>Lot</th>
                                            <th>Quantité</th>
                                            <th>Poids sorti</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                      @foreach($exits as $exit)
                                      <tr>
                                        <td>{{ $exit->getUser->code }}</td>
                                        <td>{{ Carbon\Carbon::parse($exit->created_at)->format('Ymd') }}</td>
                                        <td>{{ $exit->num_bag }}</td>
                                        <td>{{ $exit->qte_weight }}</td>
                                        <td>
                                          <a class="btn icon-btn btn-outline-info mr-2" href="{{-- {{ route('reception.stockbygrade',[$grade->id] ) }} --}} "><span class="feather icon-eye"></span></a>
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
@endsection