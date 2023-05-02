@extends('layouts.base')


@section('content')


<div style="margin-left: 2%;">
    <h4 class="font-weight-bold py-3 mb-0">Détails</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Détails</a></li>
            <li class="breadcrumb-item active">Détails</li>
        </ol>
    </div>
</div>

<div class="row">
    
<div class="col-lg-10" style="margin-left: 2%;">
         <div class="row d-flex justify-content-between" >
            <div class="mb-2">
                <a href="{{ URL::previous() }}" class="btn btn-lg btn-outline-info">Retour</a>
            </div>
         </div>
         <div class="row">
            
         <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Détails</h6>
                        </div>
                        <div class="card-body ">
                            <div class="table-responsive   col-md-6-sm-6-xs-6">
                                <table class="table table-bordered "  width="100%" cellspacing="0">
                                    
                                    <tbody>
                                      <tr>
                                        <td>Date</td>
                                        <td>{{ \Carbon\Carbon::parse($classification->created_at)->format('d/m/Y') }}</td>
                                      </tr>
                                      <tr>
                                        <td>Id lot</td>
                                        <td>{{$classification->getUnskinning->unskinning_batch }}  </td>
                                      </tr>
                                      <tr>
                                        <td>Poids </td>
                                        <td>{{$classification->weight}}  </td>
                                      </tr>
                                      <tr>
                                        <td>Grade </td>
                                        <td>{{$classification->getGrade->designation}}</td>
                                      </tr>
                                      <tr>
                                        <td>Séquence</td>
                                        <td>{{str_pad($classification->getSequence->code, 2, '0', STR_PAD_LEFT)}}</td>
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

