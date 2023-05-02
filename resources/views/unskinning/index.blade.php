@extends('layouts.base')
@section('css')
    <style>
       table td {
            width: 1% !important;
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
    <h4 class="font-weight-bold py-3 mb-0">Stock</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Stock</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>

<div class="row">
    
<div class="col-lg-10" style="margin-left: 2%;">
         <div class="row d-flex justify-content-between mb-3">
             <div class="col-lg-6 col-md-6 col-sm-6 " >
                 <a class="btn btn-info" href="{{route('drying.stock_unskinning_liste')}}">Retour</a>
            </div>{{-- --}}
         </div>
         <div class="row">
            
         <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Stocks  </h6>
                        </div>
                        <div class="card-body ">
                            <div class="table-responsive">{{-- id="dataTable" --}}
                                <table class="table table-hover table-bordered"  width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Lot</th>
                                            <th>Poids</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Lot</th>
                                            <th>Poids</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                      
                                        @foreach($unskinnings as $unskinning)
                                        <tr>
                                          <td> {{ $unskinning->id }}</td>
                                          <td>
                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $unskinning->created_at)->format('d/m/Y') }}
                                          </td>
                                          <td>
                                            {{ $unskinning->unskinning_batch }}
                                          </td>
                                          <td>
                                            {{ isset($unskinning->weight) ? $unskinning->weight : (isset($unskinning->weight_cj) ? $unskinning->weight_cj : '')}}
                                          </td>
                                          <td>
                                            @if ($unskinning->transfert == 1)
                                                <button class="btn btn-success" >Transférer</button>
                                            @else
                                                @if (isset($unskinning->weight_cj) && !isset($unskinning->weight))
                                                    <input type="text" hidden value="{{ $unskinning->id }}" name="unskinning_id" class="unskinning_id">
                                                    <button class="btn btn-warning transfert">Dépélliculage</button>
                                                @else
                                                  @if (isset($unskinning->weight_cj) && isset($unskinning->weight))
                                                    <a class="btn btn-info" href=" {{ route('unskinning.transfert', [$unskinning->id]) }} ">Transférer </a>
                                                      
                                                  @endif
                                                  @if (isset($unskinning->weight) && !isset($unskinning->weight_cj))
                                                  <a class="btn btn-info" href=" {{ route('unskinning.transfert', [$unskinning->id]) }} ">Transférer </a>
                                                  @endif
                                                
                                                @endif
                                            @endif
                                          </td>
  
                                        </tr>
                                        @endforeach
                                      </tbody>
                                  
                                </table>
                                {{ $unskinnings->links('pagination::bootstrap-4') }}
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
                    <h5 class="modal-title" id="exampleModalLabel">Dépélliculage!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                        <label for="p2">Amande</label>
                        <input type="text" hidden name="id_unskinning" value="" id="id_unskinning">
                        <input type="number" class="form-control mb-3" min=0 step="0.1" name="weight" id="" placeholder="Amande" value="">
                        
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

<script src="{{ asset('asset/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('asset/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets/js/bootstrap.js')}}"></script>
<script>
    
    $(document).ready(function(){
        $('.transfert').click(function(event) {
            event.preventDefault();
            var unskinning = $(this).siblings(".unskinning_id").val();
            console.log(unskinning);
            
            var id_unskinning =  $('#id_unskinning').attr('value', unskinning);
            
            
            $('#mytransfert').modal('show');
        });

        $('#myvalider').click(function(event) {
            event.preventDefault();

            var weight = $("input[name='weight']").val();
            var unskinning = $("input[name='id_unskinning']").val();
            
            console.log(weight);
            console.log(unskinning);
            var data = {
                    "_token": "{{ csrf_token() }}",
                    weight : weight,
                    unskinning : unskinning,
                    
                }
            
            $.ajax({
                url: '/operateur/unskinning/second/'+ unskinning +'',
                method: 'POST',
                data : data,
                success: function(response) {
                    // Traitez la réponse ici
                    console.log(response);
                    location.reload(true);
                },
                error:function(erreur) {
                    console.log(erreur);
                }
                 
            }); /**/

        });
        

    });
</script>


@endsection