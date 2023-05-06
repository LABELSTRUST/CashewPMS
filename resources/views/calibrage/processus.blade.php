
@extends('layouts.base')


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
<h4 class="font-weight-bold py-3 mb-0">Calibrage</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Calibrage</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>



<div class="row">
  
        <div class="row col-lg-10 d-flex justify-content-between" style="margin-bottom: 2%;">
            <div class="mb-2">
                <a href="{{ route('stock_dispo_op' ) }}"  class="btn btn-lg btn-outline-info">Retour</a>
            </div>
            <div class="mb-2" >
                <a href="{{ route('calibrage.index',[$stock]) }}" class="btn btn-lg btn-outline-info">Stocks calibrés</a>
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
                  <div class="col-sm-8 col-md-8 col-lg-8" >
                      <div class="p-5">
                        
                      <h1 class="h4 text-gray-900 text-center mb-4">Activités et bonnes pratiques du calibrage </h1>
                        <div class="card mb-1" >
                            <div class="card-body">
                              <h5 class="card-title">1. Alimentation de la calibreuse</h5>
                              
                              <div class="d-flex justify-content-between" id="c1">
                                <p class="card-text">Confirmer le poids net du stock</p><button class="btn btn-info btn-sm btn-xs mb-1"  data-toggle="modal" data-target="#c01">Fait</button>
                              </div>
                              <div class="d-flex justify-content-between" id="c2">
                                <p class="card-text">Choisir la machine</p><button class="btn btn-info btn-sm btn-xs  mb-1" data-toggle="modal" data-target="#c02">Fait</button>
                              </div>
                              
                            </div>
                        </div>
                        <div class="card mb-1" >
                            <div class="card-body">
                              <h5 class="card-title">2. Calibrage</h5>
                              
                              
                              <div class="d-flex justify-content-between" id="c3">
                                <p class="card-text">Démarrer la machine et peser les noix par calibre</p><button class="btn btn-info btn-sm btn-xs mb-1" data-toggle="modal" data-target="#c03">Fait</button>
                              </div>
                              <div class="d-flex justify-content-between" id="c5">
                                <p class="card-text">Poids rejets</p><button class="btn btn-info btn-sm btn-xs mb-1"  data-toggle="modal" data-target="#c05">Fait</button>
                              </div>
                              <!--div class="d-flex justify-content-between" id="c4">
                                <p class="card-text">Pesage des noix calibrées</p><button class="btn btn-info btn-sm btn-xs mb-1" onclick="changeColor('c3','c4')">Fait</button>
                              </div-->
                            
                            </div>
                        </div>
                        <div class="card mb-1" >
                            <div class="card-body">
                              <h5 class="card-title">3. Stockage des noix calibrés</h5>
                              <div class="d-flex justify-content-between" id="c6">
                                <p class="card-text">Transport des noix dans le magasin</p><button id="ajouterc4" data-toggle="modal" data-target="#c04" class="btn btn-info btn-sm btn-xs mb-1" onclick="changeColor('c5','c6')">Fait</button>
                              </div>
                              {{-- <div class="d-flex justify-content-between" id="c7">
                                <p class="card-text">Empiler les sacs de noix</p><button data-toggle="modal" data-target="#c04"  class="btn btn-info btn-sm btn-xs mb-1" >Fait</button>
                              </div> --}}
                              
                              
                            </div>
                        </div>
                      </div>
                  </div>
                  <div class="col-lg-2"></div>
              </div>
          </div>
      </div>
  </div>
</div>



<div class="modal fade" id="c05" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        <label for="campagne">Poids rejets</label>
                        <input type="number" class="form-control" min=0 name="rejection_weight" required id="rejection_weight" placeholder="Poids rejets" value="">
                        <input type="text" name="stock" id="stock" hidden value="{{ $stock}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-primary ajouter" id="ajouterc5" data-dismiss="modal" onclick="changeColor('c3','c5')"  href="">Valider</a>
                </div>
            </div>
        </div>
</div>

<div class="modal fade" id="c01" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        <label for="net_weight">Poids net du stock </label>
                        <input type="number" class="form-control" min=0 name="net_weight" required id="net_weight" placeholder="Poids net du stock" value="">
                        <input type="text" name="stock" hidden value="{{$stock}}">
                    </div>

                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-primary ajouter" id="ajouterc1" data-dismiss="modal" onclick="changeColor('','c1')"  href="">Valider</a>
                </div>
            </div>
        </div>
</div>
<div class="modal fade" id="c02" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        <select class="form-control" name="name_seizer" id="name_seizer">
                            <option disabled selected value="">Calibreuse</option>
                            @foreach($graders as $grader)
                                <option value="{{ $grader->designation }}">
                                    {{ $grader->code_calibreuse }} {{ $grader->designation }}
                                </option>
                            @endforeach
                        </select>
                        
                        <input type="text" name="stock" id="stock" hidden value="{{ $stock}}">
                    </div>

                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-primary ajouter" id="ajouterc2" data-dismiss="modal" onclick="changeColor('c1','c2')"  href="">Valider</a>
                </div>
            </div>
        </div>
