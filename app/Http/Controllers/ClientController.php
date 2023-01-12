<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
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
            $clients = Client::get();
            return view('admin.clients',compact('clients'));
            
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
            return view('admin.createclient');
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
                'email' => 'required',
                'name' => 'required',
            ]);
            
            $data = $request->all();
            $exist = Client::where('email',$data['email'])->first();
            if (isset($exist)) {
                return redirect('admin/client/create')->with('error',"Ce Client existe déjà");
            }else{
                $client = Client::create([
                    'email'=>$data['email'],
                    'name'=>$data['name'],
                ]);
                if ($client) {
                    return redirect('admin/client/create')->with('message',"Enregistrer avec succès");
                }else return redirect('admin/client/create')->with('error',"Une erreur s'est produite");
            }

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
        //
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
        //
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
