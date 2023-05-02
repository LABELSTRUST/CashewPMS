<?php

namespace App\Http\Controllers;

use App\Models\Four;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FourController extends Controller
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
                $etape_drying = 1;
                $fours = Four::get();
                return view('drying.fourindex', compact('etape_drying', 'fours'));

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
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_drying = 1;

                return view('drying.createfour',compact('etape_drying'));

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
                $etape_drying = 1;
                $request->validate([
                    'designation'=>'sometimes|nullable',
                ]);
                $data = $request->all();

                $exist = Four::where('designation',$data['designation'])->first();

                if ($exist) {
                    return redirect()->route('drying.createfour')->with('error','Existe déjà');
                }else{
                    $four = Four::create([
                        'designation'=>$data['designation']
                    ]);
                    if ($four) {
                        return redirect()->route('drying.createfour')->with('message','Enregistrer avec succès');
                    }return redirect()->route('drying.createfour')->with('error',"Une erreur s'est produite");
                }
            }else return redirect('login');
        }else return redirect('login');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Four  $four
     * @return \Illuminate\Http\Response
     */
    public function show(Four $four)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Four  $four
     * @return \Illuminate\Http\Response
     */
    public function edit(Four $four)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_drying = 1;
                
                return view('drying.createfour',compact('etape_drying','four'));
            }else return redirect('login');
        }else return redirect('login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Four  $four
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Four $four)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $request->validate([
                    'designation' => 'required',
                ]);
                $data = $request->all();
                $update = $four->update([
                    'designation'=>$data['designation']
                ]);
                if ($update) {
                    return redirect()->route('drying.fouredit',$four->id)->with('message',"Modifier avec succès");
                }else {
                    return redirect()->route('drying.fouredit',$four->id)->with('error','Une erreur s\'est produite');
                }

            }else return redirect('login');
        }else return redirect('login');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Four  $four
     * @return \Illuminate\Http\Response
     */
    public function destroy(Four $four)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                
                $result = $four->delete();
        
                return redirect()->route('drying.fourindex')->with('message','Supprimer avec succès');
            }else return redirect('login');
        }else return redirect('login');
    }
}
