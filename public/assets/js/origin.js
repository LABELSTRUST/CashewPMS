
$(document).ready(function(){
  $('#ajouter').click(function(event) {
    event.preventDefault();
    //var id_lot_externe = $("input[name='id_lot_externe']").val();
    
    $.ajax({
          url: '/lot/pms/get',
          method: 'GET',
          
          success: function(response) {
              // Traitez la réponse ici
              console.log(response);
            $('#id_lot_pms').val(response);
            console.log($('#id_lot_pms').val());
          },
          
      });
  });
  
  $("#ajouterGeo").click(function(event) {
    event.preventDefault();
    let form = $("#form_geo").serialize();
    console.log(form);
    
    $.ajax({
      url: "/inventaire/geolocalisation",
      method: 'POST',
      data: form,
      success: function (response) {
          console.log('ça a marché');
          $("#id_geolocalisation").val(response.localisation);
          $("#id_geo").val(response.geo_id);
          console.log(response.geo_id);
          console.log(response);
          
      },
      error: function(xhr, status, error) {
          console.log(error);
      }
    });


  });
  
});


$(document).ready(function() {
  $("#myprocess").click(function(event) {
    event.preventDefault();
  
    var data = {
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
     /*if (setdat == 1) {
      
      $.ajax({
        type: "POST",
        url: "{{ route('processus.register') }}",
        data: data,
        success: function(response) {
          console.log('Requête réussie !');
          console.log(response.id);
          window.location.href = "/inventaire/produits/kor/"+ $("input[name='matiere_id']").val();
        },
        error: function() {
          console.log(error);
        }
      });
      
    }else{ */
   
    // }console.log(setdat);

  });
}); 