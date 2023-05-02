
@extends('layouts.base')
@section('css')

<link rel="stylesheet" href="{{ asset('assets/css/countdown.css')}}">

    
<style type="text/css">
    .countdown-v{
      border: 1px solid gray !important; display: flex; align-items: center; padding: 10px; margin: 10px;
    }
    .red{
      color: red;
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

<div style="margin-bottom: 2%;">
<h4 class="font-weight-bold py-3 mb-0">Cuisson</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Cuisson</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>



<div class="row">
  
        <div class="row col-lg-10 d-flex justify-content-between" style="margin-bottom: 2%;">
            <div class="mb-2">
                <a href="{{ route('fragilisation.stock_calib_liste' ) }}"  class="btn btn-lg btn-outline-info">Retour</a>
            </div>
            <div class="mb-2" >
                <a href="{{ route('fragilisation.index',[$stock]) }}" class="btn btn-lg btn-outline-info">Cuisson en cours</a>
            </div>
         </div>
  <div class="container">
    
      <div class="card o-hidden border-0 mt-5 shadow-lg my-5">
          <div class="card-body  p-0">
              <!-- Nested Row within Card Body -->
              <div class="row">
                  <div class="col-lg-2"></div>
                  
                  <!--div class="col-lg-5 d-none d-lg-block bg-register-image">

                      </div-->
                  <div class="col-8 col-sm-8 col-md-8 col-lg-8" >
                      <div class="p-5">
                        <div id="alert-placeholder"></div>
                        
                      <h1 class="h4 text-gray-900 text-center mb-4">Activités et bonnes pratiques de cuisson </h1>
                        <div class="card mb-1" >
                            <div class="card-body">
                              <h5 class="card-title">1. Alimentation de la chaudière à eau </h5>
                              
                              <div class="d-flex justify-content-between" id="c1">
                                
                                <p class="card-text">
                                   Nettoyer la zone <br>
                                    Démarrer la chaudière <br>
                                    Contrôler la pression  
                                </p>
                                <p class="card-text"><button class="btn btn-info btn-sm btn-xs mb-1 p-2"  onclick="changeColor('','c1')">Fait</button></p>
                              </div>
                            </div>
                        </div>

                        <div class="card mb-1" >
                            <div class="card-body">
                              <h5 class="card-title">2. Réglage du niveau d'eau  </h5>
                              
                              <div class="d-flex justify-content-between" id="c2">
                                <p class="card-text">Observer le niveau d'eau  </p>
                                <p>
                                  <button class="btn btn-info btn-sm btn-xs p-2 mb-1" data-toggle="modal" onclick="changeColor('c1','c2')" >Fait</button>
                                </p>
                              </div>
                            </div>
                        </div>

                        <div class="card mb-1" >
                            <div class="card-body">
                              <h5 class="card-title">3. Chargement de l'autoclave et Observation du temps de cuisson et pression</h5>
                              <div class="d-flex justify-content-between" id="c3">
                                <p class="card-text"> Peser le lot calibre </p>
                                <p><button data-toggle="modal" data-target="#peser" class="btn btn-info btn-sm btn-xs p-2 mb-1" >Fait</button></p>
                              </div>
                              <div class="d-flex justify-content-between" id="c4">
                                <p class="card-text">Charger les autoclaves <br> 

                                  Lancer le chronomètre <br>
                                  
                                  Vérifier la pression </p>
                                  <p><button data-toggle="modal" data-target="#c04"  class="btn btn-info btn-sm btn-xs p-2 mb-1" >Fait</button></p>
                                  
                              </div>
                              
                              
                            </div>
                        </div>
                      </div>
                  </div>
                  <div class="col-lg-2">
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>



    


<div class="modal fade" id="peser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmer le poids net du lot calibre !</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label for="campagne">Poids du calibre </label>
                        <input type="text" class="form-control" name="net_weigth" required id="net_weigth" placeholder="Poids du calibre  " value="">
                        <input type="text" hidden name="callibre_stock_id" value="{{ $stock}}">
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <button class="btn btn-info" type="button" id="ajouterlocalisation">Confirmer</button>
                    <a class="btn btn-success ajouter" id="ajouterc4" data-dismiss="modal" onclick="changeColor('c2','c3')"  href="">Valider</a>
                </div>
            </div>
        </div>
</div>
<div class="modal fade" id="c04" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label for="campagne">Poids chargé  </label>
                        <input type="text" class="form-control" name="cook_net_weigth" required id="cook_net_weigth" placeholder="Poids chargé " value="">
                        <label for="campagne">Autoclaves </label>
                        <select class="form-control" name="cuiseur_id" id="cuiseur_id2">
                            <option disabled selected value=""></option>
                            @foreach($cuiseurs as $cuiseur)
                                <option value="{{ $cuiseur->id }}">
                                    {{ $cuiseur->designation }}
                                </option>
                            @endforeach {{-- --}}
                        </select>
                        <label for="campagne">Durée </label>
                        <input type="time" class="form-control" name="cooking_time" required id="cooking_time" placeholder="Durée " value="">
                        <label for="campagne">Pression </label>
                        <input type="text" class="form-control" name="pressure" required id="pressure" placeholder="Pression " value="">
                        <input type="text" hidden name="callibre_stock_id" value="{{ $stock}}">
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <button class="btn btn-info" type="button" id="ajouter1">Ajouter</button>
                    <a class="btn btn-success ajouter" id="ajouterc4" data-dismiss="modal" onclick="changeColor('c3','c4')"  href="">Valider</a>
                </div>
            </div>
        </div>
</div>


@endsection

@section('javascript')

<script src="{{ asset('assets/js/jquery-3.6.3.js')}}" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
<script>
    
    
    $('#ajouterlocalisation').click(function() {
        var net_weigth = $("input[name='net_weigth']").val();
        var callibre_stock_id = $("input[name='callibre_stock_id']").val();

        $.ajax({
            type : 'POST',
            url  : '/operateur/fragilisation/process/confirm/weigth',
            data: {
                "_token": "{{ csrf_token() }}",
                net_weigth : net_weigth,
                callibre_stock_id : callibre_stock_id
                
            },
            success: function (response) {
                console.log(response);
                console.log('Confirmé');
                $("#alert-placeholder").html('<div class="alert alert-dark-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" >x</button> Poids confirmé </div>')[0].scrollIntoView({behavior: 'smooth'});
                $('#net_weigth').val('');
                $('#callibre_stock_id').val('');
                

            },
            error:function(erreur) {
                    $("#alert-placeholder").html('<div class="alert alert-dark-warning alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" >x</button> Erreur sur le poids </div>')[0].scrollIntoView({behavior: 'smooth'});
                console.log(erreur);
            }
        });
    });
    
    


        $('#ajouter1').click(function() {
            var net_weigth = $("input[name='net_weigth']").val();
            var callibre_stock_id = $("input[name='callibre_stock_id']").val();
            var cooking_time = $("input[name='cooking_time']").val();
            var pressure = $("input[name='pressure']").val();
            var cuiseur_id = $("#cuiseur_id2").val();
            var cook_net_weigth = $("input[name='cook_net_weigth']").val();
            console.log(cuiseur_id);
            $.ajax({
                type : 'POST',
                url  : '/operateur/fragilisation/process/store',
                data: {
                    "_token": "{{ csrf_token() }}",
                    net_weigth : net_weigth,
                    callibre_stock_id:callibre_stock_id,
                    cooking_time:cooking_time,
                    pressure:pressure,
                    cuiseur_id:cuiseur_id,
                    cook_net_weigth:cook_net_weigth,
                    
                },
                success: function (response) {
                    //timerJS(cooking_time);
                    console.log(response);
                    console.log('Confirmé');
                    $("#alert-placeholder").html('<div class="alert alert-dark-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" >x</button> Enregistrer avec Succès </div>')[0].scrollIntoView({behavior: 'smooth'});
                    $('#net_weigth').val('');
                    $('#callibre_stock_id').val('');
                    $('#cooking_time').val('');
                    $('#pressure').val('');
                    $('#cuiseur_id2').val('');
                    $('#cook_net_weigth').val('');
                },
                error:function(erreur) {
                        $("#alert-placeholder").html('<div class="alert alert-dark-warning alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" >x</button> Une erreur est survenue </div>')[0].scrollIntoView({behavior: 'smooth'});
                    console.log(erreur);
                }
            });  /**/
        });

    
  

  
        function changeColor(preve,id) {
            if (preve=="") {
                var tableRow = document.getElementById(id);
                tableRow.style.backgroundColor = "green";
                tableRow.style.color = "white";
                
            }else if(preve){
                var tableRow = document.getElementById(preve);
                if (tableRow.style.backgroundColor == "green") {
                    var tableRow = document.getElementById(id);
                    tableRow.style.backgroundColor = "green";
                    tableRow.style.color = "white";
                }
            }

        }

</script>
@endsection