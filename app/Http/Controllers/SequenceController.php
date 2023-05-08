<?php

namespace App\Http\Controllers;

use App\Models\Assigner;
use App\Models\Ligne;
use App\Models\Objectif;
use App\Models\OperatorSequence;
use App\Models\Planning;
use App\Models\Sequence;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SequenceController extends Controller
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
        if($result){
            $sequences = Sequence::orderBy('id','DESC')->paginate(10);
            /*$date = "";
            foreach ($sequences as $key => $sequence) {
                $date = Carbon :: createFromFormat ( 'm/d/Y' , $sequence->date_start )-> format ( 'Y-m-d' ); 
            }*/
            return view('admin.sequences',compact('sequences'));
            
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
                $plannings = Planning::get();
                return view('admin.createsequence', compact('plannings'));
            }return redirect('login'); 
    
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
        $user=$this->verifyAdmin();
        if ($user) {
            $request->validate([
                'quantity' => 'required',
                'date_start' => 'required',
                'date_end' => 'required',
                'quantity_do'=> 'required',
            ]);
            $data = $request->all();
            $sequence = Sequence::create([
                'quantity' => $data['quantity'], 
                'date_start' => $data['date_start'],
                'date_end' => $data['date_end'],
                'quantity_do'=> $data['quantity_do'],
                //'date_start'=> date_create('now')->format('Y-m-d H:i:s'),
            ]);
            if ($sequence) {
                return redirect('admin/sequence/create')->with('message',"Enregistré avec succès");
            }else return redirect('admin/sequence/create')->with('error',"Une erreur s'est produite");
        }return redirect('login'); 
    
        }else return redirect('login');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sequence  $sequence
     * @return \Illuminate\Http\Response
     */
    public function show(Sequence $sequence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sequence  $sequence
     * @return \Illuminate\Http\Response
     */
    public function edit(Sequence $sequence)
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                $shifts = Shift::get();
                $lignes = Ligne::get();
                
                return view('planning.editsequence', compact('lignes','shifts','sequence'));
            }else return redirect('login'); 
        }else return redirect('login'); 

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sequence  $sequence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sequence $sequence)
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
               
               if ($sequence->getObjectif->obj_remain_quantity) {
                     
                    $request->validate([
                        'quantity' => 'required',
                        'date_start' => 'required',
                        'shift_id'  =>'required',
                        'ligne_id'=>'required',
                    ]);
                    $data = $request->all();
                   
                    if ($data['quantity'] > $sequence->getObjectif->obj_remain_quantity ) {
                        return redirect()->route('sequence.edit',[$sequence->id])->with('error',"Erreur sur la quantité attendue");
                    }
                    if ($data['quantity'] == $sequence->quantity) {
                        $update = $sequence->update([
                            'date_start' => $data['date_start'],
                            'shift_id'=>$data['shift_id'],
                            'ligne_id'=>$data['ligne_id'],
                            'author_id'=>$user->id
                        ]);
                        if ( $update) {
                            return redirect()->route('sequence.index')->with('message','Modifier avec succès');
                        }
                    }
                    $obj_seq_remain = ($sequence->getObjectif->obj_remain_quantity + $sequence->quantity) - $data['quantity'];

                    if ($obj_seq_remain <= 0) {
                        return redirect()->route('sequence.edit',[$sequence->id])->with('error',"La quantité restante est insuffisante");
                    }
                    
                    $remain_objectif = Objectif::where('id',$sequence->getObjectif->id)
                                ->update(['obj_remain_quantity'=>$obj_seq_remain 
                    ]);
                    $update = $sequence->update([
                        'quantity' => $data['quantity'], 
                        'date_start' => $data['date_start'],
                        'shift_id'=>$data['shift_id'],
                        'ligne_id'=>$data['ligne_id'],
                        'remain_quantity'=> $obj_seq_remain,
                        'author_id'=>$user->id
                    ]);
                    
                    if ($update) {
                        return redirect()->route('sequence.index')->with('message','Modifier avec succès');
                    }
                }else{
                    $request->validate([
                        'date_start' => 'required',
                        'shift_id'  =>'required',
                        'ligne_id'=>'required',
                    ]);
                    $data = $request->all();
                    $allredy_exist = Sequence::where('objectif_id',$sequence->getObjectif->id)
                        ->where('shift_id',$data['shift_id'])
                        ->where('ligne_id',$data['ligne_id'])
                        ->get();
                    if ($allredy_exist) {
                        return redirect()->route('sequence.edit',[$sequence->id])->with('error',"Erreur la séquence existe déjà");
                    }
                    $update = $sequence->update([
                        'date_start' => $data['date_start'],
                        'shift_id'=>$data['shift_id'],
                        'ligne_id'=>$data['ligne_id'],
                        'author_id'=>$user->id
                    ]);
                    if ($update) {
                        return redirect()->route('sequence.index')->with('message','Modifier avec succès');
                    }
                }
            }else return redirect('login'); 
        }else return redirect('login'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sequence  $sequence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sequence $sequence)
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                
                $result = $sequence->delete();
        
                return redirect()->route('sequence.index')->with('message','Supprimer avec succès');
            }else return redirect('login');
        }else return redirect('login');
    }

    
    public function verifyOperator()
    {
        $magasinier = app(AuthController::class);
        $result = $magasinier->operatorCheck();
        return  $result;
    }
    /* 
    $startOfWeek = Carbon::now()->startOfWeek();
    $endOfWeek = Carbon::now()->endOfWeek();
    $assigner = Assigner::where('shift_id',$sequence->shift_id)
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek]) */

    public function operateurSequence()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $twoWeeksAgo = Carbon::today();
                $sequences = Assigner::where('user_id', $user->id)
                                ->whereDate('created_at', $twoWeeksAgo)
                                ->orderBy('id','DESC')
                                ->first();
               //dd($twoWeeksAgo);->isNotEmpty()dd($sequences);
               
                if ($sequences) {
                    return view('operateur.sequences', compact('sequences','user'));
                }else {
                    return view('operateur.sequences', compact('sequences','user'));
                }
            }else return redirect('login');
        }else return redirect('login');
    }

    public function OperateurConnecter(Sequence $sequence)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $operator = OperatorSequence::whereDate('created_at',Carbon::today())
                            ->where('user_id',$user->id )
                            ->where('sequence_id',$sequence->id )
                            ->orderBy('id','DESC')->first();
                if ($operator) {
                    $response  = session::put('sequence' , $sequence->id);
                   
                    return redirect('dashboard');
                }else {
                    $operateur = OperatorSequence::create([
                        'sequence_id'=>$sequence->id,
                        'user_id'=>$user->id
                    ]);
                    $response  = session::put('sequence' , $sequence->id);
                    if ($operateur) {
                        return redirect('dashboard');
                    }else return redirect()->route('sequence.operateurSequence');
                    
                }

            }else return redirect('login');
        }else return redirect('login');
    }
}
