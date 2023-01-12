<?php

namespace App\Http\Controllers;

use App\Models\Assigner;
use App\Models\User;
use App\Models\Ligne;
use App\Models\Poste;
use App\Models\Shift;
use Illuminate\Http\Request;
use PhpParser\NodeVisitor\FirstFindingVisitor;

class AssignerController extends Controller
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
            $assigners = Assigner::get();
            return view('admin.assigner',compact('assigners'));
            
        }else return redirect('login');
    }

    /**
     * Show the form for creating a new resource.
     *@param App\Models\User $operator
     * @return \Illuminate\Http\Response
     */
    public function create($the_operator = null)
    {
        $user=$this->verifyAdmin();
        if ($user) {

            $operators = User::query()
            ->whereNotNull('author_id')
            ->get();
            if ($operators) {
                $lignes = Ligne::get();
                if ($lignes) {
                    $postes = Poste::get();
                    if ($postes) {
                        $shifts = Shift::get();
                        return view('admin.createassigner', compact('operators','lignes','postes','shifts','the_operator'));
                    }
                }
            }
        }
    }

    
    public function verifyAdmin()
    {
        $admin = app(AuthController::class);
        $result = $admin->adminCheck();
        return  $result;
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, )
    {
        $user=$this->verifyAdmin();
        if ($user) {
            $request->validate([
                'poste_id' => 'required',
                'ligne_id' => 'required',
                'user_id' => 'required',
                'date_end'=> 'required',
                'shift_id'=> 'required',
            ]);
            
        //'author_id' date_start
            $data = $request->all();
           

            /*$exist = Assigner::where('user_id',$data['user_id'])->
                        where('ligne_id',$data['ligne_id'])->
                        where('poste_id',$data['poste_id'])->first();
            if ($exist) {
                return redirect('admin/assiger/create')->with('error',"Ce poste est assigner existe déjà");
            }else {*/
                $assigner = Assigner::create([
                    'poste_id' => $data['poste_id'], 
                    'ligne_id' => $data['ligne_id'],
                    'user_id' => $data['user_id'],
                    'date_end'=> $data['date_end'],
                    'shift_id'=> $data['shift_id'],
                    'author_id'=> $user->id,
                    'date_start'=> date_create('now')->format('Y-m-d H:i:s'),
                ]);
                if ($assigner) {
                    $update_statuts = User::find($data['user_id']);
                    if ($update_statuts) {
                        $update_statuts->update([
                            'affected' => True,
                        ]);
                        if ($update_statuts) {
                            return redirect('admin/assiger/create')->with('message',"Enregistré avec succès");
                        }else  return redirect('admin/assiger/create')->with('error',"Une erreur s'est produite");
                    }
                }
            //}

        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assigner  $assigner
     * @return \Illuminate\Http\Response
     */
    public function show(Assigner $assigner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assigner  $assigner
     * @return \Illuminate\Http\Response
     */
    public function edit(Assigner $assigner)
    {
        $user=$this->verifyAdmin();
        if ($user) {
            $lignes = Ligne::get();
            if ($lignes) {
                $shifts = Shift::get();
                if ($shifts) {
                    $postes = Poste::get();
                    if ($postes) {
                         $sequence_plan = "";
                        return view('admin.createplannig', compact('lignes','shifts','postes','assigner'));
                    }
                }
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assigner  $assigner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assigner $assigner)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assigner  $assigner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assigner $assigner)
    {
        //
    }
}
