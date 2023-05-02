<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use App\Models\Conditionnement;
use App\Models\Current_rapportConditionnement;
use App\Models\OperatorSequence;
use App\Models\RapportConditionnement;
use App\Models\Sequence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ConditionnementController extends Controller
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
                $etape_conditioning = 1;
                
                $conditionings = Conditionnement::where('transfert',0)->orderBy('id','DESC')->paginate(20); 

                return view('conditioning.index',compact('conditionings','etape_conditioning'));

            }else return redirect('login');
        }else return redirect('login');
    }

    
    public function conditioningrapport()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_conditioning = 1;
                $session = session::all();
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                if ($operator_sequence) {
                    $sequence = Sequence::where('id',$operator_sequence->sequence_id)->first();
                    if ($sequence) {
                        $sequence_deb = Sequence::where('objectif_id',$sequence->objectif_id)->first();
                        $conditionings = Conditionnement::where('transfert',true)->whereDate('updated_at',Carbon::today())->orderBy('id','DESC')->paginate(20);
                        
                        $quantity = 0;
                        foreach ($conditionings as $key => $value) {
                            $quantity = $value['weight'] + $quantity;
                        }
                        return view('conditioning.rapport',compact('sequence_deb','sequence','quantity','conditionings','user','etape_conditioning'));
                    }else return redirect()->route('dashboard');
                }else return redirect()->route('dashboard');
            }else return redirect('login');
        }else return redirect('login');
    }

    public function transfert(Conditionnement $conditioning)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                if ($operator_sequence) {
                    $etape_conditioning = 1;
                    $transfert= $conditioning->update([
                        'transfert'=>true,
                    ]);
                    if ($transfert) {
                        
                        $current_rapport = Current_rapportConditionnement::create([
                            "sequence_id"=>$operator_sequence->sequence_id,
                            "author_id"=>$user->id,
                            "conditioning_id"=>$conditioning->id
                        ]);
                        if ($current_rapport) {
                            return redirect()->route('conditioning.index')->with('message',"Stock transférer");
    
                        }else return redirect()->route('conditioning.index')->with('error',"Echec du transfert");
    
                    }else return redirect()->route('conditioning.index')->with('error',"Echec du transfert");
    
                }else return redirect()->route('conditioning.index')->with('error',"Echec du transfert");
            }else return redirect('login');
        }else return redirect('login');
    }
    
    public function verifyOperator()
    {
        $magasinier = app(AuthController::class);
        $result = $magasinier->operatorCheck();
        return  $result;
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
                ]);
                
                $data = $request->all();

                $stock = Conditionnement::where('sequence_id',$data['sequence_id'])->whereDate('updated_at',Carbon::today())->first();
                
                if (!$stock) {
                    $stock = Conditionnement::whereDate('updated_at', Carbon::today())->orderBy('updated_at', 'desc')->first();
                    if (!$stock) {
                        return redirect()->route('conditioning.rapport')->with('error','Rapport vide');
                    }

                }

                
                $exist = RapportConditionnement::where('sequence_id',$data['sequence_id'])
                            ->where('conditioning_id',$stock->id)
                            ->where('author_id',$user->id)
                            ->first();
                if ($exist) {
                    
                    foreach($data as $column => $value) {

                        $exist->update([$column => $value]);
                        
                    }
                    $currents = Current_rapportConditionnement::where('sequence_id',$operator_sequence->sequence_id)->where('author_id',$user->id)->get();
                    
                    if ($currents) {
                        foreach($currents as $current) {
                            $current->update(['rapport_id' => $exist->id]);
                        }
                        return redirect()->route('conditioning.rapport')->with('message','Rapport modifié');
                    }else return redirect()->route('conditioning.rapport')->with('error','Rapport non modifié');
                }

                $rapport = RapportConditionnement::create([
                    'sequence_id'=>$data['sequence_id'],
                    'conditioning_id'=>$stock->id,
                    'observation'=>$data['observation'],
                    'author_id'=>$user->id,
                    'workforce'=>$data['workforce'],
                ]);
                if ($rapport) {
                    
                    $currents = Current_rapportConditionnement::where('sequence_id',$operator_sequence->sequence_id)->where('author_id',$user->id)->get();
                    if ($currents) {
                        foreach($currents as $current) {
                            $current->update(['rapport_id' => $rapport->id]);
                        }
                        return redirect()->route('conditioning.rapport')->with('message','Rapport enregistré');

                    }else return redirect()->route('conditioning.rapport')->with('error','Une erreur s\'est produite');
                }else return redirect()->route('conditioning.rapport')->with('error','Une erreur s\'est produite');

            }else return redirect('login');
        }else return redirect('login');
    }

    public function conditioningdetails(Conditionnement $conditioning)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_conditioning = 1;

                return view('conditioning.details',compact('conditioning','etape_conditioning'));
            }else return redirect('login');
        }else return redirect('login');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Classification $classification)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                if ($operator_sequence) {
                    $etape_conditioning = 1;
                    $bag_quantity = 22.68;

                    $num_bag =floatval($classification->weight) / $bag_quantity;
                    $num_bag = intval($num_bag);
                    $remain_bag=1;
                    $remain_weight =  floatval($classification->weight)- floatval($num_bag * $bag_quantity);
                    
                    
                    return view('conditioning.create', compact('classification','etape_conditioning','num_bag','remain_weight','remain_bag','bag_quantity'));

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
                    'num_bag'=>'sometimes|nullable',
                   'weight'=>'sometimes|nullable',
                   'classification_id'=>'sometimes|nullable',
                   'remain_bag'=>'sometimes|nullable',
                   'remain_weight'=>'sometimes|nullable',
               ]); /**/
               
               $data = $request->all();
               $session1 = session::all();

            
            $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                ->whereDate('created_at',Carbon::today())
                                ->orderBy('id','DESC')->first();
            if ($operator_sequence) {
                $exist = Conditionnement::where('classification_id',$data['classification_id'])->first();
                if ($exist) {
                    if ($exist->transfert == true) {
                        return redirect()->route('conditioning.create',$data['classification_id'])->with('message',"Stock Transférer");
                    }
                    
                    foreach($data as $column => $value) {

                        $exist->update([$column => $value]);
                        
                    }

                    return redirect()->route('conditioning.create',$data['classification_id'])->with('message',"Modifier avec succès");
                }else {
                    $conditioning = Conditionnement::create([
                        'num_bag'=>$data['num_bag'],
                        'weight'=>$data['weight'],
                        'classification_id'=>$data['classification_id'],
                        'remain_bag'=>$data['remain_bag'],
                        'remain_weight'=>$data['remain_weight'],
                        'author_id'=>$user->id,
                        'sequence_id'=>$operator_sequence->sequence_id
                    ]);
                    if ($conditioning) {
                        return redirect()->route('conditioning.create',$data['classification_id'])->with('message',"Enregistré avec succès");
                    }else return redirect()->route('conditioning.create',$data['classification_id'])->with('error',"Une erreur s'est produite");
                }
                
            }else return redirect('login');
            }else return redirect('login');
        }else return redirect('login');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Conditionnement  $conditionnement
     * @return \Illuminate\Http\Response
     */
    public function show(Conditionnement $conditionnement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Conditionnement  $conditionnement
     * @return \Illuminate\Http\Response
     */
    public function edit(Conditionnement $conditionnement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conditionnement  $conditionnement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conditionnement $conditionnement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conditionnement  $conditionnement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conditionnement $conditionnement)
    {
        //
    }
}
