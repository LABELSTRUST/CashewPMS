<?php

namespace App\Http\Controllers;

use App\Models\InventConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventConfigController extends Controller
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
                $configs = InventConfig::get();
                if ($configs ) {
                    return view('auth.dashboard',compact('configs'));
                }else return redirect('login');
            }else return redirect('login');
        }
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
            $result = $this->verifyAdmin();
            if($result){
                return view('inventconf.create');
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
            $result = $this->verifyAdmin();
            if($result){
                
                $request->validate([
                    'code_config' => 'required',
                    'name' => 'required',
                ]);
                $data = $request->all();

                $config = InventConfig::create([
                    'code_config'=>$data['code_config'],
                    'name'=>$data['name'],
                ]);
                if ($config) {
                    return redirect()->route('inventconf.create')->with('message',"Enregistrer avec succès");
                }else redirect()->route('inventconf.create')->with('error',"Une erreur s'est produite");
            
            }else return redirect('login');
        }else return redirect('login');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InventConfig  $inventConfig
     * @return \Illuminate\Http\Response
     */
    public function show(InventConfig $inventConfig)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InventConfig  $inventConfig
     * @return \Illuminate\Http\Response
     */
    public function edit(InventConfig $inventConfig)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InventConfig  $inventConfig
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InventConfig $inventConfig)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InventConfig  $inventConfig
     * @return \Illuminate\Http\Response
     */
    public function destroy(InventConfig $inventConfig)
    {
        //
    }
}
