@extends('layouts.base')


@section('content')


<div style="margin-left: 2%;">
    <h4 class="font-weight-bold py-3 mb-0">Client</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Client</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>

<div class="row">
    
<div class="col-lg-10" style="margin-left: 2%;">
         <div class="row d-flex justify-content-between" style="margin-bottom: 20px;">
            <div class="mb-2">
                <a href="{{ URL::previous() }}" class="btn btn-lg btn-outline-info">Retour</a>
            </div>
         </div>
         <div class="row">
            
         <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Détails clients</h6>
                        </div>
                        <div class="card-body ">
                            <div class="table-responsive   ">
                                <table class="table table-bordered " >
                                    
                                    <tbody>
                                      <tr>
                                        <th>Nom</th>
                                        <td>{{ $client->name }} </td>
                                      </tr>
                                      <tr>
                                        <th>Prénom (s)</th>
                                        <td>{{ $client->first_name }} </td>
                                      </tr>
                                      <tr>
                                        <th>Email </th>
                                        <td>{{ $client->email }}</td>
                                      </tr>
                                      <tr>
                                        <th>Téléphone</th>
                                        <td>{{ $client->tel }}</td>
                                      </tr>
                                      <tr>
                                        <th>Position</th>
                                        <td>{{ $client->position }}</td>
                                      </tr>
                                      <tr>
                                        <th>Entreprise</th>
                                        <td>{{ $client->company }}</td>
                                      </tr>
                                      <tr>
                                        <th>Pays</th>
                                        <td>{{ $client->country }}</td>
                                      </tr>
                                      <tr>
                                        <th>Ville / Commune</th>
                                        <td>{{ $client->city }}</td>
                                      </tr>
                                      <tr>
                                        <th>Adresse</th>
                                        <td>{{ $client->adresse }}</td>
                                      </tr>
                                      <tr>
                                        <th>Code Postal</th>
                                        <td>{{ $client->postal_code }}</td>
                                      </tr>
                                      <tr>
                                        <th>Catégorie</th>
                                        <td>{{ $client->categorie }}</td>
                                      </tr>

                                    </tbody>
                                  
                                </table>
                            </div>
                        </div>
                    </div>
         </div>
    </div>
</div>

@endsection

