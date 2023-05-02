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

<div >
<h4 class="font-weight-bold py-3 mb-0">Modifier un Poste</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Modifier un Poste</a></li>
            <li class="breadcrumb-item active">Liste</li>
    </div>
</div>

<div class="row">
    
    <div class="col-lg-10" >
         <div class="row" style="margin-bottom: 20px;">
            <div class="col-lg-6 col-md-6 col-sm-6">
            <a href="{{ route('assigner.index') }}" class="btn btn-lg btn-outline-info">Assignation</a>
            </div>
         </div>
         <div class="row">
            
         <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Modifier les opérateurs assignés</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="alert alert-danger text-dark" role="alert">
                                    Cliquez sur les flèches en en-tête du tableau pour trier.
                                </div>
                                
                                <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                        <tr>
                                            <th>Poste</th>
                                            <th>Opérateur</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Poste</th>
                                            <th>Opérateur</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </tfoot>
                                    <tbody> 
                                    @foreach($posteproduits as $posteproduit)
                                            <tr>
                                                <td>{{ $posteproduit->getPoste?->title }}</td>
                                                <form class="user" action="{{ route('assigner.assignerPostecreate',[$sequence_id] ) }}" method="POST"  enctype="multipart/form-data">
                                                @csrf
                                                    <td>
                                                    <input type="text" hidden value="{{ $posteproduit->getPoste?->title }}" name="poste">
                                                    <select name="user_id" id="" class="form-control ">
                                                        <option disabled selected value="">Opérateur</option>
                                                        @foreach ($the_postes as $the_poste)
                                                          @foreach ($posteusers as $posteuser)
                                                            @if($the_poste->getPoste?->id == $posteproduit->getPoste?->id)
                                                            <option value="{{ $the_poste->getUser?->id }}"{{$posteuser->getUser->id == $the_poste->getUser->id ?  'selected' : '' }}>
                                                                {{ $the_poste->getUser?->name}}
                                                            </option>
                                                            @endif
                                                            
                                                          @endforeach
                                                        @endforeach
                                                    </select> 
                                                    </td>
                                                    <td style="width: 25%;"><button  class=" btn btn-info" type="submit">Valider</button> </td>
                                                </form>
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