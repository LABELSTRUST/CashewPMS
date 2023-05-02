@extends('layouts.base')

@section('css')
    
<link rel="stylesheet" href="{{ asset('assets/css/pmanager.css')}}">

<!-- 
<style>
    @media (max-width: 767px) {
  .mytable {
    
    display: block !important;
    width: 100% !important;
    }
  
  thead {
    display: none !important;
  }
  tr {
    margin-bottom: 10px !important;
    display: block !important;
    border-bottom: 2px solid #ddd !important;
  }
  td {
    display: block !important;
    text-align: right !important;
    font-size: 13px !important;
    border-bottom: 1px dotted #ccc !important;
  }
  td::before {
    content: attr(data-label) !important;
    float: left !important;
    font-weight: bold !important;
    text-transform: uppercase !important;
  }
  td:last-child {
    border-bottom: 0 !important;
  } 
}

</style> -->


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

    <h4 class="font-weight-bold py-3 mb-0">Liste des opérateurs</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Séquence</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
    <div class="row">
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-lg-6 col-md-6 col-sm-6 " >
                <a href="{{ route('assigner.index') }}" class="btn btn-lg btn-outline-info">Assignation</a>
            </div>
        </div>

        <div class="container-fluid flex-grow-1  shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Liste des opérateurs par poste</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table table-bordered mytable" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Poste</th>
                                            <th>Opérateur</th>
                                            <th>Nouvel opérateur</th>
                                            <th>Action</th>
                                            <!--th>Commande Quantité</th>
                                            <th>Shift</th>
                                            <th>Date</th>
                                            <th>Action</th-->
                                            <!--th>Salary</th-->
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Poste</th>
                                            <th>Opérateur</th>
                                            <th>Nouvel opérateur</th>
                                            <th>Action</th>
                                            <!--th>Commande Quantité</th>
                                            <th>Shift</th>
                                            <th>Date</th>
                                            <th>Salary</th-->
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                      @foreach($assigners as $assigner)
                                      <tr>
                                        <td>{{ $assigner->id }}</td>
                                        <td>{{ $assigner->getPoste?->title }}</td>
                                        <td>{{ $assigner->getUser?->name }}</td>
                                        <td>

                                        <form class="user" action="{{ route('assigner.update_operateur',   [$assigner->id] ) }}" method="POST"  enctype="multipart/form-data">
                                              @csrf
                                          <select name="user_id" id="" class="form-control ">
                                            <option disabled selected value="">Opérateur</option>
                                            @foreach ($the_postes as $the_poste)
                                              @if($the_poste->getPoste?->id == $assigner->getPoste?->id)
                                              <option value="{{ $the_poste->getUser?->id }}">
                                                  {{ $the_poste->getUser?->name}}
                                              </option>
                                              @endif
                                            @endforeach
                                          </select> 

                                        
                                          
                                        </td>
                                        <td>
                                          <button  class=" btn btn-info" type="submit">Modifier</button>
                                        </form>
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
<script src="{{ asset('asset/js/demo/datatables-demo.js')}}"></script>

<script src="{{ asset('asset/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('asset/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
@endsection