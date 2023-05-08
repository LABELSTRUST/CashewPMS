<!DOCTYPE html>

<html lang="en" class="material-style layout-fixed">

<head>
    <title>CashewPMS</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="Empire Bootstrap admin template made using Bootstrap 4, it has tons of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
    <meta name="keywords" content="Empire, bootstrap admin template, bootstrap admin panel, bootstrap 4 admin template, admin template">
    <meta name="author" content="Srthemesvilla" />
    <link rel="icon" type="image/x-icon"  href="{{ asset('assets/img/cashew.jpeg')}}">

    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

    <!-- Icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/ionicons.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/linearicons.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/open-iconic.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/pe-icon-7-stroke.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css')}}">
    
    <link href="{{ asset('assets/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

    <!-- Core stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-material.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/shreerang-material.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/uikit.css')}}">

    <!-- Libs -->
    <link rel="stylesheet" href="{{ asset('assets/libs/perfect-scrollbar/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/libs/flot/flot.css')}}">
    
    <link rel="stylesheet" href="{{ asset('assets/css/pmanager.css')}}">
    
  <style>
    @page {
      size: 21cm 29.7cm;
      margin: 0;
    }
    body {
      padding: 0;
    }
    #customers {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    #customers td, #customers th {
      border: 1px solid #ddd;
      padding: 8px;
    }

    #customers tr:nth-child(even){background-color: #f2f2f2;}

    #customers tr:hover {background-color: #ddd;}

    #customers th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: #04AA6D;
      color: white;
    }
  </style>
</head>

<body >



  
    <table class="table table-bordered" id="customers"  width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Calibrage</th>
                <th>{{ $date_recep->format('d-m-Y')}}</th>
                <!--th>Salary</th-->
            </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="3">Origines  : </td>
            <td>Pays :  {{ $calibrage->get_Geo?->country}}</td>
          </tr>
          <tr>
            <td >Villes / Communes : {{ $calibrage->get_Geo?->town}} </td>
          </tr>
          <tr>
            <td >Quartier de ville / Village :  {{ $calibrage->get_Geo?->neighborhood}}</td>
            
          </tr>
          <tr>
            <td>Fournisseur : </td>
            <td> {{ $calibrage->geSupplier?->company}}</td>
          </tr>
          <tr>
            <td>Date de déchargement : </td>
            <td> {{ $date_time_decharge->format('d-m-Y')}} {!! DNS1D::getBarcodeHTML($bar_decharge, 'PHARMA') !!}</td>
          </tr>
          <tr>
            <td>Lieu de déchargement : </td>
            <td> {{ $calibrage->port_decharge}}</td>
          </tr>
          <tr>
            <td>Date de chargement : </td>
            <td> {{ $date_charg->format('d-m-Y')}} {!! DNS1D::getBarcodeHTML($bar_recharge, 'PHARMA') !!}</td>
          </tr>
          <tr>
            <td>Lot PMS : </td>
            <td> <h2>{{ $calibrage->id_lot_pms}}</h2> </td>
          </tr>
          <tr>
            <td>Localisation dans le Magasin : </td>
            <td> {{ $calibrage->localisation}}</td>
          </tr>
          <tr>
            <td>Magasinier : </td>
            <td> {{ $calibrage->nom_mag }} {{-- {{ $calibrage->getUser?->name}} --}}</td>
          </tr>
          <tr>
            <td>Nombre total de sacs : </td>
            <td> {{ $calibrage->qte_decharge}} {{-- {!! DNS1D::getBarcodeHTML($calibrage->qte_decharge, 'PHARMA') !!} --}}</td>
          </tr>
          {{-- <tr>
            <td>Poids brut en kg : </td>
            <td> {{ $calibrage->poids_theorique}}</td>
          </tr> --}}
          <tr>
            <td style="height: 10%">Poids net en kilogramme : </td>
            <td> <h2>{{ $calibrage->net_weight }} {!! DNS1D::getBarcodeHTML($calibrage->net_weight, 'PHARMA') !!}</h2></td>
          </tr>
          <tr>
            <td>Contrôle qualité:</td>
            <td><img src="data:image/png;base64, {!! base64_encode(QrCode::size(100)->generate(route('get_data_quality', $calibrage->id))) !!} "></td>
          </tr>
          <tr>
            <td>Contrôleur qualité:</td>
            <td> {{ $calibrage->nom_controleur }} </td>
          </tr>

          
        </tbody>
      
    </table>





    <script src="{{ asset('assets/js/pace.js')}}"></script>
    <script src="{{ asset('assets/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{ asset('assets/libs/popper/popper.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap.js')}}"></script>
    <script src="{{ asset('assets/js/demo.js')}}"></script><script src="{{ asset('assets/js/analytics.js')}}"></script>
    <script src="{{ asset('assets/js/pages/dashboards_index.js')}}"></script>
</body>
</html>