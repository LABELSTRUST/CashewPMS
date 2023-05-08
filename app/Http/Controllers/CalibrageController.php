<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\Poste;
use App\Models\Stock;
use App\Models\Section;
use App\Models\Assigner;
use App\Models\Sequence;
use App\Models\Calibrage;
use App\Models\Calibreuse;
use App\Models\OrigineProd;
use App\Models\StockRecepT;
use App\Models\TypeCalibre;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Depelliculage;
use App\Models\Classification;
use App\Models\Conditionnement;
use App\Models\OperatorSequence;
use App\Models\RapportCalibrage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Current_rapport_Calibrage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CalibrageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($stock = null)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {

               // $origin_id = OrigineProd::where('matiere_id',$stock)->pluck('id');
              //dd($origin_id);  
                //$receptions = Stock::whereIn('origin_id',$origin_id)->get();
               // $calibrage= Calibrage::find('id')->first();
            // $origin = $calibrage->getStock?->getStock?->getOrigin?->get_Geo?->country
                $etape_calibrage = 1;
                
                $calibrages = Calibrage::where('stock_id',$stock)->orderBy('id','DESC')->paginate(20);
                 
            // $origin = $calibrages->getStock?->getStock?->getOrigin?->get_Geo?->countr;
            //    ( $origin);
                return view('calibrage.index',compact('calibrages','stock','etape_calibrage'));

            }else return redirect('login');
        }else return redirect('login');
    }
    
    public function verifyOperator()
    {
        $magasinier = app(AuthController::class);
        $result = $magasinier->operatorCheck();
        return  $result;
    }

    public function processusCalibrage($stock)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                if ($operator_sequence) {
                    $etape_calibrage = 1;
                    $calibres = TypeCalibre::get();
                    $session = session::all();
                    $graders = Calibreuse::get();
                    return view('calibrage.processus', compact('calibres','stock','etape_calibrage','graders'));

                }else return redirect()->route('dashboard')->with('message',"Accès refusé");

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
        //
    }


    public function registerGradering(Request $request)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                
                $request->validate([
                    'name_seizer'=>'sometimes|nullable',
                    'net_weight'=>'sometimes|nullable',
                ]); /* */
                $data = $request->all();

                
                foreach($data as $key=>$value){
                    if($key != '_token'){
                        $keys = $key;
                        $response  = session::put($keys , $value);
                    }
                }

                $session = session::all();
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();

                $calibrage = new Calibrage();
                foreach ($data as $column => $value) {
                    if($column != '_token'){
                        $calibrage->$column = $value;
                    }
                }
                $calibrage->author_id = $user->id;
                $calibrage->name_seizer = $session['name_seizer'];
                $calibrage->net_weight =  $session['net_weight'];
                $calibrage->sequence_id =  $operator_sequence->sequence_id;
                $calibrage->save();

            }else return redirect('login');
        }else return redirect('login');
    }

    public function session_add_weight(Request $request)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $request->validate([
                   'name_seizer'=>'sometimes|nullable',
                   'net_weight'=>'sometimes|nullable',
                   'rejection_weight'=>'sometimes|nullable',
                   'caliber_weight'=>'sometimes|nullable',
               ]); 

                $data = $request->all();
                foreach($data as $key=>$value){
                    if($key != '_token'){
                        $keys = $key;
                        $response  = session::put($keys , $value);
                    }
                }
                $session = session::all();
                return response()->json([
                    'message'=>"Poids et calibreuse enregistrés dans la session"
                ]);

            }else return redirect('login');
        }else return redirect('login');
    }

    public function registercalibrage(Request $request)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                
                
                 $request->validate([
                    'name_seizer'=>'sometimes|nullable',
                    'net_weight'=>'sometimes|nullable',
                    'rejection_weight'=>'sometimes|nullable',
                    'caliber_weight'=>'sometimes|nullable',
                    'stock_id'=>'sometimes|nullable',
                    'calibre_id'=>'sometimes|nullable',
                ]); /**/
                
                $session1 = session::all();
                $data = $request->all();
                if (isset($session1['stock_id']) ) {
                    if ($session1['stock_id'] != $data['stock_id']  && ($session1['name_seizer'] != $data['name_seizer'])) {
                        
                        
                        $array = ['name_seizer','net_weight','stock_id','rejection_weight','caliber_weight','calibre_id','localisation'];
                        foreach($array as $key){
                            session::forget($key);
                        }
                    }
                }
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();

                $session = session::all();
                $exist = Calibrage::where('stock_id',$data['stock_id'])->where('calibre_id',$data['calibre_id'])->first();
                if ($exist) {
                    
                    foreach($data as $column => $value) {
                        if ($column != '_token') {
                            $exist->update([$column => $value]);
                        }
                    }
                    
                    $exist->update([
                        'name_seizer' => $session['name_seizer'],
                        'net_weight' => $session['net_weight'],
                        'rejection_weight' => $session['rejection_weight'],
                    ]);
                    return response()->json([
                        'existant'=>$exist
                    ]);

                }else {
                    $type = TypeCalibre::where('id',$data['calibre_id'])->first();
                    $stock = StockRecepT::where('id',$session['stock_id'])->first();
                    $id_lot = $stock->new_id_lot_transfert.'-'.$type->code_calibre;

                    
                    $calibrage = new Calibrage();
                    foreach ($data as $column => $value) {
                        if($column != '_token'){
                            $calibrage->$column = $value;
                        }
                    }
                    $calibrage->author_id = $user->id;
                    $calibrage->name_seizer = $session['name_seizer'];
                    $calibrage->net_weight =  $session['net_weight'];
                    //$calibrage->rejection_weight =  $session['rejection_weight'];
                    $calibrage->sequence_id =  $operator_sequence->sequence_id;
                    $calibrage->id_lot_calibre =  $id_lot;
                    $calibrage->save();
                    if ($calibrage) {
                        return response()->json([
                            'calibrage'=>$calibrage
                        ]);
                    }else {
                        return response()->json([
                            'ça ne marche pas'
                        ]);
                    }
                }

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
            $user=$this->verifyOperator();
            if ($user) {
                
                
                 $request->validate([
                    'name_seizer'=>'sometimes|nullable',
                    'net_weight'=>'sometimes|nullable',
                    'rejection_weight'=>'sometimes|nullable',
                    'caliber_weight'=>'sometimes|nullable',
                ]); /**/
                
                $session1 = session::all();
                $data = $request->all();
                if (isset($session1['stock_id']) ) {
                    if ($session1['stock_id'] != $data['stock_id']) {
                        
                        $array = ['name_seizer','net_weight','stock_id','rejection_weight','caliber_weight','calibre_id','localisation'];
                        foreach($array as $key){
                            session::forget($key);
                        }
                    }
                }
                
                foreach($data as $key=>$value){
                    if($key != '_token'){
                        $keys = $key;
                        $response  = session::put($keys , $value);
                    }
                }

                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                
                $session = session::all();
                if ($session) {
                        if (isset($session['calibre_id'])) {

    
                            $exist = Calibrage::where('stock_id',$session['stock_id'])->where('calibre_id',$session['calibre_id'])->first();
    
                            if ($exist) {

    
                                foreach($data as $column => $value) {
                                    if ($column != '_token') {
                                        $exist->update([$column => $value]);
                                    }
                                }
                                $stock = StockRecepT::where('id',$session['stock_id'])->first();
                                $id_lot = $stock->id_lot_transfert.'-'.$exist->getCalibre->code_calibre;
                                
    
                                $exist->update([
                                    'name_seizer' => $session['name_seizer'],
                                    'net_weight' => $session['net_weight'],
                                    'rejection_weight' => $session['rejection_weight'],
                                    'id_lot_calibre'=>$id_lot,
                                    'sequence_id'=> $operator_sequence->sequence_id
                                ]);
                                return response()->json([
                                    'existant'=>$exist
                                ]);
    
    
                            }else {
                                
                              /*   $allready = Calibrage::where('stock_id',$session['stock_id'])->first();
                                if (!$allready) {
                                    $array = ['net_weight','rejection_weight','localisation'];
                                    foreach($array as $key){
                                        session::forget($key);
                                    }
                                } */

                                $calibrage = new Calibrage();
                                foreach ($data as $column => $value) {
                                    if($column != '_token'){
                                        $calibrage->$column = $value;
                                    }
                                }
                                

                                $calibrage->author_id = $user->id;
                                $calibrage->name_seizer = $session['name_seizer'];
                                $calibrage->net_weight =  $session['net_weight'];
                                $calibrage->sequence_id =  $operator_sequence->sequence_id;
                                $calibrage->save();
                                if ($calibrage) {
                                    return response()->json([
                                        'calibrage'=>$calibrage
                                    ]);
                                }else {
                                    return response()->json([
                                        'ça ne marche pas'
                                    ]);
                                }
                            }
                            
                        }else {
    
                            return response()->json([
                                $session
                            ]);
                            
                        }


                }
            

            }else return redirect('login');
        }else return redirect('login');
    }

    public function storelocation(Request $request)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $request->validate([
                    'localisation'=>'required',
                    'calibre_id'=>'required',
                    'stock_id'=>'required',
                ]);
                
                $data = $request->all();
                $exist = Calibrage::where('stock_id',$data['stock_id'])->where('calibre_id',$data['calibre_id'])->first();
                if ($exist) {
                    
                    session::put('localisation',$data['localisation']);
                    session::put('calibre_id',$data['calibre_id']);

                    $session = session::all();
                    $update = $exist->update([
                        'localisation'=>$data['localisation'],
                        'rejection_weight'=>$session['rejection_weight']
                    ]);
                    
                    if ($update) {
                        return response()->json([
                            $session
                        ],200);
                    }            
                }else {

                    session()->flash('error', "Ce calibre n'est pas définit pour ce stock");
                    return response()->json([
                        'error'=>"Ce calibre n'est pas définit pour ce stock"
                    ]);
                }
            }else return redirect('login');
        }else return redirect('login');
    }

    public function ajouterValider()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $session = session::all();
                
                if ($session['calibre_id']) {
                    $calibrage = Calibrage::where('stock_id',$session['stock_id'])->where('localisation',$session['localisation'])->orderBy('id','DESC')->first();
                    

                    if ($calibrage) {
                        
                        session()->flash('message', 'Stock calibré avec succès');
                        return response()->json([
                            $session
                        ]);
                    }else {
                        session()->flash('error', 'Informations manquantes');
                        return response()->json([
                            $session
                        ]);
                    }
                }

            }else return redirect('login');
        }else return redirect('login');
    }

    
    public function add_session(Request $request)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {

                $data = $request->all();
                $i = 1;
                $keys = "";
                $response = 1;
                foreach($data as $key=>$value){
                    if($key != '_token'){
                        $keys = $key;
                        $response  = session::put($keys , $value);
                    }
                }
                $ses = session::all();
                return response()->json([
                    $ses['calibrage_id']
                ]);
            }else return redirect('login');
        }else return redirect('login');
    }

    
    public function issue()
    {
         if( Auth::check()){/* 
            $user = $this->verifyOperator();
            if($user){  */
                $etape_calibrage = 1;
                
                return view('calibrage.issue',compact('etape_calibrage'));

            /* }else return redirect('login'); */
        }else return redirect('login');
    }
    
    public function searchissue(Request $request)
    {
        if( Auth::check()){
            //$user = $this->verifyOperator();
            //if($user){
                
                $request->validate([
                    'batch_id'=>'required',
                    'weight'=>'sometimes|nullable'
                ]);

                //weight
                $data = $request->all();
                if ($data['weight'] != null) {
                    $depelliculage = Depelliculage::where('unskinning_batch',$data['batch_id'])->where('weight',$data['weight'])->first();
                }else {
                    $depelliculage = Depelliculage::where('unskinning_batch',$data['batch_id'])->orderBy('id','DESC')->first();
                }
                
                if ($depelliculage) {
                    $classification = Classification::where('unskinning_id',$depelliculage->id)->first();
                    if ($classification) {
                        $conditionning = Conditionnement::where('classification_id',$classification->id)->first();
                        
                        $amande = "";
                        $lastDashPos = strrpos($depelliculage->getDrying->getFirstDrying->getShelling->sub_batch_caliber, '-'); // Trouver la position du dernier "-"
                        if ($lastDashPos !== false) { // S'assurer qu'il y a un "-"
                            $substring = substr($depelliculage->getDrying->getFirstDrying->getShelling->sub_batch_caliber, $lastDashPos + 1); // Extraire la partie après le dernier "-"
                            if (Str::contains($substring, 'AE')) { // Vérifier si la partie extraite contient l'une des deux sous-chaînes
                                $amande = "Amandes Entières";
                            } else {
                                $amande = "Amandes Brisées";
                            }
                        }
                        $amande_color = "";
                        $lastDashPos = strrpos($depelliculage->unskinning_batch, '-'); // Trouver la position du dernier "-"
                        if ($lastDashPos !== false) { // S'assurer qu'il y a un "-"
                            $substring = substr($depelliculage->unskinning_batch, $lastDashPos + 1); // Extraire la partie après le dernier "-"
                            if (Str::contains($substring, 'CB')) { // Vérifier si la partie extraite contient l'une des deux sous-chaînes
                                $amande_color = "Amandes Blanches";
                            } else {
                                $amande_color = "Amandes Jaunes";
                            }
                        }

                        $tableau = '<table class="table table-bordered " width="100%" cellspacing="0">';
                        $tableau .= '<tbody>';
                        $tableau .= '<tr> <th rowspan="13"><strong style="text-transform:uppercase;font-size:larger;">NOIX DE CAJOU </strong></th>
                        <td>LOT PMS:   </td>
                        <td id="noix" >'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getStock->getStock->getOrigin->id_lot_pms.' </td>
                        </tr>';
                        $tableau .='
                        <tr>
                                    <td>ID Fournisseur:  </td>
                                    <td id="id_fournisseur">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getStock->getStock->getOrigin->id_lot_externe.' </td>
                                  </tr>
                                  <tr>
                                    <td>Géolocalisation</td>
                                    <td id="geolocalisation">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getStock->getStock->getOrigin->cooperative.'</td>
                                  </tr>
                                  <tr>
                                    <td>Date déchargement:  </td>
                                    <td id="noix_quantity">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getStock->getStock->getOrigin->date_time_decharge.'</td>
                                  </tr>
                                  <tr>
                                    <td>Quantité:  </td>
                                    <td id="noix_quantity">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getStock->getStock->getOrigin->qte_decharge.'</td>
                                  </tr>
                                  <tr>
                                    <td>Poids :  </td>
                                    <td id="noix_weight">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getStock->getStock->getOrigin->net_weight.'</td>
                                  </tr>
                                  <tr>
                                    <td >Contrôle qualité /Taux d\'humidité  :</td>
                                    <td id="noix_control_th">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getStock->getStock->getOrigin->taux_humidite.'</td>
                                  </tr>
                                  <tr>
                                    <td> Contrôle qualité / Grainage :</td>
                                    <td id="noix_control_graine">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getStock->getStock->getOrigin->grainage.'</td>
                                  </tr>
                                  <tr>
                                    <td> Contrôle qualité / TDR : </td>
                                    <td id="noix_control_tdr">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getStock->getStock->getOrigin->default_thaux.'</td>
                                  </tr>
                                  <tr>
                                    <td>Contrôle qualité / KOR :</td>
                                    <td id="noix_control_controler">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getStock->getStock->getOrigin->kor.'</td>
                                  </tr>
                                  <tr>
                                    <td>Contrôle qualité / Contrôleur :</td>
                                    <td id="noix_control_controler">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getStock->getStock->getOrigin->nom_controleur.'</td>
                                  </tr>
                                  <tr>
                                    <td>Stockage : </td>
                                    <td id="noix_control_stockage">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getStock->getStock->getOrigin->localisation.'</td>
                                  </tr>
                                  <tr>
                                    <td> Magasinier : </td>
                                    <td id="noix_control_mag">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getStock->getStock->getOrigin->nom_mag.'</td>
                                  </tr>
                                  <tr>
                                    <th rowspan="16"><strong style="text-transform:uppercase;font-size:larger;">CALIBRAGE </strong></th>
                                    <td>ID Target  </td>
                                    <td id="calibrage_id_target">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getSequence->getObjectif->id_target.' </td>
                                  </tr>
                                  <tr>
                                    <td>SEQUENCE </td>
                                    <td id="calibrage_sequence">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getSequence->id.' </td>
                                  </tr>
                                  <tr>
                                    <td>Shift </td>
                                    <td id="shift">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getSequence->getShift->title.' </td>
                                  </tr>
                                  <tr>
                                    <td>Ligne </td>
                                    <td id="shift">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getSequence->getLigne->name.' </td>
                                  </tr>
                                  <tr>
                                    <td>Date de reception:  </td>
                                    <td id="calibrage_date_reception">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->created_at.' </td>
                                  </tr>
                                  <tr>
                                    <td>Calibre: (le calibre qui conseil le produit fini) </td>
                                    <td id="calibrage_calibre">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getCalibre->designation.' </td>
                                  </tr>
                                  <tr>
                                    <td>Lot:</td>
                                    <td id="calibrage_lot">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->id_lot_calibre.' </td>
                                  </tr>
                                  <tr>
                                    <td>Quantité </td>
                                    <td id="calibrage_quantity"></td>
                                  </tr>
                                  <tr>
                                    <td>Poids : </td>
                                    <td id="calibrage_weight">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->net_weight.'</td>
                                  </tr>
                                  <tr>
                                    <td>Contrôle qualité / Taux d\'humidité:</td>
                                    <td id="calibrage_control_th">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->taux_humidite.'</td>
                                  </tr>
                                  <tr>
                                    <td>Contrôle qualité / Grainage :</td>
                                    <td id="calibrage_control_graine">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->grainage.'</td>
                                  </tr>
                                  <tr>
                                    <td>Contrôle qualité / TDR:</td>
                                    <td id="calibrage_control_tdr">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->default_thaux.'</td>
                                  </tr>
                                  <tr>
                                    <td>Contrôle qualité / KOR: </td>
                                    <td id="calibrage_control_kor">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->kor.'</td>
                                  </tr>
                                  <tr>
                                    <td>Contrôle qualité /Contrôleur: </td>
                                    <td id="calibrage_control_controler">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->name_controler.'</td>
                                  </tr>
                                  <tr>
                                    <td>Stockage: </td>
                                    <td id="calibrage_control_stockage">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->localisation.'</td>
                                  </tr>
                                  <tr>
                                    <td>Magasin: </td>
                                    <td id="calibrage_control_mag">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->localisation.'</td>
                                  </tr>
                                  <tr>
                                    <th rowspan="9"><strong style="text-transform:uppercase;font-size:larger;">CUISSON</strong></th>
                                    <td>ID Target : </td>
                                    <td id="cooking_id_target">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getSequence->getObjectif->id_target.' </td>
                                  </tr>
                                  <tr>
                                    <td>SEQUENCE </td>
                                    <td id="cooking_id_sequence">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getSequence->id.'</td>
                                  </tr>
                                  <tr>
                                    <td>Shift </td>
                                    <td id="cooking_id_sequence">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getSequence->getShift->title.'</td>
                                  </tr>
                                  <tr>
                                    <td>Ligne  </td>
                                    <td id="cooking_id_sequence">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getSequence->getLigne->name.'</td>
                                  </tr>
                                  <tr>
                                    <td>Date de reception </td>
                                    <td id="cooking_date">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->created_at.'</td>
                                  </tr>
                                  <tr>
                                    <td>Lot Calibre </td>
                                    <td id="cooking_lot">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->id_lot_calibre.'</td>
                                  </tr>
                                  <tr>
                                    <th>Durée</strong></th>
                                    <td id="cooking_duration">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->cooking_time.'</td>
                                  </tr>
                                  <tr>
                                    <td>Poids (poids net après cuisson) </td>
                                    <td id="cooking_weight">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->weight_after_cook.'</td>
                                  </tr>
                                  <tr>
                                    <td>Opérateur</td>
                                    <td id="cooking_operateur">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getUser->name.'</td>
                                  </tr>
                                  <tr>
                                    <th rowspan="9">REFROIDISSEMENT  </th><td>ID Target  </td>
                                    <td id="calibrage_id_target">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getSequence->getObjectif->id_target.'</td>
                                   </tr>
                                   <tr>
                                    <td>SEQUENCE</td>
                                    <td id="cooling_sequence">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getSequence->id.'</td>
                                  </tr>
                                  <tr>
                                   <td>Shift</td>
                                   <td id="cooling_sequence">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getSequence->getShift->title.'</td>
                                 </tr>
                                 <tr>
                                  <td>Ligne</td>
                                  <td id="cooling_sequence">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getSequence->getLigne->name.'</td>
                                </tr>
                                  <tr>
                                    <td>Date de reception </td>
                                    <td id="cooling_date">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->created_at.'</td>
                                  </tr>
                                  <tr>
                                    <td>Lot  </td>
                                    <td id="cooling_lot">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->id_lot_calibre.'</td>
                                  </tr>
                                  <tr>
                                    <td>Durée</td>
                                    <td id="cooling_duration">2 h</td>
                                  </tr>
                                  <tr>
                                    <td>Poids (poids net après cuisson) </td>
                                    <td id="cooling_weight">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->weight_after_cooling.'</td>
                                  </tr>
                                  
                                  <tr>
                                    <td>Opérateur</td>
                                    <td id="cooling_operator">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getUser->name.'</td>
                                  </tr>
                                  <tr>
                                    <th rowspan="7"><strong style="text-transform:uppercase;font-size:larger;">DECORTICAGE</strong> </th>
                                    <td>ID Target </td>
                                    <td id="shelling_id_target">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getSequence->getObjectif->id_target.' </td>
                                  </tr>
                                  <tr>
                                    <td>Sequence</td>
                                    <td id="shelling_id_target">'. $depelliculage->getDrying->getFirstDrying->getShelling->getSequence->id.'</td>
                                  </tr>
                                  <tr>
                                    <td>Date de reception </td>
                                    <td id="shelling_date">'. $depelliculage->getDrying->getFirstDrying->getShelling->created_at.'</td>
                                  </tr>
                                  <tr>
                                    <td>Amandes entieres ou Amandes brisees</td>
                                    <td id="shelling_amande">'. $amande.'</td>
                                  </tr>
                                  <tr>
                                    <td>Lot</td>
                                    <td id="shelling_lot">'.$depelliculage->getDrying->getFirstDrying->getShelling->sub_batch_caliber.'</td>
                                    </tr>
                                  <tr>
                                    <td>Poids </td>
                                    <td id="shelling_weight">'.$depelliculage->getDrying->getFirstDrying->getShelling->weight.'</td>
                                  </tr>
                                  <tr>
                                    <td>Opérateur</td>
                                    <td id="shelling_operator">'.$depelliculage->getDrying->getFirstDrying->getShelling->getUser->name.' </td>
                                  </tr>
                                  <tr>
                                    <th rowspan="8" ><strong style="text-transform:uppercase;font-size:larger;">SECHAGE</strong> </th>
                                    <td>ID Target</td>
                                    <td id="drying_id_target">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getSequence->getObjectif->id_target.' </td>
                                  </tr>
                                  <tr>
                                    <td>SEQUENCE </td>
                                    <td id="drying_sequence">'.$depelliculage->getDrying->getSequence->id.' </td>
                                  </tr>
                                  <tr>
                                    <td>Shift </td>
                                    <td id="drying_sequence">'.$depelliculage->getDrying->getSequence->getShift->title.' </td>
                                  </tr>
                                  <tr>
                                    <td>Ligne </td>
                                    <td id="drying_sequence">'.$depelliculage->getDrying->getSequence->getLigne->name.' </td>
                                  </tr>
                                  <tr>
                                    <td>Date de reception</td>
                                    <td id="drying_date">'.$depelliculage->getDrying->created_at.' </td>
                                  </tr>
                                  <tr>
                                    <td>Amandes entières ou Amandes brisées</td>
                                    <td id="drying_amande">'. $amande.'</td>
                                  </tr>
                                  <tr>
                                    <td>Lot (poids net apres sechage 2 ) </td>
                                    <td id="drying_lot">'.$depelliculage->getDrying->weigth_after.' </td>
                                  </tr>
                                  <tr>
                                    <td>Opérateur </td>
                                    <td id="drying_operator">'.$depelliculage->getDrying->getUser->name.' </td>
                                  </tr>
                                  <tr>
                                    <th rowspan="9">DEPELICULAGE</th>
                                    <td>ID Target </td>
                                    <td id="unskinning_id_target">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getSequence->getObjectif->id_target.' </td>
                                  </tr>
                                  <tr>
                                    <td>SEQUENCE : </td>
                                    <td id="unskinning_sequence">'.$depelliculage->getDrying->getSequence->id.' </td>
                                  </tr>
                                  <tr>
                                    <td>Shift : </td>
                                    <td id="unskinning_sequence">'.$depelliculage->getDrying->getSequence->getShift->title.' </td>
                                  </tr>
                                  <tr>
                                    <td>Ligne : </td>
                                    <td id="unskinning_sequence">'.$depelliculage->getDrying->getSequence->getLigne->name.' </td>
                                  </tr>
                                  <tr>
                                    <td>Date de reception </td>
                                    <td id="unskinning_date">'.$depelliculage->created_at.' </td>
                                  </tr>
                                  <tr>
                                    <td> Couleur blanches ou Couleur jaune </td>
                                    <td id="unskinning_color">'.$amande_color.'</td>
                                  </tr>
                                  <tr>
                                    <td>Lot</td>
                                    <td id="unskinning_lot">'.$depelliculage->unskinning_batch.'</td>
                                  </tr>
                                  <tr>
                                    <td>Poids</td>
                                    <td id="unskinning_weight">'.$depelliculage->weight.'</td>
                                  </tr>
                                  <tr>
                                    <td>Opérateur </td>
                                    <td id="unskinning_operator">'.$depelliculage->getUser->name.'</td>
                                  </tr>
                                  <tr>
                                    <th rowspan="9">CLASSIFICATION</th>
                                    <td>ID Target </td>
                                    <td id="classification_idtarget">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getSequence->getObjectif->id_target.' </td>
                                  </tr>
                                  <tr>
                                    <td>SEQUENCE : </td>
                                    <td id="classification_sequence">'.$classification->getSequence->id.'</td>
                                  </tr>
                                  <tr>
                                    <td>Shift : </td>
                                    <td id="classification_sequence">'.$classification->getSequence->getShift->title.'</td>
                                  </tr>
                                  <tr>
                                    <td>Ligne : </td>
                                    <td id="classification_sequence">'.$classification->getSequence->getLigne->name.'</td>
                                  </tr>
                                  <tr>
                                    <td>Date de reception </td>
                                    <td id="classification_date">'.$classification->created_at.'</td>
                                  </tr>
                                  <tr>
                                    <td>Lot</td>
                                    <td id="classification_lot">'.$depelliculage->unskinning_batch.'</td>
                                  </tr>
                                  <tr>
                                    <td>Grade</td>
                                    <td id="classification_grade">'.$classification->getGrade->designation.'</td>
                                  </tr>
                                  <tr>
                                    <td>Poids</td>
                                    <td id="classification_weight">'.$classification->weight.'</td>
                                  </tr>
                                  <tr>
                                    <td>Opérateur</td>
                                    <td id="classification_operator">'.$classification->getUser->name.'</td>
                                  </tr>
                                  <tr>
                                    <th rowspan="11"> CONDITIONNEMENT</th>
                                    <td>  ID Target</td>
                                    <td id="conditioning_id_target">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getSequence->getObjectif->id_target.'</td>
                                  </tr>
                                  <tr>
                                    <td>SEQUENCE : </td>
                                    <td id="conditioning_sequence">'. $conditionning?->getSequence?->id.'</td>
                                  </tr>
                                  <tr>
                                    <td>Shift : </td>
                                    <td id="conditioning_sequence">'. $conditionning?->getSequence?->getShift->title.'</td>
                                  </tr>
                                  <tr>
                                    <td>Ligne : </td>
                                    <td id="conditioning_sequence">'. $conditionning?->getSequence?->getLigne->name.'</td>
                                  </tr>
                                  <tr>
                                    <td>Date de reception </td>
                                    <td id="conditioning_date">'. $conditionning?->created_at.'</td>
                                  </tr>
                                  <tr>
                                    <td>Lot</td>
                                    <td>'.$depelliculage->unskinning_batch.'</td>
                                  </tr>
                                  <tr>
                                    <td>Grade</td>
                                    <td id="conditioning_lot">'.$classification->getGrade->designation.'</td>
                                  </tr>
                                  <tr>
                                    <td>Poids</td>
                                    <td id="conditioning_weight">'. $conditionning?->weight.'</td>
                                  </tr>
                                  <tr>
                                    <td>Quantité /  Sacs complet: </td>
                                    <td id="conditioning_quantity_full_bag">'. $conditionning?->num_bag.'</td>
                                  </tr>
                                  <tr>
                                    <td> Sacs non complet:</td>
                                    <td id="conditioning_not_full">'. $conditionning?->remain_bag.'</td>
                                  </tr>
                                  <tr>
                                    <td>Opérateur</td>
                                    <td id="conditioning_operator">'. $conditionning?->getUser->name.' </td>
                                  </tr>
                                  <tr>
                                    <th rowspan="9">AMANDES DE CAJOU  </th>
                                    <td> ID Target</td>
                                    <td id="amande_id_target">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getSequence->getObjectif->id_target.' </td>
                                  </tr>
                                  <tr>
                                    <td>Date de reception </td>
                                    <td id="amande_date">'. $conditionning?->updated_at.' </td>
                                  </tr>
                                  <tr>
                                    <td>Code Produit</td>
                                    <td id="amande_code_produit">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getSequence->getObjectif->getProduit->code_prod.'</td>
                                  </tr>
                                  <tr>
                                    <td>Grade</td>
                                    <td id="amande_grade">'.$classification->getGrade->designation.'</td>
                                  </tr>
                                  <tr>
                                    <td>Code Grade : </td>
                                    <td id="amande_code">'.$classification->getGrade->code.'</td>
                                  </tr>
                                  <tr>
                                    <td>Quantité /  Sacs complet : </td>
                                    <td id="amande_full_bag">'. $conditionning?->num_bag.'</td>
                                  </tr>
                                  <tr>
                                    <td>Sacs non complet:  </td>
                                    <td id="amande_not_full">'. $conditionning?->remain_bag.'</td>
                                  </tr>
                                  <tr>
                                    <td>Stockage :</td>
                                    <td id="amande_stockage"></td>
                                  </tr>
                                  <tr>
                                    <td>Magasinier : </td>
                                    <td id="amande_mag"></td>
                                  </tr>
                        ' ;

                        $tableau .= '</tbody>';
                        $tableau .= '</table>';

                        return response()->json([
                            "tableau"=>$tableau
                        ]);
                    }else{
                        return response()->json([
                            "depelliculage"=>$depelliculage,
                        ]);
                    }
                }else {
                    return response()->json([
                        "Error"
                    ]);
                }

            //}else return redirect('login');
        }else return redirect('login');
    }

    public function addNameController(Request $request)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                
                $request->validate([
                    'name'=>'sometimes|nullable',
                ]);
                
                $data = $request->all();
                $session = Session::all();
                $calibre = Calibrage::where('id',$session['calibrage_id'])->first();
                if ($calibre) {
                    if ($data['name']) {
                        $update = $calibre->update([
                            'name_controler' => $data['name'],
                        ]);
                        if ($update) {
                            return response()->json([
                                $update
                            ]);
                        }
                    }else return response()->json([
                        "Message"=>"Le nom est vide"
                    ]);
                }else return response()->json([
                    "Message"=>"Une erreur s'est produite"
                ]);

            }else return redirect('login');
        }else return redirect('login');
    }

    
    public function get_kor(Request $request)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $session = Session::all();
                $au = $session['p2'] + ($session['p4'])/2;
                $ra = (($session['p2'] + ($session['p4'])/2)/$session['p1'])*100;
                $kor = $au * (80/454);
                $kor1 = round($kor, 2);

                $register_thau = Calibrage::where('id',$session['calibrage_id'])->first();
                
                $update = $register_thau->update([
                    'kor' => $kor1,
                ]);/**/
                if ($update) {
                    return response()->json([
                        'kor'=>$kor1,
                        'calibrage_id'=>$register_thau->id
                    ]);
                }
        
            }else return redirect('login');
        }else return redirect('login');
    }
    
    public function get_default_th()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $session = Session::all();
                $thau_def = (( $session['p3'] + $session['p5'])/$session['p1'])*100;


                $register_thau = Calibrage::where('id',$session['calibrage_id'])->first();
                if ($register_thau) {
                    
                    $thau_def1 = round($thau_def, 2);
                    $update =  $thau_def; $register_thau->update([
                                'grainage' => $session['nbr_noix'],
                                'default_thaux' => $thau_def1,
                                'taux_humidite' => $session['taux_humidite']
                            ]);/**/
                }else {
                    $thau_def1 = round($thau_def, 2);
                    $calibrage = new Calibrage();
                    $calibrage->grainage = $session['nbr_noix'];
                    $calibrage->default_thaux = $thau_def1;
                    $calibrage->taux_humidite = $session['taux_humidite'];
                    $calibrage->save();

                    $origin_session = session::put('calibrage_id' , $calibrage->id);

                }

                if($thau_def){
                    return response()->json($thau_def);
                }
        
            }else return redirect('login');
        }else return redirect('login');
    }

    public function controleQualite(Request $request, Calibrage $calibrage)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $request->validate([
                    'kor'=>'sometimes|nullable',
                    'taux_humidite'=>'sometimes|nullable',
                ]);
                
                $data = $request->all();
                $update = $calibrage->update([
                    'kor'=>$data['kor'],
                    'taux_humidite'=>$data['taux_humidite'],
                ]);
                if ($update) {
                    return redirect()->route('calibrage.show', [$calibrage->id])->with('message','Enregistrer avec succès');
                }else return redirect()->route('calibrage.show',[$calibrage->id])->with('error','Une erreur s\' est produite');
            }else return redirect('login');
        }else return redirect('login');
    }

    public function rapport()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_calibrage = 1;
                $session = session::all();
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                $sequence = Sequence::where('id',$operator_sequence->sequence_id)->first();
                if ($sequence) {
                    $sequence_deb = Sequence::where('objectif_id',$sequence->objectif_id)->first();
                    $calibrages = Calibrage::where('sequence_id',$sequence->id)->where('transfert',true)->whereDate('updated_at',Carbon::today())->orderBy('id','DESC')->paginate(20);
                    $quantity = 0;
                    foreach ($calibrages as $key => $value) {
                        $quantity = $value['initial_caliber_weight'] + $quantity;
                    }
                    return view('calibrage.rapport',compact('sequence_deb','sequence','quantity','calibrages','etape_calibrage','user'));
                }else {
                    return redirect()->route('dashboard');
                }
            }else return redirect('login');
        }else return redirect('login');
    }
    
    public function calibragedetail(Calibrage $calibrage)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_calibrage = 1;
                
                return view('calibrage.details',compact('calibrage','etape_calibrage'));
            }else return redirect('login');
        }else return redirect('login');
    }

    public function registerRapport(Request $request)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();

                $request->validate([
                    'sequence_id'=>'sometimes|nullable',
                    'observation'=>'sometimes|nullable',
                    'name'=>'sometimes|nullable',
                    'workforce'=>'sometimes|nullable',
                ]);
                
                $data = $request->all();

                $stock = Calibrage::where('sequence_id',$data['sequence_id'])->whereDate('updated_at',Carbon::today())->first();
                if (!$stock) {
                    $stock = Calibrage::whereDate('updated_at', Carbon::today())->orderBy('updated_at', 'desc')->first();
                    if (!$stock) {
                        
                        return redirect()->route('calibrage.rapport')->with('error','Rapport vide');
                    }
                }
                $exist = RapportCalibrage::where('sequence_id',$data['sequence_id'])->where('stock_cal_id',$stock->stock_id)
                ->where('author_id',$user->id)->first();
                if ($exist) {
                    foreach($data as $column => $value) {
    
                        $exist->update([$column => $value]);
                        
                    }
                    $currents = Current_rapport_Calibrage::where('sequence_id',$operator_sequence->sequence_id)->where('author_id',$user->id)->get();
                    if ($currents) {
                        foreach($currents as $current) {
                            $current->update(['rapport_id' => $exist->id]);
                        }
                        return redirect()->route('calibrage.rapport')->with('message','Rapport enregistré');
                        
                    }else return redirect()->route('calibrage.rapport')->with('error','Une erreur s\'est produite');
                    /* return redirect()->route('calibrage.rapport')->with('message','Rapport enregistré'); */
                }

                $rapport = RapportCalibrage::create([
                    'sequence_id'=>$data['sequence_id'],
                    'stock_cal_id'=>$stock->stock_id,
                    'observation'=>$data['observation'],
                    'workforce'=>$data['workforce'],
                    'author_id'=>$user->id,
                ]);
                if ($rapport) {
                    $currents = Current_rapport_Calibrage::where('sequence_id',$operator_sequence->sequence_id)->where('author_id',$user->id)->get();
                    if ($currents) {
                        foreach($currents as $current) {
                            $current->update(['rapport_id' => $rapport->id]);
                        }
                        return redirect()->route('calibrage.rapport')->with('message','Rapport enregistré');
                        
                    }else return redirect()->route('calibrage.rapport')->with('error','Une erreur s\'est produite');
                }else return redirect()->route('calibrage.rapport')->with('error','Une erreur s\'est produite');

            }else return redirect('login');
        }else return redirect('login');
    }


    /* $data = $request->all();

foreach($data as $key=>$value){
    if($key != '_token'){
        $keys = $key;
        $response  = session ::put($keys , $value);
        // ajoutez la validation ici
        $validatedData = Validator::make([$key => $value], [
            $key => 'required|date',
        ])->validate();
    }
}

$session = session::all();

return response()->json([$session]); */

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Calibrage  $calibrage
     * @return \Illuminate\Http\Response
     */
    public function show(Calibrage $calibrage)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_calibrage = 1;
                return view('calibrage.show',compact('calibrage','etape_calibrage'));
                
            }else return redirect('login');
        }else return redirect('login');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Calibrage  $calibrage
     * @return \Illuminate\Http\Response
     */
    public function edit(Calibrage $calibrage)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                
            }else return redirect('login');
        }else return redirect('login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Calibrage  $calibrage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calibrage $calibrage)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                
            }else return redirect('login');
        }else return redirect('login');
    }

    public function calibrageTransfert(Calibrage $calibrage)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                $transfert= $calibrage->update([
                    'transfert'=>true,
                    'initial_caliber_weight'=>$calibrage->caliber_weight
                ]);

                if ($transfert) {
                    $current_rapport = Current_rapport_Calibrage::create([
                        "sequence_id"=>$operator_sequence->sequence_id,
                        "author_id"=>$user->id,
                        "calibrage_id"=>$calibrage->id
                    ]);
                    if ($current_rapport) {
                        $all_caliber = Calibrage::where('stock_id',$calibrage->stock_id)
                                        ->where('transfert',false)->get();
                        if ($all_caliber->isEmpty()) {
                            return redirect()->route('calibrage.index',[$calibrage->stock_id])->with('message',"Stock transférer");
                        }else {
                            $stock = StockRecepT::where('id',$calibrage->stock_id)->first();
                            $calibrated_stock = $stock->update([
                                'calibrated_stock'=>true
                            ]);
                            if ($calibrated_stock) {
                                return redirect()->route('calibrage.index',[$calibrage->stock_id])->with('message',"Stock transférer");
                            }else return redirect()->route('calibrage.index',[$calibrage->stock_id])->with('error',"Une erreur s'est produite");
                        }
                    }else return redirect()->route('calibrage.index',[$calibrage->stock_id])->with('error',"Erreur sur le transfert");
                }else {
                    return redirect()->route('calibrage.index',[$calibrage->stock_id])->with('error',"Une erreur s'est produite");
                }

            }else return redirect('login');
        }else return redirect('login');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Calibrage  $calibrage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calibrage $calibrage)
    {
        //
    }
