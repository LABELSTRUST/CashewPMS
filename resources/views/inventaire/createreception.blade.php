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
  .modal-body {
    max-height: calc(100vh - 110px); /* hauteur maximale de 100% de la fenêtre moins 210px pour la marge */
    overflow-y: auto; /* ajout de débordement de défilement vertical */
  }
  .modal-dialog {
    width: 75%; /* définit la largeur à 90% de la fenêtre */
    max-width: 750px; /* définit la largeur maximale à 1200px */
  }
</style>
@endsection
@section('js')
<script src="{{ asset('assets/js/countries.js')}}"></script>
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
  <h4 class="font-weight-bold py-3 mb-0">Réception</h4>
  <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
          <li class="breadcrumb-item"><a href="#">Réceptionner</a></li>
      </ol>
  </div>

</div>

<div class="row">
  <div class="col-lg-10" >
    <div class="row d-flex justify-content-between" style="margin-bottom: 20px;">
      <div class="mb-2">
        @if (isset($origin_prod->matiere_id))
          <a href="{{ route('stock_receptionner',[$origin_prod->matiere_id]) }}" class="btn btn-lg btn-outline-info">Stock</a>
            
        @else
          <a href="{{ route('stock_receptionner',[$type]) }}" class="btn btn-lg btn-outline-info">Stock</a>
        @endif
          
      </div>

      @if (isset( $origin_prod->date_time_decharge)&& isset($origin_prod->date_charg))
        <div class="mb-2 " >
          <a href="{{ route('reception.fiche',[$origin_prod->id]) }}" class="btn btn-lg btn-outline-info">Fiche</a>
        </div>
        
      @endif

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
        <h4 class="card-title">Réception!</h4>
      </div>
      <div class="card-body">
        
        <form class="user"action="{{ route('reception.store') }}" id="form_reception" method="POST"  enctype="multipart/form-data">
          @csrf
          
          <fieldset id="origin">
            <legend class="">ORIGINE </legend>
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="">Date</label>
                  <input   type="datetime-local" name="date_recep" value="{{ isset($origin_prod ) ? $origin_prod->date_recep : '' }}" class="form-control " id="date" placeholder="date" >
              </div>
              @if (isset($origin_prod) )
                <input   type="text" hidden name="id" value="{{ $type }}">
              @else
                <input   type="text" hidden name="matiere_id" value="{{ $type }}">
              @endif
              
              <div class="form-group col-md-3">
                
                {{--  --}}
                <label for="">Campagne</label>
                <select name="campagne" class="form-control " id="campagne">
                  <option  value=""></option>
                    
                  @foreach ($campaigns as $campaign)
                      <option value="{{ $campaign->id }}" {{ isset($origin_prod ) ? 'selected' : '' }}>
                          {{ $campaign->name }} 
                      </option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-md-3">
                <label for="">Quantité</label>
                  <input  type="number" name="sacks_bought" min="0" class="form-control " id="sacks_bought"
                      placeholder="Nombre" value="{{ isset($origin_prod ) ? $origin_prod->sacks_bought : '' }}">
              </div>
              <div class="form-group col-md-3">
                <label for="">Poids net </label>
                  <input  type="text" name="total_weight" class="form-control " id="total_weight"
                      placeholder="Poids net en Kg" value="{{ isset($origin_prod ) ? $origin_prod->total_weight : '' }}">
              </div>


            </div>

            <div class="form-group row">
              <div class="col-sm-6 mb-3">
                <a class="btn btn-info mb-1 text-white" data-toggle="modal" data-target="#geolocalisation" >Géolocalisation</a>
                <input type="text" class="form-control" name="geolocalisation" id="id_geolocalisation" value="{{ isset($origin_prod ) ? $local : '' }}">
                <input type="text"hidden name="geolocation_id" id="id_geo"  value="{{ isset($origin_prod ) ? $origin_prod->geolocation_id : '' }}">
              </div>
              <div class="col-sm-6 mb-3">
                <button class="btn btn-info mb-1" id="ajouter">Générer</button>
                <label for="">Lot PMS</label>
                  <input  type="text" name="id_lot_pms"  class="form-control " id="id_lot_pms"
                      placeholder="Lot PMS" value="{{ isset($origin_prod ) ? $origin_prod->id_lot_pms : '' }}">
              </div>
            </div>
            
            <div class="form-group row">
              
              <div class="col-sm-6 mb-3">
                <label for="">Fournisseur</label>
                <select name="supplier_id" id="" class="form-control ">
                  <option disabled selected value=""></option>
                  @foreach ($suppliers as $supplier)
                  @if (isset($origin_prod))
                    <option value="{{ $supplier->id }}" {{ $supplier->id == $origin_prod->supplier_id ?  'selected' : '' }}>
                      {{ $supplier->code }} {{ $supplier->company }}
                    </option>
                  @else
                    <option value="{{ $supplier->id }}" >
                      {{ $supplier->code }} {{ $supplier->company }}
                    </option>
                  @endif
                  @endforeach
                </select>
              </div>
              <div class="col-sm-6 mb-3">

                  <label  class="" for="">Id lot fournisseur</label>
                  <input  type="text" name="id_lot_externe" class="form-control " id="id_lot_externe"
                    placeholder="id lot externe" value="{{ isset($origin_prod ) ? $origin_prod->id_lot_externe : '' }}">
                
              </div>
              {{-- <div class="col-sm-6 mb-3">
                <button class="btn btn-info mb-1" id="ajouter">Générer</button>
                <label for="">Lot PMS</label>
                  <input  type="text" name="id_lot_pms"  class="form-control " id="id_lot_pms"
                      placeholder="Lot PMS" value="{{ isset($origin_prod ) ? $origin_prod->id_lot_pms : '' }}">
              </div> --}}
            </div>
            

          </fieldset>
          <fieldset>
            <legend>TRANSFERT </legend>
            <div class="form-row mb-3">
              <div class="form-group col-md-4">
                <label for="">Date de chargement </label>
                  <input  type="datetime-local" name="date_charg" value="{{ isset($origin_prod ) ? $origin_prod->date_charg : '' }}" class="form-control " id="date_charg"
                      placeholder=" id lot externe">
              </div>
              <div class="col-md-4">
                <label for="">Numéro du permis de conduire</label>
                  <input  type="text" name="num_permis" class="form-control " id="num_permis"
                      placeholder="Numéro du permis de conduire" value="{{ isset($origin_prod ) ? $origin_prod->num_permis : '' }}">
              </div>
              <div class="form-group col-md-4">
                <label for="">Nom du chauffeur</label>
                  <input  type="text" name="name_driver" min="0" step="0.01" class="form-control " id="code"
                      placeholder="Nom du chauffeur" value="{{ isset($origin_prod ) ? $origin_prod->name_driver : '' }}">
              </div> 
            </div>{{-- 
            <div class="form-row mb-3">
               <div class="form-group col-md-4">
                <label for="">Poids théorique </label>
                  <input  type="number" name="poids_theorique" min="0" step="0.01" class="form-control " id="poids_theorique"
                      placeholder="Poids Brute théorique" value="{{ isset($origin_prod ) ? $origin_prod->poids_theorique : '' }}">
              </div> 
              <div class="form-group col-md-4">
                <label for="">Marque Camion</label>
                  <input  type="text" name="marque_cam" class="form-control " id="marque_cam"
                      placeholder="Marque Camion" value="{{ isset($origin_prod ) ? $origin_prod->marque_cam : '' }}">
              </div>
              <div class="form-group col-md-4">
                <label for="">Immatriculation Camion</label>
                  <input  type="text" name="immatriculation_camion" class="form-control " id="code"
                      placeholder="Immatriculation Camion" value="{{ isset($origin_prod ) ? $origin_prod->immatriculation_camion : '' }}">
              </div>
            </div> --}}
            <div class="form-group row">
              
              <div class="col-md-4">
                <label for="signature_chauffeur">Signature du Chauffeur</label>
                
                @if(isset( $origin_prod->signature_chauffeur))
                  <img class='imported' style="border: 1px solid #ced4da54;display: block;width: 100%;margin: auto;" src="data:{{ $origin_prod->signature_chauffeur }}"></img>
                  <input  type="hidden" class="form-control" id="signature_chauffeur" name="signature_chauffeur" value="{{ $origin_prod->signature_chauffeur }}">

                @else
                    <div id="signature_chauffeur_div"  style="border: 1px solid #ced4da;"></div>
                    <input  type="hidden" id="signature_chauffeur" name="signature_chauffeur" value="">
                    <button class=" btn btn-info" id="clear_tans">Effacer</button>

                @endif

              </div>
            </div>
            
            
          </fieldset>

          <fieldset>
            <legend>DESTINATION </legend>
            <div class="form-row mb-3">
              
              <div class="form-group col-md-3">
                <label for="">Date et heure de déchargement</label>
                  <input  type="datetime-local" name="date_time_decharge" value="{{ isset($origin_prod ) ? $origin_prod->date_time_decharge : '' }}" class="form-control " id="date_time_decharge">
              </div>
              {{-- <div class="form-group col-md-4">
                <label for="">Pont bascule</label>
                  <input  type="text" name="pont_bascule"  value="{{ isset($origin_prod ) ? $origin_prod->pont_bascule : '' }}"  class="form-control " id="pont_bascule"
                    placeholder="Pont bascule">
              </div> --}}
              <div class="form-group col-md-3">
                <label for="">Usine de déchargement</label>
                <input  type="text" name="port_decharge"  class="form-control " id="port" placeholder="Port/usine de déchargement" value="{{ isset($origin_prod ) ? $origin_prod->port_decharge : '' }}">
              </div>
              <div class="form-group col-md-3">
                <label for="">Quantité déchargée</label>
                  <input  type="number" name="qte_decharge"  class="form-control " id="qte_decharge"
                      placeholder="Nombre "  value="{{ isset($origin_prod ) ? $origin_prod->qte_decharge : '' }}">
              </div>
              <div class="form-group col-md-3">
                <label for="">Poids net </label>
                  <input  type="number" name="net_weight" min="0" step="0.01" class="form-control " id="code"
                      placeholder="Poids net " value="{{ isset($origin_prod ) ? $origin_prod->net_weight : '' }}">
              </div>

            </div>
            
            <div class="form-row mb-3">

              <div class="form-group col-md-3 ">
                  <label for="">Prix Unitaire </label>
                    <input  type="number" name="unit_price" min="0" class="form-control " id="unit_price"
                        placeholder="Prix Unitaire" value="{{ isset($origin_prod ) ? $origin_prod->unit_price : '' }}">
              </div>
              <div class="form-group col-md-3">
                <label for="">Montant Payé</label>
                  <input  type="number" name="amount_paid" min="0" step="0.1" class="form-control " id="amount_paid"
                      placeholder="Montant payé" value="{{ isset($origin_prod ) ? $origin_prod->amount_paid : '' }}">
              </div>

              <div class="form-group col-md-3">
                <label for="">Devise</label>
                <select name="devise" class="form-control"   id="devise">
                  <option value="{{ isset($origin_prod ) ? $origin_prod->devise : '' }}">{{ isset($origin_prod ) ? $origin_prod->devise : '' }}</option>
                  <option value="Euro">Euro</option>
                  <option value="Dollars">Dollars</option>
                  <option value="CFA">CFA</option>
                </select>
              </div>

            </div>
          </fieldset>

          <fieldset>
            <legend>CONTRÔLE QUALITÉ</legend>
            
            <div class="form-row mb-3">
              <div class="form-group col-md-6">
                <label for="Bonnes Amandes, BA (g)">Date contrôle qualité</label>
                <input  type="date" name="date_controle"   value="{{ isset($origin_prod ) ? $origin_prod->date_controle : '' }}" class="form-control" step="0.01" >
              </div>
              <div class="form-group col-md-6 d-flex" >
                <div class="form-group col-md-4 pt-4 justify">
                  @if(isset( $origin_prod->kor))

                  @else
                    <a class="btn btn-info " id="myprocess" href="" >Noix Cajou</a>
                  @endif
                </div><!-- {{ route('processus.index',[$type]) }} -->
              </div>

            </div>
            
            <div class="form-row mb-3">
              <div class="form-group col-md-6">
                  <label for="contrleur">Nom Contôleur</label>
                  <input  type="text" class="form-control" id="nom_controleur" value="{{ isset($origin_prod ) ? $origin_prod->nom_controleur : '' }}" placeholder="Nom Contôleur" name="nom_controleur" >
              </div>
              
              <div class="col-sm-4 md-6 mb-sm-0">
                <label for="signature_controleur">Signature du Contrôleur</label>
                
                @if(isset( $origin_prod->signature_controleur))
                <img class='imported' style="border: 1px solid #ced4da54;display: block;width: 100%;margin: auto;" src="data:{{ $origin_prod->signature_controleur }}"></img>
                <input  type="hidden" class="form-control" id="signature_controleur" name="signature_controleur" value="{{ $origin_prod->signature_controleur }}">

                @else
                  <div id="signature_controleur_div" style="border: 1px solid #ced4da;"></div>
                  <input  type="hidden" class="form-control" id="signature_controleur" name="signature_controleur" value="">
                  <button class="clear btn btn-info" id="clear_control">Effacer</button>

                @endif
              </div>

            </div>
            
            <div class="form-group ">
              
              <label for="">Observation</label>
              <textarea name="observation" class="form-control mytextarea"   id="observation" cols="30" rows="10">{{ isset($origin_prod ) ? $origin_prod->observation : '' }}</textarea>
           
          </div>



          </fieldset>
          <fieldset>
            <legend>STOCKAGE</legend>
            <div class="from-group row mb-3">

              <div class="col-sm-4  mb-sm-0">
                <label for="local">Nom Magasinier</label>
                <input  type="text" name="nom_mag" placeholder="Nom Magasinier" value="{{ isset($origin_prod ) ? $origin_prod->nom_mag : '' }}" class="form-control">
              </div>
              <div class="col-sm-4  mb-sm-0">
                <label for="signature_magasinier">Signature du magasinier</label>
                
              @if(isset($origin_prod->signature_magasinier))
                <img class='imported' style="border: 1px solid #ced4da54;display: block;width: 100%;margin: auto;" src="data:{{ $origin_prod->signature_magasinier }}"></img>
                <input  type="hidden" class="form-control" id="signature_magasinier" name="signature_magasinier" value="{{ $origin_prod->signature_magasinier }}">

                @else
                  <div id="signature_magasinier_div" style="border: 1px solid #ced4da;"></div>
                  <input  type="hidden" id="signature_magasinier" name="signature_magasinier" value="">
                  <button class=" btn btn-info" id="clear_mag">Effacer</button>

                @endif
                

              </div>
              <div class="col-sm-4 mb-3 mb-sm-0">
                <label for="Bonnes Amandes, BA (g)">Localisation dans le magasin</label>
                <input  type="text" name="localisation" class="form-control" value="{{ isset($origin_prod ) ? $origin_prod->localisation : '' }}" placeholder="Localisation dans le magasin">
                
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

