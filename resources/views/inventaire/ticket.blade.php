@extends('layouts.base')

@section('css')
    <style>
        .label-text {
          font-weight: bold;
          font-size: 16px;
          line-height: 28px;
          margin-bottom: 10px;
        }
        .mymargin{
          margin: 0px
        }

        .card {
          padding: 30px;
          background-color: #f8f9fc;
        }

        .container {
          margin-top: 50px;
        }
        .ticket {
          border: 1px solid black;
          box-sizing: border-box;
        }

        .square {
          width: 410px !important; /* Remplacez la valeur par la taille que vous souhaitez */
          height: 410px !important; /* Remplacez la valeur par la taille que vous souhaitez */
          
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
  <h4 class="font-weight-bold py-3 mb-0">Etiquette</h4>
  <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
          <li class="breadcrumb-item"><a href="#">Etiquette</a></li>
          <li class="breadcrumb-item active">Créer</li>
      </ol>
  </div>

</div>

<div class="row">
  <div class="col-lg-10" >
    
  <div class="row" style="margin-bottom: 20px;">
            <div class="col-lg-6">
                <a href="{{ route('reception.liste_sortie') }}" class="btn btn-xl btn-outline-primary">Retour</a>
            </div>
         </div>
  </div>

</div>

<div class="row">
  <div class="container">
    <div class="card o-hidden border-0 mt-5 shadow-lg my-5">
      <div class="card-body p-0">
        <div class="row">
          <div class="col-lg-2"></div>
          <div class="col-lg-8  ticket square">
            <div class="row ">
              <div class="col-sm-6 label-text ">
                <div class="d-flex">Code PMS: <p class="mymargin " style="font-size: 25px">129329</p> </div>
                 
                {{-- {{$sortie->getConditioning->getSequence->getObjectif->getProduit->code_prod}} --}}
              </div>
              <div class="col-sm-6 label-text"> <p class="mymargin mb-3" style="font-size: 20px">{{ $sortie->getUser->company}}</p></div>
              <div class="col-sm-6 label-text d-flex justify-content-center "> <p class="mymargin mb-3" style="font-size: 30px">{{$sortie->getConditioning->getSequence->getObjectif->getProduit->name}}</p> {{-- {{$sortie->getConditioning->getClassification->getUnskinning->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getStock->getStock->getOrigin->getMatiere->name}} --}}</div>
              <div class="col-sm-6 label-text mb-3">ID /ORDER : C001-21 {{-- {{ $sortie->getUser->code}} --}}</div>
              <div class="col-sm-6 label-text mb-3"> {{ Carbon\Carbon::parse($sortie->created_at)->format('H:i:s')}}</div>
              <div class="col-sm-6 label-text d-flex justify-content-center"><p class="mymargin mb-3"  style="font-size: 30px">Grade : WW180</p> {{-- {{ $sortie->getConditioning->getClassification->getGrade->designation }} --}}</div>
              <div class="col-sm-6 label-text d-flex justify-content-center "><p> Weight : 22.68 kg</p></div>
              <div class="col-sm-6 label-text mb-3">Lot PMS : {{$sortie->getConditioning->getClassification->getUnskinning->unskinning_batch}}</div>
            </div>
            <div class="row">
              <div class="col-sm-6 label-text">
                <div class="d-flex">
                  Lot :
                  <div>{{$lot}}</div>
                </div>
                <div class="mb-3">{!! DNS1D::getBarcodeHTML($lot, 'PHARMA') !!}</div>
              </div>
              {{-- <div class="col-sm-6 label-text">EXPIRATION</div> --}}
            </div>
            <div class="row">
              <div class="col-sm-6 label-text"></div>
              <div class="col-sm-6 label-text ">{{ $qrcode }}</div>
              
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
    
@endsection