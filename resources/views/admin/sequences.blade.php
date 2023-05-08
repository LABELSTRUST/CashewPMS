@extends('layouts.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/pmanager.css') }}">
@endsection

@section('content')
    @if (session()->has('message'))
        <div class="alert alert-dark-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong> {{ session()->get('message') }}</strong>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-dark-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong> {{ session()->get('error') }}</strong>
        </div>
    @endif

    <div style="margin-left: 1%;">
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

        <div class="col-md-12">
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-lg-6 col-md-6 col-sm-6 ">
                    <a href="{{ route('planning.index') }}" class="btn btn-lg btn-outline-info">Planification</a>
                </div>
            </div>
            <div class="row">


                <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-info">Liste des Séquences</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>ID Target</th>
                                        <th>Produit</th>
                                        <th>Date</th>
                                        <th>Jour</th>
                                        <th>Shift</th>
                                        <th>Ligne</th>
                                        <th>Séquence</th>
                                        <th>Action</th>
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
                                        <th>Séquence</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                @php
                                    $d = 1;
                                @endphp
                                
                                <tbody>
                                    @foreach ($sequences as $sequence)
                                        <tr>
                                            <td>{{ $d++ }}</td>
                                           
                                            <td>{{ $sequence->getObjectif?->id_target }}</td>
                                            <td>{{ $sequence->getObjectif?->getProduit->name }}</td>
                                            <td>{{ $sequence->date_start }}</td>
                                            <td>{{ date('l', strtotime($sequence->date_start)) }}</td>
                                            <td>{{ $sequence->getShift?->title }}</td>
                                            <td>{{ $sequence->getLigne?->name }}</td>{{-- 
                                                    <td>{{ $sequence->quantity}} {{$sequence->getObjectif?->unit_measure}} </td> --}}
                                            <td>{{ str_pad($sequence->code, 2, '0', STR_PAD_LEFT) }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info">Action</button>
                                                    <button type="button"
                                                        class="btn btn-info dropdown-toggle dropdown-toggle-split"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('sequence.edit', [$sequence->id]) }}">Modifier</a>
                                                        <a class="dropdown-item"
                                                            onclick="return  confirm('Voulez vous supprimer cette séquence?')"
                                                            href="{{ route('sequence.destroy', [$sequence->id]) }}">Supprimer</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('assigner.assignerposte', [$sequence->id]) }}">Assigner</a>
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
    .scroll::-webkit-scrollbar {
        width: 5px;
        background-color: gray;
        height: 5px;

    }

    .scroll::-webkit-scrollbar-thumb {
        background: black;
        height: 3px;
    }
</style>

@section('javascript')
    <script src="{{ asset('asset/js/demo/datatables-demo.js') }}"></script>
    <script src="{{ asset('asset/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('asset/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endsection
