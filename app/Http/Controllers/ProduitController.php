<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProduitController extends Controller
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
            $produits = Produit::get();
            return view('admin.produits',compact('produits'));
            
        }else return redirect('login');
    
        }else return redirect('login');
    }

    
    public function verifyAdmin()
    {
        $admin = app(AuthController::class);
        $result = $admin->adminCheck();
        return  $result;
    }
    
    //Magasinier
    
    public function verifyMagasinier()
    {
        $magasinier = app(AuthController::class);
        $result = $magasinier->magasinierCheck();
        return  $result;
    }

    
    public function createMatierePremiere()
    {
        
        if( Auth::check()){
            $magasinier = $this->verifyMagasinier();
            $produits = Produit::get();
            if ($magasinier) {
                return view('inventaire.createproduit',compact('produits'));
            }else return redirect('login'); 

        }else return redirect('login'); 
    }


    public function listeMatierePremiere()
    {
        
        if( Auth::check()){
            $magasinier = $this->verifyMagasinier();
            $produits = Produit::get();
            if ($magasinier) {
                return view('admin.produits',compact('produits'));
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
        $user=$this->verifyAdmin();
        if ($user) {
            return view('admin.createproduit');
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
                'code_prod' => 'required',
                'name' => 'required',
            ]);
                
            //'author_id' date_start
            $data = $request->all();
            $exist = Produit::where('code_prod',$data['code_prod'])->first();
            if ($exist) {
                return redirect()->route('produit.create')->with('error',"Ce produit existe déjà");
            }else {
                $produit = Produit::create([
                    'code_prod' => $data['code_prod'], 
                    'name' => $data['name'],
                ]);
                if ($produit) {
                    return redirect()->route('produit.create')->with('message',"Enregistré avec succès");
                }
            }

        }return redirect('login'); 
    
        }else return redirect('login');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function show(Produit $produit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function edit(Produit $produit)
    {
        if( Auth::check()){
        $user=$this->verifyAdmin();
        if ($user) {
            return view('admin.createproduit',compact('produit'));
            
        }return redirect('login');
    
        }else return redirect('login'); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produit $produit)
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                    
                $request->validate([
                    'code_prod' => 'required',
                    'name' => 'required',
                ]);
                
                $data = $request->all();

                $update = $produit->update([
                    'code_prod' => $data['code_prod'], 
                    'name' => $data['name'],
                ]);
                
                if ($update) {
                    return redirect()->route('produit.edit',[$produit->id])->with('message',"Modifier avec succès");
                }else return redirect()->route('produit.edit',[$produit->id])->with('error',"Une erreur s'est produite");

            }else return redirect('login');
    
        }else return redirect('login');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produit $produit)
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                
                $result = $produit->delete();
        
                return redirect()->route('produit.index')->with('message','Supprimer avec succès');
            }else return redirect('login');
        }else return redirect('login');
    }


    public function createposte(Produit $produit)
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                return view('admin.createposte',compact('produit'));
            }else return redirect('login'); 
        }else return redirect('login'); 
    }


}