<div class="modal fade" id="geolocalisation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Géolocalisation!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                  <!-- resources/views/form.blade.php -->
                  <form id="form_geo">
                    @csrf
                    <div class="form-group">
                      <label>Pays</label>
                      <input type="text" name = "country" class="form-control" id="pays">
                      {{-- <label for="region">Region </label>
                      <input type="text" name = "region" class="form-control" id="region"> --}}
                      {{-- <select name="country" class="pays form-control" >
                        <option value="">Sélectionnez le pays</option>
                      </select> --}}
                      <label>Villes/ communes </label>
                      <input type="text" name = "town" class="form-control" id="ville">
                      {{-- <select name="town" class="etat form-control" >
                        <option value="">Sélectionner l'état</option>
                      </select> --}}
                      <label>Quartiers de villes/ Villages</label>
                      <input type="text" name = "neighborhood" class="form-control" id="commune">
                      {{-- <select name="neighborhood" class="ville form-control">
                        <option value="">Sélectionner le Quartier</option>
                      </select> --}}
                    </div>
                    
                  </form>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <button class="btn btn-primary ajouter" id="ajouterGeo" data-dismiss="modal" >Valider</button>
                </div>
            </div>
        </div>
</div>


@endsection

@section('javascript')


<script src="{{ asset('assets/jsignature/libs/jSignature.min.noconflict.js')}}"></script>

