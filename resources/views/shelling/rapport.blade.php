@extends('layouts.base')

@section('css')
    <style>
      
  .mytextarea{
    border: 1px solid #ced4da;
    border-radius: 1px;
  }
    </style>
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
<div style="margin-left: 2%;">
    <h4 class="font-weight-bold py-3 mb-0">Rapport</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Rapport</a></li>
            <li class="breadcrumb-item active">Rapport</li>
        </ol>
    </div>
</div>

<div class="row">
    
  <div class="col-lg-10" style="margin-left: 2%;">
      <div class="row d-flex justify-content-between">
        <div class="mb-2">
            <a href="{{ route('dashboard') }}" class="btn btn-lg btn-outline-info">Retour</a>
        </div>
        <div class="mb-2">
            <a href="{{ route('shelling.index') }}" class="btn btn-lg btn-outline-info">Liste</a>
        </div>
      </div>
      <div class="row">
            
        <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">Rapport</h6>
            </div>
            <div class="card-body">
              <div class="">
                <div class="row"><h3>Rapport</h3></div>
                <div class="row d-flex ">
                  <div class="col-6"></div>
                  <div class="col-6">
                    <div class=" d-flex" >
                      <div class="col-6"><h5 class=" ">Séquence Début :</h5></div>
                      <div class="col-6"><h5>{{str_pad($sequence_deb->code, 2, '0', STR_PAD_LEFT)}}</h5> </div>
                        
                    </div>
                    <div class="d-flex ">
                      <div class="col-6"><h5 cla>Date : </h5></div>
                      <div class="col-6"><h5>{{ \Carbon\Carbon::parse($sequence_deb->date_start)->format('d/m/Y') }}</h5>  </div>
                    </div>
                    <div class="d-flex ">
                      <div class="col-6"><h5 cla>Produit : </h5></div>
                      <div class="col-6"><h5>{{ $sequence_deb->getObjectif->getProduit->name }}</h5>  </div>
                    </div>
                    <div  class="d-flex ">
                      <div class="col-6"><h5>ID Target : </h5> </div>
                      <div class="col-6"> <h5>{{$sequence_deb->getObjectif?->id_target}}</h5> </div>
                      
                    </div>
                    <div  class=" d-flex">
                      <div class="col-6"> <h5>Quantité  Prévue : </h5></div>
                      <div class="col-6"> <h5>{{$sequence_deb->getObjectif?->qte_totale}} {{$sequence_deb->getObjectif?->unit_measure}}</h5> </div>
                      
                    </div>
                    <div  class="d-flex ">
                      <div class="col-6"> <h5>Quantité Produite :</h5></div>
                      <div class="col-6"> </div>
                      
                    </div>

                  </div>

                </div>

                <div class="row d-flex">
                  <div class="col-6">
                    <div class="d-flex">
                      <div class="col-6"> 
                        <h5>Séquence Section : </h5>
                      </div>
                      <div class="col-6">
                        <h5>{{str_pad($sequence->code, 2, '0', STR_PAD_LEFT)}}</h5>
                      </div>
                    </div>
                    <div class="d-flex">
                      <div class="col-6">
                        <h5>Date : </h5>
                      </div>
                      <div class="col-6">
                        <h5>{{ \Carbon\Carbon::parse($sequence->created_at)->format('d/m/Y') }}</h5>
                      </div>
                    </div>
                    <div class="d-flex">
                      <div class="col-6"><h5>Shift : </h5></div>
                      <div class="col-6"><h5>{{ $sequence->getShift?->title}}</h5>  </div>
                    </div>
                    <div class="d-flex">
                      
                      <div class="col-6"><h5>Quantité traitée : </h5></div>
                      <div class="col-6"><h5>{{$quantity}} {{$sequence_deb->getObjectif?->unit_measure}}</h5></div>
                  </div>
                  </div>

                </div>

                <div class=" row table-responsive">
                  <table class="table table-bordered"  width="100%" cellspacing="0">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Date</th>
                              <th>Lot PMS</th>
                              <th>Poids </th>
                              <th>Action</th>
                              <!--th>Salary</th-->
                          </tr>
                      </thead>
                      <tfoot>
                          <tr>
                              <th>#</th>
                              <th>Date</th>
                              <th>Lot PMS</th>
                              <th>Poids</th>
                              <th>Action</th>
                              <!--th>Salary</th-->
                          </tr>
                      </tfoot>
                      <tbody>
                        
                          @foreach ($shellings as $shelling)
                            <tr>
                              <td>{{$shelling->id}}</td>
                              <td>{{ \Carbon\Carbon::parse($shelling->created_at)->format('d/m/Y') }}</td>
                              <td>{{$shelling->sub_batch_caliber}}</td>
                              <td>{{$shelling->weight}}</td>
                              <td >
                                  <a class="btn icon-btn btn-outline-info mr-2" href="{{route('shelling.shellingdetails',[$shelling->id])}} "><span class="feather icon-eye"></span></a>
                              </td>
                            </tr>
                          @endforeach
                      </tbody>
                    
                  </table>
                  {{ $shellings->links('pagination::bootstrap-4') }}
                </div>
                <div class="row mt-2">
                  <div class="col-lg-12 col-12">
                    <form action="{{ route('shelling.registerRapport')}}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group">
                        <label for="">Observation</label>
                        <textarea name="observation" class="form-control mytextarea"   id="observation" cols="30" rows="10"></textarea>
                        <div class="form-group  mt-1">
                          <div class="form-group d-flex mt-1">
                            <div class="col-lg-6 col-6 d-flex align-items-baseline">
                              <label for="" class="mr-2">Opérateur: </label>
                                <input  type="text" name="name" min="0" class="form-control " id="name"
                                    placeholder="Name" value="{{$user->name}}">
                                    <input hidden type="text" name="sequence_id" value="{{$sequence->id}}">
                            </div>
                            <div class="col-lg-6 col-6 d-flex align-items-baseline">
                              <label for="" class="mr-2">Workforce</label>
                                <input  type="number" name="workforce" min="0" class="form-control " id="workforce"
                                    placeholder="La main d'oeuvre" value="">
                            </div> {{-- --}}
                          </div>
                        
                        <button class="btn btn-primary btn-user btn-block" type="submit">
                          Enregistrer
                        </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
  </div>
</div>

@endsection


@section('javascript')

<script src="{{ asset('asset/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('asset/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
@endsection