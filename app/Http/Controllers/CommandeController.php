<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if( Auth::check()){
            $result = $this->verifyAdmin();
            
            if($result){
                $commandes = Commande::get();
                return view('admin.commandes',compact('commandes'));
                
            }else {
                $user=$this->Admin_memberCheck();
                if ($user instanceof \App\Models\User) {
                    $admin_member = $user;
                    $commandes = Commande::get();
                    return view('admin.commandes',compact('commandes','admin_member'));
                }else return redirect('login');
            }
    
        }else return redirect('login');
    }

    
    
    public function Admin_memberCheck()
    {
        $admin_member = app(AuthController::class);
        $result = $admin_member->Admin_memberCheck();
        return  $result;
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
        if( Auth::check()){
        $user=$this->verifyAdmin();
        if ($user) {
            $clients = Client::get();
            $produits = Produit::get();
            return view('admin.createcommande', compact('clients','client','produits'));
        }else {
            $user=$this->Admin_memberCheck();
            if ($user instanceof \App\Models\User) {
                $clients = Client::get();
                $produits = Produit::get();
                $admin_member = $user;
                return view('admin.createcommande', compact('clients','client','produits','admin_member'));
            }else return redirect('login'); 
        }
        //else return redirect('login'); 
    
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

        }else {
            $user=$this->Admin_memberCheck();
            if ($user instanceof \App\Models\User) { 
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
                    $id_order = $this->id_order($data['client_id']);
                   
                        $commande = Commande::create([
                            'produit_id'=>$data['produit_id'],
                            'quantity'=>$data['quantity'],
                            'date_liv'=>$data['date_liv'],
                            'client_id'=>$data['client_id'],
                            'code'=>$code,
                            'id_order'=>$id_order
                        ]);
                        if ($commande) {
                            return redirect('admin/commande/create')->with('message',"Enregistrer avec succès");
                        }else return redirect('admin/commande/create')->with('error',"Une erreur s'est produite");
                        
                    
                }
    
            }return redirect('login');
        } 
    
        }else return redirect('login');
    }

    public function id_order($client)
    {
        $client = Client::where('id', $client)->first();
        $commandes = Commande::where('client_id', $client->id)->get();
        if ($commandes->count() != null) {
            $count = $commandes->count() + 1;
            $count_str = str_pad($count, 3, '0', STR_PAD_LEFT);
            $id_order = $client->code."-".$count_str;
        } else {
            $id_order = $client->code."-001";
        }
        return $id_order;
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
