
@extends('layouts.base')


@section('content')


<div >
<h4 class="font-weight-bold py-3 mb-0">Réception</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Réception</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>



<div class="row">
    
    <div class="col-md-12" >
         <div class="row" style="margin-bottom: 20px;">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <a href="" id="retour" class="btn btn-lg btn-outline-info">Retour</a>
            </div>
            <!--div class="col-lg-6" style="display: flex; justify-content: flex-end;">id="returnOrigin"
                <a href="{{ route('client.index') }}" class="btn btn-xl btn-outline-info">Gestion des clients</a>
            </div-->
         </div>
         <div class="row">
            
         <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">PROCESSUS DE CONTRÔLE QUALITÉ</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div id="alert-com"></div>
                                <div id="alert-placeholder"></div>

                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Étapes</th>
                                            <th>Activités</th>
                                            <th>Action</th>
                                            <th>N°</th>
                                            
                                            <!--th>Salary</th-->
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Étapes</th>
                                            <th>Activités</th>
                                            <th>Action</th>
                                            <th>N°</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr id="echantillon">
                                            <td rowspan="5">Échantillonnage</td>
                                            <td >Prélèvement de l'échantillon mère</td>
                                            <td> <button class="btn btn-info  mybutton"  onclick="changeColor('','echantillon')">FAIT</button></td>
                                            <td>1</td>
                                        </tr>
                                        <tr id="melange">
                                            <td >Mélanger l'échantillon</td>
                                            <td><button class="btn btn-info mybutton"  onclick="changeColor('echantillon','melange')">FAIT</button></td>
                                            <td>2</td>
                                        </tr>
                                        <tr id="quarts">
                                            <td>Constituer des quarts</td>
                                            <td><button class="btn btn-info"  onclick="changeColor('melange','quarts')">FAIT</button></td>
                                            <td>3</td>
                                        </tr>
                                        <tr id="seaux">
                                            <td>Constituer des échantillons à analyser dans des seaux</td>
                                            <td><button class="btn btn-info"  onclick="changeColor('quarts','seaux')">FAIT</button></td>
                                            <td>4</td>
                                        </tr>
                                        <tr id="prelevernoix">
                                            <td>Prélever un kilogramme (1000 g) de noix</td>
                                            <td><button class="btn btn-info"  onclick="changeColor('seaux','prelevernoix')">FAIT</button></td>
                                            <td>5</td>
                                        </tr>
                                        <tr id="thaux">
                                            <td >Taux d'humidité</td>
                                            <td>Mesurer le taux d'humidité</td>
                                            <td><button class="btn btn-info" data-toggle="modal" data-target="#logoutModal" >FAIT</button> </td>
                                            <td>1</td>
                                        </tr>
                                        <tr id="grainage">
                                            <td rowspan="2">Grainage</td>
                                            <td>Regrouper les noix par petits Tas </td>
                                            <td><button class="btn btn-info"  onclick="changeColor('thaux','grainage')">FAIT</button></td>
                                            <td>1</td>
                                        </tr>
                                        <tr id="nbrtas">
                                            <td>Comptabiliser le nombre de tas </td>
                                            <td><button class="btn btn-info" data-toggle="modal" data-target="#nbrtas1" >FAIT</button> </td>
                                            <td>2</td>
                                        </tr>
                                        <tr id="ouv_noix">
                                            <td rowspan="2">Ouverture des noix</td>
                                            <td>Couper toutes les noix de l'échantillon</td>
                                            <td><button class="btn btn-info"  onclick="changeColor('nbrtas','ouv_noix')">FAIT</button></td>
                                            <td>1</td>
                                        </tr>
                                        <tr id="ctrl_amande">
                                            <td>Contrôle et classification des amandes</td>
                                            <td><button class="btn btn-info"  onclick="changeColor('ouv_noix','ctrl_amande')">FAIT</button></td>
                                            <td>2</td>
                                        </tr>
                                        <tr id="amande_saine">
                                            <td rowspan="4">Pesée</td>
                                            <td>Extraire et peser les amandes saines</td>
                                            <td><button class="btn btn-info" data-toggle="modal" data-target="#amande_saine1" >FAIT</button></td>
                                            <td>1</td>
                                        </tr>
                                        <tr id="coque">
                                            <td>Peser les amandes et coques (50% rejetés)</td>
                                            <td><button class="btn btn-info" data-toggle="modal" data-target="#pique1" >FAIT</button></td>
                                            <td>2</td>
                                        </tr>
                                        <tr id="pique">
                                            <td>Extraire et peser les amandes seules (immatures et piquées)</td>
                                            <td><button class="btn btn-info" data-toggle="modal" data-target="#pique2" >FAIT</button></td>
                                            <td>3</td>
                                        </tr>
                                        <tr id="amande_rejet">
                                            <td>Extraire les amandes + coques (rejetées a 100%)</td>
                                            <td><button class="btn btn-info" data-toggle="modal" data-target="#amande_rejet1" >FAIT</button></td>
                                            <td>4</td>
                                        </tr>
                                        <tr id="taux_default">
                                          <td>Taux de défauts</td>
                                          <td>Calculer le taux de défauts</td>
                                          <td> <a href="" class="btn btn-info" onclick="changeColor('pique','taux_default')" id="genethaux"> FAIT </a></td>
                                            <td>1</td>
                                        </tr>
                                        <tr id="kor">
                                          <td>KOR</td>
                                          <td>Calculer le KOR</td>
                                          <td><a href="" class="btn btn-info" onclick="changeColor('taux_default','kor')" id="genekor"> FAIT </a> </td>
                                            <td>1</td>
                                        </tr>
                                    </tbody>
                                  
                                </table>
                            </div>
                        </div>
                    </div>
         </div>
    </div>
