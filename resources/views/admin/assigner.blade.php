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

<!-- [ content ] Start -->
<div class="container-fluid flex-grow-1 container-p-y">

    <h4 class="font-weight-bold py-3 mb-0">Assignation</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Séquence</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
    <div class="row">
        <div class="row" style="margin-bottom: 20px;">
            <!--div class="col-lg-6 col-md-6 col-sm-6 " >
                <a href="{{ route('planning.index') }}" class="btn btn-lg btn-outline-info">Assignation</a>
            </div-->
        </div>

        <div class="container-fluid flex-grow-1  shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Liste des Séquences</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table table-bordered mytable" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ID Target</th>
                                            <th>Produit</th>
                                            <th>Date</th>
                                            <th>Jour</th>
                                            <th>Shift</th>
                                            <th>Ligne</th>
                                            <th>Quantité</th>
                                            <th>Séquence</th>
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
                                            <th>ID Target</th>
                                            <th>Produit</th>
                                            <th>Date</th>
                                            <th>Jour</th>
                                            <th>Shift</th>
                                            <th>Ligne</th>
                                            <th>Quantité</th>
                                            <th>Séquence</th>
                                            <th>Action</th>
                                            <!--th>Commande Quantité</th>
                                            <th>Shift</th>
                                            <th>Date</th>
                                            <th>Salary</th{{setlocale(LC_TIME, 'fr_FR')}}
                                        {{date_default_timezone_set('Europe/Paris')}}-->
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                      @foreach($sequences as $sequence)
                                      <tr>
                                        <td>{{ $sequence->id }}</td>
                                        <td>{{ $sequence->getObjectif?->id_target }}</td>
                                        <td>{{ $sequence->getObjectif?->getProduit->name }}</td>
                                        <td>{{ Carbon\Carbon::parse($sequence->date_start)->format('d-m-Y') }}</td>
                                        <td> {{ date("l",utf8_encode(strtotime($sequence->date_start))) }}</td>
                                        <td>{{ $sequence->getShift?->title }}</td>
                                        <td>{{ $sequence->getLigne?->name }}</td>
                                        <td>{{ $sequence->quantity}}</td>
                                        <td>{{str_pad($sequence->code, 2, '0', STR_PAD_LEFT)}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info">Action</button>
                                                <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" id="assigner" href="{{ route('assigner.assignerposte',[$sequence->id]) }}">Assigner</a>
                                                    <a class="dropdown-item" href="{{ route('assigner.poste_operateur',[$sequence->id]) }}">Opérateurs assigners</a>
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
<script src="{{ asset('asset/js/demo/datatables-demo.js')}}"></script>
<script src="{{ asset('asset/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('asset/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
@endsection