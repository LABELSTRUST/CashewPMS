@extends('layouts.base')


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
    <div>
        <h4 class="font-weight-bold py-3 mb-0">Poste</h4>
        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="#">Postes</a></li>
                <li class="breadcrumb-item active">Liste</li>
            </ol>
        </div>
    </div>

    <div class="row">


        <div class="col-md-12">
            <div class="row" style="margin-bottom: 20px;">

                @if (isset($assigners))
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <a href="{{ route('operateur.list') }}" class="btn btn-lg btn-outline-info">Opérateurs</a>
                    </div>
                @else
                    <div class="col-lg-6 col-md-6 col-sm-6 ">
                        <a href="{{ route('poste.create') }}" class="btn btn-lg btn-outline-info">Nouveau Poste</a>
                    </div>
                @endif
                <!--div class="col-lg-6" style="display: flex; justify-content: flex-end;">
                        <a href="{{ route('shift.index') }}" class="btn btn-lg btn-outline-info">Gestion des shifts</a>
                    </div-->
            </div>
            <div class="row">
                @if (isset($assigners))
                    <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Liste des Postes </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Intitulé</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Intitulé</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($assigners as $poste)
                                            <tr>
                                                <td>{{ $poste->getPoste->id }}</td>
                                                <td>{{ $poste->getPoste->title }}</td>
                                                <td>{{ $poste->getPoste->created_at }}</td>
                                                <td style=" width: 25%;">
                                                    <a class="btn btn-outline-info" href="">Modifier</a>
                                                </td>
                                                <!--td>$320,800</td-->
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                @elseif(isset($postes))
                    <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Liste des Postes</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Intitulé</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Intitulé</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                            $d = 1;
                                        @endphp


                                        @foreach ($postes as $poste)
                                            <tr>
                                                <td>{{ $d++ }}</td>
                                                <td>{{ $poste->title }}</td>
                                                <td>{{ $poste->created_at }}</td>
                                                <td style=" width: 25%;">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info">Action</button>
                                                        <button type="button"
                                                            class="btn btn-info dropdown-toggle dropdown-toggle-split"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item"
                                                                href="{{ route('poste.operateors', [$poste->id]) }}">Agents
                                                                par poste</a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('poste.edit', [$poste->id]) }}">Modifier</a>
                                                            <a class="dropdown-item"
                                                                onclick="return  confirm('Voulez vous supprimer cette ligne?')"
                                                                href="{{ route('poste.destroy', [$poste->id]) }}">Supprimer</a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <!--td>$320,800</td-->
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                @endif
                @if (isset($attributions))
                    <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Liste des Postes Attribués</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="alert alert-danger text-dark" role="alert">
                                    Cliquez sur les flèches en en-tête du tableau pour trier.
                                </div>
                                <table class="table table-bordered table-hover" id="dataTable" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Intitulé</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Intitulé</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($attributions as $attribution)
                                            <tr>
                                                <td>{{ $attribution->getPoste->id }}</td>
                                                <td>{{ $attribution->getPoste->title }}</td>
                                                <td>{{ $attribution->getPoste->created_at }}</td>
                                                <td style=" width: 25%;">
                                                    <a class="btn btn-outline-info" href="">Modifier</a>
                                                </td>
                                                <!--td>$320,800</td-->
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('asset/js/demo/datatables-demo.js') }}"></script>
    <script src="{{ asset('asset/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('asset/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endsection
