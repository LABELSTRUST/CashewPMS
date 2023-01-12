<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
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
            $produits = Produit::get();
            return view('admin.produits',compact('produits'));
            
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
            return view('admin.createproduit');
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

        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produit $produit)
    {
        //
    }
}
