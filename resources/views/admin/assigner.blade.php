@extends('layouts.base')


@section('content')


<div style="margin-left: 50px;">
<h4 class="font-weight-bold py-3 mb-0">Poste assigner</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Poste assigner</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>

<div class="row">
    
    <div class="col-lg-10" style="margin-left: 50px;">
         <div class="row" style="margin-bottom: 20px;">
            <div class="col-lg-6">
                <a href="{{ route('assigner.create') }}" class="btn btn-xl btn-outline-primary">Assigner un poste</a>
            </div>
            <!--div class="col-lg-6" style="display: flex; justify-content: flex-end;">
                <a href="{{ route('shift.index') }}" class="btn btn-xl btn-outline-primary">Gestion des shifts</a>
            </div-->
         </div>
         <div class="row">
            
         <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Liste des Lignes</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Ligne</th>
                                            <th>Opérateur</th>
                                            <th>Poste</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Ligne</th>
                                            <th>Opérateur</th>
                                            <th>Poste</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                      
                                      @foreach ($assigners as $assigner)
                                          <tr>
                                              <td>{{ $assigner->id }}</td>
                                              <td>{{ $assigner->getLigne->code }} {{ $assigner->getLigne->name }}</td>
                                              <td>{{ $assigner->getUser->name }}</td>
                                              <td>{{ $assigner->getPoste->title }}</td>
                                              <td>{{ $assigner->created_at }}</td>
                                              <td>
                                                <a class="btn btn-outline-primary" href="">Modifier</a>
                                            </td>
                                              <!--td>$320,800</td-->
                                          </tr>
                                      @endforeach
                                    </tbody>
                                  
                                </table>
                            </div>
                        </div>
                    </div>
         </div>
    </div>
</div>

@endsection