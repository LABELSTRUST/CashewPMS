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
  <h4 class="font-weight-bold py-3 mb-0">Classification</h4>
  <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
          <li class="breadcrumb-item"><a href="#">Classification</a></li>
      </ol>
  </div>

</div>

<div class="row">
  <div class="col-lg-10" >
    <div class="row d-flex justify-content-between" style="">
      <div class="mb-2">
        <a class="btn btn-info" href="{{route('classification.stock_classification_liste')}}">Retour</a>
      </div>
      <div class="mb-2">
        <a class="btn btn-info" href="{{route('classification.index')}}">Liste</a>
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
        <h4 class="card-title">Classification !</h4>
      </div>
      <div class="card-body">
        
        <form class="user"action="{{ route('classification.store') }}" id="form-data" method="POST"  enctype="multipart/form-data">
          @csrf
          
            <div class="form-row">
              <div class="form-group col-md-4" id="nbr_sacs">
                <label for="">Poids Dépellicullé</label>{{-- {{ isset($origin_prod ) ? $origin_prod->date_recep : '' }} --}}
                  <input type="text"  name="dep_weight" value="{{ isset($remain) ? $remain : $unskinning->weight }}" class="form-control" id="" disabled placeholder="Poids" >
              </div>

              <div class="form-group col-md-4" id="nbr_sacs">
                <label for="">Poids</label>{{-- {{ isset($remain ) ? $remain : $unskinning->weight }} --}}
                  <input type="number" min="0" step="0.01" name="weight" value="" class="form-control" id="weight" placeholder="Poids" >
              </div>
              
              
                <input   type="text" hidden name="unskinning_id" value="{{ $unskinning->id }}">
              
              
              <div class="form-group col-md-4">
                <label for="campagne">Grade </label>
                <select class="form-control" name="grade_id" id="grade_id">
                    <option disabled selected value=""></option>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}">
                            {{ $grade->code }} {{ $grade->designation }}
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
  
  $('#ajouterlocalisation').click(function() {
        var localisation = $("input[name='localisation']").val();
        var calibre_id =  $('#calibre_id2').val();
        var stock_id = $("input[name='stock']").val();
        console.log(stock_id);
        $.ajax({
            type : 'POST',
            url  : '/calibrage/store/localisation',
            data: {
                "_token": "{{ csrf_token() }}",
                localisation : localisation,
                calibre_id : calibre_id,
                stock_id : stock_id
                
            },
            success: function (response) {
                console.log(response);
                console.log('Localisation enregistrer');
                $('#localisation').val('');
                $('#calibre_id2').val('');
            },
            error:function(erreur) {
                console.log(erreur);
            }
        });
    });

</script>


@endsection