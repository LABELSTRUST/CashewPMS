<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Assigner;
use App\Models\Campaign;
use App\Models\Classification;
use App\Models\Client;
use App\Models\Conditionnement;
use App\Models\Current_rapportConditionnement;
use App\Models\Decorticage;
use App\Models\Depelliculage;
use App\Models\Fournisseur;
use App\Models\Geolocation;
use App\Models\Grade;
use App\Models\MatierePremiere;
use App\Models\OperatorSequence;
use App\Models\OrigineProd;
use App\Models\Poste;
use App\Models\Produit;
use App\Models\Reception;
use App\Models\Section;
use App\Models\Sequence;
use App\Models\Sortie;
use App\Models\Stock;
/* use GuzzleHttp\Client; */
use App\Models\StockRecepT;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Milon\Barcode\BarcodeGenerator;
//use Illuminate\Support\Facades\Validator;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReceptionController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type = null)
    {
        if( Auth::check()){
            $user = $this->verifyMagasinier();
            if($user){
                $produits = Produit::get();
                $receptions = Stock::get();
                $sections = Poste::get();
                return view('inventaire.receptions',compact('produits','receptions','sections'));
                
            }else return redirect('login');
            
        }else return redirect('login');
    }

    public function generate_qr (){
      
    	# 2. On génère un QR code de taille 200 x 200 px
    	$qrcode = Qrcode::size(200)->generate("https://www.akilischool.com");
    	
    	# 3. On envoie le QR code généré à la vue "simple-qrcode"
    	return view("inventaire.simple", compact('qrcode'));
    }
    
    public function dispatchStock()
    {
        if( Auth::check()){
            $user = $this->verifyMagasinier();
            if($user){
                $grades = Grade::get();
               
                $stocks = Conditionnement::get();
            
                return view('inventaire.dispatchstocks',compact('grades','stocks'));

            }else return redirect('login');
        }else return redirect('login');
    }

    public function liste_sortie()
    {
      if( Auth::check()){
          $user = $this->verifyMagasinier();
          if($user){
            $exits = Sortie::orderBy('id','DESC')->paginate(20);
            //dd($exits);
            return view('inventaire.liste_sortie',compact('exits'));

          }else return redirect('login');
      }else return redirect('login');
    }

    public function stock_receptionner($id_article = null)
    {
        if( Auth::check()){
            $user = $this->verifyMagasinier();
            if($user){
                $origin_id = OrigineProd::where('matiere_id',$id_article)->pluck('id');
                
                $receptions = Stock::whereIn('origin_id',$origin_id)->get();
                $sections = Poste::get();

                return view('inventaire.receptions',compact('receptions','sections'));


            }else return redirect('login');
        }else return redirect('login');
    }

    public function stockbygrade(Grade $grade)
    {
      if( Auth::check()){
        $user = $this->verifyMagasinier();
        if($user){
          
          $classification_ids = Classification::where('grade_id',$grade->id)->where('transfert',true)->pluck('id');
          if ($classification_ids) {
            $stocks = Conditionnement::where('transfert',true)->whereIn('classification_id',$classification_ids)->get();

            if ($stocks) {
              $clients = Client::get();
              if ($clients) {
                return view('inventaire.listbygrade',compact('stocks','clients'));
              }
            }

          }

        }else return redirect('login');
      }else return redirect('login');
    }

    public function ticket(Sortie $sortie)
    {
      if( Auth::check()){
          $user = $this->verifyMagasinier();
          if($user){

            $conditionning = Conditionnement::where('id',$sortie->conditioning_id)->first();
            /* 
            $depelliculage = Depelliculage::where('unskinning_batch',$data['batch_id'])->first(); */
              /*
            $classification = Classification::where('unskinning_id',$depelliculage->id)->first(); */
            
             /**/
            $lot =  Carbon::parse($sortie->created_at)->format('Ymd');
            
            $qrcode = Qrcode::size(100)->generate(route('reception.issue'));
            $productCode = rand(1234567890,50);
            return view('inventaire.ticket',compact('productCode','sortie','lot','qrcode'));

          }else return redirect('login');
      }else return redirect('login');
    }

    public function list_exit()
    {
      if( Auth::check()){
          $user = $this->verifyMagasinier();
          if($user){
            $exits = Sortie::orderBy('id','desc')->get();
            $qte_weight = 0;
            foreach ($exits as $value) {
              $qte_weight += $value->num_bag;
            }

            return view('inventaire.list_exit',compact('exits','qte_weight'));
          }else return redirect('login');
      }else return redirect('login');
    }

   /*  public function searchBy_get($batch_id)
    {
      
    } */

    public function exit_stocks(Request $request)
    {
      if (Auth::check()) {
        $user = $this->verifyMagasinier();
        if($user){
          $request->validate([
              'num_bag'=>'sometimes|nullable',
              'conditioning_id'=>'sometimes|nullable',
              'remain_bag'=>'sometimes|nullable',
              'client_id'=>'sometimes|nullable',

          ]);
          $data = $request->all();
          

          
              
          $conditionning = Conditionnement::where('id',$data['conditioning_id'])->first();
          
          if ($conditionning) {
            if (!isset($data['remain_bag'])) {

              if ($conditionning->num_bag >= $data['num_bag']) {
                /* $exist = Sortie::where('conditioning_id',$data['conditioning_id'])->first();
                if ($exist) {
                  $update1 = $exist->update([
                    'num_bag'=>$data['num_bag']
                  ]);
                  if ($update1) {
                    $quantity = $conditionning->num_bag - $data['num_bag'];
                    $update = $conditionning->update(['num_bag'=>$quantity]);
                    if ($update) {
                      return redirect()->route('reception.stockbygrade',$conditionning->classification_id)->with('message',"Sortie avec succès");
                    }else return redirect()->route('reception.stockbygrade',$conditionning->classification_id)->with('error',"Echec");
                  }else return redirect()->route('reception.stockbygrade',$conditionning->classification_id)->with('error',"Echec");
                } */

                $exit = Sortie::create([
                  'num_bag'=>$data['num_bag'],
                  'conditioning_id'=>$data['conditioning_id'],
                  'initial_quantity'=>$conditionning->num_bag,
                  'client_id'=>$data['client_id'],
                ]);
                if ($exit) {
                  $quantity = $conditionning->num_bag - $data['num_bag'];
                  $update = $conditionning->update(['num_bag'=>$quantity]);
                  
                  session()->flash('message', 'Sortie avec succès');
                  return response()->json([
                      $conditionning
                  ]);
                }else 
                  session()->flash('error', 'Echec');
                  return response()->json([
                      'error'=>"Une erreur s'est produite"
                  ]);
              }else 
                  session()->flash('error', 'Une erreur s\'est produite');
                  return response()->json([
                      'error'=>"Une erreur s'est produite"
                  ]);
            }else {
              if ($conditionning->remain_bag >= $data['remain_bag']) {
                $exit = Sortie::create([
                  'remain_bag'=>$data['remain_bag'],
                  'conditioning_id'=>$data['conditioning_id'],
                  'initial_quantity'=>$conditionning->num_bag,
                  'client_id'=>$data['client_id'],
                  
                ]);
                if ($exit) {
                  $quantity = $conditionning->remain_bag - $data['remain_bag'];
                  $update = $conditionning->update(['remain_bag'=>$quantity]);
                  session()->flash('message', 'Sortie avec succès');
                  return response()->json([
                      $conditionning
                  ]);
                }else  
                    session()->flash('error', 'Une erreur s\'est produite');
                    return response()->json([
                        'error'=>"Une erreur s'est produite"
                    ]);
              }else  
                session()->flash('error', 'Une erreur s\'est produite');
                return response()->json([
                    'error'=>"Une erreur s'est produite"
                ]);
            }
          }
        }else return redirect('login');
      }else return redirect('login');
    }


    


    public function genarateCode($column = null, $table)
    {
        if ($column != null) {
            $length = $column;
        }else $length = 7;
		
      // Initialisation des caractères utilisables
      $characters = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
      $key_password = array_rand($characters, $length);

      for ($i = 0; $i < $length; $i++) {
        $password_tab[] = $characters[$key_password[$i]];
      }

      $generated_code = strtoupper(implode("", $password_tab));

          
          $existingCode = $table::where('id_lot_transfert', $generated_code)->first();
          while ($existingCode) {
              $generated_code = $this->genarateCode($length,$table);
              $existingCode = $table::where('id_lot_transfert', $generated_code)->first();
          }

      return $generated_code;
    }

    public function transfererstock(Request $request ,Stock $stock)
    {
        if( Auth::check()){
            $user = $this->verifyMagasinier();
            if($user){
                $request->validate([
                    'net_weight'=>'sometimes|nullable',
                    'section_id'=>'sometimes|nullable'
                ]);
                $data = $request->all();
                $matiere = MatierePremiere::where('id',$stock->getOrigin->matiere_id)->first();
                $stock_quantity = $stock->net_weight - $data['net_weight'];
                
                if ($matiere->net_weight > 0 && $stock->net_weight >0 ) {
                    $quantity = $matiere->net_weight - $data['net_weight'];
                    if ($quantity >= 0 && $stock_quantity >= 0) {

                        $stockt =  new StockRecepT();
                        $stockt->stock_id = $stock->id;
                        $stockt->net_weight = $data['net_weight'];
                        $stockt->matiere_id = $stock->getOrigin->matiere_id;
                        $stockt->receptionner = True;
                        $stockt->section_id = $data['section_id'];
                        $stockt->id_lot_transfert = $this->genarateCode(7,StockRecepT::class);
                        $stockt->new_id_lot_transfert = $stock->getOrigin->id_lot_pms;

                        $stockt->save();

                        if ($stockt) {

                            $matieres = StockRecepT::where('matiere_id',$stock->getOrigin->matiere_id)->get();
                            $sommes=0;
                            foreach ($matieres as  $value) {
                                $sommes = $value->net_weight + $sommes;
                            }

                            $update = $matiere->update([
                                'net_weight'=>$quantity,
                                'transfert_weight'=>$sommes
                            ]);

                            if ($update) {
                                $update1 = 1;
                                if ($stock_quantity == 0) {
                                    $update1 = $stock->update([
                                        'net_weight'=>$stock_quantity,
                                        'transfert'=>True
                                    ]);
                                    
                                }else {
                                    $update1 = $stock->update([
                                        'net_weight'=>$stock_quantity
                                    ]);
                                }
                                if ($update1) {
                                    session()->flash('message', 'Stock transféré avec succès');
                                    return response()->json([
                                        $update
                                    ]);
                                }else {
                                    session()->flash('error', 'Une erreur s\'est produite');
                                    return response()->json([
                                        $update
                                    ]);
                                }
                            }
                        }
                    }
                }else {
                    session()->flash('message', 'Le stock est vide');
                    return response()->json([
                        $matiere
                    ]);
                }
            }else return redirect('login');
        }else return redirect('login');
    }

    
    public function verifyMagasinier()
    {
        $magasinier = app(AuthController::class);
        $result = $magasinier->magasinierCheck();
        return  $result;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type = null)
    {
        if( Auth::check()){
            $user = $this->verifyMagasinier();
            
            if($user){
                $produits = MatierePremiere::get();
                $campaigns = Campaign::get();

               /*  $client = new Client();
                $response = $client->get('https://restcountries.com/v3.1/all');
        
                $countries = $response->getBody()->getContents();
                $countries = json_decode($countries, true);
        
                $regions = [];
                $cities = [];
                $villages = []; */

                $suppliers = Fournisseur::get();


                return view('inventaire.createreception',compact('produits','campaigns','type','suppliers'));
            }else return redirect('login');
        }else return redirect('login');
    }

    public function storeGeo(Request $request)
    {
      if( Auth::check()){
        $user = $this->verifyMagasinier();
          
        if($user){
          $request->validate([
             'country'=>'required',
             'town'=>'required',
             'neighborhood'=>'required',
             //'region'=>'required',
         ]);/* */
         $data = $request->all();

         $geo = Geolocation::create([
          'country'=>$data['country'],
          'town'=>$data['town'],
          'neighborhood'=>$data['neighborhood'],
          //'region'=>$data['region'],
         ]);

         if ($geo) {
          $session  = session::put('geolocalisation' , $geo->id);
          $local = $geo->country ."-".$geo->town."-".$geo->neighborhood;
          $session  = session::put('local_geo' , $local);

          return response()->json([
            "localisation"=>$local,
            "geo_id"=>$geo->id
          ]);
         
         }


        }else return redirect('login');
      }else return redirect('login');
    }

    
    public function modifOrigin($type = null)
    {
        if( Auth::check()){
            $user = $this->verifyMagasinier();
            
            if($user){
                $campaigns = Campaign::get();
                $suppliers = Fournisseur::get();
                $origin_prod = OrigineProd::where('id', $type)->first();
                //localisation

                //dd($origin_prod->geolocation_id);
                $session = session::all(); 
                
                
                $local = $session['local_geo']; //$origin_prod->get_Geo->country ."-".$origin_prod->get_Geo->town."-".$origin_prod->get_Geo->neighborhood;
                return view('inventaire.createreception',compact('campaigns','type','origin_prod','suppliers','local'));
            }else return redirect('login');
        }else return redirect('login');
    }

    public function test()
    {
      if( Auth::check()){
        $user = $this->verifyMagasinier();
          
        if($user){
          return view('inventaire.test');

        }else return redirect('login');
      }else return redirect('login');
    }

    public function processusKor($origin=null)
    {
        if( Auth::check()){
            $user = $this->verifyMagasinier();
            if($user){

              $produits = MatierePremiere::get();
                
              return view('inventaire.processuskor',compact('origin','produits'));
            }else return redirect('login');
        }else return redirect('login');
    }
    
    public function add_session(Request $request)
    {
        if( Auth::check()){
            $user = $this->verifyMagasinier();
            if($user){

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
                    $ses['origin_id']
                ]);
            }else return redirect('login');
        }else return redirect('login');
    }
    
    public function add_session_recep(Request $request)
    {
        if( Auth::check()){
            $user = $this->verifyMagasinier();
            if($user){
                $data = $request->all();
               /* foreach($data as $key=>$value){
                    if($key != '_token'){
                        $keys = $key;
                        $response  = session::put($keys , $value);
                    }
                }

                $session = session::all();

                if (isset($session['origin_id'])) {
                    $exist = OrigineProd::where('id', $session['origin_id'])->first();
                    if ($exist) {
                        return response()->json([
                            $exist->id
                        ]);
                    }

                }else {*/
                  $ses = session::all();
                    $origin = new OrigineProd();
                    foreach ($data as $column => $value) {
                        if($column != '_token'){
                            $origin->$column = $value;
                        }
                    }
                    $origin->geolocation_id = $ses['geolocalisation'];
                    $origin->save();
                    $origin_session = session::put('origin_id' , $origin->id);
                    if ($origin_session) {
                        return response()->json([
                            $origin->id
                        ]);
                    }
                /*} */
            }else return redirect('login');
        }else return redirect('login');
    }

    public function issue()
    {
        if( Auth::check()){
            $user = $this->verifyMagasinier();
            if($user){
                return view('reception.issue');

            }else return redirect('login');
        }else return redirect('login');
    }

    public function searchissue(Request $request)
    {
        if( Auth::check()){
            $user = $this->verifyMagasinier();
            if($user){
                
                $request->validate([
                    'batch_id'=>'required',
                ]);
                //
                $data = $request->all();
                $depelliculage = Depelliculage::where('unskinning_batch',$data['batch_id'])->first();
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

                        $tableau = '<table class="table table-bordered ">';
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
                                    <th rowspan="14"><strong style="text-transform:uppercase;font-size:larger;">CALIBRAGE </strong></th>
                                    <td>ID Target  </td>
                                    <td id="calibrage_id_target">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getSequence->getObjectif->id_target.' </td>
                                  </tr>
                                  <tr>
                                    <td>SEQUENCE </td>
                                    <td id="calibrage_sequence">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getSequence->id.' </td>
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
                                    <th rowspan="7"><strong style="text-transform:uppercase;font-size:larger;">CUISSON</strong></th>
                                    <td>ID Target : </td>
                                    <td id="cooking_id_target">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getSequence->getObjectif->id_target.' </td>
                                  </tr>
                                  <tr>
                                    <td>SEQUENCE </td>
                                    <td id="cooking_id_sequence">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getSequence->id.'</td>
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
                                    <th rowspan="7">REFROIDISSEMENT  </th><td>ID Target  </td>
                                    <td id="calibrage_id_target">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getSequence->getObjectif->id_target.'</td>
                                   </tr>
                                   <tr>
                                    <td>SEQUENCE</td>
                                    <td id="cooling_sequence">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getSequence->id.'</td>
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
                                    <th rowspan="6" ><strong style="text-transform:uppercase;font-size:larger;">SECHAGE</strong> </th>
                                    <td>ID Target</td>
                                    <td id="drying_id_target">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getSequence->getObjectif->id_target.' </td>
                                  </tr>
                                  <tr>
                                    <td>SEQUENCE </td>
                                    <td id="drying_sequence">'.$depelliculage->getDrying->getSequence->id.' </td>
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
                                    <th rowspan="7">DEPELICULAGE</th>
                                    <td>ID Target </td>
                                    <td id="unskinning_id_target">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getSequence->getObjectif->id_target.' </td>
                                  </tr>
                                  <tr>
                                    <td>SEQUENCE : </td>
                                    <td id="unskinning_sequence">'.$depelliculage->getDrying->getSequence->id.' </td>
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
                                    <th rowspan="7">CLASSIFICATION</th>
                                    <td>ID Target </td>
                                    <td id="classification_idtarget">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getSequence->getObjectif->id_target.' </td>
                                  </tr>
                                  <tr>
                                    <td>SEQUENCE : </td>
                                    <td id="classification_sequence">'.$classification->getSequence->id.'</td>
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
                                    <th rowspan="9"> CONDITIONNEMENT</th>
                                    <td>  ID Target</td>
                                    <td id="conditioning_id_target">'. $depelliculage->getDrying->getFirstDrying->getShelling->getCooling->getFrag->getCalibrage->getSequence->getObjectif->id_target.'</td>
                                  </tr>
                                  <tr>
                                    <td>SEQUENCE : </td>
                                    <td id="conditioning_sequence">'. $conditionning?->getSequence?->id.'</td>
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

            }else return redirect('login');
        }else return redirect('login');
    }
    

    public function get_default_th()
    {
        if( Auth::check()){
            $user = $this->verifyMagasinier();
            if($user){
                $session = Session::all();
                $thau_def = (( $session['p3'] + $session['p5'])/$session['p1'])*100;


                $register_thau = OrigineProd::where('id',$session['origin_id'])->first();
                if ($register_thau) {
                    
                    $thau_def1 = round($thau_def, 2);
                    $update =  $thau_def; $register_thau->update([
                                'grainage' => $session['nbr_noix'],
                                'default_thaux' => $thau_def1,
                                'taux_humidite' => $session['taux_h']
                            ]);/**/
                }else {
                    $thau_def1 = round($thau_def, 2);
                    $origin = new OrigineProd();
                    $origin->matiere_id = $session['matiere_id'];
                    $origin->grainage = $session['nbr_noix'];
                    $origin->default_thaux = $thau_def1;
                    $origin->taux_humidite = $session['taux_h'];
                    $origin->save();

                    $origin_session = session::put('origin_id' , $origin->id);

                }

                if($thau_def){
                    return response()->json($thau_def);
                }
        
            }else return redirect('login');
        }else return redirect('login');
    }

    
    public function get_kor(Request $request)
    {
        if( Auth::check()){
            $user = $this->verifyMagasinier();
            if($user){
                $session = Session::all();
                $au = $session['p2'] + ($session['p4'])/2;
                $ra = (($session['p2'] + ($session['p4'])/2)/$session['p1'])*100;
                $kor = $au * (80/454);
                $kor1 = round($kor, 2);

                $register_thau = OrigineProd::where('id',$session['origin_id'])->first();
                
                $update = $register_thau->update([
                    'kor' => $kor1,
                ]);/**/
                if ($update) {
                    return response()->json([
                        'kor'=>$kor1,
                        'origin_id'=>$register_thau->id
                    ]);
                }
        
            }else return redirect('login');
        }else return redirect('login');
    }

    public function pageaccueil(){
        return view('auth.accueil');
    }
    /**
     * @Route("Route", name="RouteName")
     */
    public function LotPMS()
    {
        if( Auth::check()){
            $user=$this->verifyMagasinier();
            if ($user) {
                $pms = $this->generateCode(7);
                
                return response()->json([
                    $pms
                ]); 
            }else return redirect('login');
        }else return redirect('login');
    }

    
    public function generateCode($column = null)
	{
        if ($column != null) {
            $length = $column;
        }else $length = 7;
		
		// Initialisation des caractères utilisables
		$characters = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
		$key_password = array_rand($characters, $length);

		for ($i = 0; $i < $length; $i++) {
			$password_tab[] = $characters[$key_password[$i]];
		}

		$generated_code = strtoupper(implode("", $password_tab));

        
        $existingCode = OrigineProd::where('id_lot_pms', $generated_code)->first();
        while ($existingCode) {
            $generated_code = $this->generateCode($length);
            $existingCode = OrigineProd::where('id_lot_pms', $generated_code)->first();
        }

		return $generated_code;
		
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
                 $request->validate([
                    'date_recep'=>'sometimes|nullable',
                    'matiere_id'=>'sometimes|nullable',
                    //'cooperative'=>'sometimes|nullable',
                    'sacks_bought'=>'required',
                    'total_weight'=>'required',
                    'id_lot_externe'=>'sometimes|nullable',
                    'id_lot_pms'=>'required',
                    'unit_price'=>'sometimes|nullable',
                    'amount_paid'=>'sometimes|nullable',
                    'campagne'=>'sometimes|nullable',
                    'devise'=>'sometimes|nullable',
                    'date_charg'=>'sometimes|nullable',
                    'num_permis'=>'sometimes|nullable',
                    'name_driver'=>'sometimes|nullable',
                    'signature_chauffeur'=>'sometimes|nullable',
                    'date_time_decharge'=>'sometimes|nullable',
                    'port_decharge'=>'sometimes|nullable',
                    'qte_decharge'=>'sometimes|nullable',
                    'net_weight'=>'required',
                    'date_controle'=>'sometimes|nullable',
                    'nom_controleur'=>'sometimes|nullable',
                    'signature_controleur'=>'sometimes|nullable',
                    'localisation'=>'sometimes|nullable',
                    'observation'=>'sometimes|nullable',
                    'nom_mag'=>'sometimes|nullable',
                    'signature_magasinier'=>'sometimes|nullable',
                    'supplier_id'=>'required',
                    'geolocation_id'=>'required'

                ]);/* */

                
                $ses = session::all();

                $data = $request->all();
                //dd($data);

                if ($data['geolocation_id'] == null) {
                  if ($ses['geolocalisation']) {
                    $data['geolocation_id'] = $ses['geolocalisation'];
                  }
                } /* */

                if (isset($data['id'])) {
                    $origin = OrigineProd::where('id',$data['id'])->first();
                }
                

                if(isset($origin)){

                    $update = $origin->update([
                        'date_recep'=>$data['date_recep'],
                        'matiere_id'=>$origin->matiere_id,
                        //'cooperative'=>$data['cooperative'],
                        'sacks_bought'=>$data['sacks_bought'],
                        'total_weight'=>$data['total_weight'],
                        'id_lot_externe'=>$data['id_lot_externe'],
                        'id_lot_pms'=>$data['id_lot_pms'],
                        'unit_price'=>$data['unit_price'],
                        'amount_paid'=>$data['amount_paid'],
                        'devise'=>$data['devise'],
                        'date_charg'=>$data['date_charg'],
                        'num_permis'=>$data['num_permis'],
                        'name_driver'=>$data['name_driver'],
                        'signature_chauffeur'=>$data['signature_chauffeur'],
                        'date_time_decharge'=>$data['date_time_decharge'],
                        'port_decharge'=>$data['port_decharge'],
                        'qte_decharge'=>$data['qte_decharge'],
                        'net_weight'=>$data['net_weight'],
                        'date_controle'=>$data['date_controle'],
                        'campagne'=>$data['campagne'],
                        'nom_controleur'=>$data['nom_controleur'],
                        'signature_controleur'=>$data['signature_controleur'],
                        'localisation'=>$data['localisation'],
                        'observation'=>$data['observation'],
                        'nom_mag'=>$data['nom_mag'],
                        'signature_magasinier'=>$data['signature_magasinier'],
                        'supplier_id'=>$data['supplier_id'],
                        'geolocation_id'=>$data['geolocation_id'],
 
                        'user_id'=>$user->id
                    ]);
                    if($update){

                        /*$matiere = MatierePremiere::where('id',$data['matiere_id'])->first();
                         $mat_update = $matiere->update([
                            'receptionner'=> True
                        ]); */
                        
                        $exist_stock = Stock::where('origin_id',  $origin->id)->where('transfert', False)->first();
                        if ($exist_stock) {
                            $matiere = MatierePremiere::where('id',$origin->matiere_id)->first();
    
                            $mat_update = $matiere->update([
                                'net_weight'=> floatval($data['net_weight']) + floatval( $matiere->net_weight)
                            ]);
                            $updat_stock = $exist_stock->update([
                                'net_weight'=>$data['net_weight']
                            ]); /* */
                            return redirect()->route('inventaire.edit', $data['id'])->with('message',"Enregistrer avec succès");
                        }else {
                            $matiere = MatierePremiere::where('id',$origin->matiere_id)->first();
    
                            $mat_update = $matiere->update([
                                'net_weight'=> floatval($data['net_weight']) + floatval($matiere->net_weight)
                            ]);
                            $stock = Stock::create([
                                'origin_id'=>$origin->id,
                                'net_weight'=>$data['net_weight']

                            ]);
                            if ($stock) {
                                return redirect()->route('inventaire.edit', $data['id'])->with('message',"Enregistrer avec succès");
                            }
                            
                        }
                    }else return redirect()->route('inventaire.edit', $data['id'])->with('error',"Une erreur s'est produite");
                }else{
                    $create =OrigineProd::create([
                        'date_recep'=>$data['date_recep'],
                        'matiere_id'=>$data['matiere_id'],
                        /* 'cooperative'=>$data['cooperative'], */
                        'sacks_bought'=>$data['sacks_bought'],
                        'total_weight'=>$data['total_weight'],
                        'id_lot_externe'=>$data['id_lot_externe'],
                        'id_lot_pms'=>$data['id_lot_pms'],
                        'unit_price'=>$data['unit_price'],
                        'amount_paid'=>$data['amount_paid'],
                        'devise'=>$data['devise'],
                        'date_charg'=>$data['date_charg'],
                        'num_permis'=>$data['num_permis'],
                        'name_driver'=>$data['name_driver'],
                        'signature_chauffeur'=>$data['signature_chauffeur'],
                        'date_time_decharge'=>$data['date_time_decharge'],
                        'port_decharge'=>$data['port_decharge'],
                        'qte_decharge'=>$data['qte_decharge'],
                        'net_weight'=>$data['net_weight'],
                        'date_controle'=>$data['date_controle'],
                        'campagne'=>$data['campagne'],
                        'nom_controleur'=>$data['nom_controleur'],
                        'signature_controleur'=>$data['signature_controleur'],
                        'localisation'=>$data['localisation'],
                        'observation'=>$data['observation'],
                        'nom_mag'=>$data['nom_mag'],
                        'signature_magasinier'=>$data['signature_magasinier'],

                        'supplier_id'=>$data['supplier_id'],
                        'geolocation_id'=>$data['geolocation_id'],

                        'user_id'=>$user->id
                    ]);
                    if($create){
                        $matiere = MatierePremiere::where('id',$data['matiere_id'])->first();

                        $mat_update = $matiere->update([
                            'net_weight'=> floatval($data['net_weight']) + floatval($matiere->net_weight)
                        ]);
                        $stock = Stock::create([
                            'origin_id'=>$create->id,
                            'net_weight'=>$data['net_weight']
                        ]);
                        if ($stock) {
                            /**/
                            return redirect()->route('inventaire.edit', $data['matiere_id'])->with('message',"Enregistrer avec succès");
                        }
                    }else return redirect()->route('inventaire.edit', $data['matiere_id'])->with('error',"Une erreur s'est produite");
                }
                
            }else return redirect('login');
        }else return redirect('login');
    }
