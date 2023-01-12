<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Http\Request;
use  \Illuminate\Support\Str;

class CommandeController extends Controller
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
            $commandes = Commande::get();
            return view('admin.commandes',compact('commandes'));
            
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
     *@param App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function create($client = null)
    {
        $user=$this->verifyAdmin();
        if ($user) {
            $clients = Client::get();
            $produits = Produit::get();
            return view('admin.createcommande', compact('clients','client','produits'));
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
                'produit_id' => 'required',
                'quantity' => 'required',
                'date_liv' => 'required',
                'client_id' => 'required',
            ]);
            
            $data = $request->all();

            $exist = Client::where('id',$data['client_id'])->first();
            //dd($exist);
            if (!isset($exist)) {
                return redirect('admin/commande/create')->with('error',"Ce client n'existe pas");
            }else{
                $code =  Str::random(6,'alpha_num');
                $existingCode = Commande::where('code', $code)->first();
                while ($existingCode) {
                    $code = Str::random(6,'alpha_num');
                    $existingCode = Commande::where('code', $code)->first();
                }
                    $commande = Commande::create([
                        'produit_id'=>$data['produit_id'],
                        'quantity'=>$data['quantity'],
                        'date_liv'=>$data['date_liv'],
                        'client_id'=>$data['client_id'],
                        'code'=>$code
                    ]);
                    if ($commande) {
                        return redirect('admin/commande/create')->with('message',"Enregistrer avec succès");
                    }else return redirect('admin/commande/create')->with('error',"Une erreur s'est produite");
                    
                
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function show(Commande $commande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function edit(Commande $commande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commande $commande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commande  $commande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commande $commande)
    {
        //
    }
}
