@extends('layouts.app ')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/myform.css')}}">
@endsection

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
  <h4 class="font-weight-bold py-3 mb-0">Clients</h4>

</div>

<div class="row">
  <div class="col-lg-10" >
    
  <div class="row" style="margin-bottom: 2%;">
            <div class="col-lg-6 col-md-6 col-md-6 ">
                <a href="{{ route('admin_operation.clientindex') }}" class="btn btn-lg btn-outline-primary">Retour</a>
            </div>
         </div>
  </div>

</div>


<div class="row">
    <div class="container">
      
      <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <h1 class="h4 text-gray-900 mb-4">Créer Un Client!</h1>
        </div>
        <div class="card-body">

          @if (isset($client))
            <form class="user"action="{{ route('admin_operation.store_client',$client->id) }}" method="POST"  enctype="multipart/form-data">
                @csrf
                <div class="form-row mb-3">
                  <div class="form-group col-md-3" id="nbr_sacs">
                    <label for="">Nom</label>{{-- {{ isset($origin_prod ) ? $origin_prod->date_recep : '' }} --}}
                    <input type="text" name="name" required class="form-control" value="{{ $client->name }}" id="" placeholder="Nom">
                  </div>
                  <div class="col-md-6">
                      <label for="">Prénom</label>
                      <input type="text" name="first_name" value="{{ $client->first_name }}" required class="form-control " id="" placeholder="Prénom">
                  </div>
                  <div class="col-md-6">
                      <label for="">Entreprise</label>
                      <input type="text" name="company" required class="form-control " id="exampleLastName" value="{{ $client->company}}"
                          placeholder="Entreprise">
                  </div>
                  <div class="col-md-6">
                      <label for="">Position</label>
                      <input type="text" name="position" required class="form-control " id="position" placeholder=" Position" value="{{ $client->position}}">
                  </div>
                  <div class="col-md-6">
                      <label for="">Téléphone</label>
                      <input type="tel" name="tel" required class="form-control" value="{{ $client->tel }}" id="tel"
                          placeholder="Téléphone">
                  </div>
                  <div class="form-group col-md-3" id="nbr_sacs">
                    <label for="">Email</label>
                    <input type="email" name="email" required class="form-control " value="{{ $client->email }}" id="exampleLastName"
                        placeholder=" Email">
                  </div>
                  <div class="col-md-6 mb-3 mb-md-0">
                      <label for="">Pays</label>
                      <input type="text" name="country" required value="{{ $client->country }}" class="form-control " id="exampleUsername"
                          placeholder="Pays">
                  </div>
                  <div class="col-md-6">
                      <label for="">Ville</label>
                      <input type="text" name="city" required class="form-control " id="city" placeholder="Ville" value="{{ $client->city}}">
                  </div>
                  <div class="col-md-6">
                      <label for="">Adresse</label>
                      <input type="text" name="adresse" required class="form-control " id="exampleLastName" value="{{ $client->adresse}}"
                          placeholder="Adresse">
                  </div>

                  
                  <div class="col-md-6">
                      <label for="">Code postal</label>
                      <input type="text" name="postal_code" required class="form-control " id="exampleLastName" value="{{ $client->postal_code}}"
                          placeholder=" Code postal">
                  </div>
                  <div class="col-md-6">
                      <label for="">Categorie</label>
                      <select name="categorie" class="form-control" id="categorie">
                        <option value=""></option>
                        <option value="usine" {{ $client->categorie == 'usine' ? 'selected' : ''}}>Usine</option>
                        <option value="commerce" {{ $client->categorie == 'commerce' ? 'selected' : ''}}>Commerce</option>
                      </select>
                  </div>
            </div>
          @else
            <form class="user"action="{{ route('admin_operation.store_client') }}" method="POST"  enctype="multipart/form-data">
                @csrf
                <div class="form-row mb-3">
                  <div class="form-group col-md-6" id="nbr_sacs">
                    <label for="">Nom</label>{{-- {{ isset($origin_prod ) ? $origin_prod->date_recep : '' }} --}}
                    <input type="text" name="name" required class="form-control " id=""
                        placeholder="Nom">
                  </div>
                  <div class="col-md-6">
                      <label for="">Prénom</label>
                      <input type="text" name="first_name" required class="form-control " id="" placeholder="Prénom">
                  </div>
                  <div class="col-md-6">
                    <label for="">Entreprise</label>
                    <input type="text" name="company" required class="form-control " id="exampleLastName"
                        placeholder="Entreprise">
                  </div>
                  <div class="col-md-6">
                      <label for="">Position</label>
                      <input type="text" name="position" required class="form-control " id="position"
                          placeholder=" Position">
                  </div>
                  <div class="col-md-6">
                      <label for="">Téléphone</label>
                      <input type="tel" name="tel" required class="form-control " id="tel"
                          placeholder="Téléphone">
                  </div>
                  <div class="form-group col-md-6" id="nbr_sacs">
                    <label for="">Email</label>
                    <input type="email" name="email" required class="form-control " id="exampleLastName"
                        placeholder=" Email">
                  </div>
                  <div class="col-md-6 mb-3 mb-md-0">
                      <label for="">Pays</label>
                      <input type="text" name="country" required class="form-control " id="exampleUsername"
                          placeholder="Pays">
                  </div>
                  <div class="col-md-6">
                      <label for="">Ville</label>
                      <input type="text" name="city" required class="form-control " id="city"
                          placeholder="Ville">
                  </div>
                  <div class="col-md-6">
                      <label for="">Adresse</label>
                      <input type="text" name="adresse" required class="form-control " id="exampleLastName"
                          placeholder=" Adresse">
                  </div>
                  <div class="col-md-6">
                      <label for="">Code postal</label>
                      <input type="text" name="postal_code" required class="form-control " id="exampleLastName"
                          placeholder=" Code postal">
                  </div>
                  <div class="col-md-6">
                      <label for="">Categorie</label>
                      <select name="categorie" class="form-control" id="categorie">
                        <option value=""></option>
                        <option value="usine">Usine</option>
                        <option value="commerce">Commerce</option>
                      </select>
                  </div>
                  <div class="col-md-6">
                      <label for="">Code </label>
                      <input type="text" name="code" required class="form-control " id="exampleLastName"
                          placeholder=" Code ">
                  </div>
                </div>
              
          @endif
          

            <button class="btn btn-primary btn-user btn-block" type="submit">
              Enregistrer
            </button>
        </form>
        </div>
      </div>
  
    </div>
  </div>

@endsection
@section('javascript')
<script>
  $('#tel').on('input', function() {
    var telephone = $(this).val().replace(/[^0-9]/g, ''); // supprime tous les caractères non numériques
    var formattedTelephone = '';
    for (var i = 0; i < telephone.length; i++) {
      if (i == 3 || i == 5 || i == 7 || i == 9) {
        formattedTelephone += ' ';
      }
      formattedTelephone += telephone[i];
    }
    $(this).val(formattedTelephone);
  });

</script>
@endsection