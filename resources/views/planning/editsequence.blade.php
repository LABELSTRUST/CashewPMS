@extends('layouts.base ')


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
<div >
  <h4 class="font-weight-bold py-3 mb-0">Séquence</h4>
  <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
          <li class="breadcrumb-item"><a href="#">Séquence</a></li>
          <li class="breadcrumb-item active">Créer</li>
      </ol>
  </div>

</div>

<div class="row">
  <div class="col-lg-10" >
    
    <div class="row" style="margin-bottom: 20px;">
        
            <!--div class="col-lg-6">
                <a href="{{ route('operateur.list') }}" class="btn btn-xl btn-outline-primary">Retour</a>
            </div-->
        
        <div class="col-lg-6 col-md-6 col-sm-6 ">
            <a href="{{ route('sequence.index') }}" class="btn btn-lg btn-outline-primary">Retour</a>
        </div>
    </div>
  </div>

</div>

<div class="row">
  <div class="container">
    
<div class="card o-hidden border-0 mt-5 shadow-lg my-5">
            <div class="card-body  p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-2"></div>
                    
                    <!--div class="col-lg-5 d-none d-lg-block bg-register-image">

                        </div-->
                    <div class="col-lg-8" >
                        
                    <div class="p-5">
                      <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Modifier Séquence!</h1>
                            </div>
                            <form class="user"action="{{ route('sequence.update',[$sequence->id]) }}" method="POST"  enctype="multipart/form-data">
                                @method('PUT')
                                    @csrf

                                    <div class="form-group row">
                                      
                                      <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="">Shift</label>
                                          <select name="shift_id" class="form-control " id="shift_id_plan">
                                              <option disabled selected >Shift</option>
                                              @foreach ($shifts as $shift)
                                                  <option value="{{ $shift->id }}"{{ $sequence->getShift->id === $shift->id ? 'selected' : '' }}>
                                                      {{ $shift->title }} 
                                                  </option>
                                              @endforeach
                                          </select>
                                      </div>
                                      
                                      <div class="col-sm-6">
                                        
                                        @if($sequence->getObjectif->obj_remain_quantity)
                                          <label for="">Quantité Restante</label>
                                            <input type="number" min=0 name="quantity_commander" value="{{ $sequence->getObjectif->obj_remain_quantity }}" class="form-control"
                                                id="quantity_commander" disabled placeholder="Quantité Commander">

                                            <input type="number" name="quantity_commander" hidden value="{{ $sequence->getObjectif->obj_remain_quantity }}">
                                        

                                        @elseif($sequence->getObjectif->obj_remain_quantity==0)
                                          
                                          <label for="">Quantité Restante</label>
                                              <input type="number" min=0 name="quantity_commander" value="{{ $sequence->getObjectif->obj_remain_quantity }}" class="form-control"
                                                  id="quantity_commander" disabled placeholder="Quantité Commander">

                                              <input type="number" name="quantity_commander" hidden value="{{ $sequence->getObjectif->obj_remain_quantity }}">
                                        @endif
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <label for="">Date</label>
                                            <input type="date" name="date_start" value="{{ $sequence->date_start }}" class="form-control"
                                                    id="date_start_plan" placeholder="">
                                        </div>
                                        <div class="col-sm-6">
                                        @if($sequence->getObjectif->obj_remain_quantity == 0)
                                          <label for="">Quantité à produire</label>
                                              <input type="number" min=0 name="quantity" disabled value="{{ $sequence->quantity }}" class="form-control"
                                                      id="quantity_plan" placeholder="">
                                            <input type="number" name="quantity" value="{{ $sequence->quantity }}" hidden>
                                        @else
                                        
                                          <label for="">Quantité à produire</label>
                                              <input type="number" min=0 name="quantity"  value="{{ $sequence->quantity }}" class="form-control"
                                                      id="quantity_plan" placeholder="">
                                        @endif
                                        </div>
                                    </div>
                                    <div class="form-group row"> 
                                          <select name="ligne_id" class="form-control " id="ligne_id_plan">
                                              <option disabled selected >Ligne</option>
                                              @foreach ($lignes as $ligne)
                                                  <option value="{{ $ligne->id }}" {{ $sequence->getLigne->id === $ligne->id ? 'selected' : '' }}>
                                                      {{ $ligne->name }}
                                                  </option>
                                              @endforeach
                                          </select>
                                    </div>
                                    
                                
                                <button class="btn btn-primary btn-user btn-block" type="submit">
                                  Enregistrer
                                </button>
                            </form>
                      
                        </div>
                    </div>
                    <div class="col-lg-2"></div>
                </div>
            </div>
        </div>

  </div>
</div>

@endsection