</div>



<div class="modal fade" id="amande_rejet1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        <label for="campagne">Poids des noix rejetées à 100 % </label>
                        <input type="number" class="form-control" min=0 name="p5" required id="amande_rejet" placeholder="Poids des noix rejetées à 100 %" value="">
                    </div>

                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-primary ajouter" id="ajouterp5" data-dismiss="modal" onclick="changeColor('pique','amande_rejet')"  href="">Valider</a>
                </div>
            </div>
        </div>
</div>
<div class="modal fade" id="nbrtas1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        <label for="campagne">Poids des noix prélevés</label>
                        <input type="number" class="form-control" min=0 name="p1" required id="pique_form" placeholder="Poids des noix prélevés" value="">
                    </div>
                    <div class="row">
                        <label for="nbr_noix">Nombre de noix</label>
                        <input type="number" class="form-control" min=0 name="nbr_noix" id="pique_form" placeholder="Nombre de noix" required value="">
                    </div>

                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-primary ajouter" id="ajouterp1" data-dismiss="modal" onclick="changeColor('grainage','nbrtas')"  href="">Valider</a>
                </div>
            </div>
        </div>
</div>
<div class="modal fade" id="pique1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        
                        <label for="campagne">Poids des noix rejetées à 50%</label>
                        <input type="number" class="form-control" min=0 name="p3" id="pique_form" placeholder="Poids des noix rejetées à 50%" value="">

                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-primary ajouter" id="ajouterp3" data-dismiss="modal" onclick="changeColor('amande_saine','coque')" href="">Valider</a>
                </div>
            </div>
        </div>
</div>
<div class="modal fade" id="pique2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        
                        <label for="campagne">Poids des amandes seules (immatures et piquées)</label>
                        <input type="number" class="form-control" min=0 name="p4" id="pique_form" placeholder="Poids des amandes seules (immatures et piquées)" value="">

                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-primary ajouter" id="ajouterp4" data-dismiss="modal" onclick="changeColor('coque','pique')" href="">Valider</a>
                </div>
            </div>
        </div>
</div>
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        
                        
                        <label for="campagne">Taux d'humidité</label>
                        <input type="number" class="form-control" min=0 name="taux_h" id="taux_h" placeholder="Taux d'humidité en %" value="">
                        <input type="text" name="matiere_id" value="{{$origin}} " hidden>

                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-primary " id="ajouterth" data-dismiss="modal" onclick="changeColor('prelevernoix','thaux')" href="" >Valider</a>
                </div>
            </div>
        </div>
</div>
<div class="modal fade" id="amande_saine1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        
                        <label for="p2">Poids des amandes saines</label>
                        <input type="number" class="form-control" min=0 name="p2" id="" placeholder="Poids des amandes saines" value="">

                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-primary" id="ajouterp2" data-dismiss="modal" onclick="changeColor('ctrl_amande','amande_saine')"  href="">Valider</a>
                </div>
            </div>
        </div>
