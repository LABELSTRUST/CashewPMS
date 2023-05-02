<?php

namespace App\Http\Controllers;

use App\Models\Assigner;
use App\Models\Classification;
use App\Models\Current_rapportClassification;
use App\Models\Depelliculage;
use App\Models\Grade;
use App\Models\OperatorSequence;
use App\Models\Poste;
use App\Models\RapportClassification;
use App\Models\Section;
use App\Models\Sequence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ClassificationController extends Controller
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
                $etape_classification = 1;
                
                $classifications = Classification::where('transfert',0)->orderBy('id','DESC')->paginate(20); 
                return view('classification.index',compact('classifications','etape_classification'));

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
    public function create(Depelliculage $unskinning)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                if ($operator_sequence) {
                    $etape_classification = 1;
                    $grades = Grade::get();
                    $exists = Classification::where('unskinning_id',$unskinning->id)->get();
                    $remain = 0;
                    if ($exists->isNotEmpty()) {
                        foreach ($exists as $key ) {
                            $remain += $key->weight;
                        }
                        $remain = $unskinning->weight - $remain;
                        if ($remain == 0) {
                            $remain = "Stock utilisé";
                            return view('classification.create', compact('grades','unskinning','etape_classification','remain'));
                        }elseif ($remain >0) {
                            # code...
                        }
                    }
                    
                    return view('classification.create', compact('grades','unskinning','etape_classification'));

                }else return redirect()->route('dashboard')->with('message',"Accès refusé");

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
                   'weight'=>'sometimes|nullable',
                   'unskinning_id'=>'sometimes|nullable',
                   'grade_id'=>'sometimes|nullable',
               ]); /**/
               
               $data = $request->all();
               $session1 = session::all();

            
            $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                ->whereDate('created_at',Carbon::today())
                                ->orderBy('id','DESC')->first();

               $unskinning = Depelliculage::where('id',$data['unskinning_id'])->first();

                if ($unskinning) {

                    $exists = Classification::where('unskinning_id',$unskinning->id)->get();
                    $remain = 0;
                    if ($exists->isNotEmpty()) {
                        foreach ($exists as $key ) {
                            $remain += $key->weight;
                        }
                        $remain = $unskinning->weight - $remain;
                        if ($remain = 0 || $data['weight'] > $remain) {
                            return redirect()->route('classification.create',$unskinning->id)->with('error',"Toutle stock est déjà utilisé");
                        }
                    }

                    $exist = Classification::where('grade_id',$data['grade_id'])->where('unskinning_id',$data['unskinning_id'])->first();
                    if ($exist) {
                        if ($data['weight'] > $unskinning->weight) {
                            return redirect()->route('classification.create',$unskinning->id)->with('error',"Le poids entré est supérieur à celui du stock");
                        }
                        $update = $exist->update([
                            'weight'=>$data['weight']
                        ]);
                        if ($update) {
                            return redirect()->route('classification.create',$unskinning->id)->with('message',"Enregistré avec succès");
                        }else return redirect()->route('classification.create',$unskinning->id)->with('error',"Une erreur s'est produite");
                    }else {
                        if ($data['weight'] > $unskinning->weight) {
                            return redirect()->route('classification.create',$unskinning->id)->with('error',"Le poids entré est supérieur à celui du stock");
                        }
                        $classification = Classification::create([
                            'weight'=>$data['weight'],
                            'unskinning_id'=>$data['unskinning_id'],
                            'grade_id'=>$data['grade_id'],
                            'author_id'=>$user->id,
                            'sequence_id'=>$operator_sequence->sequence_id
                        ]);
                        if ($classification) {
                            return redirect()->route('classification.create',$unskinning->id)->with('message',"Enregistré avec succès");
                        }else return redirect()->route('classification.create',$unskinning->id)->with('error',"Une erreur s'est produite");
                    }
                }else return redirect('login');
            }else return redirect('login');
        }else return redirect('login');
    }

    public function classificationrapport()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_classification = 1;
                $session = session::all();
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                if ($operator_sequence) {
                    $sequence = Sequence::where('id',$operator_sequence->sequence_id)->first();
                    if ($sequence) {
                        $sequence_deb = Sequence::where('objectif_id',$sequence->objectif_id)->first();
                        $classifications = Classification::where('transfert',true)->whereDate('updated_at',Carbon::today())->orderBy('id','DESC')->paginate(20);
                        
                        $quantity = 0;
                        foreach ($classifications as $key => $value) {
                            $quantity = $value['weight'] + $quantity;
                        }
                        return view('classification.rapport',compact('sequence_deb','sequence','quantity','classifications','etape_classification','user'));
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

                $stock = Classification::where('sequence_id',$data['sequence_id'])->whereDate('updated_at',Carbon::today())->first();
                if (!$stock) {
                    $stock = Classification::whereDate('updated_at', Carbon::today())->orderBy('updated_at', 'desc')->first();
                    if (!$stock) {
                        return redirect()->route('unskinning.rapport')->with('error','Rapport vide');
                    }

                }
                $exist = RapportClassification::where('sequence_id',$data['sequence_id'])
                            ->where('classification_id',$stock->id)
                            ->where('author_id',$user->id)
                            ->first();
                if ($exist) {
                    
                    foreach($data as $column => $value) {

                        $exist->update([$column => $value]);
                        
                    }
                    $currents = Current_rapportClassification::where('sequence_id',$operator_sequence->sequence_id)->where('author_id',$user->id)->get();
                    
                    if ($currents) {
                        foreach($currents as $current) {
                            $current->update(['rapport_id' => $exist->id]);
                        }
                        
                        return redirect()->route('classification.rapport')->with('message','Rapport modifié');
                    }else return redirect()->route('classification.rapport')->with('error','Rapport non modifié');
                }

                $rapport = RapportClassification::create([
                    'sequence_id'=>$data['sequence_id'],
                    'classification_id'=>$stock->id,
                    'observation'=>$data['observation'],
                    'name'=>$data['name'],
                    'workforce'=>$data['workforce'],
                    'author_id'=>$user->id,
                ]);
                if ($rapport) {
                    $currents = Current_rapportClassification::where('sequence_id',$operator_sequence->sequence_id)->where('author_id',$user->id)->get();
                    if ($currents) {
                        foreach($currents as $current) {
                            $current->update(['rapport_id' => $rapport->id]);
                        }
                        return redirect()->route('unskinning.rapport')->with('message','Rapport enregistré');
                    }else return redirect()->route('unskinning.rapport')->with('error','Une erreur s\'est produite');

                }else return redirect()->route('unskinning.rapport')->with('error','Une erreur s\'est produite');

            }else return redirect('login');
        }else return redirect('login');
    }

    
    public function classificationdetails(Classification $classification)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_classification = 1;

                return view('classification.details',compact('classification','etape_classification'));
            }else return redirect('login');
        }else return redirect('login');
    }
    
    public function transfert(Classification $classification)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                $etape_classification = 1;
                $transfert= $classification->update([
                    'transfert'=>true,
                ]);
                if ($transfert) {
                    
                    $current_rapport = Current_rapportClassification::create([
                        "sequence_id"=>$operator_sequence->sequence_id,
                        "author_id"=>$user->id,
                        "classification_id"=>$classification->id
                    ]);
                    if ($current_rapport) {
                        return redirect()->route('classification.index')->with('message',"Stock transférer");

                    }else return redirect()->route('classification.index')->with('error',"Echec du transfert");
                }else return redirect()->route('classification.index')->with('error',"Echec du transfert");

            }else return redirect('login');
        }else return redirect('login');
    }

    public function stock_conditioning_liste()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $session = session::all();
                $section_poste = Section::where('designation', 'Conditionnement')
                   //->orderBy('id','DESC')Where('designation', 'Refroidissement')
                   ->first();
                if ($section_poste) {
                    $poste = Poste::where('section_id',$section_poste->id)->first();
                    
                    if ($poste) {
                        $assigner = Assigner::where('user_id',$user->id)->where('poste_id',$poste->id)->where('sequence_id',$session['sequence'])->first();
                        if ($assigner) {
                            $stocks = Classification::where('transfert',true)->orderBy('id','DESC')->paginate(20); 
                            $etape_conditioning = 1;
                            if ($stocks) {
                                return view('conditioning.stocks', compact('stocks','etape_conditioning'));
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




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classification  $classification
     * @return \Illuminate\Http\Response
     */
    public function show(Classification $classification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classification  $classification
     * @return \Illuminate\Http\Response
     */
    public function edit(Classification $classification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classification  $classification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classification $classification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classification  $classification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classification $classification)
    {
        //
    }
}
