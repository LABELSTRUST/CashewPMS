@extends('layouts.base ')

@section('css')
<style>
  fieldset{
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    margin-bottom: 0.5rem;
    padding: 0.5rem;
  }
  .mytextarea{
    border: 1px solid #ced4da;
    border-radius: 1px;
  }
  .modal-body {
    max-height: calc(100vh - 210px); /* hauteur maximale de 100% de la fenêtre moins 210px pour la marge */
    overflow-y: auto; /* ajout de débordement de défilement vertical */
  }
  .modal-dialog {
    width: 90%; /* définit la largeur à 90% de la fenêtre */
    max-width: 1200px; /* définit la largeur maximale à 1200px */
  }
    fieldset{
      border: 1px solid #ced4da;
      border-radius: 0.25rem;
      margin-bottom: 0.5rem;
      padding: 0.5rem;
    }
    .mytextarea{
      border: 1px solid #ced4da;
      border-radius: 1px;
    }
    .modal-body {
    max-height: calc(100vh - 210px); /* hauteur maximale de 100% de la fenêtre moins 210px pour la marge */
    overflow-y: auto; /* ajout de débordement de défilement vertical */
  }
  .modal-dialog {
    width: 90%; /* définit la largeur à 90% de la fenêtre */
    max-width: 1200px; /* définit la largeur maximale à 1200px */
  }
  .form-control{
    border: 1px solid rgba(24, 28, 33, 0.1) !important;
    padding: 1px;
  }
  input::-webkit-input-placeholder {
    text-indent: 10px !important;
  }

  input::-moz-placeholder {
    text-indent: 10px !important;
  }

  input::-ms-input-placeholder {
    text-indent: 10px !important;
  }
  input {
    height: 2em !important;
    border-radius: 0.9em !important;
  }
</style>
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
  <h4 class="font-weight-bold py-3 mb-0">Données</h4>
  <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
          <li class="breadcrumb-item"><a href="#">Données</a></li>
      </ol>
  </div>

</div>

<div class="row">
  <div class="col-lg-10" >
    <div class="row d-flex justify-content-between" style="">
      <div class="mb-2">
        <a class="btn btn-info" href="{{route('cooling.index')}}">Retour</a>
      </div>


    </div>
  </div>

</div>

<!-- <div class="text-center">
       <h1 class="h4 text-gray-900 mb-4">Réception!</h1>
    </div> -->
<div class="row">
  <div class="container">
    
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <h4 class="card-title">Données! </h4>
      </div>
      <div class="card-body">
        
        <form class="user"action="{{ route('cooling.store') }}" id="form_reception" method="POST"  enctype="multipart/form-data">
          @csrf
          
          <fieldset id="origin">
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="">Poids net Après cuisson</label>{{-- {{ isset($origin_prod ) ? $origin_prod->date_recep : '' }} --}}
                  <input   type="number" step="0.1" min="0" name="weight_after_cook" value="" class="form-control " id="date" placeholder="Poids net Après cuisson" >
              </div>
              @if (isset($fragilisation) )
                <input   type="text" hidden name="fragilisation_id" value="{{ $fragilisation->id }}">
              @endif
              
              <div class="form-group col-md-4">
                
                {{--  --}}
                <label for="">Poids net Après Refroidissement</label>
                <input   type="number" step="0.1" min="0" name="weight_after_cooling" value="" class="form-control " id="date" placeholder="Poids net Après Refroidissement" >
              </div>
              <div class="form-group col-md-4">
                <label for="">Ecart</label>
                  <input  type="number" name="gap" step="0.1" min="0" class="form-control " id="gap" placeholder="Ecart" value="">
              </div>


            </div>
            
            <div class="form-row ">
              <div class="form-group col-md-6">
                <label for="">Température de début</label>
                  <input  type="number" name="start_temp" step="0.1" min="0" class="form-control " id="start_temp"
                      placeholder="Température de début" value="">
              </div>
              <div class="form-group col-md-6">
                <label for="">Température de fin</label>
                <input  type="number" name="end_temp" step="0.1" min="0" class="form-control " id="end_temp" placeholder="Température de fin" value="">
              </div>
            </div>
          </fieldset>
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




@endsection