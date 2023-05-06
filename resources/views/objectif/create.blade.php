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
    @if (session()->has('errors'))
        <div class="alert alert-dark-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div style="margin-left: 50px;">
        <h4 class="font-weight-bold py-3 mb-0">Objectif</h4>
        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="#">Objectif</a></li>
                <li class="breadcrumb-item active">Créer</li>
            </ol>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-10" style="margin-left: 50px;">

            <div class="row" style="margin-bottom: 20px;">
                <div class="col-lg-6">
                    <a href="{{ route('objectif.index') }}" class="btn btn-lg btn-outline-primary">Retour</a>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="container">

            <div class="card o-hidden border-0 mt-5 shadow-lg my-5">
                <div class="card-body  p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-2"></div>

                        <!--div class="col-lg-5 d-none d-lg-block bg-register-image">

                            </div-->
                        @if (isset($objectif))
                            <div class="col-lg-8">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Modifier un Objectif!</h1>
                                    </div>
                                    <form class="user"action="{{ route('objectif.update', [$objectif->id]) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <label for="">Date début</label>
                                                <input required type="date" name="date_start"
                                                    value="{{ $objectif->obj_date_start }}" class="form-control "
                                                    id="date_start" placeholder="Code">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="">Date fin</label>
                                                <input required type="date" name="date_end" class="form-control"
                                                    value="{{ $objectif->obj_date_end }}" id="exampleLastName"
                                                    placeholder="date">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-4 mb-3 mb-sm-0">
                                                <label for="">Quantité</label>
                                                <input required type="number" name="qte_totale"
                                                    value="{{ $objectif->qte_totale }}" class="form-control " min=0
                                                    step="1" id="code" placeholder="Quantite">
                                            </div>
                                            <div class="col-sm-4 mb-3 ">
                                                <label for="">Unité</label>
                                                <input required type="text" name="unit_measure"
                                                    value="{{ $objectif->unit_measure }}" class="form-control " min=0
                                                    step="1" id="code" placeholder="Unité ex : Kg ou L">
                                            </div>
                                            <!--input type="text" hidden name="direct"-->
                                            <div class="col-sm-4">
                                                <label for="">Produit</label>
                                                <select name="produit_id" class="form-control" id="produit_id">

                                                    <option disabled selected>Produit</option>
                                                    @foreach ($produits as $produit)
                                                        <option value="{{ $produit->id }}"
                                                            {{ $objectif->produit_id === $produit->id ? 'selected' : '' }}>
                                                            {{ $produit->produit }} {{ $produit->code_prod }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block" type="submit">
                                            Modifier
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="col-lg-8">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Créer un Objectif!</h1>
                                    </div>
                                    <form class="user"action="{{ route('objectif.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <label for="">Date début</label>
                                                <input required type="date" name="date_start" class="form-control "
                                                    id="code" placeholder="Code">
                                            </div>


                                            <div class="col-sm-6">
                                                <label for="">Date fin</label>
                                                <input required type="date" name="date_end" class="form-control "
                                                    id="exampleLastName" placeholder="date">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-4 mb-3 ">
                                                <label for="">Quantité</label>
                                                <input required type="number" name="qte_totale" class="form-control "
                                                    min=0 step="1" id="code" placeholder="Quantite">
                                            </div>
                                            <div class="col-sm-4 mb-3 ">
                                                <label for="">Unité</label>
                                                <input required type="text" name="unit_measure" class="form-control "
                                                    min=0 step="1" id="code" placeholder="Unité ex : Kg ou L">
                                            </div>
                                            {{-- <input required type="text" hidden name="direct"> --}}
                                            <div class="col-sm-4">
                                                <label for="">Produit</label>
                                                <select name="produit_id" class="form-control" id="produit_id">
                                                    <!--option disabled selected>Produit</option-->
                                                    @foreach ($produits as $produit)
                                                        <option value="{{ $produit->id }}">
                                                            {{ $produit->produit }} {{ $produit->code_prod }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block" type="submit">
                                            Enregistrer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        <div class="col-lg-2"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