/* 
    public function stock_calib_liste()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $session = session::all();
                $section_poste = Section::where('designation', 'Fragilisation')
                   ->orWhere('designation', 'Cuisson')
                   ->first();
                if ($section_poste) {
                    
                    $poste = Poste::where('section_id',$section_poste->id)->first();
                    if ($poste) {
                        $assigner = Assigner::where('user_id',$user->id)->where('poste_id',$poste->id)->where('sequence_id',$session['sequence'])->first();
                        if ($assigner) {
                            $stocks = Calibrage::where('transfert',true)->get();
                            $etape_fragilisation = 1;
                            if ($stocks) {
                                return view('fragilisation.stock', compact('stocks' , 'etape_fragilisation'));
                            }
                        }else {
                            return redirect()->route('dashboard')->with('error',"Vous n'êtes pas habilité à travailler à ce poste.");
                       }
                    }else {
                        return redirect()->route('dashboard')->with('error',"Veuillez créer des postes reliés à la section fragilisation");
                    }
                }
            }else return redirect('login');
        }else return redirect('login');
    } */

    public function stock_calib_liste()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $session = session::all();
                    $section_poste = Section::where('designation', 'Cuisson')->first();
                    if ($section_poste) {
            
                        $poste = Poste::where('section_id',$section_poste->id)->first();
                        if ($poste) {
                            $assigner = Assigner::where('user_id',$user->id)->where('poste_id',$poste->id)->where('sequence_id',$session['sequence'])->first();
                            if ($assigner) {
                                $stocks = Calibrage::where('transfert',true)->where('caliber_weight','<>',0)->orderBy('id','DESC')->paginate(20);//->orderBy('id','DESC')->paginate(20); 
                                $etape_fragilisation = 1;
                                if ($stocks) {
                                    return view('fragilisation.stock', compact('stocks' , 'etape_fragilisation'));
                                }
                            }else return redirect()->route('dashboard')->with('error',"Vous n'êtes pas habilité à travailler à ce poste.");
                        }else return redirect()->route('dashboard')->with('error',"Veuillez créer des postes reliés à la section Cuisson");
                    }else return redirect()->route('dashboard')->with('error',"Veuillez créer des postes reliés à la section Cuisson");

                    //return redirect()->route('dashboard')->with('error',"Vous n'êtes pas habilité à travailler à ce poste.");
                       
            }else return redirect('login');
        }else return redirect('login');
    }

    public function fiche(OrigineProd $calibrage)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $date_recep = null;
                
                if ($calibrage->date_recep) {
                    $date_recep = Carbon::createFromFormat('Y-m-d H:i:s', $calibrage->date_recep);
                   
                }
                $date_time_decharge = null;
                if ($calibrage->date_time_decharge) {
                    $date_time_decharge = Carbon::createFromFormat('Y-m-d H:i:s', $calibrage->date_time_decharge);
                }
                
                //dd($calibrage->get_Geo->country);
                
                $date_charg = null;
                if ($calibrage->date_charg) {
                    $date_charg = Carbon::createFromFormat('Y-m-d H:i:s', $calibrage->date_charg);
                }
                
                $qr = QrCode::size(100)->generate(route('get_data_quality', $calibrage->id));
                return view('calibrage.fiche',compact('calibrage','date_recep','date_time_decharge','date_charg', 'qr'));
            }else return redirect('login');
        }else return redirect('login');
    }


    public function monpdf()
    {
        $calibrage = OrigineProd::where('id',1)->first();
        
        $date_recep = Carbon::createFromFormat('Y-m-d H:i:s', $calibrage->date_recep);
        $date_time_decharge = Carbon::createFromFormat('Y-m-d H:i:s', $calibrage->date_time_decharge);
        $date_charg = Carbon::createFromFormat('Y-m-d H:i:s', $calibrage->date_charg);
        
        $qr = QrCode::size(100)->generate(route('get_data_quality', $calibrage->id));
        return view('calibrage.pdf',compact('calibrage','date_recep','date_time_decharge','date_charg','qr'));
    }

    public function imprimer(OrigineProd $calibrage)
    {
        if (Auth::user()) {
            $user=$this->verifyOperator();
            if ($user) {
                $date_recep = Carbon::createFromFormat('Y-m-d H:i:s', $calibrage->date_recep);
                $date_time_decharge = Carbon::createFromFormat('Y-m-d H:i:s', $calibrage->updated_at);
                $date_charg = Carbon::createFromFormat('Y-m-d H:i:s', $calibrage->created_at);
                
                $qr = QrCode::size(100)->generate(route('get_data_quality', $calibrage->id));
                $bar_decharge = Carbon::parse($calibrage->date_time_decharge)->format('Ymd');
                $bar_recharge = Carbon::parse($calibrage->date_charg)->format('Ymd');
                
                $local = $calibrage->get_Geo?->country ."- ".$calibrage->get_Geo?->town."- ".$calibrage->get_Geo?->neighborhood;
                $pdf = PDF::loadView('calibrage.pdf', compact('calibrage', 'date_recep', 'date_time_decharge', 'date_charg', 'qr', 'local','bar_decharge','bar_recharge'))
                            ->setOptions([
                                'defaultFont' => 'sans-serif',
                                'font-size' => '25px'
                            ]);
                //$pdf->download('fiche.pdf');
                return $pdf->stream();
            }else return redirect('login');
            
        }else return redirect('login');
    }
}
