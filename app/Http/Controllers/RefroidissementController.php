<?php

namespace App\Http\Controllers;

use App\Models\Assigner;
use App\Models\Current_rapportRefroidissement;
use App\Models\Fragilisation;
use App\Models\OperatorSequence;
use App\Models\Poste;
use App\Models\RapportRefroidissement;
use App\Models\Refroidissement;
use App\Models\Section;
use App\Models\Sequence;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefroidissementController extends Controller
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
                $etape_cooling = 1;
                $coolings = Refroidissement::where('transfert',false)->orderBy('id','DESC')->paginate(20); ;
                return view('cooling.index', compact('etape_cooling','coolings'));
            }else return redirect('login');
        }else return redirect('login');
    }

    
    public function rapport()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_cooling = 1;
                $session = session::all();
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                $sequence = Sequence::where('id',$operator_sequence->sequence_id)->first();
                if ($sequence) {
                    $sequence_deb = Sequence::where('objectif_id',$sequence->objectif_id)->first();
                    $coolings = Refroidissement::where('sequence_id',$sequence->id)->where('transfert',true)->orderBy('id','DESC')->paginate(20);
                    $quantity = 0;
                    foreach ($coolings as $key => $value) {
                        $quantity = $value['weight_after_cook'] + $quantity;
                    }
                    return view('cooling.rapport',compact('sequence_deb','sequence','quantity','coolings','etape_cooling','user'));
                }else {
                    return redirect()->route('dashboard');
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

                $stock = Refroidissement::where('sequence_id',$data['sequence_id'])->first();
                if (!$stock) {
                    return redirect()->route('cooling.rapport')->with('error','Rapport vide');
                }
                

                $exist = RapportRefroidissement::where('sequence_id',$data['sequence_id'])
                            ->where('cooling_id',$stock->id)
                            ->where('author_id',$user->id)
                            ->first();
                if ($exist) {
                    
                    foreach($data as $column => $value) {

                        $exist->update([$column => $value]);
                        
                    }
                    $currents = Current_rapportRefroidissement::where('sequence_id',$operator_sequence->sequence_id)->where('author_id',$user->id)->get();
                    
                    if ($currents) {
                        foreach($currents as $current) {
                            $current->update(['rapport_id' => $exist->id]);
                        }
                        return redirect()->route('fragilisation.rapport')->with('message','Rapport enregistré');
                    }else return redirect()->route('fragilisation.rapport')->with('error','Rapport non enregistré');
                }
                $rapport = RapportRefroidissement::create([
                    'sequence_id'=>$data['sequence_id'],
                    'cooling_id'=>$stock->id,
                    'observation'=>$data['observation'],
                    'workforce'=>$data['workforce'],
                    'name'=>$data['name'],
                    'author_id'=>$user->id,
                ]);
                
                if ($rapport) {
                    $currents = Current_rapportRefroidissement::where('sequence_id',$operator_sequence->sequence_id)->where('author_id',$user->id)->get();
                    if ($currents) {
                        foreach($currents as $current) {
                            $current->update(['rapport_id' => $rapport->id]);
                        }
                        return redirect()->route('cooling.rapport')->with('message','Rapport enregistré');
                    }else return redirect()->route('cooling.rapport')->with('error','Rapport non enregistré');
                }else return redirect()->route('cooling.rapport')->with('error','Une erreur s\'est produite');

            }else return redirect('login');
        }else return redirect('login');
    }
    public function __construct()
    {
        $this->middleware('auth')->except('endCounting');
    }
    
    public function endCounting($fragilisation_id)
    {
        $etape_cooling = 1;
        $fragilisation = Fragilisation::where('id',$fragilisation_id)->first();
        if ($fragilisation) {
            $update = $fragilisation->update([
                'end_counting_cooling'=>true,
            ]);

            if ($update) {
                return response()->json([
                    $update
                ],200);
            }
        }

    }

    
    public function coolingTransfert(Refroidissement $cooling)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                $transfert= $cooling->update([
                    'transfert'=>true,
                ]);
                //dd($fragilisation);
                if ($transfert) {
                        
                    $current_rapport = Current_rapportRefroidissement::create([
                        "sequence_id"=>$operator_sequence->sequence_id,
                        "author_id"=>$user->id,
                        "cooling_id"=>$cooling->id
                    ]);
                    if ($current_rapport) {
                        $fragilisation = Fragilisation::where('id',$cooling->fragilisation_id)->first();
                        if ($fragilisation) {
                        $update_fragilisation = $fragilisation->update([
                                                        'end_cooling'=>true
                                                    ]);
                        }
                        if ($update_fragilisation) {
                            return redirect()->route('cooling.index')->with('message',"Stock transférer");
                        }

                    }else return redirect()->route('cooling.index')->with('error',"Stock non transférer");
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
    
    public function create(Fragilisation $fragilisation)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_cooling = 1;

                return view('cooling.create',compact('etape_cooling','fragilisation'));
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
                $etape_cooling = 1;
                $request->validate([
                    'weight_after_cook' => 'required',
                    'fragilisation_id' => 'required',
                    'weight_after_cooling' => 'required',
                    'gap' => 'required',
                    'end_temp' => 'required',
                    'start_temp' => 'required',
                ]);
                $data = $request->all();
                //dd( $data );
                /* $fragilisation = Fragilisation::where('id',$data['fragilisation_id'])->first();
                if ($fragilisation->total_weight >= $data['weight_after_cook'] && >$data['weight_after_cooling']) {
                    # code...
                } */
                
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                if ($operator_sequence) {
                    $exist = Refroidissement::where('fragilisation_id',$data['fragilisation_id'])->first();
                    if ($exist) {
                        $update = $exist->update([
                            'weight_after_cook'=>$data['weight_after_cook'],
                            'fragilisation_id'=>$data['fragilisation_id'],
                            'weight_after_cooling'=>$data['weight_after_cooling'],
                            'gap'=>$data['gap'],
                            'end_temp'=>$data['end_temp'],
                            'start_temp'=>$data['start_temp'],
                        ]);
                        if ($update) {
                            return redirect()->route('cooling.create',$data['fragilisation_id'])->with('message','Modifier avec succès');
                        }else {
                            return redirect()->route('cooling.create',$data['fragilisation_id'])->with('error','Une erreur s\'est produite');
                        }
                    }else {
                        $cooling = Refroidissement::create([
                            'weight_after_cook'=>$data['weight_after_cook'],
                            'fragilisation_id'=>$data['fragilisation_id'],
                            'weight_after_cooling'=>$data['weight_after_cooling'],
                            'gap'=>$data['gap'],
                            'end_temp'=>$data['end_temp'],
                            'start_temp'=>$data['start_temp'],
                            'sequence_id'=>$operator_sequence->sequence_id,
                            'author_id'=>$user->id,
                        ]);
                        if ($cooling) {
                            return redirect()->route('cooling.create',$data['fragilisation_id'])->with('message','Enregistrer avec succès');
                        }else {
                            return redirect()->route('cooling.create',$data['fragilisation_id'])->with('error','Une erreur s\'est produite');
                        }
                    }
                }

            }else return redirect('login');
        }else return redirect('login');
    }

    public function coolingdetails(Refroidissement $cooling)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_cooling = 1;

                return view('cooling.details',compact('cooling','etape_cooling'));
            }else return redirect('login');
        }else return redirect('login');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Refroidissement  $refroidissement
     * @return \Illuminate\Http\Response
     */
    public function show(Refroidissement $refroidissement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Refroidissement  $refroidissement
     * @return \Illuminate\Http\Response
     */
    public function edit(Refroidissement $refroidissement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Refroidissement  $refroidissement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Refroidissement $refroidissement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Refroidissement  $refroidissement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Refroidissement $refroidissement)
    {
        //
    }

    
    public function stock_cooling_liste()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $session = session::all();
                $section_poste = Section::where('designation','Décorticage')->first();
                if ($section_poste) {
                    $poste = Poste::where('section_id',$section_poste->id)->first();
                    if ($poste) {
                        $assigner = Assigner::where('user_id',$user->id)->where('poste_id',$poste->id)->where('sequence_id',$session['sequence'])->first();
                        if ($assigner) {
                            $stocks = Refroidissement::where('transfert',true)->orderBy('id','DESC')->paginate(20);
                            $etape_shelling = 1;
                            if ($stocks) {
                                return view('shelling.stock', compact('stocks' , 'etape_shelling'));
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
    }

    

}
