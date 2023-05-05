@extends('layouts.app ')


@section('content')

@if(session()->has('message'))
<div class="alert bg-gradient-success text-white alert-dismissible fade show"  >
    <button type="button" class="close" data-dismiss="alert" >x</button>
    <strong> {{ session()->get('message')}}</strong>
</div>
@endif
@if(session()->has('error'))
  <div class="alert bg-gradient-danger text-white alert-dismissible fade show"  >
      <button type="button" class="close" data-dismiss="alert" >x</button>
      <strong> {{ session()->get('error')}}</strong>
  </div>
@endif

@if(session()->has('errors'))
  <div class="alert bg-gradient-success text-white alert-dismissible fade show"  >
      <button type="button" class="close" data-dismiss="alert" >x</button>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div style="margin-left: 2%;">
  <h4 class="font-weight-bold py-3 mb-0">Opérateurs</h4>

</div>

<div class="row">
  <div class="col-lg-10" style="margin-left: 2%;">
    
  <div class="row" style="margin-bottom: 20px;">
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <a href="{{ route('operateur.list') }}" class="btn btn-lg btn-outline-primary">Retour</a>
            </div>
         </div>
  </div>

</div>

<div class="row">
  <div class="container">
    
<div class="card o-hidden border-0 mt-5 shadow-lg my-5">
            <div class="card-body  ">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-2"></div>
                    
                    <!--div class="col-lg-5 d-none d-lg-block bg-register-image">

                        </div-->
                    <div class="col-lg-8" >
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Créer Un Opérateur!</h1>
                            </div>
                            <form class="user"action="{{ route('auth.registration') }}" method="POST"  enctype="multipart/form-data">
                                    @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="username" required class="form-control " id="exampleUsername"
                                            placeholder="Username">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="name" required class="form-control " id="exampleLastName"
                                            placeholder=" Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="email" name="email" required class="form-control "
                                            id="email" placeholder="email">
                                    </div>
                                    <div class="col-sm-6">
                                        <select name="roles_id" class="form-control"  id="roles_id">
                                            <option value="">Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="designation" required class="form-control "
                                            id="designation" placeholder="Titre">
                                    </div>
                                    <div class="col-sm-6">
                                        <select name="departement_id" class="form-control"  id="departement_id">
                                            <option value="">Département</option>
                                            @foreach ($departements as $departement)
                                                <option value="{{ $departement->id }}">
                                                    {{ $departement->designation }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" required name="password" class="form-control "
                                            id="exampleInputPassword" placeholder="Password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control "
                                            id="exampleRepeatPassword" placeholder="Repeat Password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="form-group col-md-12">
                                        <label for="">Avatar</label>
                                        <input type="file" name="avatar" class="form-control-file">
                                    </div>
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