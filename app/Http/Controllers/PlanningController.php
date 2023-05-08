<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Ligne;
use App\Models\Objectif;
use App\Models\Planning;
use App\Models\Sequence;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PlanningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( Auth::check()){
            $result = $this->verifyAdmin();
            if($result){/*
                $plannings = Planning::orderBy('created_at', 'desc')->get();
                $ligne_id = Planning::orderBy('created_at', 'desc')->pluck('ligne_id');
                $shift_id = Planning::orderBy('created_at', 'desc')->pluck('shift_id');
                $lignes = Ligne::whereIn('id',$ligne_id)->get();
                $sequences = Sequence::get();
                $shifts = Shift::whereIn('id',$shift_id)->get();
                return view('admin.plannigs',compact('plannings','sequences','lignes','shifts'));*/
                
                /*$objectifs = DB::table('objectifs')
                            ->leftJoin('sequences', 'objectifs.id', '=', 'sequences.objectif_id')
                            ->leftJoin('produits', 'objectifs.produit_id', '=', 'produits.id')
                            ->select('objectifs.*','objectifs.id As ob_id', 'sequences.id AS sequence_id','sequences.objectif_id','produits.*')
                            ->distinct()
                            ->get();*/
                            //dd($objectifs);
                $objectifs = Objectif::orderBy('id','DESC')->paginate(12);
                $objs = Objectif::all()->pluck('id');
                $sequences = Sequence::whereIn('objectif_id',$objs)->get();
                // $sequences = Sequence::whereIn('objectif_id',$objs)->orderBy('id','DESC')->get();

                return view('admin.plannigs',['objectifs' => $objectifs, 'sequences'=>$sequences]);
                // if ($objectifs) {
                //     $formatted_objectifs = $objectifs->map(function ($objectif) {
                //         $objectif->obj_date_start = Carbon::createFromFormat('Y-m-d', $objectif->obj_date_start);
                //         $objectif->obj_date_end = Carbon::createFromFormat('Y-m-d', $objectif->obj_date_end);
                //         $objectif->formatted_date = $objectif->obj_date_start->format('M-d') . " - " . $objectif->obj_date_end->format('M-d') . ", " .  $objectif->obj_date_end->year;
                //         return $objectif;
                //     });
                //     //dd($formatted_objectifs);
                //     $objs = Objectif::all()->pluck('id');
                //     $sequences = Sequence::whereIn('objectif_id',$objs)->get();
                //     // $sequences = Sequence::whereIn('objectif_id',$objs)->orderBy('id','DESC')->get();

                //     return view('admin.plannigs',['objectifs' => $formatted_objectifs, 'sequences'=>$sequences]);
                // }
                
            }else return redirect('login');
    
        }else return redirect('login');
    }


    public function verifyAdmin()
    {
        $admin = app(AuthController::class);
        $result = $admin->adminCheck();
        return  $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                $lignes = Ligne::get();
                if ($lignes) {
                    $shifts = Shift::get();
                    if ($shifts) {
                        $objectifs = Objectif::orderBy('id','desc')->get();

                        if ($objectifs) {
                            $planning = ""; $sequence_plan = "";
                            return view('admin.createplannig', compact('lignes','shifts','objectifs', 'planning','sequence_plan'));
                        }
                    }
                }
                
                
            }else return redirect('login'); 
    
        }else return redirect('login');
    }

    public function plannifier(Objectif $objectif)
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                $lignes = Ligne::get();
                $shifts = Shift::get();
                return  view('planning.create', compact('lignes','shifts','objectif'));
            }else return redirect('login');
        }else return redirect('login');
    }

    public function getcommande($commande_id)
    {
        
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {

                $response = Objectif::where('id',$commande_id)->first();
                return response()->json($response);

            }else return redirect('login');
        }else return redirect('login');
        
    }

    public function generateCode($column = null)
	{
        if ($column != null) {
            $length = $column;
        }else $length = 4;
		
		// Initialisation des caractères utilisables
		$characters = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
		$key_password = array_rand($characters, $length);

		for ($i = 0; $i < $length; $i++) {
			$password_tab[] = $characters[$key_password[$i]];
		}

		$generated_code = implode("", $password_tab);

        
        $existingCode = Sequence::where('code', $generated_code)->first();
        while ($existingCode) {
            $generated_code = $this->generateCode($length);
            $existingCode = Sequence::where('code', $generated_code)->first();
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
            $user=$this->verifyAdmin();
            if ($user) {
                //dd($request);
                
                $validator = Validator::make($request->all(), [
                    'objectif_id' => 'required',
                    'shift_id' => 'required',
                    'ligne_id' => 'required',
                    //'quantity'=> 'required',
                    'date_start'=> 'required',
                    'quantity_commander'=> 'required',
                ]);
                $data = $request->all();
                
                if ($validator->fails()) {
                    return redirect()->route('plannifier',[$data['objectif_id']])->withErrors($validator)->withInput();
                }
                
                //'author_id' date_start dd();


                
                /*if ($data['date_end'] > $data['date_livraison']) {
                    return redirect('admin/planning/create')->with('error',"Erreur sur la date de fin de production");
                }*/
                
               /*  if ($data['quantity'] > $data['quantity_commander']) { 01/03/2023
                    return redirect()->route('plannifier',[$data['objectif_id']])->with('error',"Erreur sur la quantité attendue");
                }
                 */
                //$code = $this->generateCode();

               /* $list_planning = Planning::where('ligne_id',$data['ligne_id'])
                                    ->where('commande_id',$data['commande_id'])
                                    ->pluck('id');
                $existe_sequence = Sequence::whereIn('planning_id',$list_planning)
                                    ->where('shift_id',$data['shift_id'])
                                    ->first();
                if ($existe_sequence) {
                    return redirect()->route('plannifier',[$data['objectif_id']])->with('error',"Erreur Cette séquence existe déjà");
                }*/
                
                
                /*$date_start = Carbon::createFromFormat('Y-m-d H:i:s', $data['date_start']);
                dd($date_start);dd($data['date_start']);*/
                
                $allredy_exist = Sequence::where('objectif_id',$data['objectif_id'])
                                ->where('shift_id',$data['shift_id'])
                                ->where('ligne_id',$data['ligne_id'])
                                ->where('date_start',$data['date_start'])
                                ->get();
                if ($allredy_exist->isNotEmpty()) {
                    return redirect()->route('plannifier',[$data['objectif_id']])->with('error',"Erreur la séquence existe déjà");
                }
                
                
                $sequence_obj = Sequence::where('objectif_id',$data['objectif_id'])
                                                ->orderBy('id', 'desc')
                                                ->first();
               
                if ($sequence_obj) {
                    $commande_exist = Objectif::where('id',$data['objectif_id'])->first();
                    
                    /*$totalQty = 0;
                    foreach ($sequence_obj as $sequence) {
                        $totalQty += $sequence->remain_quantity;
                    }*/
                    $remain_quantity = $commande_exist->obj_remain_quantity ;
                    
                    if ($remain_quantity == 0 || $remain_quantity < 0 ) {
                        return redirect()->route('plannifier',[$data['objectif_id']])->with('error',"Cette commande est déjà répartie");
                    }
                    /* elseif ( $remain_quantity < $data['quantity']) 01/03/2023
                        return redirect()->route('plannifier',[$data['objectif_id']])->with('error',"La quantité restante à produire est : ".$remain_quantity);
                    } */else {
                        /*$planning = Planning::create([
                            'commande_id' => $data['commande_id'], 
                            'shift_id' => $data['shift_id'],
                            'ligne_id' => $data['ligne_id'],
                            //'date_start'=> date_create('now')->format('Y-m-d H:i:s'),
                        ]);
                        if ($planning) {*/
                            $existe_code = Sequence ::where('objectif_id',$data['objectif_id'])->get();
                            $code = 0;
                            if ($existe_code->isEmpty()) {
                                $code = 1;
                            }else {
                                foreach ($existe_code as $codes) {
                                    $code = $codes->code + 1;
                                }
                            }
                            $remain_objectif = Objectif::where('id',$data['objectif_id'])
                                                ->update(['obj_remain_quantity'=>$remain_quantity //- $data['quantity'] 01/03/2023
                                                ]);
                            
                            $sequence = Sequence::create([
                                //'quantity' => $data['quantity'], 01/03/2023
                                'date_start' => $data['date_start'],
                                'code'=>$code,
                                'shift_id'=>$data['shift_id'],
                                'ligne_id'=>$data['ligne_id'],
                                'objectif_id'=>$data['objectif_id'],
                                'remain_quantity'=>$remain_quantity //- $data['quantity']01/03/2023
                                //'date_start'=> date_create('now')->format('Y-m-d H:i:s'),
                            ]);
                            if ($sequence) {
                            return redirect()->route('plannifier',[$data['objectif_id']])->with('message',"Enregistré avec succès");
            
                            }else  return redirect()->route('plannifier',[$data['objectif_id']])->with('error',"Séquence non enregistrée");
            
                        //}else  return redirect()->route('plannifier',[$data['objectif_id']])->with('error',"Planning non enregistré");
                    }
                }else {
                    $existe_code = Sequence ::where('objectif_id',$data['objectif_id'])->get();
                            $code = 0;
                            if ($existe_code->isEmpty()) {
                                $code = 1;
                            }else {
                                foreach ($existe_code as $codes) {
                                    $code = $codes->code + 1;
                                }
                            }
                            $commande_exist = Objectif::where('id',$data['objectif_id'])->first();
                            
                            $remain_objectif = Objectif::where('id',$data['objectif_id'])
                                                ->update(['obj_remain_quantity'=>$commande_exist->qte_totale //- $data['quantity']01/03/2023
                                                ]);
                            $sequence = Sequence::create([
                                //'quantity' => $data['quantity'], 01/03/2023
                                'date_start' => $data['date_start'],
                                'code'=>$code,
                                'shift_id'=>$data['shift_id'],
                                'ligne_id'=>$data['ligne_id'],
                                'objectif_id'=>$data['objectif_id'],
                                'remain_quantity'=>$commande_exist->qte_totale //- $data['quantity']

                                //'date_start'=> date_create('now')->format('Y-m-d H:i:s'),
                            ]);
                            if ($sequence) {
                            return redirect()->route('plannifier',[$data['objectif_id']])->with('message',"Enregistré avec succès");
            
                            }else  return redirect()->route('plannifier',[$data['objectif_id']])->with('error',"Séquence non enregistrée");
            
                }



            }else return redirect('login'); 
    
        }else return redirect('login');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function show(Planning $planning)
    {
        //
    }


     public function addsequence(Request $request)
     {
        if( Auth::check()){
        $user=$this->verifyAdmin();
        if ($user) {
            $request->validate([
                'date_start'=> 'required',
                'date_end'=> 'required',
                'quantity'=> 'required',
                'shift_id' => 'required',
                'date_liv'=>'required',
                'quantity_remain' =>'required',
                'planning'=>'required'
            ]);
            
            //dd($request);

            $data = $request->all();
            $sequence_plan = Planning::where('id',$data['planning'])->first();
            
            $existe_sequence = Sequence::where('planning_id',$sequence_plan->id)
                                ->where('shift_id',$data['shift_id'])
                                ->first();
                                
            if ($existe_sequence) {
                return redirect()->route('planning.sequenceadd', [$sequence_plan->id])->with('error',"Erreur Cette séquence existe déjà");
            }
            
            if ($data['date_end'] > $data['date_liv']) {
                return redirect('admin/planning/create')->with('error',"Erreur sur la date de fin de production");
            }

            if ($data['quantity'] > $data['quantity_remain']) {
                return redirect('admin/planning/create')->with('error',"La quantité restante à produire est inférieure à celle attendue");
            }


            $code = $this->generateCode();

            $sequence = Sequence::create([
                'quantity' => $data['quantity'], 
                'date_start' => $data['date_start'],
                'date_end' => $data['date_end'],
                'code'=>$code,
                'planning_id'=>$sequence_plan->id,
                'shift_id'=>$data['shift_id'],
                //'date_start'=> date_create('now')->format('Y-m-d H:i:s'),
            ]);
            if ($sequence) {
                    return redirect()->route('planning.sequenceadd', [$sequence_plan->id])->with('message',"Séquence ajoutée");
            }else return redirect()->route('planning.sequenceadd', [$sequence_plan->id])->with('error',"Erreur sur la séquence");
        }return redirect('login'); 
    
        }else return redirect('login');
        
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function edit(Planning $planning)
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                $lignes = Ligne::get();
                if ($lignes) {
                    $shifts = Shift::get();
                    if ($shifts) {
                        $commandes = Commande::get();
                        if ($commandes) {
                            $sequence_plan = "";
                            return view('admin.createplannig', compact('lignes','shifts','commandes', 'planning','sequence_plan'));
                        }
                    }
                }
            }return redirect('login');
    
        }else return redirect('login'); 
    }

    public function sequenceadd(Request $request, Planning $sequence_plan)
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {

            $last_sequence = Sequence::where('planning_id',$sequence_plan->id)->get();
            $totalQty = 0;
            foreach ($last_sequence as $commande) {
                $totalQty += $commande->quantity;
            }

            $remain_quantity =  $sequence_plan->getCommande->quantity - $totalQty;
            $shifts = Shift::get();
                
                return view('admin.sequenceadd', compact('sequence_plan','remain_quantity','shifts'));
            }return redirect('login'); 
    
        }else return redirect('login');
    }

    public function showSequence($planning){
        
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                $sequences = Sequence::where('planning_id',$planning)->get();
                if ($sequences) {
                    
                    return view('admin.showsequences', compact('sequences'));
                }
            }return redirect('login'); 

        }else return redirect('login');
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Planning $planning)
    {
        if( Auth::check()){
            $user = $this->verifyAdmin();
            if ($user) {
                $validatedData = $request->validate([
                    'commande_id' => 'required',
                    'shift_id' => 'required',
                    'ligne_id' => 'required',
                
                ]);/*$update = $sejour->update([
                    "heure_depart_effectif"=>$date1,
                    "montant_sejour"=>$montant*/
                $planning->update($validatedData);
                if ($planning) {
                    return redirect()->route('planning.edit', [$planning->id])->with('message',"Modifier avec succès");
                }
                
            }return redirect('login'); 
    
        }else return redirect('login');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function destroy(Planning $planning)
    {
        //
    }
}
