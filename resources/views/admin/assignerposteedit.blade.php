@extends('layouts.base')


@section('content')
    @if (session()->has('message'))
        <div class="alert alert-dark-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong> {{ session()->get('message') }}</strong>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-dark-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong> {{ session()->get('error') }}</strong>
        </div>
    @endif

    @if (session()->has('errors'))
        <div class="alert alert-dark-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>
        <h4 class="font-weight-bold py-3 mb-0">Modification de l'opération</h4>
        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="#">Modifier une assignation de l'opération</a></li>

        </div>
    </div>

   
    <div class="row">
        <div class="col-lg-10" style="margin-left: 2%;">
          
          <div class="row" style="margin-bottom: 20px;">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <a href="{{ route('assigner.assignerposte', [$assigners->sequence_id]) }}" class="btn btn-lg btn-outline-primary">Retour</a>
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
                                        <h1 class="h4 text-gray-900 mb-4">Modification de l'operateur!</h1>
                                    </div>
                                    <form class="user" action="{{ route('assigner.update_operateur_on', [$assigners->id]) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <label for="">Poste</label><br>
                                                <input type="text" disabled
                                                value="{{ $assigners->getPoste?->title }}"
                                                name="poste">
                                              </div>
                                              <div class="col-sm-6">
                                                <label for="">Nouvel opérateur</label>
                                                <select name="user_id" id="" class="form-control ">
                                                    <option disabled selected value="">Opérateur</option>
                                                    @foreach ($the_postes as $the_poste)
                                                        @if ($the_poste->getPoste?->id == $assigners->getPoste?->id)
                                                            <option value="{{ $the_poste->getUser?->id }}">
                                                                {{ $the_poste->getUser?->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                              </div>
                                            
                                        </div>
                                       
                                        <button class="btn btn-primary btn-user btn-block" type="submit">
                                          Modifier
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

@section('javascript')
    <script src="{{ asset('asset/js/demo/datatables-demo.js') }}"></script>
    <script src="{{ asset('asset/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('asset/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endsection
