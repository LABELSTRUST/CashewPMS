@extends('layouts.base')

@section('css')
    
<style>
  .myDiv{
      transition: all 0.5s ease;
  }
  .myDiv:hover{
      transform: scale(1.2);
      z-index: 1;
  }
</style>
@endsection

@section('content')
<div >
<h4 class="font-weight-bold py-3 mb-0">Menu</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href=""><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Menu</a></li>
            <li class="breadcrumb-item active">Menu</li>
        </ol>
    </div>

</div>
<div class="container">
    
</div>
<div class="row">            <!-- 1st row Start -->
  <div class="col-lg-10">
      <div class="row">{{-- --}}
              <div class="col-md-4">
                <div class="card border-primary mb-3" style="max-width: 35rem;">
                    <div class="card-header text-center d-flex justify-content-between" style="background-color: #efb71dcb; color: white;"><a class="  mr-2 " href=""><span class="feather icon-eye text-white"></span></a><span>Produits Finis</span> </div>
                    <div class="card-body ">
                        <div class="ml-5">
                          <h5 class="card-title ">Name : Amandes</h5>
                          <h5 class="card-title">Code : </h5>
                          <h5 class="card-title ">Grade : WW180 </h5>
                          <h5 class="card-title ">Code Grade : M001WW180 </h5>

                        </div>
                        
                        <div class="d-flex justify-content-around">
                          <div>
                          <div class=" badge-info text-center text-white p-3 mb-1" style=" background-color:  #0f5ca6"> 
                            1480
                          </div>
                            <h6 class="row ml-1">
                              <button class="btn"></button>
                            </h6>

                          </div>
                          <div>
                          <div class=" badge-warning  text-center text-white p-3 mb-1">
                              14801
                          </div>
                            <h6 class="row ml-1">
                              Stock Sortie
                            </h6>

                          </div>
                        </div>

                    </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card border-primary mb-3" style="max-width: 35rem;">
                    <div class="card-header text-center d-flex justify-content-between" style="background-color: #0f5ca6; color: white;"><a class="  mr-2 " href=""><span class="feather icon-eye text-white"></span></a><span>Produits Finis</span> </div>
                    <div class="card-body ">
                        <div class="ml-5">
                          <h5 class="card-title ">Name : Amandes</h5>
                          <h5 class="card-title">Code : </h5>
                          <h5 class="card-title ">Grade : WW180 </h5>
                          <h5 class="card-title ">Code Grade : M001WW180 </h5>

                        </div>
                        
                        <div class="d-flex justify-content-around">
                          <div>
                          <div class=" bg-info text-center text-white p-3 mb-1"> 
                            1480
                          </div>
                            <h6 class="row ml-1">
                              Stock Disponible
                            </h6>

                          </div>
                          <div>
                          <div class=" badge-warning  text-center text-white p-3 mb-1">
                              14801
                          </div>
                            <h6 class="row ml-1">
                              Stock Sortie
                            </h6>

                          </div>
                        </div>

                    </div>
                </div>
              </div>
              
              <div class="col-md-4">
                <div class="card border-primary mb-3" style="max-width: 35rem;">
                    <div class="card-header text-center d-flex justify-content-between" style="background-color: #0f5ca6; color: white;"><a class="  mr-2 " href=""><span class="feather icon-eye text-white"></span></a><span>Produits Finis</span> </div>
                    <div class="card-body ">
                        <div class="ml-5">
                          <h5 class="card-title ">Name : Amandes</h5>
                          <h5 class="card-title">Code : </h5>
                          <h5 class="card-title ">Grade : WW180 </h5>
                          <h5 class="card-title ">Code Grade : M001WW180 </h5>

                        </div>
                        
                        <div class="d-flex justify-content-around">
                          <div>
                          <div class=" bg-info text-center text-white p-3 mb-1"> 
                            1480
                          </div>
                            <h6 class="row ml-1">
                              Stock Disponible
                            </h6>

                          </div>
                          <div>
                          <div class=" badge-warning  text-center text-white p-3 mb-1">
                              14801
                          </div>
                            <h6 class="row ml-1">
                              Stock Sortie
                            </h6>

                          </div>
                        </div>

                    </div>
                </div>
              </div>
              
              <div class="col-md-4">
                <div class="card border-primary mb-3" style="max-width: 35rem;">
                    <div class="card-header text-center d-flex justify-content-between" style="background-color: #0f5ca6; color: white;"><a class="  mr-2 " href=""><span class="feather icon-eye text-white"></span></a><span>Produits Finis</span> </div>
                    <div class="card-body ">
                        <div class="ml-5">
                          <h5 class="card-title ">Name : Amandes</h5>
                          <h5 class="card-title">Code : </h5>
                          <h5 class="card-title ">Grade : WW180 </h5>
                          <h5 class="card-title ">Code Grade : M001WW180 </h5>

                        </div>
                        
                        <div class="d-flex justify-content-around">
                          <div>
                          <div class=" bg-info text-center text-white p-3 mb-1"> 
                            1480
                          </div>
                            <h6 class="row ml-1">
                              Stock Disponible
                            </h6>

                          </div>
                          <div>
                          <div class=" badge-warning  text-center text-white p-3 mb-1">
                              14801
                          </div>
                            <h6 class="row ml-1">
                              Stock Sortie
                            </h6>

                          </div>
                        </div>

                    </div>
                </div>
              </div>
              
              </div> 
      </div>
  </div>
                       
</div>


@endsection