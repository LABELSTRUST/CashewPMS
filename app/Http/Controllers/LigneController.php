<?php

namespace App\Http\Controllers;
use App\Http\Controllers\AuthController;
use App\Models\Ligne;

use Illuminate\Http\Request;

class LigneController extends Controller
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
            $lignes = Ligne::get();
            return view('admin.ligne',compact('lignes'));
            
        }else  return redirect('login');
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
            return view('admin.createligne');
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
                'code' => 'required',
                'name' => 'required',
            ]);
            
            $data = $request->all();
            $exist = Ligne::where('code',$data['code'])->first();
            if (isset($exist)) {
                return redirect('admin/ligne/create')->with('error',"Ce code existe déjà");
            }else{
                $ligne = Ligne::create([
                    'code'=>$data['code'],
                    'name'=>$data['name']
                ]);
                if ($ligne) {
                    return redirect('admin/ligne/create')->with('message',"Enregistrer avec succès");
                }else return redirect('admin/ligne/create')->with('error',"Une erreur s'est produite");
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ligne  $ligne
     * @return \Illuminate\Http\Response
     */
    public function show(Ligne $ligne)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ligne  $ligne
     * @return \Illuminate\Http\Response
     */
    public function edit(Ligne $ligne)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ligne  $ligne
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ligne $ligne)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ligne  $ligne
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ligne $ligne)
    {
        //
    }
}
