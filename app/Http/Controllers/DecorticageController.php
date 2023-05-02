<?php

namespace App\Http\Controllers;

use App\Models\Assigner;
use App\Models\Current_rapportDecorticage;
use App\Models\Decorticage;
use App\Models\OperatorSequence;
use App\Models\Poste;
use App\Models\RapportDecorticage;
use App\Models\Refroidissement;
use App\Models\Section;
use App\Models\Sequence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DecorticageController extends Controller
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
                $etape_shelling = 1;
                $shellings = Decorticage::where('transfert',0)->orderBy('id','DESC')->paginate(20); 
                return view('shelling.index', compact('etape_shelling', 'shellings'));

            }else return redirect('login');
            
        }else return redirect('login');
    }
    
    public function listBycaliber($cooling)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_shelling = 1;
                $shellings = Decorticage::where('cooling_id',$cooling)->orderBy('id','DESC')->paginate(20); 

                return view('shelling.index', compact('shellings','etape_shelling'));

            }else return redirect('login');
        }else return redirect('login');
    }

    
    public function shellingdetails(Decorticage $shelling)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_shelling = 1;

                return view('shelling.details',compact('shelling','etape_shelling'));
            }else return redirect('login');
        }else return redirect('login');
    }
    

    public function verifyOperator()
    {
        $magasinier = app(AuthController::class);
        $result = $magasinier->operatorCheck();
        return  $result;
    }

    public function process(Refroidissement $cooling)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_shelling = 1;

                return view('shelling.processus', compact('cooling','etape_shelling'));

            }else return redirect('login');
            
        }else return redirect('login');
    }


    public function createProcess(Request $request)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_shelling = 1;
                
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                if ($operator_sequence) {
                    $request->validate([
                        'bag_Number'=>'sometimes|nullable',
                        'cooling_id'=>'sometimes|nullable',
                        'sub_batch_caliber'=>'sometimes|nullable',
                        'weight'=>'sometimes|nullable',
                        'tool'=>'sometimes|nullable',
                        'capacity'=>'sometimes|nullable',
                    ]);
                    $data = $request->all();
                    $cooling = Refroidissement::where('id', $data['cooling_id'])->first();
                    
    
                    $exist = Decorticage::where('cooling_id',$data['cooling_id'])->first();
                    
                    if ($exist) {
                        $lot = $cooling->getFrag?->getCalibrage?->id_lot_calibre.'-'. $data['sub_batch_caliber'];
                        if ($exist->sub_batch_caliber == $lot ) {
                            if ($data['weight']) {
                                $update = $exist->update([
                                    'weight'=>$data['weight']
                                ]);
                                if ($update) {
                                    return response()->json([
                                        'message'=>'Modifié avec succès'
                                    ],200);
                                }
                            }
                        }else {
                            
                            $exist2 = Decorticage::where('cooling_id',$data['cooling_id'])->orderBy('id','DESC')->first();
                            if ($exist2->sub_batch_caliber == $lot) {
                                if ($data['weight']) {
                                    $update = $exist2->update([
                                        'weight'=>$data['weight']
                                    ]);
                                    if ($update) {
                                        return response()->json([
                                            'message'=>'Modifié avec succès'
                                        ],200);
                                    }
                                }
                            }
                            if ($exist->tool != $data['tool']) {
                                return response()->json([
                                    'message'=>'Erreur'
                                ],401);
                            }
                                $shelling = Decorticage::create([
                                    'bag_Number'=>$exist->bag_Number,
                                    'cooling_id'=>$exist->cooling_id,
                                    'sub_batch_caliber'=>$cooling->getFrag?->getCalibrage?->id_lot_calibre.'-'. $data['sub_batch_caliber'],
                                    'weight'=>$data['weight'],
                                    'tool'=>$exist->tool,
                                    'capacity'=>$exist->capacity,
                                    'sequence_id'=>$operator_sequence->sequence_id,
                                    'author_id'=>$user->id
                                ]);
                                if ($shelling) {
                                    $all = Decorticage::where('cooling_id', $exist->cooling_id)->get();
                                    if ($all->count() > 1) {
                                        $total_weight = 0;
                                        $kor_after = 0;
                                        foreach ($all as $key => $value) {
                                            $total_weight = $value['weight'] + $total_weight;
                                        }
                                        $kor_after = ($total_weight * 2.2046) / $exist->bag_Number;
                                        $after_update = Decorticage::where('cooling_id',$exist->cooling_id)->first();
                                        if ($after_update) {
                                            $gap = $after_update->kor_after - $cooling->getFrag?->getCalibrage?->kor;
                                            
                                            foreach ($all as $key => $value) {
                                                $value->gap = $gap;
                                                $value->kor_after = $kor_after;
                                                $value->total_weight = $total_weight;
                                                $value->save();
                                            }
                                            return response()->json([
                                                'message'=>"Enregistré avec succès"
                                            ],200);
                                        }
                                    }
                                }
                        }
                    }else {
                        /* $exist = Decorticage::where('cooling_id',$data['cooling_id'])->first();
                        if ($exist) {

                            if ($exist->sub_batch_caliber != $cooling->getFrag?->getCalibrage?->id_lot_calibre.'-'. $data['sub_batch_caliber']) {
                            }
                        } */
                        $shelling = Decorticage::create([
                            'bag_Number'=>$data['bag_Number'],
                            'cooling_id'=>$data['cooling_id'],
                            'sub_batch_caliber'=>$cooling->getFrag?->getCalibrage?->id_lot_calibre.'-'. $data['sub_batch_caliber'],
                            'weight'=>$data['weight'],
                            'tool'=>$data['tool'],
                            'capacity'=>$data['capacity'],
                            'sequence_id'=>$operator_sequence->sequence_id,
                            'author_id'=>$user->id
                        ]);
                        if ($shelling) {
                            return response()->json([
                                'message'=>"Enregistré avec succès"
                            ],200);
                        }
                    }
    
                }else return redirect('login');
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

                $stock = Decorticage::where('sequence_id',$data['sequence_id'])->first();
                if (!$stock) {

                    return redirect()->route('cooling.rapport')->with('error','Rapport vide');
                }
                
                $exist = RapportDecorticage::where('sequence_id',$data['sequence_id'])
                            ->where('shelling_id',$stock->id)
                            ->where('author_id',$user->id)
                            ->first();
                if ($exist) {
                    
                    foreach($data as $column => $value) {

                        $exist->update([$column => $value]);
                        
                    }
                    $currents = Current_rapportDecorticage::where('sequence_id',$operator_sequence->sequence_id)->where('author_id',$user->id)->get();
                    
                    if ($currents) {
                        foreach($currents as $current) {
                            $current->update(['rapport_id' => $exist->id]);
                        }
                        return redirect()->route('shelling.rapport')->with('message','Rapport enregistré');
                    }else return redirect()->route('shelling.rapport')->with('error','Rapport non  enregistré');
                }

                $rapport = RapportDecorticage::create([
                    'sequence_id'=>$data['sequence_id'],
                    'shelling_id'=>$stock->callibre_stock_id,
                    'observation'=>$data['observation'],
                    'name'=>$data['name'],
                    'workforce'=>$data['workforce'],
                    'author_id'=>$user->id,
                ]);
                if ($rapport) {
                    $currents = Current_rapportDecorticage::where('sequence_id',$operator_sequence->sequence_id)->where('author_id',$user->id)->get();
                    if ($currents) {
                        foreach($currents as $current) {
                            $current->update(['rapport_id' => $rapport->id]);
                        }
                        return redirect()->route('fragilisation.rapport')->with('message','Rapport enregistré');
                    }else return redirect()->route('fragilisation.rapport')->with('error','Rapport non enregistré');

                }else return redirect()->route('fragilisation.rapport')->with('error','Une erreur s\'est produite');

            }else return redirect('login');
        }else return redirect('login');
    }

    public function shellingRapport()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_shelling = 1;
                $session = session::all();
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                if ($operator_sequence) {
                    $sequence = Sequence::where('id',$operator_sequence->sequence_id)->first();
                    if ($sequence) {
                        $sequence_deb = Sequence::where('objectif_id',$sequence->objectif_id)->first();
                        $shellings = Decorticage::where('transfert',true)->where('sequence_id',$sequence->id)->orderBy('id','DESC')->paginate(20);
                        $quantity = 0;
                        foreach ($shellings as $key => $value) {
                            $quantity = $value['weigth'] + $quantity;
                        }
                        return view('shelling.rapport',compact('sequence_deb','sequence','quantity','shellings','etape_shelling','user'));
                    }
                }else {
                    return redirect()->route('dashboard');
                }

            }else return redirect('login');
        }else return redirect('login');
    }

    
    
    public function shellingTransfert(Decorticage $shelling)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                $transfert= $shelling->update([
                    'transfert'=>true,
                ]);
                //dd($fragilisation);
                if ($transfert) {
                        
                    $current_rapport = Current_rapportDecorticage::create([
                        "sequence_id"=>$operator_sequence->sequence_id,
                        "author_id"=>$user->id,
                        "shelling_id"=>$shelling->id
                    ]);
                    if ($current_rapport) {
                        return redirect()->route('shelling.index')->with('message',"Stock transférer");
                    }else return redirect()->route('shelling.index')->with('error',"Stock non transférer");
                }else return redirect()->route('shelling.index')->with('error',"Stock non transférer");
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
                $etape_shelling = 1;
                
                $operator_sequence = OperatorSequence::where('user_id',$user->id)
                                    ->whereDate('created_at',Carbon::today())
                                    ->orderBy('id','DESC')->first();
                if ($operator_sequence) {
                    $request->validate([
                        'bag_Number'=>'sometimes|nullable',
                        'cooling_id'=>'sometimes|nullable',
                        'tool'=>'sometimes|nullable',
                        'capacity'=>'sometimes|nullable',
                        'amande_entiere'=>'sometimes|nullable',
                        'amande_brise'=>'sometimes|nullable',
                    ]);
                    $data = $request->all();
                    
                    $cooling = Refroidissement::where('id', $data['cooling_id'])->first();

                    if ($cooling) {

                        
                        $exist = Decorticage::where('cooling_id',$data['cooling_id'])->first();
                        if ($exist) {
                            $lot = $cooling->getFrag?->getCalibrage?->id_lot_calibre.'-'. 'AE';
                            $lot2 = $cooling->getFrag?->getCalibrage?->id_lot_calibre.'-'. 'AB';
                            if ($exist->sub_batch_caliber == $lot ) {
                                if ($data['amande_entiere']) {
                                    $update = $exist->update([
                                        'weight'=>$data['amande_entiere']
                                    ]);
                                    if ($update) {
                                        return redirect()->route('shelling.process',$cooling->id)->with('message','Enregistré avec succès');
                                    }else return redirect()->route('shelling.process',$cooling->id)->with('error','erreur');
                                }else return redirect()->route('shelling.process',$cooling->id)->with('error','erreur 1');
                            }else if ($lot2 == $exist->sub_batch_caliber) {
                                if ($data['amande_brise']) {
                                    $update = $exist->update([
                                        'weight'=>$data['amande_brise']
                                    ]);
                                    if ($update) {
                                        return redirect()->route('shelling.process',$cooling->id)->with('message','Enregistré avec succès');
                                    }else return redirect()->route('shelling.process',$cooling->id)->with('error','erreur 2');
                                }
                            }
                        }else{
                            $exist2 = Decorticage::where('cooling_id',$data['cooling_id'])->orderBy('id','DESC')->first();
                            if ($exist2) {
                                $lot = $cooling->getFrag?->getCalibrage?->id_lot_calibre.'-'. 'AE';
                                $lot2 = $cooling->getFrag?->getCalibrage?->id_lot_calibre.'-'. 'AB';
                                if ($exist2->sub_batch_caliber == $lot ) {
                                    if ($data['amande_entiere']) {
                                        $update = $exist2->update([
                                            'weight'=>$data['amande_entiere']
                                        ]);
                                        if ($update) {
                                            return redirect()->route('shelling.process',$cooling->id)->with('message','Enregistré avec succès');
                                        }else return redirect()->route('shelling.process',$cooling->id)->with('error','erreur 3');
                                    }else return redirect()->route('shelling.process',$cooling->id)->with('error','erreur existe 4');
                                }else if ($lot2 == $exist2->sub_batch_caliber) {
                                    if ($data['amande_brise']) {
                                        $update = $exist2->update([
                                            'weight'=>$data['amande_brise']
                                        ]);
                                        if ($update) {
                                            return redirect()->route('shelling.process',$cooling->id)->with('message','Enregistré avec succès');
                                        }else return redirect()->route('shelling.process',$cooling->id)->with('error','erreur 5');
                                    }
                                }

                            }else {
                                
                                $shelling = Decorticage::create([
                                    'bag_Number'=>$data['bag_Number'],
                                    'cooling_id'=>$data['cooling_id'],
                                    'sub_batch_caliber'=>$cooling->getFrag?->getCalibrage?->id_lot_calibre.'-'. 'AE',
                                    'weight'=>$data['amande_entiere'],
                                    'tool'=>$data['tool'],
                                    'capacity'=>$data['capacity'],
                                    'sequence_id'=>$operator_sequence->sequence_id,
                                    'author_id'=>$user->id
        
                                    ]);
        
                                    if ($shelling) {
                                        $shelling2 = Decorticage::create([
                                            'bag_Number'=>$data['bag_Number'],
                                            'cooling_id'=>$data['cooling_id'],
                                            'sub_batch_caliber'=>$cooling->getFrag?->getCalibrage?->id_lot_calibre.'-'. 'AB',
                                            'weight'=>$data['amande_brise'],
                                            'tool'=>$data['tool'],
                                            'capacity'=>$data['capacity'],
                                            'sequence_id'=>$operator_sequence->sequence_id,
                                            'author_id'=>$user->id
                                        ]);
                                        if ($shelling2) {
                                            
                                            $all = Decorticage::where('cooling_id', $data['cooling_id'])->get();
                                            if ($all->count() > 1) {
                                                $total_weight = 0;
                                                $kor_after = 0;
                                                foreach ($all as $key => $value) {
                                                    $total_weight = floatval($value['weight']) + $total_weight;
                                                }
                                                $kor_after = ($total_weight * 2.2046) / floatval($shelling2->bag_Number);
                                                $after_update = Decorticage::where('cooling_id',$data['cooling_id'])->first();
                                                if ($after_update) {
                                                    $gap = floatval($kor_after) - floatval($cooling->getFrag?->getCalibrage?->kor);
                                                    
                                                    foreach ($all as $key => $value) {
                                                        $value->gap = round($gap, 2);
                                                        $value->kor_after = round($kor_after, 2); 
                                                        $value->total_weight = $total_weight;
                                                        $value->save();
                                                    }
                                                    return redirect()->route('shelling.process',$cooling->id)->with('message','Enregistré avec succès');
                                                }
                                            }
                                        }
                                }else return redirect()->route('shelling.process',$cooling->id)->with('error','Une erreur est survenue');
                            
                            }
                        }
                    }
                }else return redirect('login');
            }else return redirect('login');
        }else return redirect('login');
            
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Decorticage  $decorticage
     * @return \Illuminate\Http\Response
     */
    public function show(Decorticage $decorticage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Decorticage  $decorticage
     * @return \Illuminate\Http\Response
     */
    public function edit(Decorticage $decorticage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Decorticage  $decorticage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Decorticage $decorticage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Decorticage  $decorticage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Decorticage $decorticage)
    {
        //
    }

    
    public function stock_drying_liste()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $session = session::all();
                $section_poste = Section::where('designation','Séchage')->first();
                if ($section_poste) {
                    $poste = Poste::where('section_id',$section_poste->id)->first();
                    if ($poste) {
                        $assigner = Assigner::where('user_id',$user->id)->where('poste_id',$poste->id)->where('sequence_id',$session['sequence'])->first();
                        if ($assigner) {
                            $stocks = Decorticage::where('transfert',true)->orderBy('id','DESC')->paginate(20);
                            $etape_drying = 1;
                            if ($stocks) {
                                
                                return view('drying.stock', compact('stocks' , 'etape_drying'));
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
