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




  /* 
$(document).ready(function() {
  // Récupérer les pays
 // Récupérer les pays
  $.ajax({
    url: "https://api.worldbank.org/v2/country/?format=json&per_page=304",
    success: function(result) {
      $.each(result[1], function(index, pays) {
        $("#pays").append($("<option />").val(pays.name).text(pays.name));
      });
    }
  });


  // Récupérer les villes$("#pays").change(function() {
  $.ajax({
    url: "https://nominatim.openstreetmap.org/search?format=json&countrycodes=" + $("#pays option:selected").val() + "&q=",
    success: function(result) {
      console.log($("#pays option:selected").val());
      $("#ville").empty();
      $.each(result, function(index, ville) {
        if (ville.type === "city") {
          $("#ville").append($("<option />").val(ville.display_name).text(ville.display_name));
        }
      });
    }
  });


  // Récupérer les quartiers de villes
  $("#ville").change(function() {
    $.ajax({
      url: "https://nominatim.openstreetmap.org/search?format=json&countrycodes=&q=" + $("#ville option:selected").val(),
      success: function(result) {
        $("#commune").empty();
        $.each(result, function(index, commune) {
          if (commune.type === "administrative") {
            $("#commune").append($("<option />").val(commune.display_name).text(commune.display_name));
          }
        });
      }
    });
  });
});



   */