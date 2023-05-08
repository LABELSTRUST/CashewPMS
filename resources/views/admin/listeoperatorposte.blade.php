@extends('layouts.base')


@section('content')
    <div>
        <h4 class="font-weight-bold py-3 mb-0">Agents par poste</h4>
        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="#">Agents par poste</a></li>
                <li class="breadcrumb-item active">Postes</li>
            </ol>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">
            <div class="row d-flex justify-content-between mb-2">
                <div class="mb-2">
                    <a href="{{ route('assigner.index') }}" class="btn btn-lg btn-outline-info">Assigner un poste</a>
                </div>
                <div class="mb-2">
                    <a href="{{ route('operateur.list') }}" class="btn btn-lg btn-outline-info">Opérateurs</a>
                </div>
            </div>
            <div class="row">

                <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-info">Liste des Agents ayants des postes</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Poste</th>
                                        <th>Ligne</th>
                                        <th>Shift</th>
                                        <th>Action</th>
                                        <!--th>Salary</th-->
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Poste</th>
                                        <th>Ligne</th>
                                        <th>Shift</th>
                                        <th>Action</th>
                                        <!--th>Salary</th-->
                                    </tr>
                                </tfoot>
                                @php
                                    $d = 1;
                                @endphp

                                <tbody>

                                    @foreach ($assigns as $assign)
                                        <tr>
                                            <td>{{ $d++ }}</td>
                                            <td>{{ $assign->getUser->name }}</td>
                                            <td>{{ $assign->created_at }}</td>
                                            <td>{{ $assign->getPoste->title }}</td>
                                            <td>{{ $assign->getLigne->code }} {{ $assign->getLigne->name }}</td>
                                            <td>{{ $assign->getShift->title }}</td>
                                            <td>
                                                <a class="btn btn-outline-info" href="">Changer de poste</a>
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
    <script src="{{ asset('asset/js/demo/datatables-demo.js') }}"></script>
    <script src="{{ asset('asset/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('asset/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endsection