/**
 * Undocumented function
 *
 * @param OrigineProd $reception
 * @return void
 */
    public function fiche(OrigineProd $reception)
    {
        if( Auth::check()){
            $user=$this->verifyMagasinier();
            if ($user) {
                $date_recep = null;
                
                if ($reception->date_recep) {
                    $date_recep = Carbon::createFromFormat('Y-m-d H:i:s', $reception->date_recep);
                   
                }
                $date_time_decharge = null;
                if ($reception->date_time_decharge) {
                    $date_time_decharge = Carbon::createFromFormat('Y-m-d H:i:s', $reception->date_time_decharge);
                }
                
                //dd($reception->get_Geo->country);
                
                $date_charg = null;
                if ($reception->date_charg) {
                    $date_charg = Carbon::createFromFormat('Y-m-d H:i:s', $reception->date_charg);
                }
                
                $qr = QrCode::size(100)->generate(route('get_data_quality', $reception->id));
                return view('reception.fiche',compact('reception','date_recep','date_time_decharge','date_charg', 'qr'));
            }else return redirect('login');
        }else return redirect('login');
    }


    public function getInfoQuality($reception){
        $quality = OrigineProd::where('id',$reception)->first();//get_data_quality

         /*return  $data = [
                'Kor'=>$quality->kor,
                'Date contrôle'=>$quality->date_controle,
                'Grainage'=>$quality->grainage,
                'Thaux d\'umidité'=>$quality->taux_humidite,
                'Thaux de défaut'=>$quality->default_thaux
            ]; */
        return view('reception.getinfoquality',compact('quality'));
    }



    public function imprimer(OrigineProd $reception)
    {
        if (Auth::user()) {
            $user=$this->verifyMagasinier();
            if ($user) {
                $date_recep = Carbon::createFromFormat('Y-m-d H:i:s', $reception->date_recep);
                $date_time_decharge = Carbon::createFromFormat('Y-m-d H:i:s', $reception->date_time_decharge);
                $date_charg = Carbon::createFromFormat('Y-m-d H:i:s', $reception->date_charg);
                
                $qr = QrCode::size(100)->generate(route('get_data_quality', $reception->id));
                $bar_decharge = Carbon::parse($reception->date_time_decharge)->format('Ymd');
                $bar_recharge = Carbon::parse($reception->date_charg)->format('Ymd');
                
                $local = $reception->get_Geo?->country ."- ".$reception->get_Geo?->town."- ".$reception->get_Geo?->neighborhood;
                $pdf = PDF::loadView('reception.pdf', compact('reception', 'date_recep', 'date_time_decharge', 'date_charg', 'qr', 'local','bar_decharge','bar_recharge'))
                            ->setOptions([
                                'defaultFont' => 'sans-serif',
                                'font-size' => '25px'
                            ]);
                //$pdf->download('fiche.pdf');
                return $pdf->stream();
            }else return redirect('login');
            
        }else return redirect('login');
    }

    public function monpdf()
    {
        $reception = OrigineProd::where('id',1)->first();
        
        $date_recep = Carbon::createFromFormat('Y-m-d H:i:s', $reception->date_recep);
        $date_time_decharge = Carbon::createFromFormat('Y-m-d H:i:s', $reception->date_time_decharge);
        $date_charg = Carbon::createFromFormat('Y-m-d H:i:s', $reception->date_charg);
        
        $qr = QrCode::size(100)->generate(route('get_data_quality', $reception->id));
        return view('reception.pdf',compact('reception','date_recep','date_time_decharge','date_charg','qr'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reception  $reception
     * @return \Illuminate\Http\Response
     */
    public function show(Reception $reception)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reception  $reception
     * @return \Illuminate\Http\Response
     */
    public function edit(Reception $reception)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reception  $reception
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reception $reception)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reception  $reception
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reception $reception)
    {
        //
    }

    
    public function verifyOperator()
    {
        $magasinier = app(AuthController::class);
        $result = $magasinier->operatorCheck();
        return  $result;
    }

    public function operator_stock()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                return view('calibrage.dash');
            }else return redirect('login');
        }else return redirect('login');
    }
    
    public function stock_dispo_op()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_calibrage = 1;
                $section_poste = Section::where('designation','Calibrage')->first();
                if ($section_poste) {
                    $poste = Poste::where('section_id',$section_poste->id)->first();
                    //$assigner = Assigner::where('user_id',$user->id)->where('poste_id',$poste->id)->first();
                    $stocks = StockRecepT::where('receptionner',true)->where('section_id',$poste->id)->orderBy('id','DESC')->paginate(20);
                    
                    $sequence = session::all();          
                    $assigner = Assigner::where('user_id',$user->id)->where('poste_id',$poste->id)->where('sequence_id',$sequence['sequence'])->first();
                    
                    if ($assigner) {
                        return view('calibrage.stock',compact('stocks','etape_calibrage'));
                    }else return redirect()->route('dashboard')->with('error',"Vous n'êtes pas habilité à travailler à ce poste.");
                }
            }else return redirect('login');
        }else return redirect('login');
    }
}
