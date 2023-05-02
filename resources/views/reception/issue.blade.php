@extends('layouts.base')
@section('css')
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
<div style="margin-left: 2%;">
    <h4 class="font-weight-bold py-3 mb-0">Stock</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Stock</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>

<div class="row">
    
<div class="col-lg-10" style="margin-left: 2%;">
         <div class="row d-flex justify-content-between mb-3">
             <div class="col-lg-6 col-md-6 col-sm-6 " >
                 <a class="btn btn-info" href="{{route('dashboard')}}">Retour</a>
            </div>{{-- --}}
         </div>
         <div class="row">
            
         <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Stocks  </h6>
                        </div>
                        <div class="card-body ">
                          <form id="search-form" class="mb-3">
                            @csrf
                            <div class="form-row">
                              <div class="form-group col-4">
                                <input type="text" class="form-control" placeholder="Batch ID:" name="batch_id" id="batch_id">
                              </div>
                              <div class="form-group col-4">
                                
                                <button class="btn btn-primary " type="submit"><i class="feather icon-search align-middle"></i></button>
                              </div>
                            </div>
                        
                        
                          </form>
                          <div class="table-responsive" id="search-results">
                           
                          </div>
                        </div>
                    </div>
         </div>
    </div>
</div>

@endsection


@section('javascript')

<script>
$(document).ready(function() {
  $('#search-form').submit(function(e) {
      e.preventDefault(); // empêcher le formulaire d'être soumis normalement

      var formData = $(this).serialize(); // récupérer les données du formulaire

      // envoyer une requête AJAX pour récupérer les résultats de la recherche 
      $.ajax({
          url: "{{ route('reception.searchissue') }}",
          type: "POST",
          data: formData,
          dataType: "json",
          success: function(response) {
              // afficher les résultats de la recherche dans la page
              var resultsHtml = '';
              console.log(response);

                
              if(response) {
                resultsHtml = response.tableau
                  /*resultsHtml += 
                   '<table class="table table-hover table-bordered"><thead><tr><th>Batch ID</th><th>Poids du stock</th></tr></thead><tbody>';

                  resultsHtml += '<tr><td>' + response.depelliculage.unskinning_batch + '</td><td>' + response.depelliculage.weight + '</td></tr>';
                  
                // Récupérez les données renvoyées par le contrôleur
                var data = response.data;

                // Remplissez les cellules du tableau avec les données
                $('#lot_pms').html(data.lot_pms);
                $('#id_fournisseur').html(data.id_fournisseur);
                $('#geolocalisation').html(data.geolocalisation);
                $('#quantite').html(data.quantite);
                $('#poids').html(data.poids);

                  resultsHtml += '</tbody></table>'; */
              } else {
                  resultsHtml = '<p>Aucun résultat trouvé.</p>';
              }
              //$("#mytable").show();
              $('#search-results').html(resultsHtml);
          },
          error:function(erreur) {
            resultsHtml = '<p>Aucun résultat trouvé.</p>';
            $('#search-results').html(resultsHtml);
              console.log(erreur);
          }
      });
  });
});

</script>
@endsection