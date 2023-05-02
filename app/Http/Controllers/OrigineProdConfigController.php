<?php

namespace App\Http\Controllers;

use App\Models\OrigineProd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrigineProdConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( Auth::check()){
            $user = $this->verifyMagasinier();
            if($user){
                //
            }else return redirect('login');
        }else return redirect('login');
    }

    
    public function verifyMagasinier()
    {
        $magasinier = app(AuthController::class);
        $result = $magasinier->magasinierCheck();
        return  $result;
    }

    public function registerOrigin(Request $request)
    {
        
        if( Auth::check()){
            $user=$this->verifyMagasinier();
            if ($user) {
                
                $validator = Validator::make($request->all(), [
                    'total_weight'=>'',
                    'date_recep'=>'',
                    'sacks_bought'=>'',
                    'sack_transmit'=>'',
                    'campagne'=>'',
                    'rep_usine'=>'',
                    'cooperative'=>'',
                    'id_lot_externe'=>'',
                    'id_lot_pms'=>'',
                    'unit_price'=>'',
                    'amount_paid'=>'',
                    'matiere_id'=>'',
                    'date_charg'=>'',
                    'name_transporter'=>'',
                    'nb_sacks'=>'',
                    'poids_theorique'=>'',
                    'marque_cam'=>'',
                    'immatriculation_camion'=>'',
                    'name_driver'=>'',
                    'num_permis'=>'',
                    'date_time_decharge'=>'',
                    'port_decharge'=>'',
                    'pont_bascule'=>'',
                    'qte_decharge'=>'',
                    'nb_sac_return'=>'',
                    'brut_weight'=>'',
                    'net_weight'=>'',
                    'devise'=>''

                ]);
                
                $data = $request->all();
                $exist = OrigineProd::where('matiere_id',$data['matiere_id'])->first();
                if($exist){
                    return response()->json($exist);
                }

                $response = OrigineProd::create([
                    'total_weight'=>$data['total_weight'],
                    'date_recep'=>$data['date_recep'],
                    'sacks_bought'=>$data['sacks_bought'],
                    'sack_transmit'=>$data['sack_transmit'],
                    'campagne'=>$data['campagne'],
                    'rep_usine'=>$data['rep_usine'],
                    'cooperative'=>$data['cooperative'],
                    'id_lot_externe'=>$data['id_lot_externe'],
                    'id_lot_pms'=>$data['id_lot_pms'],
                    'unit_price'=>$data['unit_price'],
                    'amount_paid'=>$data['amount_paid'],
                    'date_charg'=>$data['date_charg'],
                    'name_transporter'=>$data['name_transporter'],
                    'nb_sacks'=>$data['nb_sacks'],
                    'poids_theorique'=>$data['poids_theorique'],
                    'marque_cam'=>$data['marque_cam'],
                    'immatriculation_camion'=>$data['immatriculation_camion'],
                    'name_driver'=>$data['name_driver'],
                    'num_permis'=>$data['num_permis'],
                    'date_time_decharge'=>$data['date_time_decharge'],
                    'port_decharge'=>$data['port_decharge'],
                    'pont_bascule'=>$data['pont_bascule'],
                    'qte_decharge'=>$data['qte_decharge'],
                    'nb_sac_return'=>$data['nb_sac_return'],
                    'brut_weight'=>$data['brut_weight'],
                    'net_weight'=>$data['net_weight'],
                    'devise'=>$data['devise'],
                    'matiere_id'=>$data['matiere_id']

                ]);
                if ($response) {
                    return response()->json($response);
                }

            }else return redirect('login');
        }else return redirect('login');
        
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( Auth::check()){
            $user=$this->verifyMagasinier();
            if ($user) {
                

            }else return redirect('login');
        }else return redirect('login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if( Auth::check()){
            $user=$this->verifyMagasinier();
            if ($user) {
                
                $validator = Validator::make($request->all(), [
                    'total_weight'=>'require',
                    'date_recep'=>'require',
                    'sacks_bought'=>'require',
                    'sack_transmit'=>'require',
                    'campagne'=>'require',
                    'rep_usine'=>'require',
                    'cooperative'=>'require',
                    'id_lot_externe'=>'require',
                    'id_lot_pms'=>'require',
                    'unit_price'=>'require',
                    'amount_paid'=>'require',
                    'matiere_id'=>'require',
                    'date_charg'=>'require',
                    'name_transporter'=>'require',
                    'nb_sacks'=>'require',
                    'poids_theorique'=>'require',
                    'marque_cam'=>'require',
                    'immatriculation_camion'=>'require',
                    'name_driver'=>'require',
                    'num_permis'=>'require',
                    'date_time_decharge'=>'require',
                    'port_decharge'=>'require',
                    'pont_bascule'=>'require',
                    'qte_decharge'=>'require',
                    'nb_sac_return'=>'require',
                    'brut_weight'=>'require',
                    'net_weight'=>'require',
                    'devise'=>'require',

                    'localisation'=>'require',
                    'signature_chauffeur'=>'require',
                    'default_thaux'=>'require',
                    'taux_humidite'=>'require',
                    'grainage'=>'require',
                    'date_controle'=>'require',
                    'kor'=>'require',
                    'nom_controleur'=>'require',
                    'signature_controleur'=>'require',
                    'nom_mag'=>'require',
                    'signature_magasinier'=>'require',
                    'observation'=>'require',

                ]);
                
                $data = $request->all();
                $origin = OrigineProd::where('matiere_id',$data['matiere_id'])->first();
                if($origin){
                    $update = $origin->update([
                        'total_weight'=>$data['total_weight'],
                        'date_recep'=>$data['date_recep'],
                        'sacks_bought'=>$data['sacks_bought'],
                        'sack_transmit'=>$data['sack_transmit'],
                        'campagne'=>$data['campagne'],
                        'rep_usine'=>$data['rep_usine'],
                        'cooperative'=>$data['cooperative'],
                        'id_lot_externe'=>$data['id_lot_externe'],
                        'id_lot_pms'=>$data['id_lot_pms'],
                        'unit_price'=>$data['unit_price'],
                        'amount_paid'=>$data['amount_paid'],
                        'date_charg'=>$data['date_charg'],
                        'name_transporter'=>$data['name_transporter'],
                        'nb_sacks'=>$data['nb_sacks'],
                        'poids_theorique'=>$data['poids_theorique'],
                        'marque_cam'=>$data['marque_cam'],
                        'immatriculation_camion'=>$data['immatriculation_camion'],
                        'name_driver'=>$data['name_driver'],
                        'num_permis'=>$data['num_permis'],
                        'date_time_decharge'=>$data['date_time_decharge'],
                        'port_decharge'=>$data['port_decharge'],
                        'pont_bascule'=>$data['pont_bascule'],
                        'qte_decharge'=>$data['qte_decharge'],
                        'nb_sac_return'=>$data['nb_sac_return'],
                        'brut_weight'=>$data['brut_weight'],
                        'net_weight'=>$data['net_weight'],
                        'devise'=>$data['devise'],
                        'matiere_id'=>$data['matiere_id'],

                        'localisation'=>$data['localisation'],
                        'signature_chauffeur'=>$data['signature_chauffeur'],
                        'default_thaux'=>$data['default_thaux'],
                        'taux_humidite'=>$data['taux_humidite'],
                        'grainage'=>$data['grainage'],
                        'date_controle'=>$data['date_controle'],
                        'kor'=>$data['kor'],
                        'nom_controleur'=>$data['nom_controleur'],
                        'signature_controleur'=>$data['signature_controleur'],
                        'nom_mag'=>$data['nom_mag'],
                        'signature_magasinier'=>$data['signature_magasinier'],
                        'observation'=>$data['observation'],
                    ]);
                    if($update){
                        return redirect()->route('inventaire.create', $data['matiere_id'])->with('message',"Enregistrer avec succès");
                    }else return redirect()->route('inventaire.create', $data['matiere_id'])->with('error',"Une erreur s'est produite");
                }else{
                    $create =OrigineProd::create([
                        'total_weight'=>$data['total_weight'],
                        'date_recep'=>$data['date_recep'],
                        'sacks_bought'=>$data['sacks_bought'],
                        'sack_transmit'=>$data['sack_transmit'],
                        'campagne'=>$data['campagne'],
                        'rep_usine'=>$data['rep_usine'],
                        'cooperative'=>$data['cooperative'],
                        'id_lot_externe'=>$data['id_lot_externe'],
                        'id_lot_pms'=>$data['id_lot_pms'],
                        'unit_price'=>$data['unit_price'],
                        'amount_paid'=>$data['amount_paid'],
                        'date_charg'=>$data['date_charg'],
                        'name_transporter'=>$data['name_transporter'],
                        'nb_sacks'=>$data['nb_sacks'],
                        'poids_theorique'=>$data['poids_theorique'],
                        'marque_cam'=>$data['marque_cam'],
                        'immatriculation_camion'=>$data['immatriculation_camion'],
                        'name_driver'=>$data['name_driver'],
                        'num_permis'=>$data['num_permis'],
                        'date_time_decharge'=>$data['date_time_decharge'],
                        'port_decharge'=>$data['port_decharge'],
                        'pont_bascule'=>$data['pont_bascule'],
                        'qte_decharge'=>$data['qte_decharge'],
                        'nb_sac_return'=>$data['nb_sac_return'],
                        'brut_weight'=>$data['brut_weight'],
                        'net_weight'=>$data['net_weight'],
                        'devise'=>$data['devise'],
                        'matiere_id'=>$data['matiere_id'],

                        'localisation'=>$data['localisation'],
                        'signature_chauffeur'=>$data['signature_chauffeur'],
                        'default_thaux'=>$data['default_thaux'],
                        'taux_humidite'=>$data['taux_humidite'],
                        'grainage'=>$data['grainage'],
                        'date_controle'=>$data['date_controle'],
                        'kor'=>$data['kor'],
                        'nom_controleur'=>$data['nom_controleur'],
                        'signature_controleur'=>$data['signature_controleur'],
                        'nom_mag'=>$data['nom_mag'],
                        'signature_magasinier'=>$data['signature_magasinier'],
                        'observation'=>$data['observation'],
                    ]);
                    if($create){
                        
                        return redirect()->route('inventaire.create', $data['matiere_id'])->with('message',"Enregistrer avec succès");
                    }else return redirect()->route('inventaire.create', $data['matiere_id'])->with('error',"Une erreur s'est produite");
                }
                
            }else return redirect('login');
        }else return redirect('login');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrigineProd  $origineProd
     * @return \Illuminate\Http\Response
     */
    public function show(OrigineProd $origineProd)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrigineProd  $origineProd
     * @return \Illuminate\Http\Response
     */
    public function edit(OrigineProd $origineProd)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrigineProd  $origineProd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrigineProd $origineProd)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrigineProd  $origineProd
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrigineProd $origineProd)
    {
        //
    }
}
