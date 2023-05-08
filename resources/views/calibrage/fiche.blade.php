@extends('layouts.base')


@section('content')


<div style="margin-left: 2%;">
    <h4 class="font-weight-bold py-3 mb-0">Calibrage</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Calibrage</a></li>
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
              <a href="{{ route('imprimer.fiche_calibrage',[$calibrage->id]) }}" target="_blank" class="btn btn-lg lnr lnr-printer btn-outline-info"> Imprimer</a>
            </div>
         </div>
         <div class="row">
            
         <div class="container-fluid flex-grow-1 container-p-ycard shadow mb-4 pmanager">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">Fiche de calibrage</h6>
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
                                        @if (isset($calibrage->cooperative))
                                           <td> {{ $calibrage->cooperative}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Quantité</td>

                                        
                                        @if (isset($calibrage->sacks_bought))
                                          <td> {{ $calibrage->sacks_bought}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                        
                                      </tr>
                                      <tr>
                                        <td>Poids net </td>
                                        @if (isset($calibrage->total_weight))
                                          <td> {{ $calibrage->total_weight}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Id lot fournisseur </td>
                                        @if (isset( $calibrage->id_lot_externe))
                                        <td> {{ $calibrage->id_lot_externe}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Lot PMS</td>
                                        @if (isset( $calibrage->id_lot_pms))
                                        <td> {{ $calibrage->id_lot_pms}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Prix Unitaire</td>
                                        @if (isset( $calibrage->unit_price) && ($calibrage->devise))
                                        <td> {{ round($calibrage->unit_price,0) }} {{ $calibrage->devise}} </td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Montant Payé </td>
                                        @if (isset( $calibrage->amount_paid) && ($calibrage->devise))
                                          <td> {{ $calibrage->amount_paid }} {{  $calibrage->devise}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <th rowspan="4"><strong style="text-transform:uppercase;font-size:larger;">Transfert</strong></th>
                                        <td>Date de chargement </td>
                                        @if (isset( $calibrage->date_charg))
                                        <td> {{ $calibrage->date_charg}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Numéro du permis de conduire </td>
                                        @if (isset( $calibrage->num_permis ))
                                        <td>{{ $calibrage->num_permis}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Nom du chauffeur </td>
                                        @if (isset( $calibrage->name_driver ))
                                          <td>{{$calibrage->name_driver}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Signature Chauffeur</td>
                                        @if (isset( $calibrage->signature_chauffeur ))
                                        <td><img class='imported ' style="border: 1px solid #ced4da54;display: block;width: 50%;" src="data:{{ $calibrage->signature_chauffeur }}"></img>
                                          <input  type="hidden" class="form-control" id="signature_chauffeur" name="signature_chauffeur" value="{{ $calibrage->signature_chauffeur }}"></td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <th rowspan="4"><strong style="text-transform:uppercase;font-size:larger;">DESTINATION</strong></th>
                                        <td>Date et heure de déchargement</td>
                                        @if (isset(  $calibrage->date_time_decharge ))
                                        <td>{{ $calibrage->date_time_decharge}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Usine de déchargement</td>
                                        @if (isset(  $calibrage->port_decharge ))
                                        <td>{{ $calibrage->port_decharge}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Quantité déchargée</td>
                                        @if (isset(  $calibrage->qte_decharge ))
                                        <td>{{ $calibrage->qte_decharge}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Poids net</td>
                                        @if (isset(  $calibrage->net_weight ))
                                        <td>{{ $calibrage->net_weight}} Kg</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <th rowspan="{{ isset($calibrage->kor ) ? 8 : 4 }}"><strong style="text-transform:uppercase;font-size:larger;">CONTRÔLE QUALITÉ</strong></th>
                                        <td>Date contrôle qualité</td>
                                        @if (isset(  $calibrage->date_controle ))
                                        <td>{{ $calibrage->date_controle}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Nom Contôleur</td>
                                        @if (isset(  $calibrage->nom_controleur ))
                                        <td>{{ $calibrage->nom_controleur}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Signature du Contrôleur</td>
                                        @if (isset(  $calibrage->signature_controleur ))
                                        <td><img class='imported ' style="border: 1px solid #ced4da54;display: block;width: 50%;" src="data:{{ isset($calibrage->signature_controleur)? $calibrage->signature_controleur :"" }}"></img>
                                          <input  type="hidden" class="form-control" id="signature_controleur" name="signature_controleur" value="{{ $calibrage->signature_controleur }}"></td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      @if ($calibrage->kor)
                                          <tr>
                                            <td>Taux d'humidité</td>
                                            <td>{{ $calibrage->taux_humidite}}</td>
                                          </tr>
                                          <tr>
                                            <td>Grainage</td>
                                            <td>{{ $calibrage->grainage}}</td>
                                          </tr>
                                          <tr>
                                            <td>Taux de défauts</td>
                                            <td>{{ $calibrage->default_thaux}}</td>
                                          </tr>
                                          <tr>
                                            <td>KOR</td>
                                            <td>{{ $calibrage->kor}}</td>
                                          </tr>
                                          
                                      @endif
                                          
                                      <tr>
                                        <td>Observation</td>
                                        @if (isset(  $calibrage->observation ))
                                        <td>{{ $calibrage->observation}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <th rowspan="3"><strong style="text-transform:uppercase;font-size:larger;">STOCKAGE</strong> </th>
                                        <td>Nom Magasinier</td>
                                        @if (isset(  $calibrage->nom_mag ))
                                        <td>{{ $calibrage->nom_mag}}</td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Signature du magasinier</td>
                                        @if (isset($calibrage->signature_magasinier ))
                                        <td><img class='imported ' style="border: 1px solid #ced4da54;display: block;width: 50%;" src="data:{{ $calibrage->signature_magasinier }}"></img>
                                          <input  type="hidden" class="form-control" id="signature_magasinier" name="signature_magasinier" value="{{ $calibrage->signature_magasinier }}"></td>
                                            
                                        @else
                                            <td></td>
                                        @endif
                                      </tr>
                                      <tr>
                                        <td>Localisation dans le magasin</td>
                                        @if (isset(  $calibrage->localisation ))
                                        <td>{{ $calibrage->localisation}}</td>
                                            
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

