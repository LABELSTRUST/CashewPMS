@extends('layouts.base')


@section('content')


<div style="margin-left: 50px;">
<h4 class="font-weight-bold py-3 mb-0">Opérateurs</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Opérateurs</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>

<div class="row">
    
    <div class="col-lg-10" style="margin-left: 50px;">
         <div class="row" style="margin-bottom: 20px;">
            <div class="col-lg-6">
                <a href="{{ route('create.operator') }}" class="btn btn-xl btn-outline-primary">Ajouter un Opérateurs</a>
            </div>
            <!--div class="col-lg-6" style="display: flex; justify-content: flex-end;">
                <a href="{{ route('shift.index') }}" class="btn btn-xl btn-outline-primary">Gestion des shifts</a>
            </div-->
         </div>
         <div class="row">
            
         <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Liste des Opérateurs</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Username</th>
                                            <th>Role</th>
                                            <th>Poste</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Username</th>
                                            <th>Role</th>
                                            <th>Poste</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                      
                                      @foreach ($operators as $operator)
                                            
                                        <tr>
                                            <td>{{ $operator->name }}</td>
                                            <td>{{ $operator->email }}</td>
                                            <td>{{ $operator->username }}</td>
                                            <td>{{ $operator->getRole->name }}</td>
                                            <td>@if ($operator->affected) 
                                                <button class="btn btn-success">En poste</button>
                                                @else <button class="btn btn-primary">Pas de poste</button> 
                                                @endif
                                            </td>
                                            <td style=" width: 25%;">
                                                <!--a class="btn btn-outline-primary" href="">Modifier</a>
                                                <a class="btn btn-outline-primary" href="">Ajouter Ligne</a-->
                                                <a class="btn btn-outline-primary" href="{{route('assiger.create', [$operator->id])}}">Assigner un poste</a>
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