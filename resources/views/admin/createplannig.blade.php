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
<div style="margin-left: 50px;">
  <h4 class="font-weight-bold py-3 mb-0">Plannig</h4>
  <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
          <li class="breadcrumb-item"><a href="#">Planning</a></li>
          <li class="breadcrumb-item active">Créer</li>
      </ol>
  </div>

</div>

<div class="row">
  <div class="col-lg-10" style="margin-left: 50px;">
    
    <div class="row" style="margin-bottom: 20px;">
        
            <!--div class="col-lg-6">
                <a href="{{ route('operateur.list') }}" class="btn btn-xl btn-outline-primary">Retour</a>
            </div-->
        
        <div class="col-lg-6">
            <a href="{{ route('planning.index') }}" class="btn btn-xl btn-outline-primary">Retour</a>
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
                      @if($sequence_plan)
                      <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Ajouter Séquence</h1>
                        <form class="user"action="{{ route('planning.addsequence',[$sequence_plan->id]) }}" method="POST"  enctype="multipart/form-data">
                          @method('PUT')
                          @csrf
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="">Date début</label>
                                    <input type="datetime-local" name="date_start" class="form-control "
                                            id="date_start" placeholder="Date début">
                                </div>
                                <div class="col-sm-6">
                                    <label for="">Date fin</label>
                                    <input type="datetime-local" name="date_end" class="form-control "
                                            id="date_end" placeholder="Date fin">
                                </div>
                            </div>
                            <div class="form-group">
                              <input type="number" name="quantity" class="form-control "
                                      id="quantity" placeholder="Quantité attendue">
                            </div>

                          <button class="btn btn-primary btn-user btn-block" type="submit">
                            Enregistrer
                          </button>
                        </form>
                      </div>

                      @elseif($planning)
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Modifier un planning!</h1>
                            </div>
                            <form class="user"action="{{ route('planning.update',[$planning->id]) }}" method="POST"  enctype="multipart/form-data">
                          @method('PUT')
                                    @csrf

                                    <div class="form-group row"> 
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <select name="commande_id" class="form-control " id="commande_id">
                                                <option disabled  selected value="">Commande</option>
                                                @foreach ($commandes as $commande)
                                                    <option value="{{ $commande->id }}" {{ $planning->commande_id === $commande->id ? 'selected' : '' }}>
                                                        {{ $commande->code }} {{ $commande->getProduit->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            
                                        </div>
                                        <div class="col-sm-6">
                                          <select name="ligne_id" class="form-control " id="ligne_id">
                                              <option disabled selected >Ligne</option>
                                              @foreach ($lignes as $ligne)
                                                  <option value="{{ $ligne->id }}">
                                                      {{ $ligne->code }}  {{ $ligne->name }}
                                                  </option>
                                              @endforeach
                                          </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                      
                                      <div class="col-sm-6 mb-3 mb-sm-0">
                                          <select name="shift_id" class="form-control " id="shift_id">
                                              <option disabled selected >Shift</option>
                                              @foreach ($shifts as $shift)
                                                  <option value="{{ $shift->id }}">
                                                      {{ $shift->title }} 
                                                  </option>
                                              @endforeach
                                          </select>
                                      </div>
                                      
                                      <!--div class="col-sm-6">
                                            <input type="number" name="quantity" class="form-control "
                                                    id="quantity" placeholder="Quantité attendue">
                                      </div-->
                                    </div>
                                    <!--div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <label for="">Date début</label>
                                            <input type="datetime-local" name="date_start" class="form-control "
                                                    id="date_start" placeholder="Date début">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Date fin</label>
                                            <input type="datetime-local" name="date_end" class="form-control "
                                                    id="date_end" placeholder="Date fin">
                                        </div>
                                    </div-->
                                    
                                
                                <button class="btn btn-primary btn-user btn-block" type="submit">
                                  Enregistrer
                                </button>
                            </form>

                      @elseif($planning=="" && $sequence_plan=="") 
                      <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Créer un planning!</h1>
                            </div>
                            <form class="user"action="{{ route('planning.store') }}" method="POST"  enctype="multipart/form-data">
                          
                                    @csrf

                                    <div class="form-group row"> 
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <select name="commande_id" class="form-control " id="commande_id">
                                                <option disabled  selected value="">Commande</option>
                                                @foreach ($commandes as $commande)
                                                    <option value="{{ $commande->id }}" >
                                                        {{ $commande->code }} {{ $commande->getProduit->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            
                                        </div>
                                        <div class="col-sm-6">
                                          <select name="ligne_id" class="form-control " id="ligne_id">
                                              <option disabled selected >Ligne</option>
                                              @foreach ($lignes as $ligne)
                                                  <option value="{{ $ligne->id }}">
                                                      {{ $ligne->code }}  {{ $ligne->name }}
                                                  </option>
                                              @endforeach
                                          </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                      
                                      <div class="col-sm-6 mb-3 mb-sm-0">
                                          <select name="shift_id" class="form-control " id="shift_id">
                                              <option disabled selected >Shift</option>
                                              @foreach ($shifts as $shift)
                                                  <option value="{{ $shift->id }}">
                                                      {{ $shift->title }} 
                                                  </option>
                                              @endforeach
                                          </select>
                                      </div>
                                      
                                      <div class="col-sm-6">
                                            <input type="number" name="quantity" class="form-control "
                                                    id="quantity" placeholder="Quantité attendue">
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <label for="">Date début</label>
                                            <input type="datetime-local" name="date_start" class="form-control "
                                                    id="date_start" placeholder="Date début">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Date fin</label>
                                            <input type="datetime-local" name="date_end" class="form-control "
                                                    id="date_end" placeholder="Date fin">
                                        </div>
                                    </div>
                                    
                                
                                <button class="btn btn-primary btn-user btn-block" type="submit">
                                  Enregistrer
                                </button>
                            </form>

                      

                      @endif
                        </div>
                    </div>
                    <div class="col-lg-2"></div>
                </div>
            </div>
        </div>

  </div>
</div>

@endsection