@extends('layouts.base ')


@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/myform.css')}}">
@endsection
@section('content')

<div id="result"></div>

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
  <h4 class="font-weight-bold py-3 mb-0">Conditionnement</h4>
  <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
          <li class="breadcrumb-item"><a href="#">Conditionnement</a></li>
      </ol>
  </div>

</div>

<div class="row">
  <div class="col-lg-10" >
    <div class="row d-flex justify-content-between" style="">
      <div class="mb-2">
        <a class="btn btn-info" href="{{route('conditioning.stocks')}}">Retour</a>
      </div>
      <div class="mb-2">
        <a class="btn btn-info" href="{{route('conditioning.index')}}">Liste</a>
      </div>


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
        <h4 class="card-title">Conditionnement !</h4>
      </div>
      <div class="card-body">
        
        <form class="user"action="{{ route('conditioning.store') }}" id="form-data" method="POST"  enctype="multipart/form-data">
          @csrf
          
            <div class="form-row">
              <div class="form-group col-md-3" id="nbr_sacs">
                <label for="">Nombre de sac plein</label>{{-- {{ isset($origin_prod ) ? $origin_prod->date_recep : '' }} --}}
                  <input type="number" min="0" step="0.01" name="num_bag" value="{{$num_bag}}" class="form-control" id="" placeholder="Poids" >
              </div>

              <div class="form-group col-md-3" id="nbr_sacs">
                <label for="">Poids</label>{{-- {{ isset($origin_prod ) ? $origin_prod->date_recep : '' }} --}}
                  <input type="number" min="0" step="0.01" name="weight" value="{{$bag_quantity}}" class="form-control" id="weight" placeholder="Poids" >
              </div>
                  
                <input   type="text" hidden name="classification_id" value="{{ $classification->id }}">
              
              
                <div class="form-group col-md-3">
                  <label for="campagne">Nombre de sac restant </label>
                  <input type="number" min="0" step="0.01" name="remain_bag" value="{{$remain_bag}}" class="form-control" id="weight" placeholder="Poids" >
  
                </div>
                <div class="form-group col-md-3">
                  <label for="campagne">Poids restant </label>
                  <input type="number" min="0" step="0.01" name="remain_weight" value="{{$remain_weight}}" class="form-control" id="weight" placeholder="Poids" >
  
                </div>
            </div>
          
          <button class="btn btn-primary btn-user btn-block"  type="submit">
            Enregistrer
          </button>

        </form>
      </div>
    </div>

  </div>
</div>



@endsection

@section('javascript')


<script>

</script>


@endsection