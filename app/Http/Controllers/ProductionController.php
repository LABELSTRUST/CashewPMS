<?php

namespace App\Http\Controllers;

use App\Models\Production;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class ProductionController extends Controller
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
            $shifts = Production::get();
            return view('admin.shift',compact('shifts'));
            
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
     *@param Produit $produit
     * @return \Illuminate\Http\Response
     */
    public function create($produit = null )
    {
        $user=$this->verifyAdmin();
        if ($user) {
            return view('admin.createproduction');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *  @param User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user )
    {
        $user=$this->verifyAdmin();
        if ($user) {
            $request->validate([
                'cycle' => 'required',
                'ligne_id' => 'required',
                'shift_id' => 'required',
                'produit_id' => 'required',
                
            ]);
            
        //'author_id' date_start
            $data = $request->all();
            $exist = Production::where('user_id',$user)->
                                where('ligne_id',$data['ligne_id'])->
                                where('shift_id',$data['shift_id'])->
                                where('produit_id',$data['produit_id'])->first();
            if ($exist) {
                return redirect()->route('admin.edit', [$exist->id])->with('error',"Ce Shift existe déjà");
            }else {
                $production = Production::create([
                    'cycle' => $data['cycle'], 
                    'user_id' => $user,
                    'ligne_id' => $data['ligne_id'],
                    'shift_id' => $data['shift_id'],
                    'produit_id' => $data['produit_id'],
                ]);
                if ($production) {
                    return redirect()->route('admin.edit', [$production->id])->with('message',"Enregistré avec succès");
                }
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function show(Production $production)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function edit(Production $production)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Production $production)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function destroy(Production $production)
    {
        //
    }
}
