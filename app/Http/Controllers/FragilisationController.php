<?php

namespace App\Http\Controllers;

use App\Models\Assigner;
use App\Models\Calibrage;
use App\Models\Cuiseur;
use App\Models\Current_rapportFragilisation;
use App\Models\Fragilisation;
use App\Models\OperatorSequence;
use App\Models\Poste;
use App\Models\RapportFragilisation;
use App\Models\Refroidissement;
use App\Models\Section;
use App\Models\Sequence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FragilisationController extends Controller
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
                $etape_fragilisation = 1;
                $fragilisations = Fragilisation::where('transfert',false)->orderBy('id','DESC')->paginate(20);
                //dd($fragilisations);
                return view('fragilisation.index',compact('fragilisations','etape_fragilisation','stock'));

            }else return redirect('login');
        }else return redirect('login');
    }

    public function endCounting($fragilisation_id)
    {
        $etape_fragilisation = 1;
        $fragilisation = Fragilisation::where('id',$fragilisation_id)->first();
        if ($fragilisation) {
            $update = $fragilisation->update([
                'end_countdown'=>true,
            ]);
            if ($update) {
                return response()->json([
                    $update
                ],200);
            }
        }else {
            return response()->json([
                "error"
            ],500);
        }

    }

    public function FragilisationTransfert(Fragilisation $fragilisation)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                

                 $transfert= $fragilisation->update([
                    'transfert'=>true,
                ]);/**/
                //dd($fragilisation);
                if ($transfert) {
                    $total_weight =0;
                    $alls = Fragilisation::where('callibre_stock_id',$fragilisation->callibre_stock_id)->where('transfert',true)->orderBy('id','ASC')->get();
                    if ($alls->isNotEmpty()) {
                        foreach ($alls as $value ) {
                            if ($fragilisation->getCalibrage->id_lot_calibre == $value->getCalibrage->id_lot_calibre) {
                                $exist = Refroidissement::where('fragilisation_id',$value->id)->first();
                                if ($exist) {
                                    return redirect()->route('fragilisation.index',[$fragilisation->callibre_stock_id])->with('error',"Le refroidissement a déjà débuté");
                                }
                                $total_weight = $total_weight + $value->cook_net_weigth;
                                
                            }
                            
                        }
                    }
                    
                    $first = Fragilisation::where('callibre_stock_id',$fragilisation->callibre_stock_id)->orderBy('id','ASC')->first();
                    $first->update(['total_weight'=>$total_weight]);
                    $exist_current_rapport = Current_rapportFragilisation::where('fragilisation_id',$fragilisation->id)->first();
                    if ($exist_current_rapport) {
                        return redirect()->route('fragilisation.index',[$fragilisation->callibre_stock_id])->with('message',"Stock transférer");

                    }
                    $current_rapport = Current_rapportFragilisation::create([
                        "sequence_id"=>$operator_sequence->sequence_id,
                        "author_id"=>$user->id,
                        "fragilisation_id"=>$fragilisation->id
                    ]);
                    if ($current_rapport) {
                        return redirect()->route('fragilisation.index',[$fragilisation->callibre_stock_id])->with('message',"Stock transférer");
                    }else {
                        return redirect()->route('fragilisation.index',[$fragilisation->callibre_stock_id])->with('error',"Une erreur s'est produite");
                    }
                }return redirect()->route('fragilisation.index',[$fragilisation->callibre_stock_id])->with('error',"Une erreur s'est produite");
            }else return redirect('login');
        }else return redirect('login');
    }

    
        
    public function verifyOperator()
    {
        $magasinier = app(AuthController::class);
        $result = $magasinier->operatorCheck();
        return  $result;
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
                $etape_fragilisation = 1;
                $request->validate([
                    'net_weigth' => 'sometimes|nullable',
                    'cooking_time' => 'sometimes|nullable',
                    'pressure' => 'sometimes|nullable',
                    'callibre_stock_id' => 'required',
                    'cuiseur_id' => 'sometimes|nullable',
                    'cook_net_weigth' => 'required',
                ]);

                $data = $request->all();
                if (!$data['net_weigth']) {
                    $session = session::all();
                    $data['net_weigth'] = $session['net_weigth'];
                }
                if ($data['cuiseur_id'] == null) {
                    return response()->json([
                    'message'=>'Une erreur s\'est produite'
                    ],500);
                }

                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();

                if ($operator_sequence) {
                    $exist = Calibrage::where('id',$data['callibre_stock_id'])->first();
                    if ($exist->caliber_weight >= $data['cook_net_weigth']) {
                        $remain = $exist->caliber_weight - $data['cook_net_weigth'] ;
                        if ($remain >= 0) {
                            $exist->update([
                                'caliber_weight'=>$remain,
                            ]);
                        }

                        /* $exist_fragilisation = Fragilisation::where('sequence_id',$operator_sequence->sequence_id)
                                                ->where('callibre_stock_id',$data['callibre_stock_id'])
                                                ->where('author_id',$user->id)->first();
                        if ($exist_fragilisation ) {
                            
                            foreach($data as $column => $value) {

                                $exist_fragilisation->update([$column => $value]);
                                
                            }
                            return response()->json([
                                'message'=>'Modifier'
                            ],200);
                        } */


                        $fragilisation = Fragilisation::create([
                            'net_weigth'=>$data['net_weigth'],
                            'cooking_time'=>$data['cooking_time'] ,
                            'pressure'=>$data['pressure'] ,
                            'callibre_stock_id'=>$data['callibre_stock_id'] ,
                            'cuiseur_id'=>$data['cuiseur_id'] ,
                            'cook_net_weigth'=>$data['cook_net_weigth'],
                            'sequence_id'=>$operator_sequence->sequence_id,
                            'author_id'=>$user->id
                        ]);
                        if ($fragilisation) {
                            return response()->json([
                                'message'=>'Enregistrer'
                            ],200);
                        }else {
                            return response()->json([
                            'message'=>'Une erreur s\'est produite'
                            ],500);
                        }

                    }
                    
                }

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

                $stock = Fragilisation::where('sequence_id',$data['sequence_id'])->first();
                if (!$stock) {
                    return redirect()->route('fragilisation.rapport')->with('error','Rapport vide');
                }

                $exist = RapportFragilisation::where('sequence_id',$data['sequence_id'])
                            ->where('calibrage_id',$stock->callibre_stock_id)
                            ->where('author_id',$user->id)
                            ->first();
                if ($exist) {
                    
                    foreach($data as $column => $value) {

                        $exist->update([$column => $value]);
                        
                    }
                    
                    $currents = Current_rapportFragilisation::where('sequence_id',$operator_sequence->sequence_id)->where('author_id',$user->id)->get();
                    if ($currents) {
                        foreach($currents as $current) {
                            $current->update(['rapport_id' => $exist->id]);
                        }

                        return redirect()->route('fragilisation.rapport')->with('message','Rapport enregistré');
                    }else return redirect()->route('fragilisation.rapport')->with('error','Une erreur s\'est produite');  
                }

                $rapport = RapportFragilisation::create([
                    'sequence_id'=>$data['sequence_id'],
                    'calibrage_id'=>$stock->callibre_stock_id,
                    'observation'=>$data['observation'],
                    'name'=>$data['name'],
                    'workforce'=>$data['workforce'],
                    'author_id'=>$user->id,
                ]);
                if ($rapport) {
                    $currents = Current_rapportFragilisation::where('sequence_id',$operator_sequence->sequence_id)->where('author_id',$user->id)->get();
                    if ($currents) {
                        foreach($currents as $current) {
                            $current->update(['rapport_id' => $rapport->id]);
                        }

                        return redirect()->route('fragilisation.rapport')->with('message','Rapport enregistré');
                    }else return redirect()->route('fragilisation.rapport')->with('error','Une erreur s\'est produite');
                }else return redirect()->route('fragilisation.rapport')->with('error','Une erreur s\'est produite');

            }else return redirect('login');
        }else return redirect('login');
    }

    public function fragilisationRapport()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_fragilisation = 1;
                $session = session::all();
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                if ($operator_sequence) {
                    $sequence = Sequence::where('id',$operator_sequence->sequence_id)->first();
                    if ($sequence) {
                        $sequence_deb = Sequence::where('objectif_id',$sequence->objectif_id)->first();
                        $fragilisations = Fragilisation::where('transfert',true)->where('sequence_id',$sequence->id)->whereDate('updated_at',Carbon::today())->orderBy('id','DESC')->paginate(20);
                        $quantity = 0;
                        foreach ($fragilisations as $key => $value) {
                            $quantity = $value['cook_net_weigth'] + $quantity;
                        }
                        return view('fragilisation.rapport',compact('sequence_deb','sequence','quantity','fragilisations','etape_fragilisation','user'));
                    }
                }else {
                    return redirect()->route('dashboard');
                }

            }else return redirect('login');
        }else return redirect('login');
    }

    public function confirm_weigth(Request $request)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_fragilisation = 1;
                $request->validate([
                    'net_weigth' => 'required',
                    'callibre_stock_id' => 'required',
                ]);
                $data = $request->all();
                
                foreach($data as $key=>$value){
                    if($key != '_token'){
                        $keys = $key;
                        $response  = session::put($keys , $value);
                    }
                }
                $exist = Calibrage::where('id',$data['callibre_stock_id'])->first();
                if ($exist) {
                    if ($data['net_weigth'] != $exist->caliber_weight) {
                        //session()->flash('error', 'Erreur sur le poids');
                        return response()->json([
                            'message'=>'Erreur sur le poids'
                        ],500);
                    }else {
                        //session()->flash('message', 'Poids confirmé');
                        return response()->json([
                            'message'=>'Confirmé'
                        ],200);
                    }
                }else {
                    
                    session()->flash('error', 'Stock inexistant');
                    return response()->json([
                        $exist
                    ]);
                }

            }else return redirect('login');
        }else return redirect('login');
    }

    public function stock_fragil_liste()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $session = session::all();
                
                $section_poste = Section::where('designation', 'Refroidissement')
                //->orderBy('id','DESC')Where('designation', 'Refroidissement')
                ->first();
                if($section_poste) {
                    $poste = Poste::where('section_id',$section_poste->id)->first();
                    if ($poste) {
                        $assigner = Assigner::where('user_id',$user->id)->where('poste_id',$poste->id)->where('sequence_id',$session['sequence'])->first();
                            if ($assigner) {
                                $stocks = Fragilisation::where('transfert',true)->where('end_cooling',false)
                                                ->whereNotNull('total_weight')->orderBy('id',"DESC")->paginate(20);
                                
                                $etape_cooling = 1;
                            if ($stocks) {
                                return view('cooling.stock', compact('stocks' , 'etape_cooling'));
                                }
                            }else return redirect()->route('dashboard')->with('error',"Vous n'êtes pas habilité à travailler à ce poste.");
                        
                    }else return redirect()->route('dashboard')->with('error',"Veuillez créer des postes liés au Refroidissement");
                }else return redirect('login');
            }else return redirect('login');
        }else return redirect('login');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fragilisation  $fragilisation
     * @return \Illuminate\Http\Response
     */
    public function show(Fragilisation $fragilisation)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_fragilisation = 1;

                return view('fragilisation.details',compact('etape_fragilisation','fragilisation'));

            }else return redirect('login');
        }else return redirect('login');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fragilisation  $fragilisation
     * @return \Illuminate\Http\Response
     */
    public function edit(Fragilisation $fragilisation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fragilisation  $fragilisation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fragilisation $fragilisation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fragilisation  $fragilisation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fragilisation $fragilisation)
    {
        //
    }
}
