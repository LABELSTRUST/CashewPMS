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
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Stock</a></li>
            <li class="breadcrumb-item active">Liste</li>
        </ol>
    </div>
</div>

<div class="row">
    
<div class="col-lg-10" style="margin-left: 2%;">
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
                                            <th>Code</th>
                                            <th>Désignation</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Code</th>
                                            <th>Désignation</th>
                                            <th>Action</th>
                                            <!--th>Salary</th-->
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($grades as $grade)
                                            <tr>
                                                <td>{{ $grade->id}} </td>
                                                <td>{{ $grade->code}} </td>
                                                <td>{{ $grade->designation}} </td>
                                                <td>
                                                    <a class="btn icon-btn btn-outline-info mr-2" href="{{ route('reception.stockbygrade',[$grade->id] ) }} "><span class="feather icon-eye"></span></a>
                                                    {{-- <div class="btn-group">
                                                        <button type="button" class="btn btn-info">Action</button>
                                                        <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="">Stock</a>
                                                            {{-- <a class="dropdown-item" onclick="return  confirm('Voulez vous supprimer cette ligne?')" href="{{ route('ligne.delete',[$ligne->id]) }}">Supprimer</a> 
                                                        </div>
                                                    </div>--}}
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
                    <h5 class="modal-title" id="exampleModalLabel">Transfert!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                        <label for="p2">Poids à transférer</label>
                        <input type="text" hidden name="id_reception" value="" id="id_reception">
                        <input type="number" class="form-control mb-3" min=0 name="net_weight" id="" placeholder="Poids à transférer" value="">
                        <label for="campagne">Section </label>{{-- 
                        <select class="form-control " name="section_id" id="section_id">
                            <option  selected value="">Section</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}">
                                    {{ $section->getSection?->designation }}
                                </option>
                            @endforeach
                        </select> --}}
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
<script src="{{ asset('asset/js/demo/datatables-demo.js')}}"></script>
<script src="{{ asset('asset/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('asset/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
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