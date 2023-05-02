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

<div id="result"></div>

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
  <h4 class="font-weight-bold py-3 mb-0">Décorticage</h4>
  <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
          <li class="breadcrumb-item"><a href="#">Décorticage</a></li>
      </ol>
  </div>

</div>

<div class="row">
  <div class="col-lg-10" >
    <div class="row d-flex justify-content-between" style="">
      <div class="mb-2">
        <a class="btn btn-info" href="{{route('shelling.stock_cooling_liste')}}">Retour</a>
      </div>
      <div class="mb-2">
        <a class="btn btn-info" href="{{route('shelling.index')}}">Liste</a>
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
        <h4 class="card-title">Décorticage !</h4>
      </div>
      <div class="card-body">
        
        <form class="user"action="{{ route('shelling.store') }} " id="form-data" method="POST"  enctype="multipart/form-data">
          @csrf
          
            <div class="form-row">
              <div class="form-group col-md-3" id="nbr_sacs">
                <label for="">Nombre de sacs</label>{{-- {{ isset($origin_prod ) ? $origin_prod->date_recep : '' }} --}}
                  <input type="number" min="0" step="0.1" name="bag_Number" value="" class="form-control" id="bag_Number" placeholder="Nombre de sacs" >
              </div>
              
                <input   type="text" hidden name="cooling_id" value="{{ $cooling->id }}">
              
              <div class="form-group col-md-3">
                <label for="">Kor Avant</label>
                  <input type="text" name="kor_before" class="form-control" id="kor_before" placeholder="Kor Avant" value="{{ $cooling->getFrag?->getCalibrage?->kor }}">
              </div>
              
              <div class="form-group col-md-3">
                <label for="">Outil utilisé</label>
                <select class="form-control " name="tool" id="tool">
                  <option value=""></option>
                  <option value="machine">Machine</option>
                  <option value="main">Main</option>
                </select>

              </div>
              <div class="form-group col-md-3">
                <label for="">Capacité</label>
                <input  type="number" name="capacity" min="0" class="form-control " id="capacity" placeholder="Capacité" value=""> 
                
              </div>
            </div>
            
            <div class="form-row "id="tools_ca">
              <div class="form-group col-md-6" >
                <label for="">Quantité Amandes entières</label>
                <input type="text" name="amande_entiere"class="form-control " id="amande_entiere" placeholder="Poids" value="">


              </div>
              <div class="form-group col-md-6">
                <label for="">Quantité Amandes brisées </label>
                  <input  type="text" name="amande_brise" class="form-control " id="amande_brise" placeholder="Poids" value="">


              </div>
            </div>
          
          <button class="btn btn-primary btn-user btn-block"  type="submit">
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
  
  /* $(document).ready(function() {
        $('#form-data').on('submit', function(event) {
            event.preventDefault();
           
              var bag_Number = $("input[name='bag_Number']").val();
              var cooling_id = $("input[name='cooling_id']").val();
              var sub_batch_caliber = $("#sub_batch_caliber").val();
              var weight = $("input[name='weight']").val();
              var tool = $("#tool").val();
              var capacity = $("input[name='capacity']").val();
              $.ajax({
                  type : 'POST',
                  url  : '/operateur/shelling/process',
                  data: {
                      "_token": "{{ csrf_token() }}",
                      bag_Number : bag_Number,
                      cooling_id : cooling_id,
                      sub_batch_caliber : sub_batch_caliber,
                      weight : weight,
                      tool : tool,
                      capacity : capacity,
                  },
                  success: function (response) {
                      console.log(response);
                      $("#nbr_sacs").hide();
                      $("#sub_batch_caliber").val('');
                      $("#tool").hide('');
                      $("#weight").val('');
                      $("#tools_ca").hide();
                      $("#result").html('<div class="alert alert-dark-success alert-dismissible fade show"  ><button type="button" class="close" data-dismiss="alert" >x</button><strong>Enregistré avec succès </strong></div>');
                  },
                  error:function(erreur) {
                      console.log(erreur);
                  }
              });
          
        });
  }); */
</script>


@endsection