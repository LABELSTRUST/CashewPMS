@extends('layouts.base')


@section('content')


<div style="margin-left: 2%;">
    <h4 class="font-weight-bold py-3 mb-0">Réception</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Réception</a></li>
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
            <div class="mb-2" >
              <a href="{{ route('imprimer.fiche',[$reception->id]) }}" target="_blank" class="btn btn-lg lnr lnr-printer btn-outline-info"> Imprimer</a>
            </div>
         </div>
         <div class="row">
            
         <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Fiche de réception</h6>
                        </div>
                        <div class="card-body ">
                            <div class="table-responsive   col-md-6-sm-6-xs-6">
                                <table class="table table-bordered "  width="100%" cellspacing="0">
                                    
                                    <tbody>
                                      <tr>
                                        <th rowspan="8"><strong style="text-transform:uppercase;font-size:larger;">Origine</strong></th>
                                        <td>Date  </td>
                                        
                                     @if (isset($date_recep))
                                        <td> {{ $date_recep->format('d-m-Y')}}</td>
                                         
                                     @else
                                         <td></td>
                                     @endif
                                      </tr>
                                      <tr>
                                        <td>Fournisseur </td>
                                        @if (isset($reception->cooperative))
                                           <td> {{ $reception->cooperative}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Quantité</td>

                                        
                                        @if (isset($reception->sacks_bought))
                                          <td> {{ $reception->sacks_bought}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                        
                                      </tr>
                                      <tr>
                                        <td>Poids net </td>
                                        @if (isset($reception->total_weight))
                                          <td> {{ $reception->total_weight}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Id lot fournisseur </td>
                                        @if (isset( $reception->id_lot_externe))
                                        <td> {{ $reception->id_lot_externe}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Lot PMS</td>
                                        @if (isset( $reception->id_lot_pms))
                                        <td> {{ $reception->id_lot_pms}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Prix Unitaire</td>
                                        @if (isset( $reception->unit_price) && ($reception->devise))
                                        <td> {{ round($reception->unit_price,0) }} {{ $reception->devise}} </td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Montant Payé </td>
                                        @if (isset( $reception->amount_paid) && ($reception->devise))
                                          <td> {{ $reception->amount_paid }} {{  $reception->devise}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <th rowspan="4"><strong style="text-transform:uppercase;font-size:larger;">Transfert</strong></th>
                                        <td>Date de chargement </td>
                                        @if (isset( $reception->date_charg))
                                        <td> {{ $reception->date_charg}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Numéro du permis de conduire </td>
                                        @if (isset( $reception->num_permis ))
                                        <td>{{ $reception->num_permis}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Nom du chauffeur </td>
                                        @if (isset( $reception->name_driver ))
                                          <td>{{$reception->name_driver}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Signature Chauffeur</td>
                                        @if (isset( $reception->signature_chauffeur ))
                                        <td><img class='imported ' style="border: 1px solid #ced4da54;display: block;width: 50%;" src="data:{{ $reception->signature_chauffeur }}"></img>
                                          <input  type="hidden" class="form-control" id="signature_chauffeur" name="signature_chauffeur" value="{{ $reception->signature_chauffeur }}"></td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <th rowspan="4"><strong style="text-transform:uppercase;font-size:larger;">DESTINATION</strong></th>
                                        <td>Date et heure de déchargement</td>
                                        @if (isset(  $reception->date_time_decharge ))
                                        <td>{{ $reception->date_time_decharge}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Usine de déchargement</td>
                                        @if (isset(  $reception->port_decharge ))
                                        <td>{{ $reception->port_decharge}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Quantité déchargée</td>
                                        @if (isset(  $reception->qte_decharge ))
                                        <td>{{ $reception->qte_decharge}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Poids net</td>
                                        @if (isset(  $reception->net_weight ))
                                        <td>{{ $reception->net_weight}} Kg</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <th rowspan="{{ isset($reception->kor ) ? 8 : 4 }}"><strong style="text-transform:uppercase;font-size:larger;">CONTRÔLE QUALITÉ</strong></th>
                                        <td>Date contrôle qualité</td>
                                        @if (isset(  $reception->date_controle ))
                                        <td>{{ $reception->date_controle}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Nom Contôleur</td>
                                        @if (isset(  $reception->nom_controleur ))
                                        <td>{{ $reception->nom_controleur}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Signature du Contrôleur</td>
                                        @if (isset(  $reception->signature_controleur ))
                                        <td><img class='imported ' style="border: 1px solid #ced4da54;display: block;width: 50%;" src="data:{{ isset($reception->signature_controleur)? $reception->signature_controleur :"" }}"></img>
                                          <input  type="hidden" class="form-control" id="signature_controleur" name="signature_controleur" value="{{ $reception->signature_controleur }}"></td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      @if ($reception->kor)
                                          <tr>
                                            <td>Taux d'humidité</td>
                                            <td>{{ $reception->taux_humidite}}</td>
                                          </tr>
                                          <tr>
                                            <td>Grainage</td>
                                            <td>{{ $reception->grainage}}</td>
                                          </tr>
                                          <tr>
                                            <td>Taux de défauts</td>
                                            <td>{{ $reception->default_thaux}}</td>
                                          </tr>
                                          <tr>
                                            <td>KOR</td>
                                            <td>{{ $reception->kor}}</td>
                                          </tr>
                                          
                                      @endif
                                          
                                      <tr>
                                        <td>Observation</td>
                                        @if (isset(  $reception->observation ))
                                        <td>{{ $reception->observation}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <th rowspan="3"><strong style="text-transform:uppercase;font-size:larger;">STOCKAGE</strong> </th>
                                        <td>Nom Magasinier</td>
                                        @if (isset(  $reception->nom_mag ))
                                        <td>{{ $reception->nom_mag}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Signature du magasinier</td>
                                        @if (isset($reception->signature_magasinier ))
                                        <td><img class='imported ' style="border: 1px solid #ced4da54;display: block;width: 50%;" src="data:{{ $reception->signature_magasinier }}"></img>
                                          <input  type="hidden" class="form-control" id="signature_magasinier" name="signature_magasinier" value="{{ $reception->signature_magasinier }}"></td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Localisation dans le magasin</td>
                                        @if (isset(  $reception->localisation ))
                                        <td>{{ $reception->localisation}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
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