</div>

@endsection

@section('javascript')

    <script src="{{ asset('assets/js/jquery-3.6.3.js')}}" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <script>


    $(document).ready(function() {
        $("#ajouterth").click(function(event) {
            event.preventDefault();
            //console.log($("input[name='taux_h']").val());
            var taux_h;
            if ($("input[name='taux_h']").val() != null) {
            taux_h = $("input[name='taux_h']").val();
            matiere_id = $("input[name='matiere_id']").val();
            
                $.ajax({
                    url: '/session/store',
                    method: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        taux_h:taux_h,
                        matiere_id:matiere_id
                        
                    },
                    success: function (response) {
                        
                        console.log(response);
                        console.log('Value stored in session '+taux_h);
                    }
                });
            if (taux_h > 10) {
                $("#alert-placeholder").html('<div class="alert alert-dark-warning alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" >x</button> Taux d\'humidité :  <strong>Les noix sont exposés à la moisissure</strong> </div>')[0].scrollIntoView({behavior: 'smooth'});
                /* $('#alert-com').html('<div class="alert alert-dark-warning alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" >x</button>Commentaire N°1:</div>')[0].scrollIntoView({behavior: 'smooth'}); */
            } else if (taux_h <= 6) {
                $("#alert-placeholder").html('<div class="alert alert-dark-danger alert-dismissible fade show" ><button type="button" class="close" data-dismiss="alert" >x</button>Taux d\'humidité :<strong>Les noix sont trop sèches et sont également trop fragiles lors de la transformatione</strong> </div>')[0].scrollIntoView({behavior: 'smooth'});
            
            } else {
                $("#alert-placeholder").html('<div class="alert alert-dark-success alert-dismissible fade show" ><button type="button" class="close" data-dismiss="alert">x</button>Taux d\'humidité : <strong>Bon taux</strong> </div>')[0].scrollIntoView({behavior: 'smooth'});
            }
            }
        });

    var p1;
        $("#ajouterp1").click(function(event) {
            event.preventDefault();
            //console.log($("input[name='p2']").val());
            if ($("input[name='p1']").val() != null) {
                p1 = $("input[name='p1']").val();
                nbr_noix = $("input[name='nbr_noix']").val();
                
                $.ajax({
                    url: '/session/store',
                    method: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        p1:p1,
                        nbr_noix:nbr_noix
                    },
                    success: function (response) {
                        console.log('Value stored in session '+ p1);
                    }
                });
                var nbr
                if ($("input[name='nbr_noix']").val() != null) {
                    nbr = $("input[name='nbr_noix']").val();
                    if (nbr<180) {
                        $("#alert-placeholder").html('<div class="alert alert-dark-success alert-dismissible fade show"  ><button type="button" class="close" data-dismiss="alert" >x</button>Grainage : <strong>Excellent</strong></div>')[0].scrollIntoView({behavior: 'smooth'});
                    } else if (nbr>=180 && nbr<190 ) {
                        $("#alert-placeholder").html('<div class="alert alert-dark-success alert-dismissible fade show"  ><button type="button" class="close" data-dismiss="alert" >x</button>Grainage : <strong>Très bon</strong></div>')[0].scrollIntoView({behavior: 'smooth'});
                    }else if (nbr>=190 && nbr<200) {
                        $("#alert-placeholder").html('<div class="alert alert-dark-success alert-dismissible fade show"  ><button type="button" class="close" data-dismiss="alert">x</button>Grainage : <strong>Bon</strong> </div>')[0].scrollIntoView({behavior: 'smooth'});
                    }else if (nbr>=200 && nbr<210) {
                        $("#alert-placeholder").html('<div class="alert alert-dark-warning alert-dismissible fade show"  ><button type="button" class="close" data-dismiss="alert">x</button>Grainage : <strong>Moyen</strong>  </div>')[0].scrollIntoView({behavior: 'smooth'});
                    }else if (nbr>=210 && nbr<220) {
                        $("#alert-placeholder").html('<div class="alert alert-dark-warning alert-dismissible fade show"  ><button type="button" class="close" data-dismiss="alert">x</button>Grainage : <strong>Très moyen</strong>  </div>')[0].scrollIntoView({behavior: 'smooth'});
                    }else if (nbr>=220 && nbr<=230) {
                        $("#alert-placeholder").html('<div class="alert alert-dark-warning alert-dismissible fade show"  ><button type="button" class="close" data-dismiss="alert">x</button>Grainage : <strong>Juste acceptable</strong></div>')[0].scrollIntoView({behavior: 'smooth'});
                    }else if (nbr>230) {
                        $("#alert-placeholder").html('<div class="alert alert-dark-danger alert-dismissible fade show"  ><button type="button" class="close" data-dismiss="alert" >x</button>Grainage : <strong>Mauvais</strong></div>')[0].scrollIntoView({behavior: 'smooth'});
                    }
                }

            }
        })
        var p2;
        $("#ajouterp2").click(function(event) {
            event.preventDefault();
            //console.log($("input[name='p2']").val());
            if ($("input[name='p2']").val() != null) {
                p2 = $("input[name='p2']").val();
                
                $.ajax({
                    url: '/session/store',
                    method: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        p2:p2,
                    },
                    success: function (response) {
                        console.log('Value stored in session'+ p2);
                    }
                    
                });
            
            }
        })
        
        var p3;
        $("#ajouterp3").click(function(event) {
            event.preventDefault();
            //console.log($("input[name='p3']").val());
            if ($("input[name='p3']").val() != null) {
                p3 = $("input[name='p3']").val();
                
                $.ajax({
                    url: '/session/store',
                    method: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        p3:p3,
                    },
                    success: function (response) {
                        console.log('Value stored in session '+ p2);
                    }
                });

            }
        })
        
        var p4;
        $("#ajouterp4").click(function(event) {
            event.preventDefault();
            //console.log($("input[name='p4']").val());
            if ($("input[name='p4']").val() != null) {
                p4 = $("input[name='p4']").val();
                
                $.ajax({
                    url: '/session/store',
                    method: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        p4:p4,
                    },
                    success: function (response) {
                    
                        console.log('Value stored in session '+p4);  
                    }
                });

            }
        });
        $("#ajouterp5").click(function(event) {
            event.preventDefault();
            //console.log($("input[name='p4']").val());
            if ($("input[name='p5']").val() != null) {
                p5 = $("input[name='p5']").val();
                console.log(p5);
                $.ajax({
                    url: '/session/store',
                    method: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        p5:p5,
                        
                    },
                    success: function (response) {
                        console.log('Value stored in session '+p5);  
                    }
                });

            }
        });
        
        $("#genethaux").click(function(event) {
            event.preventDefault();
            //console.log($("input[name='p4']").val());
            $.ajax({
                url: '/session/get/data',
                method: 'GET',
                success: function(response) {
                    response = response.toFixed(2);
                    // Traitez la réponse ici
                    $("#alert-placeholder").html('<div class="alert alert-dark-success alert-dismissible fade show" ><button type="button" class="close" data-dismiss="alert">x</button>Taux de défauts: <strong>'+response+'</strong> </div>')[0].scrollIntoView({behavior: 'smooth'});
                    console.log(response);
                },
                
            });

        });
        $("#genekor").click(function(event) {
            event.preventDefault();
            //console.log($("input[name='p4']").val());
            $.ajax({
                url: '/session/get/data/kor',
                method: 'GET',
                success: function(response) {
                    // Traitez la réponse ici
                    //response = response.toFixed(2);
                    response.kor = Number(response.kor).toFixed(2);
                    $("#alert-placeholder").html('<div class="alert alert-dark-success alert-dismissible fade show" ><button type="button" class="close" data-dismiss="alert">x</button>KOR : <strong>'+response.kor+'</strong> </div>')[0].scrollIntoView({behavior: 'smooth'});
                    console.log(response.kor);
                    

                },
                
            });

            

        });
    
        $("#retour").click(function(event) {
            event.preventDefault();
            //console.log($("input[name='p4']").val());
            $.ajax({
                url: '/session/get/data/kor',
                method: 'GET',
                success: function(response) {
                    window.location.href = "/inventaire/reception/edit/"+ response.origin_id;
                },
                
            });

        });   /* */
        

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