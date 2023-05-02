<?php

namespace App\Http\Controllers;

use App\Models\Assigner;
use App\Models\Current_rapportDepelliculage;
use App\Models\Depelliculage;
use App\Models\OperatorSequence;
use App\Models\Poste;
use App\Models\RapportDepelliculage;
use App\Models\Sechage2;
use App\Models\Section;
use App\Models\Sequence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DepelliculageController extends Controller
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
                $etape_unskinning = 1;
                $unskinnings = Depelliculage::where('transfert',0)->orderBy('id','DESC')->paginate(20); 

                return view('unskinning.index', compact('etape_unskinning', 'unskinnings'));

            }else return redirect('login');
            
        }else return redirect('login');
    }

    public function transfert(Depelliculage $unskinning)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                $etape_unskinning = 1;
                $transfert= $unskinning->update([
                    'transfert'=>true,
                ]);
                if ($transfert) {
                        
                    $current_rapport = Current_rapportDepelliculage::create([
                        "sequence_id"=>$operator_sequence->sequence_id,
                        "author_id"=>$user->id,
                        "unskinning_id"=>$unskinning->id
                    ]);
                    if ($current_rapport) {
                        return redirect()->route('unskinning.index')->with('message',"Stock transférer");
                    }else return redirect()->route('unskinning.index')->with('error',"Echec du transfert");
                }else return redirect()->route('unskinning.index')->with('error',"Echec du transfert");

            }else return redirect('login');
        }else return redirect('login');
    }

    public function unskinningrapport()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_unskinning = 1;
                $session = session::all();
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                if ($operator_sequence) {
                    $sequence = Sequence::where('id',$operator_sequence->sequence_id)->first();
                    if ($sequence) {
                        $sequence_deb = Sequence::where('objectif_id',$sequence->objectif_id)->first();
                        $unskinnings = Depelliculage::where('transfert',true)->whereDate('updated_at',Carbon::today())->get();
                        
                        $quantity = 0;
                        foreach ($unskinnings as $key => $value) {
                            $quantity = $value['weight'] + $quantity;
                        }
                        return view('unskinning.rapport',compact('sequence_deb','sequence','quantity','unskinnings','etape_unskinning','user'));
                    }else return redirect()->route('dashboard');
                }else return redirect()->route('dashboard');
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

                $stock = Depelliculage::where('sequence_id',$data['sequence_id'])->whereDate('updated_at',Carbon::today())->first();
                if (!$stock) {
                    $stock = Depelliculage::whereDate('updated_at', Carbon::today())->orderBy('updated_at', 'desc')->first();
                    if (!$stock) {
                        return redirect()->route('unskinning.rapport')->with('error','Rapport vide');
                    }
                }

                
                $exist = RapportDepelliculage::where('sequence_id',$data['sequence_id'])
                            ->where('unskinning_id',$stock->id)
                            ->where('author_id',$user->id)
                            ->first();
                if ($exist) {
                    
                    foreach($data as $column => $value) {

                        $exist->update([$column => $value]);
                        
                    }
                    
                    $currents = Current_rapportDepelliculage::where('sequence_id',$operator_sequence->sequence_id)->where('author_id',$user->id)->get();
                    
                    if ($currents) {
                        foreach($currents as $current) {
                            $current->update(['rapport_id' => $exist->id]);
                        }
                        return redirect()->route('unskinning.rapport')->with('message','Rapport modifié');
                    }else return redirect()->route('unskinning.rapport')->with('error','Rapport non modifié');
                    
                }

                $rapport = RapportDepelliculage::create([
                    'sequence_id'=>$data['sequence_id'],
                    'unskinning_id'=>$stock->id,
                    'observation'=>$data['observation'],
                    'name'=>$data['name'],
                    'workforce'=>$data['workforce'],
                    'author_id'=>$user->id,
                ]);
                if ($rapport) {
                    $currents = Current_rapportDepelliculage::where('sequence_id',$operator_sequence->sequence_id)->where('author_id',$user->id)->get();
                    if ($currents) {
                        foreach($currents as $current) {
                            $current->update(['rapport_id' => $rapport->id]);
                        }
                        return redirect()->route('unskinning.rapport')->with('message','Rapport enregistré');
                    }else return redirect()->route('unskinning.rapport')->with('error','Rapport non enregistré');
                }else return redirect()->route('unskinning.rapport')->with('error','Une erreur s\'est produite');

            }else return redirect('login');
        }else return redirect('login');
    }

    
    public function dryindetails(Depelliculage $unskinning)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_unskinning = 1;

                return view('unskinning.details',compact('unskinning','etape_unskinning'));
            }else return redirect('login');
        }else return redirect('login');
    }

    public function unskinning_second(Request $request ,Depelliculage $unskinning)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_unskinning = 1;
                $request->validate([
                    'weight'=>'sometimes|nullable',
                    'unskinning'=>'sometimes|nullable',
                ]);
                $data = $request->all();

                if ($unskinning->weight_cj) {
                    if ($unskinning->weight_cj>=$data['weight']) {
                        $update = $unskinning->update([
                            'weight'=>$data['weight']
                        ]);
                        if ($update) {
                            session()->flash('message', 'Enregistrer avec succès');
                            return response()->json([
                                $update
                            ]);
                        }else {
                            session()->flash('error', 'Une erreur est survenue');
                            return response()->json([
                                "erreur"=>"Erreur"
                            ]);
                        }
                    }else {
                        session()->flash('error', 'Erreur sur le poids');
                        return response()->json([
                            "erreur"=>"Erreur"
                        ]);
                    }
                }

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
    public function create(Sechage2 $drying)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_unskinning = 1;

                return view('unskinning.create',compact('etape_unskinning','drying'));

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
                $etape_unskinning = 1;
                
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                if ($operator_sequence) {
                    $request->validate([
                        'amande_b'=>'sometimes|nullable',
                        'amande_j'=>'sometimes|nullable',
                        'drying_id'=>'sometimes|nullable',
                    ]);
                    $data = $request->all();

                    $drying = Sechage2::where('id', $data['drying_id'])->first();
                    
                    if ($drying) {

                        if (($drying->weigth_after < $data['amande_b'])|| ($drying->weigth_after < $data['amande_j']) ||($drying->weigth_after <( $data['amande_j'] + $data['amande_b'])) ) {
                           
                            return redirect()->route('unskinning.create',$drying->id)->with('error','Erreur sur les poids');
                        }
                        
                        $exist = Depelliculage::where('drying_id',$data['drying_id'])->first();
                        if ($exist) {
                            
                            $lot = $drying->getFirstDrying?->getShelling?->sub_batch_caliber.'-'. 'CB';
                            $lot2 = $drying->getFirstDrying?->getShelling?->sub_batch_caliber.'-'. 'CJ';
                            if ($exist->unskinning_batch == $lot ) {
                                if ($data['amande_b']) {
                                    $update = $exist->update([
                                        'weight'=>$data['amande_b']
                                    ]);
                                    if ($update) {
                                        if ($data['amande_j']) {
                                            $exist2 = Depelliculage::where('drying_id',$data['drying_id'])->orderBy('id','DESC')->first();
                                            $update = $exist2->update([
                                                'weight_cj'=>$data['amande_j']
                                            ]);
                                        }
                                        return redirect()->route('unskinning.create',$drying->id)->with('message','Enregistré avec succès');
                                    }else return redirect()->route('unskinning.create',$drying->id)->with('error','erreur');
                                }else if ($data['amande_j']) {
                                    $exist2 = Depelliculage::where('drying_id',$data['drying_id'])->orderBy('id','DESC')->first();
                                    $update = $exist2->update([
                                        'weight_cj'=>$data['amande_j']
                                    ]);
                                    if ($update) {
                                        return redirect()->route('unskinning.create',$drying->id)->with('message','Enregistré avec succès');
                                    }else return redirect()->route('unskinning.create',$drying->id)->with('error','erreur');
                                }else return redirect()->route('unskinning.create',$drying->id)->with('error','erreur 1')/*  */;
                            }
                        }else{
                                
                            $unskinning = Depelliculage::create([
                                'drying_id'=>$data['drying_id'],
                                'unskinning_batch'=>$drying->getFirstDrying?->getShelling?->sub_batch_caliber.'-'. 'CB',
                                'weight'=>$data['amande_b'],
                                'sequence_id'=>$operator_sequence->sequence_id,
                                'author_id'=>$user->id
    
                            ]);

                            if ($unskinning) {
                                $unskinning2 = Depelliculage::create([
                                    'drying_id'=>$data['drying_id'],
                                    'unskinning_batch'=> $drying->getFirstDrying?->getShelling?->sub_batch_caliber.'-'. 'CJ',
                                    'weight_cj'=>$data['amande_j'],
                                    'sequence_id'=>$operator_sequence->sequence_id,
                                    'author_id'=>$user->id
                                ]);
                                if ($unskinning2) {
                                    return redirect()->route('unskinning.create',$drying->id)->with('message','Enregistré avec succès');
                                }else return redirect()->route('unskinning.create',$drying->id)->with('error','Une erreur est survenue');
                            }else return redirect()->route('unskinning.create',$drying->id)->with('error','Une erreur est survenue');
                        }
                    }else return redirect('login');
                }else return redirect('login');
            }else return redirect('login');
        }else return redirect('login');
            
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Depelliculage  $depelliculage
     * @return \Illuminate\Http\Response
     */
    public function show(Depelliculage $depelliculage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Depelliculage  $depelliculage
     * @return \Illuminate\Http\Response
     */
    public function edit(Depelliculage $depelliculage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Depelliculage  $depelliculage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Depelliculage $depelliculage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Depelliculage  $depelliculage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Depelliculage $depelliculage)
    {
        //
    }

    
    
    public function stock_classification_liste()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $session = session::all();
                $section_poste = Section::where('designation', 'Classification')
                   //->orderBy('id','DESC')Where('designation', 'Refroidissement')
                   ->first();
                if ($section_poste) {
                    $poste = Poste::where('section_id',$section_poste->id)->first();
                    
                    if ($poste) {
                        $assigner = Assigner::where('user_id',$user->id)->where('poste_id',$poste->id)->where('sequence_id',$session['sequence'])->first();
                        if ($assigner) {
                            $stocks = Depelliculage::where('transfert',true)->orderBy('id','DESC')->paginate(20);
                            $etape_classification = 1;
                            if ($stocks) {
                                return view('classification.stocks', compact('stocks' , 'etape_classification'));
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
