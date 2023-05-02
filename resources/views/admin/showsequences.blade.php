@extends('layouts.base')


@section('content')


<div >
<h4 class="font-weight-bold py-3 mb-0">Séquences</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Séquences</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>

<div class="row">
    
    <div class="col-lg-10" >
         <div class="row" style="margin-bottom: 20px;">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <a href="{{ route('planning.index') }}" class="btn btn-xl btn-outline-info">Planification</a>
            </div>
            <!--div class="col-lg-6" style="display: flex; justify-content: flex-end;">
                <a href="{{ route('sequence.create') }}" class="btn btn-xl btn-outline-info">Ajouter Séquence</a>
            </div-->
         </div>
        <div class="row">
         





         <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Liste des séquences</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="alert alert-danger text-dark" role="alert">
                                    Cliquez sur les flèches en en-tête du tableau pour trier.
                                </div>
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Shift</th>
                                            <th>Quantité attendue</th>
                                            <th>Quantité produite</th>
                                            <th>Planning</th>
                                            <th>Date début</th>
                                            <th>Date Fin</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Shift</th>
                                            <th>Quantité attendue</th>
                                            <th>Quantité produite</th>
                                            <th>Planning</th>
                                            <th>Date début</th>
                                            <th>Date Fin</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                      @foreach ($sequences as $sequence)
                                          <tr>
                                                <td>{{ $sequence->id }}</td>
                                                <td>
                                                    @if(isset($sequence->getShift->title))
                                                        {{ $sequence->getShift->title }}
                                                    @endif
                                                </td>
                                                <td>{{ $sequence->quantity }}</td>
                                                <td>{{ $sequence->quantity_do }}</td>
                                                <td>{{ $sequence->planning_id }}</td>
                                                <td>{{ $sequence->date_start }}</td>
                                                <td>{{ $sequence->date_end }}</td>
                                                <td style=" width: 25%;">
                                                    <a class="btn btn-outline-info" href="{{ route('sequence.edit', [$sequence->id]) }}">Modifier</a>
                                                <a class="btn btn-outline-info" href="{{ route('assigner.assignerposte',[$sequence->id]) }}">Assigner Poste</a>
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
</div>

@endsection

@section('javascript')
<script src="{{ asset('asset/js/demo/datatables-demo.js')}}"></script>
<script src="{{ asset('asset/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('asset/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
@endsection