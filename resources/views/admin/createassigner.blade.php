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
  <h4 class="font-weight-bold py-3 mb-0">Assignation de poste</h4>
  <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
          <li class="breadcrumb-item"><a href="#">Assignation de poste</a></li>
          <li class="breadcrumb-item active">Créer</li>
      </ol>
  </div>

</div>

<div class="row">
  <div class="col-lg-10" style="margin-left: 50px;">
    
    <div class="row" style="margin-bottom: 20px; display: flex;">
        @if($the_operator)
            <div class="col-lg-6" style="justify-content: flex-end;">
                <a href="{{ route('operateur.list') }}" class="btn btn-xl btn-outline-primary">Retour</a>
            </div>
        @else
            <div class="col-lg-6" style="justify-content: flex-end;">
                <a href="{{ route('assiger.index') }}" class="btn btn-xl btn-outline-primary">Retour</a>
            </div>
        @endif
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
                                <h1 class="h4 text-gray-900 mb-4">Assigner un Poste!</h1>
                            </div>
                            <form class="user"action="{{ route('assigner.store') }}" method="POST"  enctype="multipart/form-data">
                                    @csrf
                                @if($the_operator)
                                    
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label for="Ligne">Ligne</label>
                                        <select name="ligne_id" class="form-control " id="ligne_id">
                                            <option disabled selected value="">Ligne</option>
                                            @foreach ($lignes as $ligne)
                                                <option value="{{ $ligne->id }}">
                                                    {{ $ligne->code }}  {{ $ligne->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        </div>
                                        <div class="col-sm-6">
                                        <label for="">Date fin</label>
                                            <input type="datetime-local" name="date_end" class="form-control "
                                                id="date_end" placeholder="Date fin">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" name="user_id" value="{{ $the_operator }}" hidden>
                                            
                                            <select name="poste_id" class="form-control " id="poste_id">
                                                <option disabled selected value="">Poste</option>
                                                @foreach ($postes as $poste)
                                                    <option value="{{ $poste->id }}">
                                                        {{ $poste->title }} 
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <select name="shift_id" class="form-control " id="shift_id">
                                                <option disabled selected >Shift</option>
                                                @foreach ($shifts as $shift)
                                                    <option value="{{ $shift->id }}">
                                                        {{ $shift->title }} 
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                
                                    <div class="form-group row"> 
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <select name="user_id" class="form-control " id="user_id">
                                                <option disabled  selected value="">Opérateur</option>
                                                @foreach ($operators as $operator)
                                                    <option value="{{ $operator->id }}">
                                                        {{ $operator->name }} {{ $operator->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <select name="poste_id" class="form-control " id="poste_id">
                                                <option disabled selected value="">Poste</option>
                                                @foreach ($postes as $poste)
                                                    <option value="{{ $poste->id }}">
                                                        {{ $poste->title }} 
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <select name="shift_id" class="form-control " id="shift_id">
                                            <option disabled selected >Shift</option>
                                            @foreach ($shifts as $shift)
                                                <option value="{{ $shift->id }}">
                                                    {{ $shift->title }} 
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                        
                                        <label >Ligne</label>
                                        <select name="ligne_id" class="form-control " id="ligne_id">
                                            <option disabled selected ></option>
                                            @foreach ($lignes as $ligne)
                                                <option value="{{ $ligne->id }}">
                                                    {{ $ligne->code }}  {{ $ligne->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Date fin</label>
                                            <input type="datetime-local" name="date_end" class="form-control "
                                                    id="date_end" placeholder="Date fin">
                                        </div>
                                    </div>
                                @endif
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