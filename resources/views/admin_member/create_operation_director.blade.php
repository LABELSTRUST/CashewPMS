@extends('layouts.base ')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/myform.css')}}">
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
  <h4 class="font-weight-bold py-3 mb-0">Opérations</h4>
  <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin_dash') }}"><i class="feather icon-home"></i></a></li>
          <li class="breadcrumb-item"><a href="#">Opérations</a></li>
          <li class="breadcrumb-item active">Créer</li>
      </ol>
  </div>

</div>

<div class="row">
  <div class="col-lg-10" >
    
  <div class="row" style="margin-bottom: 2%;">
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <a href="{{-- {{ route('client.index') }} --}}" class="btn btn-lg btn-outline-primary">Retour</a>
            </div>
         </div>
  </div>

</div>


<div class="row">
    <div class="container">
      
      <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <h1 class="h4 text-gray-900 mb-4">Créer Directeur des Opérations!</h1>
        </div>
        <div class="card-body">

          @if (isset($client))
          <form class="user"action="{{ route('client.update',$client->id) }}" method="POST"  enctype="multipart/form-data">
              @csrf
              <div class="form-row mb-3">
                <div class="form-group col-md-3" id="nbr_sacs">
                  <label for="">Name</label>{{-- {{ isset($origin_prod ) ? $origin_prod->date_recep : '' }} --}}
                  <input type="text" name="name" required class="form-control" value="{{ $client->name }}" id="" placeholder="Nom">
                </div>
                {{-- <div class="col-sm-3">
                    <label for="">Prénom</label>
                    <input type="text" name="first_name" value="{{ $client->first_name }}" required class="form-control " id="" placeholder="Prénom">
                </div> --}}
                <div class="form-group col-md-3" id="nbr_sacs">
                  <label for="">Email</label>
                  <input type="email" name="email" required class="form-control " value="{{ $client->email }}" id="exampleLastName"
                      placeholder=" Email">
                </div>
                <div class="col-sm-3">
                    <label for="">Password</label>
                    
                    <input type="password" required name="password" class="form-control " id="exampleInputPassword" placeholder="Password">
                </div>{{-- 
                <div class="col-sm-3">
                    <label for="">Téléphone</label>
                    <input type="tel" name="tel" required class="form-control" value="{{ $client->tel }}" id="tel"
                        placeholder="Téléphone">
                </div> --}}
            </div>
            </form>
          @else
          <form class="user" action="{{ route('gene_admin.store_operator') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-row mb-3">
                <div class="form-group col-md-4">
                    <label for="">Username</label>
                    <input type="text" name="username" required class="form-control" placeholder="username">
                </div>
                <div class="form-group col-md-4">
                    <label for="">Name</label>
                    <input type="text" name="name" required class="form-control" placeholder="Nom">
                </div>
                <div class="form-group col-md-4">
                    <label for="">Email</label>
                    <input type="email" name="email" required class="form-control" placeholder="Email">
                </div>
                <div class="form-group col-md-3">
                    <label for="">Password</label>
                    <input type="password" required name="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group col-md-3">
                    <label for="">Repeat Password</label>
                    <input type="password" class="form-control" name ="repeat_password" placeholder="Repeat Password">
                </div>
                <div class="form-group col-md-3">
                    <label for="">Avatar</label>
                    <input type="file" name="avatar" class="form-control">
                </div>
                <div class="col-sm-3">
                  <label for="">Poste</label>
                    <select name="roles_id" class="form-control"  id="roles_id">
                        <option disabled selected value=""></option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">
                                {{ $role->designation }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif
            <button class="btn btn-primary btn-user btn-block" type="submit">Enregistrer</button>
          </form>
        
        </div>
      </div>
  
    </div>
  </div>

@endsection
@section('javascript')
<script>
  $('#tel').on('input', function() {
    var telephone = $(this).val().replace(/[^0-9]/g, ''); // supprime tous les caractères non numériques
    var formattedTelephone = '';
    for (var i = 0; i < telephone.length; i++) {
      if (i == 3 || i == 5 || i == 7 || i == 9) {
        formattedTelephone += ' ';
      }
      formattedTelephone += telephone[i];
    }
    $(this).val(formattedTelephone);
  });

</script>
@endsection