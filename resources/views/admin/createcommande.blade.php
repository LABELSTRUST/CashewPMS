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
<div >
  <h4 class="font-weight-bold py-3 mb-0">Commandes</h4>
  <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
          <li class="breadcrumb-item"><a href="#">Commandes</a></li>
          <li class="breadcrumb-item active">Créer</li>
      </ol>
  </div>

</div>

<div class="row">
  <div class="col-lg-10" >
    
  <div class="row" style="margin-bottom: 20px;">
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <a href="{{ route('commande.index') }}" class="btn btn-lg btn-outline-primary">Retour</a>
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
                    <div class="col-lg-8" >
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Créer Une Commande!</h1>
                            </div>
                            <form class="user"action="{{ route('commande.store') }}" method="POST"  enctype="multipart/form-data">
                                    @csrf
                                
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                      <label for="">Quantité</label>
                                        <input type="number" name="quantity" class="form-control "
                                            id="quantity" placeholder="Quantité" required>
                                    </div>
                                    <div class="col-sm-6">
                                      <label for="">Date de livraison</label>
                                      <input type="date" name="date_liv" class="form-control "required
                                            id="quantity" placeholder= "Date de livraison">
                                    </div>
                                    
                                </div>
                                <div class="form-group row">
                                  <div class="col-sm-6 mb-3 mb-sm-0">
                                      @if($client)
                                        <input type="number" name="client_id" hidden value="{{ $client }}">
                                      @else
                                        <select name="client_id" required class="form-control"  id="client_id">
                                            <option disabled selected>Client</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}">
                                                {{ $client->name }} {{ $client->email }}
                                                </option>
                                            @endforeach
                                        </select>

                                      @endif

                                  </div> 
                                  <div class="col-sm-6">
                                      <select name="produit_id" required class="form-control"  id="produit_id">
                                          <option disabled selected>Produit</option>
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
                    <div class="col-lg-2"></div>
                </div>
            </div>
        </div>

  </div>
</div>

@endsection