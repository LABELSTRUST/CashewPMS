@extends('layouts.base')


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
  <h4 class="font-weight-bold py-3 mb-0"> Four</h4>
  <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
          <li class="breadcrumb-item"><a href="#"> Four</a></li>
          <li class="breadcrumb-item active">Créer</li>
      </ol>
  </div>

</div>

<div class="row">
  <div class="col-lg-10" >
    
      <div class="row  d-flex justify-content-between" >
          <div class="">
              <a href="{{ route('drying.stock_drying_liste') }}" class="btn btn-lg btn-outline-primary">Retour</a>
          </div>
          <div class="">
              <a href="{{ route('drying.fourindex') }}" class="btn btn-lg btn-outline-primary">Liste</a>
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
                            @if (@isset($four))
                              <div class="text-center">
                                  <h1 class="h4 text-gray-900 mb-4">Modifier un Four!</h1>
                              </div>
                              <form class="user"action="{{ route('drying.fourupdate',[$four->id]) }}" method="POST"  enctype="multipart/form-data">
                                      @csrf
                                  <div class="form-group row">
                                    <input type="text" name="designation" class="form-control" required id="exampleLastName" value="{{ $four->designation}} " placeholder="Désignation">
                                  </div>
                                  <button class="btn btn-primary btn-user btn-block" type="submit">
                                    Modifier
                                  </button>
                              </form>
                            @else
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Créer un Four!</h1>
                            </div>
                            <form class="user"action="{{ route('drying.storefour') }}" method="POST"  enctype="multipart/form-data">
                                    @csrf
                                <div class="form-group row">
                                  <input type="text" name="designation" class="form-control" required id="exampleLastName" placeholder="Désignation">
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