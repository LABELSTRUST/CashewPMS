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
                                <h1 class="h4 text-gray-900 mb-4">Créer une séquence!</h1>
                            </div>
                        <form class="user"action="{{ route('sequence.store') }}" method="POST"  enctype="multipart/form-data">
                      
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
                            <div class="form-group row">
                              <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="number" name="quantity" class="form-control "
                                        id="quantity" placeholder="Quantité attendue">
                              </div>
                              
                              <div class="col-sm-6">
                                <select name="client_id" class="form-control"  id="client_id">
                                    <option disabled selected>Planning</option>
                                    @foreach ($plannings as $planning)
                                        <option value="{{ $client->id }}">
                                        {{ $client->name }} {{ $client->email }}
                                        </option>
                                    @endforeach
                                </select>
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