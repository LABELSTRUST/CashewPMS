@extends('layouts.base ')


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
  <h4 class="font-weight-bold py-3 mb-0">Postes</h4>
  <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
          <li class="breadcrumb-item"><a href="#">Postes</a></li>
          <li class="breadcrumb-item active">Créer</li>
      </ol>
  </div>

</div>

<div class="row">
  <div class="col-lg-10" >
    
    <div class="row d-flex justify-content-between " style="margin-bottom: 20px;">
        <div class=" ">
            <a href="{{ route('produit.index') }}" class="btn btn-lg btn-outline-primary mr-3">Produits</a>
            <a class="btn btn-lg btn-outline-primary " href="{{ route('poste.createSection') }}">Section</a>
        </div>
        <div class=" ">
            <a href="{{ route('poste.index') }}" class="btn btn-lg btn-outline-primary">Postes</a>
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
                        @if (isset($poste))
                            <div class="col-lg-8" >
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Modifier un Poste!</h1>
                                    </div>
                                    <form class="user"action="{{ route('poste.update',[$poste->id]) }}" method="POST"  enctype="multipart/form-data">
                                            @csrf
                                        @if(isset($produit))
                                            <div class="form-group">
                                                <input type="text" name="title" required class="form-control " id="title"
                                                    placeholder="Title">
                                                <input type="number" hidden name="produit_id" value="{{$produit->id}}">
                                            </div>
                                            <button class="btn btn-primary btn-user btn-block" type="submit">
                                            Enregistrer
                                            </button>
                                        @else
                                            <div class="form-group row">
                                               <input type="text" name="title"  required value="{{ $poste->title }}" class="form-control " id="title" placeholder="Title">
                                            </div>
                                            
                                            <button class="btn btn-primary btn-user btn-block" type="submit">
                                                Modifier
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="col-lg-8" >
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Créer un Poste!</h1>
                                    </div>
                                    <form class="user"action="{{ route('poste.store') }}" method="POST"  enctype="multipart/form-data">
                                            @csrf
                                        @if(isset($produit))
                                            <div class="form-group">
                                                <input type="text" name="title" required class="form-control " id="title"
                                                    placeholder="Title">
                                                <input type="number" hidden name="produit_id" value="{{$produit->id}}">
                                            </div>
                                            <button class="btn btn-primary btn-user btn-block" type="submit">
                                            Enregistrer
                                            </button>
                                        @else
                                            <div class="form-group row">
                                                
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <input type="text" name="title" required class="form-control " id="title"
                                                        placeholder="Title">
                                                </div>
                                                <div class="col-sm-6">
                                                    <select name="produit_id" required class="form-control"  id="produit_id">
                                                        <option disabled selected>Produit</option>
                                                        @foreach ($produits as $produit)
                                                            <option value="{{ $produit->id }}">
                                                            {{ $produit->code_prod }} {{ $produit->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" hidden name = "nov" value="1">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <select name="section_id" required class="form-control"  id="produit_id">
                                                    <option disabled selected>Section</option>
                                                    @foreach ($sections as $section)
                                                        <option value="{{ $section->id }}">
                                                            {{ $section->designation }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <button class="btn btn-primary btn-user btn-block" type="submit">
                                                Enregistrer
                                            </button>
                                        @endif
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