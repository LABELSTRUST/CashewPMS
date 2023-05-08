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
        <h4 class="font-weight-bold py-3 mb-0">Assigner Poste</h4>
        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="#">Assigner Poste</a></li>
                <li class="breadcrumb-item active">Liste</li>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">
            <div class="row d-flex justify-content-between" style="margin-bottom: 20px;">
                <div class="mb-2">
                    <a href="{{ route('assigner.index') }}" class="btn btn-lg btn-outline-info">Assignation</a>
                </div>
                <div class="mb-2">
                    <a href="{{ route('reconduire', [$sequence->id]) }}" class="btn btn-lg btn-outline-info">Reconduire les
                        opérateurs</a>
                </div>
            </div>
            <div class="row">

                <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-info">Liste des Postes et opérateurs</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>

                                        <th>Poste</th>
                                        <th>Opérateur</th>
                                        <th>Action</th>
                                        <!--th>Salary</th-->
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>

                                        <th>Poste</th>
                                        <th>Opérateur</th>
                                        <th>Action</th>
                                        <!--th>Salary</th-->
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($posteproduits as $posteproduit)
                                        <tr>

                                            <td>{{ $posteproduit->getPoste?->title }}</td>
                                            <form class="user"
                                                action="{{ route('assigner.assignerPostecreate', [$sequence_id]) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf

                                                @foreach ($assignersnow as $assignersno)
                                                    @if ($assignersno->poste_id == $posteproduit->getPoste->id)
                                                        <td>
                                                            <input type="text" hidden
                                                                value="{{ $posteproduit->getPoste?->title }}"
                                                                name="poste">

                                                            <input type="text" disabled
                                                                value="{{ $assignersno->getUser->name }}">
                                                        </td>
                                                        <td style="width: 25%;">
                                                            <button disabled class=" btn btn-success"
                                                                type="submit">Valider</button>
                                                                {{-- <a  class=" btn btn-success" href="{{ route('assigner.poste_operateur', [$sequence->id]) }}"
                                                                >Modifier</a> --}}
                                                                <a class="btn btn-info "  href="{{route('operateur.edit', $assignersno->id)}}" >Modifier</a>
                                                                {{-- <input type="text" hidden value="{{ $assignersno->id}}" name="reception_id" class="reception_id">
                                                                <a class="btn btn-info transfert">Modifier</a> --}}
                                                                
                                                        </td>
                                                    @endif
                                                @endforeach


                                                @php
                                                    $postes_assignes = $assignersnow->pluck('poste_id')->toArray();
                                                    if (!in_array($posteproduit->getPoste->id, $postes_assignes)) {
                                                @endphp
                                                        <td>
                                                            <input type="text" hidden value="{{ $posteproduit->getPoste?->title }}" name="poste">
                                                            <select name="user_id" id="" class="form-control">
                                                                <option value="">Opérateur</option>
                                                                @foreach ($the_postes as $the_poste)
                                                                    @if ($the_poste->getPoste?->id == $posteproduit->getPoste?->id)
                                                                        <option value="{{ $the_poste->getUser?->id }}"> {{ $the_poste->getUser?->name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td style="width: 25%;">
                                                            <button class="btn btn-info" type="submit">Valider</button>
                                                        </td>
                                                @php
                                                    }
                                                @endphp


                                            </form>
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


    <div class="modal fade" id="mytransfert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modificaton de l'opérateur!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                        
                        <label for="p2">Poste</label>
                        <input type="text"  name="id_reception" value="" id="id_reception">
                        <input type="number" class="form-control mb-3" min=0 name="net_weight" id="" placeholder="Poids à transférer" value="">
                        <label for="campagne">Section </label>
                        {{-- <select class="form-control " name="section_id" id="section_id">
                            <option  selected value="">Section</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}">
                                    {{ $section->getSection?->designation }}
                                </option>
                            @endforeach
                        </select> --}}


                        {{-- <form class="user" action="{{ route('assigner.update_operateur_on', [$assigners->id]) }}"
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
                        </form> --}}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-primary" id="myvalider" data-dismiss="modal"  href="">Valider</a>
                
                </div>
            </div>
        </div>
</div>

    
@endsection

@section('javascript')
    <script src="{{ asset('asset/js/demo/datatables-demo.js') }}"></script>
    <script src="{{ asset('asset/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('asset/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.js')}}"></script>

<script>
    $(document).ready(function(){
        $('.transfert').click(function(event) {
            event.preventDefault();
            var reception_id = $(this).siblings(".reception_id").val();
            console.log(reception_id);
            
            var id_reception =  $('#id_reception').attr('value', reception_id);
            
            
            $('#mytransfert').modal('show');
        });

        $('#myvalider').click(function(event) {
            event.preventDefault();

            var net_weight = $("input[name='net_weight']").val();
            var stock_id = $("input[name='id_reception']").val();
            var section_id =  $('#section_id').val();
            
            var data = {
                    "_token": "{{ csrf_token() }}",
                    net_weight : net_weight,
                    stock_id : stock_id,
                    section_id : section_id,
                    
                }
            
            $.ajax({
                url: '/inventaire/reception/stock/transfert/'+stock_id+'',
                method: 'POST',
                data : data,
                success: function(response) {
                    // Traitez la réponse ici
                    console.log(response);
                    location.reload(true);
                },
                
            });
            console.log(net_weight);
            console.log(stock_id);

        });
        

    });
</script>
@endsection