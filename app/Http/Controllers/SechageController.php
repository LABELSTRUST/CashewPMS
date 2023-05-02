<?php

namespace App\Http\Controllers;

use App\Models\Assigner;
use App\Models\Current_rapportSechage;
use App\Models\Decorticage;
use App\Models\Four;
use App\Models\OperatorSequence;
use App\Models\Poste;
use App\Models\RapportSechage;
use App\Models\Sechage;
use App\Models\Sechage2;
use App\Models\Section;
use App\Models\Sequence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SechageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_drying = 1;

                $dryings = Sechage2::orderBy('id', 'desc')->paginate(20);
                

                return view('drying.seconddrying',compact('dryings','etape_drying'));

            }else return redirect('login');
        }else return redirect('login');
    }

    public function firstDrying()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_drying = 1;
                $first = Sechage::pluck('id');
                
                $exist_second = Sechage2::whereIn('drying1_id',$first)->pluck('drying1_id');
                $dryings="";
                if ($exist_second->isEmpty()) {
                    $dryings = Sechage::orderBy('id', 'desc')->paginate(20);
                }else {
                    $dryings = Sechage::whereNotIn('id',$exist_second)->orderBy('id', 'desc')->paginate(20);
                }
                return view('drying.firstdrying',compact('dryings','etape_drying'));

            }else return redirect('login');
        }else return redirect('login');
    }

    public function createSecondDrying(Sechage $drying)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_drying = 1;
                $fours = Four::get();
                return view('drying.createsecond',compact('etape_drying','fours','drying'));

            }else return redirect('login');
        }else return redirect('login');
    }

    public function add_weight(Request $request)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $request->validate([
                    'weigth_after'=>'sometimes|nullable',
                    'drying'=>'sometimes|nullable',
                    'finale_temp'=>'sometimes|nullable',
                ]);
                $data = $request->all();

                $drying = Sechage::where('id',$data['drying'])->first();
                if ($drying) {
                    if($drying->weigth_before>=$data['weigth_after']){
                        $update = $drying->update([
                            'weigth_after'=>$data['weigth_after'],
                            'finale_temp'=>$data['finale_temp'],
                            'transfert_to_second'=>true
                        ]);
                        if ($update) {
                            
                            return response()->json([
                                $update
                            ],200);
                        }
                    }else {
                        return response()->json([
                            "message"=>"Erreur sur le poids"
                        ],404);
                    }
                }else {
                    
                    return response()->json([
                        "message"=>"Stock inexistant"
                    ],404);
                }

            }else return redirect('login');
        }else return redirect('login');
    }

    
    public function dryindetails(Sechage2 $drying)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_drying = 1;

                return view('drying.details',compact('drying','etape_drying'));
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

                $stock = Sechage2::where('sequence_id',$data['sequence_id'])->first();
                if (!$stock) {
                    return redirect()->route('drying.rapport')->with('error','Rapport vide');
                }

                $exist = RapportSechage::where('sequence_id',$data['sequence_id'])
                            ->where('drying_id',$stock->id)
                            ->where('author_id',$user->id)
                            ->first();
                if ($exist) {
                    
                    foreach($data as $column => $value) {

                        $exist->update([$column => $value]);
                        
                    }
                    $currents = Current_rapportSechage::where('sequence_id',$operator_sequence->sequence_id)->where('author_id',$user->id)->get();
                    
                    if ($currents) {
                        foreach($currents as $current) {
                            $current->update(['rapport_id' => $exist->id]);
                        }
                        return redirect()->route('drying.rapport')->with('message','Rapport enregistré');
                    }else return redirect()->route('drying.rapport')->with('error','Rapport non enregistré');
                }

                $rapport = RapportSechage::create([
                    'sequence_id'=>$data['sequence_id'],
                    'drying_id'=>$stock->callibre_stock_id,
                    'observation'=>$data['observation'],
                    'name'=>$data['name'],
                    'workforce'=>$data['workforce'],
                    'author_id'=>$user->id,
                ]);
                if ($rapport) {
                    $currents = Current_rapportSechage::where('sequence_id',$operator_sequence->sequence_id)->where('author_id',$user->id)->get();
                    if ($currents) {
                        foreach($currents as $current) {
                            $current->update(['rapport_id' => $rapport->id]);
                        }
                        return redirect()->route('drying.rapport')->with('message','Rapport enregistré');
                    }else return redirect()->route('drying.rapport')->with('error','Rapport non enregistré');
                }else return redirect()->route('drying.rapport')->with('error','Une erreur s\'est produite');

            }else return redirect('login');
        }else return redirect('login');
    }

    public function storeSecondDeying(Request $request)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_drying = 1;
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                if ($operator_sequence) {
                    $request->validate([
                        'initial_temp'=>'sometimes|nullable',
                        'first_drying_id'=>'sometimes|nullable',
                        'start_time'=>'sometimes|nullable',
                        'end_time'=>'sometimes|nullable',
                        'weigth_before'=>'sometimes|nullable',
                        'four_id'=>'sometimes|nullable',
                    ]);
                    $data = $request->all();

                    $first = Sechage::where('id',$data['first_drying_id'])->first();
                    if ($first) {
                        $shelling = Decorticage::where('id',$first->shelling_id)->first();
    
                        if ($data['weigth_before']>$shelling->weight) {
                            return redirect()->route('drying.create',$shelling->id)->with('error','Erreur sur le poids');
                        }
                    }

                    $exist = Sechage2::where('drying1_id',$first->id)->first();
                    if ($exist) {
                        foreach($data as $column => $value) {
    
                            $exist->update([$column => $value]);
                            
                        }
                        return redirect()->route('drying.createseconddrying',$first->id)->with('message','Enregistré avec succès');
                        
                    }
                    
                    $drying = Sechage2::create([
                        'initial_temp'=>$data['initial_temp'],
                        'drying1_id'=>$data['first_drying_id'],
                        'start_time'=>$data['start_time'],
                        'end_time'=>$data['end_time'],
                        'weigth_before'=>$data['weigth_before'],
                        'four_id'=>$data['four_id'],
                        'sequence_id'=>$operator_sequence->sequence_id,
                        'author_id'=>$user->id
                    ]);
                    if ($drying) {
                        return redirect()->route('drying.createseconddrying',$data['first_drying_id'])->with('message','Enregistré avec succès');
                    }else return redirect()->route('drying.createseconddrying',$data['first_drying_id'])->with('error','Une erreur s\'est produite');
                }return redirect('dashboard');
            }else return redirect('login');
        }else return redirect('login');
    }


    public function registerSecondDrying(Request $request)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_drying = 1;
                
                $request->validate([
                    'weigth_after'=>'sometimes|nullable',
                    'drying'=>'sometimes|nullable',
                    'loss'=>'sometimes|nullable',
                    'final_temp'=>'sometimes|nullable',
                ]);
                $data = $request->all();

                $exist = Sechage2::where('id',$data['drying'])->first();
                if ($exist) {
                    $update = $exist->update([
                        'weigth_after'=>$data['weigth_after'],
                        'loss'=>$data['loss'],
                        'final_temp'=>$data['final_temp']
                    ]);
                    if ($update) {
                        return response()->json([
                            $update
                        ],200);
                    }
                }
            }else return redirect('login');
        }else return redirect('login');
    }


    public function listeSecondDraying()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_drying = 1;

                $dryings = Sechage2::whereNotNull('weigth_after')->where('transfert',0)->orderBy('id','DESC')->paginate(20); 
                
                return view('drying.listedrying',compact('dryings','etape_drying'));

            }else return redirect('login');
        }else return redirect('login');
    }


    public function getLoss(Request $request)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_drying = 1;
                
                $request->validate([
                    'weigth_after'=>'sometimes|nullable',
                    'drying'=>'sometimes|nullable',
                ]);
                $data = $request->all();
                
                $drying = Sechage2::where('id',$data['drying'])->first();
                if ($drying) {
                    $loss = abs($data['weigth_after'] - $drying->weigth_before);
                    
                
                    if ($loss !=0) {
                        return response()->json([
                            $loss
                        ],200);
                    }else {
                        return response()->json([
                            0
                        ],200);
                    }
                }
            }else return redirect('login');
        }else return redirect('login');
    }
    
    
    public function transfertSeconddrying(Sechage2 $drying)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                $transfert= $drying->update([
                    'transfert'=>true,
                ]);

                if ($transfert) {
                    
                    $current_rapport = Current_rapportSechage::create([
                        "sequence_id"=>$operator_sequence->sequence_id,
                        "author_id"=>$user->id,
                        "drying_id"=>$drying->id
                    ]);
                    if ($current_rapport) {
                        return redirect()->route('drying.listeDraying')->with('message',"Stock transférer");
                    }else return redirect()->route('drying.listeDraying')->with('error',"Stock non transférer");
                }else return redirect()->route('drying.listeDraying')->with('error',"Stock non transférer");
            }else return redirect('login');
        }else return redirect('login');
    }

    

    public function dryingRapport()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_drying = 1;
                $session = session::all();
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                if ($operator_sequence) {
                    $sequence = Sequence::where('id',$operator_sequence->sequence_id)->first();
                    if ($sequence) {
                        $sequence_deb = Sequence::where('objectif_id',$sequence->objectif_id)->first();
                        $dryings = Sechage2::where('transfert',true)->whereDate('updated_at',Carbon::today())->get();
                        
                        $quantity = 0;
                        foreach ($dryings as $key => $value) {
                            $quantity = $value['weigth_after'] + $quantity;
                        }
                        return view('drying.rapport',compact('sequence_deb','sequence','quantity','dryings','etape_drying','user'));
                    }else return redirect()->route('dashboard');
                }else return redirect()->route('dashboard');
            }else return redirect('login');
        }else return redirect('login');
    }


    public function endsecondCounting($drying_id)
    {
        $etape_drying = 1;
        $drying = Sechage2::where('id',$drying_id)->first();
        if ($drying) {
            $update = $drying->update([
                'end_countdown'=>true,
            ]);
            if ($update) {
                return response()->json([
                    $update
                ],200);
            }
        }
    }


    public function endCounting($drying_id)
    {
        $etape_drying = 1;
        $drying = Sechage::where('id',$drying_id)->first();
        if ($drying) {
            $update = $drying->update([
                'end_countdown'=>true,
            ]);
            if ($update) {
                return response()->json([
                    $update
                ],200);
            }
        }
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
    public function create(Decorticage $shelling)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_drying = 1;

                $fours = Four::get();

                return view('drying.create',compact('etape_drying','fours','shelling'));

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
                $etape_drying = 1;
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                if ($operator_sequence) {
                    $request->validate([
                        'initial_temp'=>'sometimes|nullable',
                        'shelling_id'=>'sometimes|nullable',
                        'start_time'=>'sometimes|nullable',
                        'end_time'=>'sometimes|nullable',
                        'weigth_before'=>'sometimes|nullable',
                        'four_id'=>'sometimes|nullable',
                    ]);
                    $data = $request->all();

                    $shelling = Decorticage::where('id',$data['shelling_id'])->first();

                    if ($data['weigth_before']>$shelling->weight) {
                        return redirect()->route('drying.create',$shelling->id)->with('error','Erreur sur le poids');
                    }
                    $exist = Sechage::where('shelling_id',$data['shelling_id'])->first();
                    if ($exist) {
                        foreach($data as $column => $value) {
    
                            $exist->update([$column => $value]);
                            
                        }
                        return redirect()->route('drying.create',$data['shelling_id'])->with('message','Enregistré avec succès');
                        
                    }
                    
                    $drying = Sechage::create([
                        'initial_temp'=>$data['initial_temp'],
                        'shelling_id'=>$data['shelling_id'],
                        'start_time'=>$data['start_time'],
                        'end_time'=>$data['end_time'],
                        'weigth_before'=>$data['weigth_before'],
                        'four_id'=>$data['four_id'],
                        'sequence_id'=>$operator_sequence->sequence_id,
                        'author_id'=>$user->id
                    ]);
                    if ($drying) {
                        return redirect()->route('drying.create',$data['shelling_id'])->with('message','Enregistré avec succès');
                    }else return redirect()->route('drying.create',$data['shelling_id'])->with('error','Une erreur s\'est produite');

                }return redirect('dashboard');
            }else return redirect('login');
        }else return redirect('login');
    }

    public function endTime($time)
    {
        # code...
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sechage  $sechage
     * @return \Illuminate\Http\Response
     */
    public function show(Sechage $sechage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sechage  $sechage
     * @return \Illuminate\Http\Response
     */
    public function edit(Sechage $sechage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sechage  $sechage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sechage $sechage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sechage  $sechage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sechage $sechage)
    {
        //
    }

    
    public function stock_unskinning_liste()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $session = session::all();
                $section_poste = Section::where('designation', 'Dépelliculage')
                   //->orderBy('id','DESC')Where('designation', 'Refroidissement')
                   ->first();
                if ($section_poste) {
                    $poste = Poste::where('section_id',$section_poste->id)->first();
                    if ($poste) {
                        $assigner = Assigner::where('user_id',$user->id)->where('poste_id',$poste->id)->where('sequence_id',$session['sequence'])->first();
                        if ($assigner) {
                            $stocks = Sechage2::where('transfert',true)->orderBy('id','DESC')->paginate(20);
                            $etape_unskinning = 1;
                            if ($stocks) {
                                return view('unskinning.stocks', compact('stocks' , 'etape_unskinning'));
                            }
                        }else { 
                            return redirect()->route('dashboard')->with('error',"Vous n'êtes pas habilité à travailler à ce poste.");
                       }
                    }else {
                        return redirect()->route('dashboard')->with('error',"Veuillez créer des postes reliés à la section fragilisation");
                    }
                }else return redirect()->route('dashboard')->with('error',"Veuillez créer des postes reliés à la section fragilisation");
            }else return redirect('login');
        }else return redirect('login');
    }
}
