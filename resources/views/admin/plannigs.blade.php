@extends('layouts.base')


@section('content')
    <div>
        <h4 class="font-weight-bold py-3 mb-0">Planification</h4>
        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="#">Planification</a></li>
                <li class="breadcrumb-item active">Liste</li>
            </ol>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">
            <div class="row d-flex justify-content-between mb-2">
                <div class="mb-2">
                </div>
                <div class="mb-2">
                    <a href="{{ route('sequence.index') }}" class="btn btn-lg btn-outline-info">Séquences</a>
                </div>
            </div>
            <div class="row">


                <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-info">Liste des Objectifs</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>ID Target</th>
                                        <th>Période</th>
                                        <th>Quantité</th>
                                        <th>Produit</th>
                                        <th>Quantité restante</th>
                                        <th>Action</th>
                                        <!--th>Salary</th-->
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>ID Target</th>
                                        <th>Période</th>
                                        <th>Quantité</th>
                                        <th>Produit</th>
                                        <th>Quantité restante</th>
                                        <th>Action</th>
                                        <!--th>Salary</th-->
                                    </tr>
                                </tfoot>
                                @php
                                    $d = 1;
                                @endphp
                                
                                <tbody>
                                    @foreach ($objectifs as $objectif)
                                        <tr>
                                            <td>{{ $d++ }}</td>
                                            <td>{{ $objectif->id_target }}</td>
                                            
                                            <td>{{ Carbon\Carbon::parse($objectif->obj_date_start)->format('M-d') }} - {{ Carbon\Carbon::parse($objectif->obj_date_end)->format('M-d') }}, {{ Carbon\Carbon::parse($objectif->obj_date_end)->format('Y') }}</td>

                                            <td>{{ $objectif->qte_totale }} {{ $objectif->unit_measure }}</td>
                                            <td>{{ $objectif->getProduit->name }}</td>

                                            <td>
                                                @if ($objectif->obj_remain_quantity)
                                                    {{ $objectif->obj_remain_quantity }} {{ $objectif->unit_measure }}
                                                @elseif($objectif->obj_remain_quantity == 0)
                                                    {{ $objectif->obj_remain_quantity }} {{ $objectif->unit_measure }}
                                                @else
                                                    {{ $objectif->qte_totale }} {{ $objectif->unit_measure }}
                                                @endif

                                            </td>
                                            <td>
                                                @if ($objectif->obj_remain_quantity == 0)
                                                    <button class="btn btn-primary">FAIT</button>
                                                @else
                                                    <a class="btn btn-outline-info"
                                                        href="{{ route('plannifier', [$objectif->id]) }}">Planifier</a>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            {{ $objectifs->links('pagination::bootstrap-4') }}

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