<script>
  

  $(document).ready(function() {

    $("#myprocess").click(function(event) {
      event.preventDefault();
    
      let data = {
        "_token": "{{ csrf_token() }}",
        date_recep: $("input[name='date_recep']").val(),
        matiere_id: $("input[name='matiere_id']").val(),
        campagne: $("input[name='campagne']").val(),
        rep_usine: $("input[name='rep_usine']").val(),
        cooperative: $("input[name='cooperative']").val(),
        sacks_bought: $("input[name='sacks_bought']").val(),
        sack_transmit: $("input[name='sack_transmit']").val(),
        id_lot_externe: $("input[name='id_lot_externe']").val(),
        id_lot_pms: $("input[name='id_lot_pms']").val(),
        total_weight: $("input[name='total_weight']").val(),
        unit_price: $("input[name='unit_price']").val(),
        amount_paid: $("input[name='amount_paid']").val(),
        devise: $("select[name='devise']").val(),
        date_charg: $("input[name='date_charg']").val(),
        name_transporter: $("input[name='name_transporter']").val(),
        nb_sacks: $("input[name='nb_sacks']").val(),
        poids_theorique: $("input[name='poids_theorique']").val(),
        marque_cam: $("input[name='marque_cam']").val(),
        immatriculation_camion: $("input[name='immatriculation_camion']").val(),
        name_driver: $("input[name='name_driver']").val(),
        num_permis: $("input[name='num_permis']").val(),
        date_time_decharge: $("input[name='date_time_decharge']").val(),
        name_export: $("input[name='name_export']").val(),
        port_decharge: $("input[name='port_decharge']").val(),
        code_export: $("input[name='code_export']").val(),
        pont_bascule: $("input[name='pont_bascule']").val(),
        name_magasin: $("input[name='name_magasin']").val(),
        qte_decharge: $("input[name='qte_decharge']").val(),
        nb_sac_return: $("input[name='nb_sac_return']").val(),
        brut_weight: $("input[name='brut_weight']").val(),
        net_weight: $("input[name='net_weight']").val(),
        signature_magasinier:$("input[name='signature_magasinier']").val(),
        localisation:$("input[name='localisation']").val(),
        signature_transporteur:$("input[name='signature_transporteur']").val(),
        signature_controleur:$("input[name='signature_controleur']").val(),
        signature_chauffeur:$("input[name='signature_chauffeur']").val(),
        observation:$("input[name='observation']").val(),
        nom_mag: $("input[name='nom_mag']").val(),
        nom_controleur: $("input[name='nom_controleur']").val(),
        date_controle:$("input[name='date_controle']").val(),
      };
      console.log(data);
        $.ajax({
                url: '/session/store/origin/data',
                method: 'POST',
                data: data,
                success: function (response) {
                    console.log('ça a marché');
                    console.log(response);
                    
                  window.location.href = "/inventaire/produits/kor/"+ $("input[name='matiere_id']").val();
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });

      
    });


  });
</script>

<script>
  $(document).ready(function() {
    
     $("#signature_transporteur_div").jSignature()

    $("#signature_transporteur_div").bind('change', function(e){
      var dataToBeSavedChf =  $("#signature_transporteur_div").jSignature("getData","svgbase64");
      $("#signature_transporteur").val(dataToBeSavedChf);
    })
    
    let sigdiv_trans = $("#signature_chauffeur_div").jSignature()

    $("#signature_chauffeur_div").bind('change', function(e){
      var dataToBeSavedMag =  $("#signature_chauffeur_div").jSignature("getData","svgbase64");
      $("#signature_chauffeur").val(dataToBeSavedMag);
    })
    $('#clear_tans').click(function (event) {
      event.preventDefault();
      sigdiv_trans.jSignature("reset");

    });
    

    let $sigdiv_mag =  $("#signature_magasinier_div").jSignature()

    $("#signature_magasinier_div").bind('change', function(e){
      var dataToBeSavedMag =  $("#signature_magasinier_div").jSignature("getData","svgbase64");
      $("#signature_magasinier").val(dataToBeSavedMag);
    })

    $('#clear_mag').click(function (event) {
      event.preventDefault();
      $sigdiv_mag.jSignature("reset");

    });

    let $sigdiv_control = $("#signature_controleur_div").jSignature()

    $("#signature_controleur_div").bind('change', function(e){
      var dataToBeSavedCon =  $("#signature_controleur_div").jSignature("getData","svgbase64");
      $("#signature_controleur").val(dataToBeSavedCon);
    })

    
    $('#clear_control').click(function (event) {
      event.preventDefault();
      $sigdiv_control.jSignature("reset");

    });

  })
</script>
{{-- <script>
  $(document).ready(function() {
    let USERNAME = "achile";
    let COUNTRY_INFO_API = "https://secure.geonames.org/countryInfoJSON";
    let SEARCH_API = "https://secure.geonames.org/searchJSON";

    // Récupérer les pays
    $.ajax({
      url: COUNTRY_INFO_API,
      data: {
        username: USERNAME
      },
      success: function(result) {
        // Ajouter les options au menu déroulant
        $.each(result.geonames, function() {
          $("#pays").append($("<option />").val(this.countryName).text(this.countryName));
        });
      },
      error: function(error) {
        console.error(error);
      }
    });

    $("#pays").change(fetchCities);
    // Récupérer les villes

    function fetchCities() {
      q= $("#pays option:selected").text();
      console.log(q);
      $.ajax({
        url: SEARCH_API,
        data: {
          q: $("#pays option:selected").text(),
          featureClass: "P",
          username: USERNAME
        },
        success: function(result) {
          // Ajouter les options au menu déroulant
          $("#ville").empty();
          $.each(result.geonames, function() {
            $("#ville").append($("<option />").val(this.name).text(this.name));
          });
        },
        error: function(error) {
          console.error(error);
        }
      });
    }


    // Récupérer les communes
    function fetchCommunes() {
      $.ajax({
        url: SEARCH_API,
        data: {
          q: $("#ville option:selected").text(),
          featureClass: "P",
          username: USERNAME
        },
        success: function(result) {
          // Ajouter les options au menu déroulant
          $("#commune").empty();
          $.each(result.geonames, function() {
            $("#commune").append($("<option />").val(this.name).text(this.name));
          });
        },
        error: function(error) {
          console.error(error);
        }
      });
    }

    $("#ville").change(fetchCommunes);
  });


</script> --}}

<script>
  function capitalizeInput(id) {
    const input = document.getElementById(id);
    input.addEventListener('input', function() {
      let val = this.value.toLowerCase().split(' ');
      for (let i = 0; i < val.length; i++) {
        val[i] = val[i].charAt(0).toUpperCase() + val[i].slice(1);
        if (val[i].includes('-')) {
          let splitVal = val[i].split('-');
          for (let j = 0; j < splitVal.length; j++) {
            splitVal[j] = splitVal[j].charAt(0).toUpperCase() + splitVal[j].slice(1);
          }
          val[i] = splitVal.join('-');
        }
      }
      this.value = val.join(' ');
    });
  }



  capitalizeInput('pays');
  capitalizeInput('ville');
  capitalizeInput('commune');
  capitalizeInput('region');

</script>


<script src="{{ asset('assets/js/origin.js')}}"></script>
{{-- 
<script src="{{ asset('assets/js/countries.js')}}"></script> --}}

@endsection