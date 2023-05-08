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
  <h4 class="font-weight-bold py-3 mb-0">Planification</h4>
  <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
          <li class="breadcrumb-item"><a href="#">Planification</a></li>
          <li class="breadcrumb-item active">Créer</li>
      </ol>
  </div>

</div>

<div class="row">
  <div class="col-lg-10" >
    
    <div class="row" style="margin-bottom: 20px;">
        {{-- 
            <!--div class="col-lg-6">
                <a href="{{ route('operateur.list') }}" class="btn btn-xl btn-outline-primary">Retour</a>
            </div--> --}}
        
        <div class="col-lg-6 col-md-6 col-sm-6 ">
            <a href="{{ route('sequence.index') }}" class="btn btn-lg btn-outline-primary">Séquences</a>
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
                                <h1 class="h4 text-gray-900 mb-4">Planifier!</h1>
                            </div>
                            <form class="user"action="{{ route('planning.store') }}" method="POST"  enctype="multipart/form-data">
                          
                                    @csrf

                                    <div class="form-group row">
                                      
                                      <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="">Shift</label>
                                          <select name="shift_id" class="form-control " id="shift_id_plan">
                                              <option disabled selected >Shift</option>
                                              @foreach ($shifts as $shift)
                                                  <option value="{{ $shift->id }}">
                                                      {{ $shift->title }} 
                                                  </option>
                                              @endforeach
                                          </select>
                                      </div>
                                      
                                      <div class="col-sm-6">
                                        
                                        @if($objectif->obj_remain_quantity)
                                          <label for="">Quantité</label>
                                            <input required type="number" min=0 name="quantity_commander" value="{{ $objectif->obj_remain_quantity }}" class="form-control"
                                                id="quantity_commander" disabled placeholder="Quantité Commander">

                                            <input required type="number" name="quantity_commander" hidden value="{{ $objectif->obj_remain_quantity }}">
                                        @else
                                        <label for="">Quantité</label>
                                          <input required type="number" min=0 name="quantity_commander" value="{{ $objectif->qte_totale }}" class="form-control"
                                               id="quantity_commander" disabled placeholder="Quantité Commander">

                                          <input required type="number" name="quantity_commander" hidden value="{{ $objectif->qte_totale }}">

                                        @endif
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <label for="">Date</label>
                                            <input required type="date" name="date_start" class="form-control"
                                                    id="date_start_plan" placeholder="">
                                        </div>
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                          <label for="">Ligne</label>
                                          <select name="ligne_id" class="form-control " id="ligne_id_plan">
                                              <option disabled selected >Ligne</option>
                                              @foreach ($lignes as $ligne)
                                                  <option value="{{ $ligne->id }}">
                                                      {{ $ligne->code }}  {{ $ligne->name }}
                                                  </option>
                                              @endforeach
                                          </select>
                                          <input required type="number" name="objectif_id" hidden value="{{ $objectif->id }}">
                                        </div>
                                    </div>{{-- 
                                    <div class="form-group row"> 
                                          <select name="ligne_id" class="form-control " id="ligne_id_plan">
                                              <option disabled selected >Ligne</option>
                                              @foreach ($lignes as $ligne)
                                                  <option value="{{ $ligne->id }}">
                                                      {{ $ligne->code }}  {{ $ligne->name }}
                                                  </option>
                                              @endforeach
                                          </select>
                                          
                                          <label for="">Quantité à produire</label>
                                              <input required type="number" min=0 name="quantity" class="form-control"
                                                      id="quantity_plan" placeholder="">
                                    </div> --}}
                                    
                                
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
@section('javascript')
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
  $('#commande_id_plan').on('change', function() {
    var commande_id = $(this).val();

    $.ajax({
      type: 'GET',
      url: '/admin/planning/commande/'+commande_id,
      //data: { commande_id: commande_id },
      success: function(response) {
        // Code à exécuter lorsque la requête a réussi
        console.log('Requête réussie !');
        console.log(response);
        $('#quantity_commander').val(response.qte_totale);
        $('#quantity_commander1').val(response.qte_totale);
        /*$('#date_livraison').val(response.date_liv);
        $('#date_livraison1').val(response.date_liv); */
      },
      error: function(error) {
        // Code à exécuter lorsque la requête a échoué
        console.log('Requête échouée !');
        console.log(error);
      }
    });
  });

});

</script>
@endsection