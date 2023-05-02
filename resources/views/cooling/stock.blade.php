@extends('layouts.base')
@section('css')

    <style>
   
  @keyframes scroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(-100%); }
  }
  
  /* Appliquer l'animation au texte dans le bouton */
  .transfert span {
  display: inline-block;
  animation: scroll 5s linear infinite;
  animation-play-state: running;
  }
  .transfert {
  white-space: nowrap;
  text-overflow: clip;
  overflow: hidden;
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
<div >
    <h4 class="font-weight-bold py-3 mb-0">Refroidissement </h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Refroidissement</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>

<div class="row">
    
<div class=" col-lg-10" >
    <div class="row d-flex justify-content-between mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6 " >
            <a class="btn btn-info" href="{{ route('dashboard') }}">Retour</a>
    </div>
    </div> 
    {{-- 
        <div  class="card justify-content-end shadow-sm" style="max-width: 400px; position: fixed; z-index: 1050; bottom:3rem; right: 10px;"  id="countdown">
      <div class="d-flex p-5">
        <h5 id="hours" ></h5>
      <span class="fs-sm" > h</span>
      <h5 id="minutes" >0</h5>
      <span class="fs-sm" >m</span>
      <h5 id="seconds" >0</h5>
      <span class="fs-sm">s</span>
      </div>
</div>
        --}}
    <div class="row pagination-link">
        @foreach ($stocks as $fragilisation)
            @if ($fragilisation->end_counting_cooling)
                <div class="col-sm-4">
                    <div class="card border-success mb-3 mr-2" style="max-width: 18rem;">
                        <div class="card-header" id="CountHeader{{$fragilisation->id}}" style="background-color: #62d493; color: white;">{{$fragilisation->getCalibrage->id_lot_calibre}}</div>
                        <div class="card-body text-dark d-flex">
                            <h1 id="hours{{$fragilisation->id}}"></h1>
                            <span class="fs-sm mr-1">h</span>
                            <h1 id="minutes{{$fragilisation->id}}">0</h1>
                            <span class="fs-sm mr-1">m</span>
                            <h1 id="seconds{{$fragilisation->id}}">0</h1>
                            <span class="fs-sm mr-1">s</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h4 class="p-1">{{$fragilisation->total_weight}}{{$fragilisation->getSequence->getObjectif?->unit_measure}} </h4>
                            <h4 class="p-1">{{$fragilisation->getCuiseur->designation}}</h4>
                        </div>
                        <div class="card-footer d-flex">
                        @if ($fragilisation->end_counting_cooling)
                            <div id="butontransfert{{$fragilisation->id}}">
                                <a id='' class='btn btn-success ml-1 transfert' href="{{ route('cooling.create', [$fragilisation->id]) }}"><span class='' role='status'>Ajouter</span></a>
                            </div>
                        @else
                            <div id="butontransfert{{$fragilisation->id}}">
                                <button class="btn btn-info startCountdown" id="countstart{{$fragilisation->id}}" data-cooking-time="{{$fragilisation->cooking_time}}" data-fragilisation-id="{{$fragilisation->id}}">Démarrer</button>
                            </div>
                        @endif
                            
                        </div>



                    </div>
                </div>
            @else
            <div class="col-sm-4">
                <div class="card border-success mb-3 mr-2" style="max-width: 18rem;">
                    <div class="card-header bg-danger" id="CountHeader{{$fragilisation->id}}" style=" color: white;">{{$fragilisation->getCalibrage->id_lot_calibre}}</div>
                    <div class="card-body text-dark d-flex">
                        <h1 id="hours{{$fragilisation->id}}"></h1>
                        <span class="fs-sm mr-1">h</span>
                        <h1 id="minutes{{$fragilisation->id}}">0</h1>
                        <span class="fs-sm mr-1">m</span>
                        <h1 id="seconds{{$fragilisation->id}}">0</h1>
                        <span class="fs-sm mr-1">s</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h4 class="p-1">{{$fragilisation->total_weight}}{{$fragilisation->getSequence->getObjectif?->unit_measure}} </h4>
                        <h4 class="p-1">{{$fragilisation->getCuiseur->designation}}</h4>
                    </div>
                    <div class="card-footer d-flex">
                    @if ($fragilisation->end_counting_cooling)
                        <div id="butontransfert{{$fragilisation->id}}">
                            <a id='' class='btn btn-success ml-1 transfert' href="{{ route('cooling.create', [$fragilisation->id]) }}"><span class='' role='status'>Ajouter</span></a>
                        </div>
                    @else
                        <div id="butontransfert{{$fragilisation->id}}">
                            <button class="btn btn-info startCountdown" data-cooking-time="{{$fragilisation->cooking_time}}" data-fragilisation-id="{{$fragilisation->id}}" id="countstart{{$fragilisation->id}}">Démarrer</button>
                        </div>
                    @endif
                        
                    </div>



                </div>
            </div>
            @endif
        @endforeach
    </div>
    <div class="row">
        {{ $stocks->links('pagination::bootstrap-4') }}
    </div>
</div>
</div>

@endsection


@section('javascript')

<script src="{{ asset('assets/js/jquery-3.6.3.js')}}" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>


<script>
    
$(document).ready(function() {
    $('.startCountdown').each(function() {
        
        var cooking_time = "0:01";
        var fragilisation_id = $(this).data('fragilisation-id');
console.log(fragilisation_id);
        var countdownTimes = localStorage.getItem('countdownTimes'+fragilisation_id);

        if (countdownTimes && countdownTimes > new Date().getTime()) {
            startCountdown(cooking_time, fragilisation_id, countdownTimes);
        }

        $(this).click(function () {
            startCountdown(cooking_time, fragilisation_id, null);
        });
    });

    function startCountdown(cooking_time, fragilisation_id, countdownTimes) {
        var hours_minutes = cooking_time.split(":");
        var mHours = parseInt(hours_minutes[0]);
        var mMinutes = parseInt(hours_minutes[1]);

        var x;

        if (!countdownTimes) {
            var count = new Date();
            count.setHours(count.getHours() + mHours);
            count.setMinutes(count.getMinutes() + mMinutes);
            count.setSeconds(count.getSeconds() + 0);
            countdownTimes = count.getTime();
            localStorage.setItem('countdownTimes'+fragilisation_id, countdownTimes);
        }

        $('#countstart'+fragilisation_id).hide('flast');
        if (x) {
            clearInterval(x);
        }

        x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countdownTimes - now;

            // Vérifier si le temps restant est positif avant de l'afficher
            if (distance >= 0) {
                var hours = Math.floor(distance / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            } else {
                var hours = 0;
                var minutes = 0;
                var seconds = 0;
                clearInterval(x);
                document.getElementById("butontransfert"+fragilisation_id).innerHTML = "<a id='' class='btn btn-success ml-1 transfert' href='/operateur/refroidissement/create/" + fragilisation_id + "'>Ajouter</a>";
                document.getElementById("CountHeader"+fragilisation_id).style.backgroundColor = "#62d493";

                $.ajax({
                    type : 'GET',
                    url  : '/operateur/cooling/endCounting/'+ fragilisation_id ,
                   
                    success: function (response) {
                        console.log(response);
                        localStorage.removeItem('countdownTimes'+fragilisation_id);
                        window.location.reload();
                        return;
                    },
                    error:function(erreur) {
                        console.log(erreur);
                    }
                });/*  */

            }

            document.getElementById("hours"+fragilisation_id).innerHTML = hours;
            document.getElementById("minutes"+fragilisation_id).innerHTML = minutes;
            document.getElementById("seconds"+fragilisation_id).innerHTML = seconds;

            localStorage.setItem('countdownTimes'+fragilisation_id, countdownTimes);
        }, 1000);
    }
});


</script>

@endsection