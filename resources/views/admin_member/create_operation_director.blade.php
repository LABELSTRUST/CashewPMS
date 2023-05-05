@extends('layouts.app ')

@section('css'){{-- 
<link rel="stylesheet" href="{{ asset('assets/css/myform.css')}}"> --}}
@endsection

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


<div >
  <h4 class="font-weight-bold py-3 mb-0">Administrateur</h4>

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
    <div class="container mb-3">
      
      <div class="card o-hidden border-0 mt-5 shadow-lg my-5">
        <div class="card-header text-center">
            <h1 class="h4 text-gray-900 mb-4">Administrateur!</h1>
        </div>
        <div class="card-body">

          @if (isset($client))
            <form class="user mb-3"action="{{ route('client.update',$client->id) }}" method="POST"  enctype="multipart/form-data">
              @csrf
              <div class="form-row mb-3">
                  <div class="form-group col-md-12">
                      <label for="">Username</label>
                      <input type="text" name="username" required class="form-control" placeholder="username">
                  </div>
                  <div class="form-group col-md-12">
                      <label for="">Name</label>
                      <input type="text" name="name" required class="form-control" placeholder="Nom">
                  </div>
                  <div class="form-group col-md-12">
                      <label for="">Email</label>
                      <input type="email" name="email" required class="form-control" placeholder="Email">
                  </div>
                  <div class="form-group col-md-12">
                      <label for="">Password</label>
                      <input type="password" required name="password" class="form-control" placeholder="Password">
                  </div>
                  <div class="form-group col-md-12">
                      <label for="">Repeat Password</label>
                      <input type="password" class="form-control" name ="repeat_password" placeholder="Repeat Password">
                  </div>
                  <div class="form-group col-md-12">
                      <label for="">Avatar</label>
                      <input type="file" name="avatar" class="form-control-file">
                  </div>
                  <div class="col-md-12">
                    <label for="">Département</label>
                      <select name="roles_id" class="form-control"  id="roles_id">
                          <option disabled selected value=""></option>
                          @foreach ($roles as $role)
                              <option value="{{ $role->id }}">
                                  {{ $role->designation }}
                              </option>
                          @endforeach
                      </select>
                  </div>
                  <div class="form-group col-md-12">
                      <label for="">Titre</label>
                      <input type="text" name="title" class="form-control">
                  </div>
              </div>
            </form>
          @else
            <form class="user mb-3" action="{{ route('gene_admin.store_operator') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-row mb-3">
                  <div class="form-group col-md-12">
                      <label for="">Username</label>
                      <input type="text" name="username" required class="form-control" placeholder="username">
                  </div>
                  <div class="form-group col-md-12">
                      <label for="">Name</label>
                      <input type="text" name="name" required class="form-control" placeholder="Nom">
                  </div>
                  <div class="form-group col-md-12">
                      <label for="">Email</label>
                      <input type="email" name="email" required class="form-control" placeholder="Email">
                  </div>
                  <div class="form-group col-md-12">
                      <label for="">Password</label>
                      <input type="password" required name="password" class="form-control" placeholder="Password">
                  </div>
                  <div class="form-group col-md-12">
                      <label for="">Repeat Password</label>
                      <input type="password" class="form-control" name ="repeat_password" placeholder="Repeat Password">
                  </div>
                  <div class="form-group col-md-12">
                      <label for="">Avatar</label>
                      <input type="file" name="avatar" class="form-control-file">
                  </div>
                  <div class="col-md-12">
                    <label for="">Département</label>
                      <select name="roles_id" class="form-control"  id="roles_id">
                          <option disabled selected value=""></option>
                          @foreach ($roles as $role)
                              <option value="{{ $role->id }}">
                                  {{ $role->designation }}
                              </option>
                          @endforeach
                      </select>
                  </div>
                  <div class="form-group col-md-12">
                      <label for="">Titre</label>
                      <input type="text" name="title" class="form-control">
                  </div>
              </div>
         
              <button class="btn btn-primary btn-user btn-block" type="submit">Enregistrer</button>
            </form>
          @endif
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