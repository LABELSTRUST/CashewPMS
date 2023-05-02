<?php

namespace App\Http\Controllers;

use App\Models\Cuiseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CuiseurController extends Controller
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
                $cuiseurs = Cuiseur::get();$etape_fragilisation = 1;
                return view('fragilisation.cuiseurindex',compact('cuiseurs','etape_fragilisation'));

            }else return redirect('login');
        }else return redirect('login');
    }

    
    public function verifyOperator()
    {
        $magasinier = app(AuthController::class);
        $result = $magasinier->operatorCheck();
        return  $result;
    }

    public function processFragilisation($stock)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_fragilisation = 1;
                $cuiseurs = Cuiseur::get();
                return view('fragilisation.processfragilisation',compact('stock','cuiseurs','etape_fragilisation'));
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
                $etape_fragilisation = 1;
                return view('fragilisation.createcuiseur',compact('etape_fragilisation'));
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
            $user=$this->verifyOperator();
            if ($user) {
                $request->validate([
                    'designation' => 'required',
                ]);
                $data = $request->all();
                $exist = Cuiseur::where('designation',$data['designation'])->first();
                if (isset($exist)) {
                    return redirect()->route('cuiseur.create')->with('error',"Cuiseur existant");
                }
                $cuiseur = Cuiseur::create([
                    'designation'=>$data['designation']
                ]);
                if ($cuiseur) {
                    return redirect()->route('cuiseur.create')->with('message',"Enregistrer avec succès");
                }else return redirect()->route('cuiseur.create')->with('error',"Une erreur s'est produite");
                
            }else return redirect('login');
        }else return redirect('login');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cuiseur  $cuiseur
     * @return \Illuminate\Http\Response
     */
    public function show(Cuiseur $cuiseur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cuiseur  $cuiseur
     * @return \Illuminate\Http\Response
     */
    public function edit(Cuiseur $cuiseur)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_fragilisation = 1;
                return view('fragilisation.createcuiseur',compact('etape_fragilisation','cuiseur'));

            }return redirect('login'); 
    
        }else return redirect('login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cuiseur  $cuiseur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cuiseur $cuiseur)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_fragilisation = 1;
                $request->validate([
                    'designation' => 'required',
                ]);
                
                $data = $request->all();

                $update = $cuiseur->update([
                    'designation' =>$data['designation'],
                ]);
                
                if ($update) {
                    return redirect()->route('cuiseur.edit',[$cuiseur->id])->with('message',"Modifier avec succès");
                }else return redirect()->route('cuiseur.edit',[$cuiseur->id])->with('error',"Une erreur s'est produite");

            }else return redirect('login');
    
        }else return redirect('login');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cuiseur  $cuiseur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cuiseur $cuiseur)
    {
        //
    }
    public function cuiseurdestroy(Cuiseur $cuiseur)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_fragilisation = 1;

                $result = $cuiseur->delete();
        
                return redirect()->route('cuiseur.index')->with('message','Supprimer avec succès');
            }else return redirect('login');
        }else return redirect('login');
    }
}
