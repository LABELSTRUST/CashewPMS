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
    <h4 class="font-weight-bold py-3 mb-0">Séchage 2</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Séchage 2</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>

<div class="row">
    
<div class=" col-lg-12" >
    <div class="row d-flex justify-content-between mb-3">
    <div class=" " >
       <a class="btn btn-info" href="{{route('drying.listeDraying')}}">Liste </a>{{-- --}}
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
        @foreach ($dryings as $drying)
            @if ($drying->weigth_after && $drying->final_temp && $drying->loss!=null)
                
            @else
                
            <div class="col-sm-4">
                <div class="card border-success mb-3 mr-2" style="max-width: 18rem;">
                    <div class="card-header" style="background-color: #0f5ca6; color: white;">{{$drying->getFirstDrying->getShelling->sub_batch_caliber}}</div>
                    <div class="card-body text-dark d-flex">
                        <h1 id="hours{{$drying->id}}"></h1>
                        <span class="fs-sm mr-1">h</span>
                        <h1 id="minutes{{$drying->id}}">0</h1>
                        <span class="fs-sm mr-1">m</span>
                        <h1 id="seconds{{$drying->id}}">0</h1>
                        <span class="fs-sm mr-1">s</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h4 class="p-1">{{$drying->weigth_before}}{{$drying->getFirstDrying->getSequence->getObjectif?->unit_measure}} </h4>
                        <h4 class="p-1">{{$drying->getFour->designation}}</h4>
                    </div>
                    <div class="card-footer d-flex">
                        @if ($drying->end_countdown)
                            <div id="butontransfert{{$drying->id}}">
                              <button data-toggle='modal' data-target='#drying{{$drying->id}}' class='btn btn-success ml-1 transfert'><span class='' role='status'>Ajouter</span></button>
                            </div>
                        @else
                            <div id="butontransfert{{$drying->id}}">
                                <button class="btn btn-info startCountdown" id="countstart{{$drying->id}}" data-drying-time="{{$drying->start_time}}" data-drying-id="{{$drying->id}}">Démarrer</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            
                <div class="modal fade" id="drying{{$drying->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Données après Séchage !</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <input type="text" hidden name="drying" value="{{$drying->id}}" >
                                    <label for="campagne">Poids</label>
                                    <input type="text" class="form-control weigth_after" name="weigth_after" required id="weigth_after{{$drying->id}}" placeholder="Poids" value="">
                                    <label for="campagne">Perte</label>
                                    <input type="text" class="form-control" name="loss" required id="loss{{$drying->id}}" placeholder="Perte" value="">
                                    <label for="campagne">Température Finale</label>
                                    <input type="text" class="form-control" name="final_temp" required id="final_temp{{$drying->id}}" placeholder="Température Finale" value="">


                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                                
                                <button class="btn btn-info ajouter" type="button" data-dismiss="modal" id="ajouter{{$drying->id}}">Valider</button>
                            </div>
                        </div>
                    </div>
                </div>
        @endforeach
    </div>
    <div class="row">
        {{ $dryings->links('pagination::bootstrap-4') }}
    </div>
</div>
</div>

@endsection


@section('javascript')

<script src="{{ asset('assets/js/jquery-3.6.3.js')}}" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    $('.startCountdown').each(function() {
        var cooking_time = "00:01";
        var drying_id = $(this).data('drying-id');

        var countdownTimes = localStorage.getItem('countdownTimes'+drying_id);

        if (countdownTimes && countdownTimes > new Date().getTime()) {
            startCountdown(cooking_time, drying_id, countdownTimes);
        }

        $(this).click(function () {
            startCountdown(cooking_time, drying_id, null);
        });
    });

    function startCountdown(cooking_time, drying_id, countdownTimes) {
        var hours_minutes = cooking_time.split(":");
        var mHours = parseInt(hours_minutes[0]);
        var mMinutes = parseInt(hours_minutes[1]);

        var x;

        document.getElementById("countstart"+drying_id).style.display = "none";
        if (!countdownTimes) {
            var count = new Date();
            count.setHours(count.getHours() + mHours);
            count.setMinutes(count.getMinutes() + mMinutes);
            count.setSeconds(count.getSeconds() + 0);
            countdownTimes = count.getTime();
            localStorage.setItem('countdownTimes'+drying_id, countdownTimes);
        }

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
                document.getElementById("butontransfert"+drying_id).innerHTML ="<button data-toggle='modal' data-target='#drying" + drying_id +"' class='btn btn-success ml-1 transfert'><span class='' role='status'>Ajouter</span></button>"

                $.ajax({
                    type : 'GET',
                    url  : '/operateur/drying/second/endCounting/'+ drying_id ,
                   
                    success: function (response) {
                        console.log(response);
                        localStorage.removeItem('countdownTimes'+drying_id);
                        return;
                    },
                    error:function(erreur) {
                        console.log(erreur);
                    }
                });/*  */
            }
            document.getElementById("hours"+drying_id).innerHTML = hours;
            document.getElementById("minutes"+drying_id).innerHTML = minutes;
            document.getElementById("seconds"+drying_id).innerHTML = seconds;

            localStorage.setItem('countdownTimes'+drying_id, countdownTimes);
        }, 1000);
    }

    
    $('.weigth_after').on('change', function() {
        
        // Récupérer la valeur de l'input "weigth_after"
        var weigthAfter = $(this).closest('.modal').find('input[name="weigth_after"]').val();
        var drying = $(this).closest('.modal').find('input[name="drying"]').val();
        console.log(weigthAfter);
        console.log(drying);
        $.ajax({
            type : 'POST',
            url  : '/operateur/second/drying/getloss' ,
            data:{
                "_token": "{{ csrf_token() }}",
                weigth_after : weigthAfter,
                drying : drying
            },
            
            success: function (response) {
                console.log(response);
                // Mettre à jour la valeur de l'input "loss"
                $('input[name="loss"]').val(response);

            },
            error:function(erreur) {
                console.log(erreur);
            }
        });

    });
// 
    
    $('.ajouter').click(function() {
        
        var drying = $(this).closest('.modal').find('input[name="drying"]').val();
        var weigth_after = $(this).closest('.modal').find('input[name="weigth_after"]').val();
        var loss =  $(this).closest('.modal').find('input[name="loss"]').val();
        
        var final_temp = $(this).closest('.modal').find('input[name="final_temp"]').val();
        
        $.ajax({
            type : 'POST',
            url  : '/operateur/second/drying/registerfinal' ,
            data:{
                "_token": "{{ csrf_token() }}",
                weigth_after : weigth_after,
                drying : drying,
                loss : loss,
                final_temp : final_temp
            },
            success: function (response) {
                console.log(response);
                window.location.href = "/operateur/second/drying/stock/general";
            },
            error:function(erreur) {
                console.log(erreur);
            }
        });

        
    });
});
  

</script>

@endsection