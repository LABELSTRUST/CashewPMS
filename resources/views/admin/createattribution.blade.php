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
  <h4 class="font-weight-bold py-3 mb-0">Attriution de poste</h4>
  <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
          <li class="breadcrumb-item"><a href="#">Attribution de poste</a></li>
          <li class="breadcrumb-item active">Créer</li>
      </ol>
  </div>

</div>

<div class="row">
  <div class="col-lg-10" >
    
  <div class="row" style="margin-bottom: 20px;">
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <a href="{{ route('operateur.list') }}" class="btn btn-lg btn-outline-primary">Liste Operateur</a>
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
                                <h1 class="h4 text-gray-900 mb-4">Attribuer un Poste!</h1>
                            </div>
                            <form class="user"action="{{ route('attribuer.attribuer_store') }}" method="POST"  enctype="multipart/form-data">
                                    @csrf
                                
                                    @if(isset($operator))
                                     
                                      <input type="number" name="user_id" hidden value="{{ $operator }}">
                                      <div class="form-group">
                                                <select name="poste_id" required class="form-control"  id="poste_id">
                                                    <option disabled selected>Poste</option>
                                                    @foreach ($postes as $poste)
                                                        <option value="{{ $poste->id }}">
                                                        {{ $poste->title }} {{ $poste->code_prod }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                      </div>
                                    @else



                                        <div class="form-group row">
                                          <div class="col-sm-6 mb-3 mb-sm-0">
                                            
                                                <select name="user_id" required class="form-control"  id="user_id">
                                                    <option disabled selected>Opérateur</option>
                                                    @foreach ($operators as $operator)
                                                        <option value="{{ $operator->id }}">
                                                        {{ $operator->name }} {{ $operator->email }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            

                                          </div> 
                                          <div class="col-sm-6">
                                              <select name="poste_id" class="form-control"  id="poste_id">
                                                  <option disabled selected>Poste</option>
                                                  @foreach ($postes as $poste)
                                                      <option value="{{ $poste->id }}">
                                                      {{ $poste->title }} {{ $poste->code_prod }}
                                                      </option>
                                                  @endforeach
                                              </select>
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