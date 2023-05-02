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
        
            <!--div class="col-lg-6">
                <a href="{{ route('operateur.list') }}" class="btn btn-xl btn-outline-primary">Retour</a>
            </div-->
        
        <div class="col-lg-6 col-md-6 col-sm-6 ">
            <a href="{{ route('planning.index') }}" class="btn btn-lg btn-outline-primary">Retour</a>
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
                      @if(isset($sequence_plan))
                      <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Ajouter Séquence</h1>
                        <form class="user"action="{{ route('planning.addsequence') }}" method="POST"  enctype="multipart/form-data">
                         
                          @csrf
                            <div class="form-group row">
                              <input type="text" name="planning" value="{{ $sequence_plan->id }}" hidden>
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="">Date début</label>
                                    <input type="datetime-local" name="date_start" class="form-control "
                                            id="date_start" placeholder="Date début">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Date fin</label>
                                    <input type="datetime-local" name="date_end" class="form-control "
                                            id="date_end" placeholder="Date fin">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                  <label for="">Quantité restante à produire</label>
                                      <input type="number" disabled min=0 name="quantity_remain" class="form-control "
                                      id="quantity" value="{{ $remain_quantity }}" placeholder="Quantité Restante">
                                </div>
                                <div class="col-sm-6">
                                  <label for="">Quantité attendue</label>
                                  <input type="number" min=0 name="quantity" class="form-control "
                                          id="quantity" placeholder="Quantité attendue">
                                </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="">Shift</label>
                                <select name="shift_id" class="form-control " id="shift_id">
                                    <option disabled selected >Shift</option>
                                    @foreach ($shifts as $shift)
                                        <option value="{{ $shift->id }}">
                                            {{ $shift->title }} 
                                        </option>
                                    @endforeach
                                </select>
                              </div>
                              <div class="col-sm-6">
                                <label for="">Date Livraison</label>
                                  <input type="datetime-local" name="date_livraison" value="{{ $sequence_plan->getCommande->date_liv }}" class="form-control"
                                          id="date_livraison" disabled placeholder="Date début">
                              </div>
                            </div>

                          <button class="btn btn-primary btn-user btn-block" type="submit">
                            Enregistrer
                          </button>
                        </form>
                      </div>

                      @elseif(isset($planning))
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Modifier un Planification!</h1>
                            </div>
                            <form class="user"action="{{ route('planning.update',[$planning->id]) }}" method="POST"  enctype="multipart/form-data">
                          @method('PUT')
                                    @csrf

                                    <div class="form-group row"> 
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <select name="commande_id" class="form-control " id="commande_id">
                                                <option disabled  selected value="">Commande</option>
                                                @foreach ($commandes as $commande)
                                                    <option value="{{ $commande->id }}" {{ $planning->commande_id === $commande->id ? 'selected' : '' }}>
                                                        {{ $commande->code }} {{ $commande->getProduit->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            
                                        </div>
                                        <div class="col-sm-6">
                                          <select name="ligne_id" class="form-control " id="ligne_id">
                                              <option disabled selected >Ligne</option>
                                              @foreach ($lignes as $ligne)
                                                  <option value="{{ $ligne->id }}">
                                                      {{ $ligne->code }}  {{ $ligne->name }}
                                                  </option>
                                              @endforeach
                                          </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                      
                                      <div class="col-sm-6 mb-3 mb-sm-0">
                                          <select name="shift_id" class="form-control " id="shift_id">
                                              <option disabled selected >Shift</option>
                                              @foreach ($shifts as $shift)
                                                  <option value="{{ $shift->id }}">
                                                      {{ $shift->title }} 
                                                  </option>
                                              @endforeach
                                          </select>
                                      </div>
                                      
                                      <!--div class="col-sm-6">
                                            <input type="number" min=0 name="quantity" class="form-control "
                                                    id="quantity" placeholder="Quantité attendue">
                                      </div-->
                                    </div>
                                    <!--div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <label for="">Date début</label>
                                            <input type="datetime-local" name="date_start" class="form-control "
                                                    id="date_start" placeholder="Date début">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Date fin</label>
                                            <input type="datetime-local" name="date_end" class="form-control "
                                                    id="date_end" placeholder="Date fin">
                                        </div>
                                    </div-->
                                    
                                
                                <button class="btn btn-primary btn-user btn-block" type="submit">
                                  Enregistrer
                                </button>
                            </form>

                      @elseif(isset($planning)=="" && isset($sequence_plan)=="") 
                      <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Créer une Planification!</h1>
                            </div>
                            <form class="user"action="{{ route('planning.store') }}" method="POST"  enctype="multipart/form-data">
                          
                                    @csrf

                                    <div class="form-group row"> 
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <select name="objectif_id" class="form-control " id="commande_id_plan">
                                                <option disabled  selected value="">Objectifs</option>
                                                @foreach ($objectifs as $objectif)
                                                    <option value="{{ $objectif->id }}" >
                                                         {{ $objectif->getProduit->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            
                                        </div>
                                        <div class="col-sm-6">
                                          <select name="ligne_id" class="form-control " id="ligne_id_plan">
                                              <option disabled selected >Ligne</option>
                                              @foreach ($lignes as $ligne)
                                                  <option value="{{ $ligne->id }}">
                                                      {{ $ligne->code }}  {{ $ligne->name }}
                                                  </option>
                                              @endforeach
                                          </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                      
                                      <div class="col-sm-6 mb-3 mb-sm-0">
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
                                          <input type="number" min=0 name="quantity_commander" class="form-control"
                                               id="quantity_commander" disabled placeholder="Quantité Commander">
                                          <input type="number" min=0 name="quantity_commander" class="form-control"
                                               id="quantity_commander1" value=" " hidden placeholder="Quantité Commander">
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <label for="">Date début</label>
                                            <input type="datetime-local" name="date_start" class="form-control"
                                                    id="date_start_plan" placeholder="Date début">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Date fin</label>
                                            <input type="datetime-local" name="date_end" class="form-control"
                                                    id="date_end_plan" placeholder="Date fin">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <!--div class="col-sm-6 mb-3 mb-sm-0">
                                            <label for="">Date Livraison</label>
                                            <input type="datetime-local" name="date_livraison" class="form-control"
                                                    id="date_livraison" disabled placeholder="Date début">
                                            <input type="datetime-local" name="date_livraison" value=" " class="form-control"
                                                    id="date_livraison1" hidden placeholder="Date début">
                                        </div>
                                      <div class="col-sm-6"-->
                                        <label for="">Quantité attendue</label>
                                            <input type="number" min=0 name="quantity" class="form-control"
                                                    id="quantity_plan" placeholder="">
                                      <!--/div-->
                                    </div>
                                    
                                
                                <button class="btn btn-primary btn-user btn-block" type="submit">
                                  Enregistrer
                                </button>
                            </form>

                      

                      @endif
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
<script src="{{ asset('assets/js/jquery-3.6.3.js')}}" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
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