</div>
<div class="modal fade" id="c03" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        <label for="campagne">Calibre </label>
                        <select class="form-control" name="calibre_id" id="calibre_id1">
                            <option disabled selected value=""></option>
                            @foreach($calibres as $calibre)
                                <option value="{{ $calibre->id }}">
                                    {{ $calibre->code_calibre }} {{ $calibre->designation }}
                                </option>
                            @endforeach
                        </select>
                        <label for="campagne">Poids par calibre </label>
                        <input type="number" class="form-control" min=0 name="caliber_weight" required id="caliber_weight" placeholder="Les différents poids par calibre " value="">
                        <input type="text" hidden name="stock" value="{{ $stock}}">
                        {{-- <label for="campagne">Poids rejets</label>
                        <input type="number" class="form-control" min=0 name="rejection_weight" required id="rejection_weight" placeholder="Poids rejets" value=""> --}}
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <button class="btn btn-info" type="button" id="ajouterpoids">Ajouter</button>
                    <a class="btn btn-success ajouter" id="ajouterc3" data-dismiss="modal" onclick="changeColor('c2','c3')"  href="">Valider</a>
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
                        <label for="campagne">Calibre </label>
                        <select class="form-control" name="calibre_id" id="calibre_id2">
                            <option disabled selected value=""></option>
                            @foreach($calibres as $calibre)
                                <option value="{{ $calibre->id }}">
                                    {{ $calibre->code_calibre }} {{ $calibre->designation }}
                                </option>
                            @endforeach
                        </select>
                        <label for="campagne">Localisation </label>
                        <input type="text" class="form-control" name="localisation" required id="localisation" placeholder="Localisation " value="">
                        <input type="text" hidden name="stock" value="{{ $stock}}">
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <button class="btn btn-info" type="button" id="ajouterlocalisation">Ajouter</button>
                    <a class="btn btn-success ajouter" id="ajouterc4" data-dismiss="modal" onclick="changeColor('c6','c7')"  href="">Valider</a>
                </div>
            </div>
        </div>
</div> {{----}}


@endsection

@section('javascript')

<script src="{{ asset('assets/js/jquery-3.6.3.js')}}" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
<script>
    $('#ajouterpoids').click(function() {
        var caliber_weight = $("input[name='caliber_weight']").val();
        var calibre_id =  $('#calibre_id1').val();
        var stock_id = $("input[name='stock']").val();
        $.ajax({
            type : 'POST',
            url  : '/calibrage/store/weight/register',
            data: {
                "_token": "{{ csrf_token() }}",
                caliber_weight : caliber_weight,
                calibre_id : calibre_id,
                stock_id : stock_id,
                
            },
            success: function (response) {
                console.log(response);
                console.log('Calibrage enregistrer');
                $('#caliber_weight').val('');
                $('#calibre_id1').val('');
            },
            error:function(erreur) {
                console.log(erreur);
            }
        });
    });

    
    $('#ajouterc5').click(function() {
        var stock_id = $("input[name='stock']").val();
        var rejection_weight = $("input[name='rejection_weight']").val();
        $.ajax({
            type : 'POST',
            url  : '/calibrage/store/weight/caliber',
            data: {
                "_token": "{{ csrf_token() }}",
                rejection_weight : rejection_weight,
                stock_id : stock_id,
                
            },
            success: function (response) {
                console.log(response);
                console.log('Calibrage enregistrer');
                $('#rejection_weight').val('');
            },
            error:function(erreur) {
                console.log(erreur);
            }
        });
    });
    
    /* 'name_seizer',
        'rejection_weight',
        'net_weight',
        'caliber_weight',
        'localisation',
        'stock_id',
        'author_id',
        'calibre_id',
        'id_lot_calibre' */
    
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

    
    
    $('#ajouterc4').click(function() {
        var stock_id = $("input[name='stock']").val();

        $.ajax({
            type : 'get',
            url  : '/operateur/stock/calibre/valider',
            success: function (response) {
                console.log(response);
                location.reload(true);
            },
            error:function(erreur) {
                console.log(erreur);
            }
        });
    });
    
    $('#ajouterc2').click(function() {
        var name_seizer = $("#name_seizer").val();
        var stock_id = $("input[name='stock']").val();
        

        $.ajax({
            type : 'POST',
            url  : '/calibrage/store/weight/caliber',
            data: {
                "_token": "{{ csrf_token() }}",
                name_seizer : name_seizer,
                stock_id : stock_id
            },
            success: function (response) {
                console.log(response);
                console.log('Nom de la calibreuse enregistré');
            },
            error:function(erreur) {
                console.log(erreur);
            }
        });
    });

    $('#ajouterc1').click(function() {
        var net_weight = $("input[name='net_weight']").val();
        var stock_id = $("input[name='stock']").val();

        $.ajax({
            type : 'POST',
            url  : '/calibrage/store/weight/caliber',
            data: {
                "_token": "{{ csrf_token() }}",
                net_weight : net_weight,
                stock_id : stock_id
            },
            success: function (response) {
                console.log(response);
                console.log('Poids net du stock');
            },
            error:function(erreur) {
                console.log(erreur);
            }
        });
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