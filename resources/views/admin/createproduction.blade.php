@extends('layouts.app')


@section('content')

<div class="container">
    
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible fade show" role="alert" >
          <strong> {{ session()->get('message')}}</strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
  </div>
@endif
@if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" >
        <strong> {{ session()->get('error')}}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
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



<div class="card o-hidden border-0 mt-5 shadow-lg my-5">
            <div class="card-body  p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-2"></div>
                    
                    <!--div class="col-lg-5 d-none d-lg-block bg-register-image">cycle
user_id
ligne_id
shift_id
produit_id</div-->
                    <div class="col-lg-8" >
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Lancer une Production!</h1>
                            </div>
                            <form class="user"action="{{ route('production.store') }}" method="POST"  enctype="multipart/form-data">
                                    @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="cycle" required class="form-control " id="cycle"
                                            placeholder="cycle">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="datetime-local" required name="time_open" class="form-control " id="exampleLastName"
                                            placeholder="Début">
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

@endsection