@extends('layouts.base')

@section('css')
<style>
    .sticky {
        position: sticky;
        position: -webkit-sticky;
        left: 0;
        background-color: #fff;
    }
    thead {
  z-index: 1;
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
            <li class="breadcrumb-item"><a href="{{ route('reception.dispatchs') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Stock</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>

<div class="row">
    
<div class="col-md-12" style="margin-left: 2%;">
         <div class="row" style="margin-bottom: 20px;">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <a href="{{ URL::previous() }}" class="btn btn-lg btn-outline-info">Retour</a>
            </div>
         </div>
         <div class="row">
            
         <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Liste des stocks</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="sticky">Lot PMS</th>
                                            <th>Date</th>
                                            <th>Poids net</th>
                                            <th>Quantité sac</th>
                                            <th>Poids restant</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th class="sticky">Lot PMS</th>
                                            <th>Date</th>
                                            <th>Poids net</th>
                                            <th>Quantité sac</th>
                                            <th>Poids restant</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($stocks as $stock)
                                            <tr>
                                                <td>{{$stock->id}}</td>
                                                <td class="sticky">{{$stock->getClassification->getUnskinning->unskinning_batch}}</td>
                                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $stock->created_at)->format('d/m/Y') }}</td>
                                                <td>{{$stock->weight}} </td>
                                                <td>{{$stock->num_bag}}</td>
                                                <td>{{$stock->remain_weight}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info">Action</button>
                                                        <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <input type="text" hidden value="{{ $stock->id }}" name="stock_id" class="stock_id">
                                                            <button class="dropdown-item transfert">Sac Complet</button>
                                                            <button class="dropdown-item restant">Sac non Complet</button>
                                                            {{-- <a class="dropdown-item" onclick="return  confirm('Voulez vous supprimer cette ligne?')" href="{{ route('ligne.delete',[$ligne->id]) }}">Supprimer</a> --}}
                                                        </div>
                                                    </div>
                                                </td>
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
                    <h5 class="modal-title" id="exampleModalLabel">Sortie!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                        <div class="modal-body">
                                
                            <label for="p2">Quantité de sac complet</label>
                            <input type="text" hidden name="conditioning_id" value="" id="stock_id">
                            <input type="number" class="form-control mb-3" min=0 name="num_bag" id="" placeholder="Nombre de sac entier" value="">
                            <label for="">Order</label>
                            <select  class="form-control mb-3"  name="commande_id" id="commande_id1">
                            <label for="">Client</label>
                            <select  class="form-control mb-3"  name="client_id" id="client_id1">
                                <option value=""></option>
                                @foreach ($clients as $client)
                                <option value="{{$client->id}}">{{$client->code }} {{$client->code}}{{$client->name}} {{$client->first_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                            <a class="btn btn-primary" id="myvalider" data-dismiss="modal"  href="">Valider</a>
                        </div>
                
                
            </div>
        </div>
</div>

<div class="modal fade" id="myremainbag" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sortie!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                
                <form action=" ">
                    @csrf
                
                    <div class="modal-body">
                        <label for="p2">Quantité de sac non complet</label>
                        <input type="text" hidden name="conditioning_id" value="" id="remain_stock_id">
                        <input type="number" class="form-control mb-3" min=0 name="remain_bag" id="remain_bag" placeholder="Nombre de sac entier" value="1">

                        <label for="">Client</label>
                        <select class="form-control mb-3" name="client_id" id="client_id2">
                            <option value=""></option>
                            @foreach ($clients as $client)
                            <option value="{{$client->id}}">{{$client->code }} {{$client->code}}{{$client->name}} {{$client->first_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                        <a class="btn btn-primary" id="myremainvalider" data-dismiss="modal"  href="">Valider</a>
                    
                    </div>
                </form>
            </div>
        </div>
</div>
@endsection


@section('javascript')
<script src="{{ asset('asset/js/demo/datatables-demo.js')}}"></script>
<script src="{{ asset('asset/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('asset/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets/js/bootstrap.js')}}"></script>
    
<script>
    $(document).ready(function(){
        $('.transfert').click(function(event) {
            event.preventDefault();
            let stock_id = $(this).siblings(".stock_id").val();
            console.log(stock_id);

            
            let id_stock =  $('#stock_id').attr('value', stock_id);
            
            
            $('#mytransfert').modal('show');
        });

        $('.restant').click(function(event) {
            event.preventDefault();
            let stock_id = $(this).siblings(".stock_id").val();
            console.log(stock_id);
            
            let id_stock=  $('#remain_stock_id').attr('value', stock_id);
            
            
            $('#myremainbag').modal('show');
        });


        $('#myvalider').click(function(event) {
            event.preventDefault();

            let num_bag = $("input[name='num_bag']").val();
            let stock_id = $("input[name='conditioning_id']").val();
            let client_id = $("#client_id1").val();
            
            
            let data = {
                    "_token": "{{ csrf_token() }}",
                    num_bag : num_bag,
                    conditioning_id :stock_id,
                    client_id : client_id
                    
                }
             
            $.ajax({
                url: "{{ route('reception.exit_stocks') }}",
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

        }); /**/
        
        
        $('#myremainvalider').click(function(event) {
            event.preventDefault();

            let remain_bag = $("input[name='remain_bag']").val();
            let stock_id = $("input[name='stock_id']").val();
            let client_id = $("#client_id2").val();
            
            
            let data = {
                    "_token": "{{ csrf_token() }}",
                    remain_bag : remain_bag,
                    conditioning_id :stock_id,
                    client_id : client_id
                    
                }
             
            $.ajax({
                url: "{{ route('reception.exit_stocks') }}",
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

        })
    });
</script>
@endsection