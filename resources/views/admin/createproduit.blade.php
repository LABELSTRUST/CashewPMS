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


<div style="margin-left: 50px;">
  <h4 class="font-weight-bold py-3 mb-0">Produit</h4>
  <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
          <li class="breadcrumb-item"><a href="#">Prouits</a></li>
          <li class="breadcrumb-item active">Créer</li>
      </ol>
  </div>

</div>

<div class="row">
  <div class="col-lg-10" style="margin-left: 50px;">
    
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-lg-6">
            <a href="{{ route('produit.index') }}" class="btn btn-lg btn-outline-primary">Retour</a>
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
                    @if (isset($produit))
                        <div class="col-lg-8" >
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Modifier un Produit!</h1>
                                </div>
                                <form class="user"action="{{ route('produit.update',[$produit->id]) }}" method="POST"  enctype="multipart/form-data">
                                        @csrf
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" name="code_prod" value="{{ $produit->code_prod }}" class="form-control" required id="code" placeholder="Code">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" required name="name" value="{{ $produit->name }}" class="form-control"id="name"placeholder="Name">
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-user btn-block" type="submit">
                                        Modifier
                                    </button>
                                </form>
                            </div>
                        </div>

                    @else
                        <div class="col-lg-8" >
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Créer un Produit!</h1>
                                </div>
                                <form class="user"action="{{ route('produit.store') }}" method="POST"  enctype="multipart/form-data">
                                        @csrf
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" name="code_prod" required class="form-control " id="code"
                                                placeholder="Code">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="name" required class="form-control " id="exampleLastName"
                                                placeholder="Name">
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