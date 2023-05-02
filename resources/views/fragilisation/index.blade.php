@extends('layouts.base')
@section('css')

    <style>
   
        @keyframes scroll {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(0); }
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
    
<div class=" col-lg-12" >
    <div class="row d-flex justify-content-between mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6 " >
            <a class="btn btn-info" href="{{route('fragilisation.process',[$stock])}}">Retour</a>
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
        @foreach ($fragilisations as $fragilisation)
            <div class="col-sm-3">
                <div class="card border-success mb-3 mr-2" style="max-width: 18rem;">
                    <div class="card-header" style="background-color: #0f5ca6; color: white;">{{$fragilisation->getCalibrage->id_lot_calibre}}</div>
                    <div class="card-body text-dark d-flex">
                        <h1 id="hours{{$fragilisation->id}}"></h1>
                        <span class="fs-sm mr-1">h</span>
                        <h1 id="minutes{{$fragilisation->id}}">0</h1>
                        <span class="fs-sm mr-1">m</span>
                        <h1 id="seconds{{$fragilisation->id}}">0</h1>
                        <span class="fs-sm mr-1">s</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h4 class="p-1">{{$fragilisation->cook_net_weigth}}{{$fragilisation->getSequence->getObjectif?->unit_measure}} </h4>
                        <h4 class="p-1">{{$fragilisation->getCuiseur->designation}}</h4>
                    </div>
                    <div class="card-footer d-flex">
                        @if ($fragilisation->end_countdown)
                            <div id="butontransfert{{$fragilisation->id}}">
                                <a id='' class='btn btn-success ml-1 transfert' href="{{ route('fragilisation.transfert', [$fragilisation->id]) }}"><span class='' role='status'>Transférer</span></a>
                            </div>
                        @else
                            <div id="butontransfert{{$fragilisation->id}}">
                                <button class="btn btn-info startCountdown" id="countstart{{$fragilisation->id}}" data-cooking-time="{{$fragilisation->cooking_time}}" data-fragilisation-id="{{$fragilisation->id}}">Démarrer</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        {{ $fragilisations->links('pagination::bootstrap-4') }}
    </div>
</div>
</div>

@endsection


@section('javascript')

<script src="{{ asset('assets/js/jquery-3.6.3.js')}}" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
{{-- <script><button class="btn btn-info" id="mypage" >Page suivante</button>

    document.getElementById('mypage').addEventListener('click', () => {
    
        const paginationLinks = document.querySelectorAll('.pagination-link');
        const currentPage = 1; // Définir la page actuelle
    
        const articleList = document.querySelector('.pagination-link'); // Nouvelle variable articleList
    
        paginationLinks.forEach(link => {
            link.addEventListener('click', event => {
                event.preventDefault();
                const page = parseInt(event.target.dataset.page);
    
                // Récupérer les données paginées pour la page cliquée
                fetch(`${window.location.href}?page=${page}`)
                .then(response => response.json())
                .then(data => {
                    // Mettre à jour l'URL avec le numéro de page actuel
                    history.pushState(null, null, `?page=${page}`);
    
                    // Effacer la liste d'articles existante
                    articleList.innerHTML = '';
    
                    // Ajouter les nouveaux articles à la liste
                    data.forEach(fragilisation => {
                        const articleTemplate = `
                            <div class="col-sm-4">
                                <div class="card border-success mb-3 mr-2" style="max-width: 18rem;">
                                    <div class="card-header" style="background-color: #0f5ca6; color: white;">${fragilisation.getCalibrage.id_lot_calibre}</div>
                                    <div class="card-body text-success">
                                        <h5 class="card-title"></h5>
                                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    </div>
                                    <div class="card-footer bg-transparent border-success">Footer</div>
                                </div>
                            </div>
                        `;
                        articleList.insertAdjacentHTML('beforeend', articleTemplate);
                    });
                })
                .catch(error => console.error(error));
            });
        });
    });
</script> --}}
<script>
$(document).ready(function() {
    

    $('.startCountdown').each(function() {
        var cooking_time = $(this).data('cooking-time');
        var fragilisation_id = $(this).data('fragilisation-id');

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
        
        document.getElementById("countstart"+fragilisation_id).style.display = "none";
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
                document.getElementById("butontransfert"+fragilisation_id).innerHTML = "<a id='' class='btn btn-success ml-1 transfert' href='/operateur/fragilisation/transfert/" + fragilisation_id + "'><span class='' role='status'>Transférer</span></a>"

                $.ajax({
                    type : 'GET',
                    url  : '/operateur/fragilisation/endCounting/'+fragilisation_id ,
                   
                    success: function (response) {
                        console.log(response);
                        localStorage.removeItem('countdownTimes'+fragilisation_id);
                        return;
                    },
                    error:function(erreur) {
                        console.log(erreur);
                    }
                });

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