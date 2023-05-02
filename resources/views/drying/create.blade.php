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
  <h4 class="font-weight-bold py-3 mb-0">Séchage 1</h4>
  <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
          <li class="breadcrumb-item"><a href="#">Séchage 1</a></li>
      </ol>
  </div>

</div>

<div class="row">
  <div class="col-lg-10" >
    <div class="row d-flex justify-content-between" style="">
      <div class="mb-2">
        <a class="btn btn-info" href="{{route('drying.stock_drying_liste')}}">Retour</a>
      </div>
      <div class="mb-2">
        <a class="btn btn-info" href="{{route('drying.firstDrying')}}">Liste</a>
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
        <h4 class="card-title"> Séchage 1!</h4>
      </div>
      <div class="card-body">
        
        <form class="user"action="{{ route('drying.store') }}" id="form-data" method="POST"  enctype="multipart/form-data">
          @csrf
          
            <div class="form-row">
              <div class="form-group col-md-3" id="nbr_sacs">
                <label for="">Température initiale</label>{{-- {{ isset($origin_prod ) ? $origin_prod->date_recep : '' }} --}}
                  <input type="number" min="0" name="initial_temp" value="" class="form-control" id="initial_temp" placeholder="Température initiale" >
              </div>
              
                <input   type="text" hidden name="shelling_id" value="{{ $shelling->id }}">
              
              <div class="form-group col-md-3">
                <label for="">Heure début</label>
                  <input type="time" name="start_time" class="form-control" id="start_time" placeholder="Heure début" value="">
              </div>
              
              <div class="form-group col-md-3">
                <label for="">Heure fin</label>
                <input type="time" name="end_time" class="form-control" id="end_time" placeholder="Heure fin" value="">
              </div>
              <div class="form-group col-md-3">
                <label for="">Poids avant séchage </label>
                  <input  type="text" name="weigth_before" class="form-control " id="weigth_before" placeholder="Poids avant séchage" value="">
              </div>
            </div>
            
            <div class="form-row "id="tools_ca">
              <div class="form-group col-12" >
                <label for="">Fours</label>
                <select class="form-control " name="four_id" id="four_id">
                    <option  selected value=""></option>
                    @foreach($fours as $four)
                      <option value="{{ $four->id }}">
                          {{ $four->designation }}
                      </option>
                    @endforeach
                </select>
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


$("#start_time").change(function(){
  var heureDepart = $("input[name='start_time']").val();
  var heureDate = new Date('2000-01-01T' + heureDepart + ':00');
  heureDate.setHours(heureDate.getHours() + 2);
  var heureArrivee = heureDate.getHours().toString().padStart(2, '0') + ':' + heureDate.getMinutes().toString().padStart(2, '0');
  $('#end_time').val(heureArrivee);
});

</script>


@endsection