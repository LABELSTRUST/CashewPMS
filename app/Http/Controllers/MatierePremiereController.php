<?php

namespace App\Http\Controllers;

use App\Models\MatierePremiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatierePremiereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($inventconfig = null)
    {
        if( Auth::check()){
            $user = $this->verifyMagasinier();
            if($user){
                $produits = MatierePremiere::get();
                
                return view('inventaire.dash',compact('produits'));//inventaire.dash inventaire/matierepremieres/
                
            }else return redirect('login');
            
        }else return redirect('login');
    }

    public function listeMatiere($conf = null)
    {
        if( Auth::check()){
            $user = $this->verifyMagasinier();
            if($user){
                $produits = MatierePremiere::get();
                
                return view('matiere.matieres',compact('produits'));
                
            }else return redirect('login');
            
        }else return redirect('login');
    }

    
    public function verifyMagasinier()
    {
        $magasinier = app(AuthController::class);
        $result = $magasinier->magasinierCheck();
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
            $user = $this->verifyMagasinier();
            if($user){
                return view('matiere.create');
            }else return redirect('login');
        }else return redirect('login');
    }

    public function inv_expedition()
    {
        if( Auth::check()){
            $user = $this->verifyMagasinier();
            if($user){
                $expedition = 1;
                $mat = MatierePremiere::get();
               
                return view('inventaire.expe_dash');
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
            $user = $this->verifyMagasinier();
            if($user){
                $request->validate([
                    'name' => 'required',
                ]);
                    
                $data = $request->all();

                $code = $this->codeMat();
               
                $produit = MatierePremiere::create([
                    'code_mat' => $code, 
                    'name' => $data['name'],
                ]);
                if ($produit) {
                    return redirect()->route('matiere.create')->with('message',"Enregistré avec succès");
                }
            }else return redirect('login');
        }else return redirect('login');
    }

    public function codeMat($code = null)
    {
            $lastCode = MatierePremiere::select('code_mat')
                ->where('code_mat', 'like', 'M%')
                ->orderByDesc('code_mat')
                ->first();
    
            if ($lastCode) {
                $lastNumber = intval(substr($lastCode->code_mat, 1)) + 1;
            } else {
                $lastNumber = 1;
            }
    
            return 'M' . str_pad($lastNumber, 3, '0', STR_PAD_LEFT);
        
    }

    public function produit_fini_index()
    {
        if( Auth::check()){
            $user = $this->verifyMagasinier();
            if($user){
                return view('matiere.produits_finis');
            }else return redirect('login');
        }else return redirect('login');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MatierePremiere  $matierePremiere
     * @return \Illuminate\Http\Response
     */
    public function show(MatierePremiere $matierePremiere)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MatierePremiere  $matierePremiere
     * @return \Illuminate\Http\Response
     */
    public function edit(MatierePremiere $matierePremiere)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MatierePremiere  $matierePremiere
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MatierePremiere $matierePremiere)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MatierePremiere  $matierePremiere
     * @return \Illuminate\Http\Response
     */
    public function destroy(MatierePremiere $matierePremiere)
    {
        //
    }
}
