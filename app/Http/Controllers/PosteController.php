<?php

namespace App\Http\Controllers;

use App\Models\Poste;
use App\Models\Assigner;
use Illuminate\Http\Request;

class PosteController extends Controller
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
            $postes = Poste::get();
            return view('admin.poste',compact('postes'));
            
        }else return redirect('login');
    }

    public function verifyAdmin()
    {
        $admin = app(AuthController::class);
        $result = $admin->adminCheck();
        return  $result;
    }

    /**
     * @param  \App\Models\Poste  $id
    */

    public function listeOperator($id)
    {
        $result = $this->verifyAdmin();
        if($result){
            $assigns = Assigner::where('poste_id',$id)->get();
            if ($assigns) {
                return view('admin.listeoperatorposte', compact('assigns'));
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
        $user=$this->verifyAdmin();
        if ($user) {
            return view('admin.createposte');
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
                'title' => 'required',
            ]);
            
            $data = $request->all();
            $exist = Poste::where('title',$data['title'])->first();
            if (isset($exist)) {
                return redirect('admin/poste/create')->with('error',"Ce poste existe déjà");
            }else{
                $poste = Poste::create([
                    'title'=>$data['title']
                ]);
                if ($poste) {
                    return redirect('admin/poste/create')->with('message',"Enregistrer avec succès");
                }else return redirect('admin/poste/create')->with('error',"Une erreur s'est produite");
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Poste  $poste
     * @return \Illuminate\Http\Response
     */
    public function show(Poste $poste)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Poste  $poste
     * @return \Illuminate\Http\Response
     */
    public function edit(Poste $poste)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Poste  $poste
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Poste $poste)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Poste  $poste
     * @return \Illuminate\Http\Response
     */
    public function destroy(Poste $poste)
    {
        //
    }
}
