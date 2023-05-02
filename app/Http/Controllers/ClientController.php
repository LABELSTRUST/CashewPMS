<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if( Auth::check()){
            $user = $this->verifyAdmin();

            if($user){
                $clients = Client::get();
                return view('admin.clients',compact('clients'));
                
            }else {
                $user = $this->verifyMagasinier();
                if ($user) {
                    $clients = Client::get();
                    return view('admin.clients',compact('clients'));
                }else  return redirect('login');
            }
            
            
        }else return redirect('login');
    }

    
    public function verifyMagasinier()
    {
        $magasinier = app(AuthController::class);
        $result = $magasinier->magasinierCheck();
        return  $result;
    }

    
    public function verifyAdmin()
    {
        $admin = app(AuthController::class);
        $result = $admin->adminCheck();
        return  $result;
    }

    public function client_details(Client $client)
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                return view('admin.client_details',compact('client'));
            }else {
                $user = $this->verifyMagasinier();
                if ($user) {
                    return view('admin.client_details',compact('client'));
                }else  return redirect('login');
            }
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
                return view('admin.createclient');
            }else {
                $user = $this->verifyMagasinier();
                if ($user) {
                    return view('admin.createclient');
                }else  return redirect('login');
            }
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
                    'email' => 'required',
                    'name' => 'required',
                    'country'=>'required',
                    'tel'=>'required',
                    'adresse'=>'required',
                    'first_name'=>'required',
                    'company'=>'required',
                    'postal_code'=>'required',
                    'position'=>'required',
                    'city'=>'required',
                    'categorie'=>'required',
                    'code'=>'required',
                ]);
                
                $data = $request->all();
                $code = Client::where('code',$data['code'])->first();
                if ($code) {
                    return redirect('admin/client/create')->with('error',"Ce code existe déjà");
                }
                $exist = Client::where('tel',$data['tel'])->first();
                if ($exist) {
                    return redirect('admin/client/create')->with('error',"Ce numéro de téléphone existe déjà");
                }

                $exist = Client::where('email',$data['email'])->first();
                if (isset($exist)) {
                    return redirect('admin/client/create')->with('error',"Ce Client existe déjà");
                }else{

                    $client = $this->create_client($data['email'],$data['name'],$data['country'],$data['tel'],$data['adresse'],$data['first_name'],$data['company'],$data['postal_code'],$data['position'],$data['city'],$data['categorie'], $data['code']);
                    if ($client) {
                        return redirect('admin/client/create')->with('message',"Enregistrer avec succès");
                    }else return redirect('admin/client/create')->with('error',"Une erreur s'est produite");
                }
    
            }else {
                $user = $this->verifyMagasinier();
                if ($user) {
                    $request->validate([
                        'email' => 'required',
                        'name' => 'required',
                        'country'=>'required',
                        'tel'=>'required',
                        'adresse'=>'required',
                        'first_name'=>'required',
                        'company'=>'required',
                        'postal_code'=>'required',
                        'position'=>'required',
                        'city'=>'required',
                        'categorie'=>'required',
                        'code'=>'required',
                    ]);
                    
                    $data = $request->all();
                    $code = Client::where('code', $data['code'])->first();
                    if ($code) {
                        return redirect('admin/client/create')->with('error',"Ce code existe déjà");
                    }
                    $exist = Client::where('tel',$data['tel'])->first();
                    if ($exist) {
                        return redirect('admin/client/create')->with('error',"Ce numéro de téléphone existe déjà");
                    }
    
                    $exist = Client::where('email',$data['email'])->first();
                    if (isset($exist)) {
                        return redirect('admin/client/create')->with('error',"Ce Client existe déjà");
                    }else{
                        $client = $this->create_client($data['email'],$data['name'],$data['country'],$data['tel'],$data['adresse'],$data['first_name'],$data['company'],$data['postal_code'],$data['position'],$data['city'],$data['categorie'], $data['code']);
                        if ($client) {
                            return redirect('admin/client/create')->with('message',"Enregistrer avec succès");
                        }else return redirect('admin/client/create')->with('error',"Une erreur s'est produite");
                    }    

                } return redirect('login'); 
            }
           
        }else return redirect('login');
    }

    
    public function codeClient()
    {   
        $lastClient = Client::orderBy('id', 'desc')->first();
        $newId = ($lastClient) ? intval(substr($lastClient->code, 1)) + 1 : 1;
        $newCode = 'C' . $newId;
    
        return $newCode;

    }

    public function create_client($email,$name,$country,$tel,$adresse,$first_name,$company,$postal_code,$position,$city,$categorie,$code)
    {
        //$code = $this->codeClient();
        
        $client = Client::create([
            'email'=>$email,
            'name'=>$name,
            'country'=>$country,
            'tel'=>$tel,
            'adresse'=>$adresse,
            'first_name'=>$first_name,
            'company'=>$company,
            'postal_code'=>$postal_code,
            'code'=>$code,
            'position'=>$position,
            'city'=>$city,
            'categorie'=>$categorie
        ]);
        if ($client) {
            return $client;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                return view('admin.createclient', compact('client'));
            }else {
                $user = $this->verifyMagasinier();
                if ($user) { 
                    return view('admin.createclient', compact('client'));
                }else return redirect('login');
            }
        }else return redirect('login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                $request->validate([
                    'email' => 'required',
                    'name' => 'required',
                    'country'=>'required',
                    'tel'=>'required',
                    'adresse'=>'required',
                    'first_name'=>'required',
                    'company'=>'required',
                    'postal_code'=>'required',
                ]);
                
                $data = $request->all();
                $exist = Client::where('tel',$data['tel'])->first();
                if ($exist->id != $client->id) {
                    return redirect('admin/client/create')->with('error',"Ce numéro de téléphone existe déjà");
                }
                foreach($data as $column => $value) {
                    if ($column != '_token') {
                        $exist->update([$column => $value]);
                    }
                }

                return redirect()->route('client.edit',$client->id)->with('message',"Enregistré avec succès");

            }else {
                $user = $this->verifyMagasinier();
                if ($user) {
                    $request->validate([
                        'email' => 'required',
                        'name' => 'required',
                        'country'=>'required',
                        'tel'=>'required',
                        'adresse'=>'required',
                        'first_name'=>'required',
                        'company'=>'required',
                        'postal_code'=>'required',
                    ]);
                    
                    $data = $request->all();
                    $exist = Client::where('tel',$data['tel'])->first();
                    if ($exist->id != $client->id) {
                        return redirect('admin/client/create')->with('error',"Ce numéro de téléphone existe déjà");
                    }
                    foreach($data as $column => $value) {
                        if ($column != '_token') {
                            $exist->update([$column => $value]);
                        }
                    }

                    return redirect()->route('client.edit',$client->id)->with('message',"Enregistré avec succès");

                }else return redirect('login');
            }
        }else return redirect('login');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
