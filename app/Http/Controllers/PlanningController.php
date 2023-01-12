<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Ligne;
use App\Models\Planning;
use App\Models\Sequence;
use App\Models\Shift;
use Illuminate\Http\Request;
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
        $result = $this->verifyAdmin();
        if($result){
            $plannigs = Planning::orderBy('created_at', 'desc')->get();
            return view('admin.plannigs',compact('plannigs'));
            
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
        $user=$this->verifyAdmin();
        if ($user) {
            $lignes = Ligne::get();
            if ($lignes) {
                $shifts = Shift::get();
                if ($shifts) {
                    $commandes = Commande::get();
                    if ($commandes) {
                        $planning = ""; $sequence_plan = "";
                        return view('admin.createplannig', compact('lignes','shifts','commandes', 'planning','sequence_plan'));
                    }
                }
            }
            
            
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=$this->verifyAdmin();
        if ($user) {
            $request->validate([
                'commande_id' => 'required',
                'shift_id' => 'required',
                'ligne_id' => 'required',
                'quantity'=> 'required',
                'date_start'=> 'required',
                'date_end'=> 'required',
            ]);
            
        //'author_id' date_start
            $data = $request->all();
            $planning = Planning::create([
                'commande_id' => $data['commande_id'], 
                'shift_id' => $data['shift_id'],
                'ligne_id' => $data['ligne_id'],

                //'date_start'=> date_create('now')->format('Y-m-d H:i:s'),
            ]);
            if ($planning) {
                $code =  Str::random(4,'alpha_num');
                $existingCode = Sequence::where('code', $code)->first();
                while ($existingCode) {
                    $code = Str::random(4,'alpha_num');
                    $existingCode = Sequence::where('code', $code)->first();
                }
                $sequence = Sequence::create([
                    'quantity' => $data['quantity'], 
                    'date_start' => $data['date_start'],
                    'date_end' => $data['date_end'],
                    'code'=>$code,
                    'planning_id'=>$planning->id
                    //'date_start'=> date_create('now')->format('Y-m-d H:i:s'),
                ]);
                if ($sequence) {
                    return redirect('admin/planning/create')->with('message',"Enregistré avec succès");
                }else  return redirect('admin/planning/create')->with('error',"Planning non enregistré");
            }else  return redirect('admin/planning/create')->with('error',"Séquence non enregistrée");
        
            //}

        }
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

    /**
     * @param  \App\Models\Planning  $sequence_plan
     * @return \Illuminate\Http\Response
     * 
     */
     public function addsequence(Request $request, Planning  $sequence_plan)
     {
        
        $user=$this->verifyAdmin();
        if ($user) {
            $request->validate([
                'date_start'=> 'required',
                'date_end'=> 'required',
                'quantity'=> 'required',
            ]);
            $data = $request->all();
            
            $code =  Str::random(4,'alpha_num');
            $existingCode = Sequence::where('code', $code)->first();
            while ($existingCode) {
                $code = Str::random(4,'alpha_num');
                $existingCode = Sequence::where('code', $code)->first();
            }
            $sequence = Sequence::create([
                'quantity' => $data['quantity'], 
                'date_start' => $data['date_start'],
                'date_end' => $data['date_end'],
                'code'=>$code,
                'planning_id'=>$sequence_plan->id
                //'date_start'=> date_create('now')->format('Y-m-d H:i:s'),
            ]);
            if ($sequence) {
                    return redirect()->route('planning.sequenceadd', [$sequence_plan->id])->with('message',"Séquence ajoutée");
            }else return redirect()->route('planning.sequenceadd', [$sequence_plan->id])->with('error',"Erreur sur la séquence");
        }
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function edit(Planning $planning)
    {
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
        }
    }

    public function sequenceadd(Request $request, Planning $sequence_plan)
    {
        $user=$this->verifyAdmin();
        if ($user) {
            
            return view('admin.createplannig', compact('sequence_plan'));
        }
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
