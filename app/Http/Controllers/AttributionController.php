<?php

namespace App\Http\Controllers;

use App\Models\Assigner;
use App\Models\Attribution;
use App\Models\User;
use App\Models\Ligne;
use App\Models\Poste;
use App\Models\Role;
use Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttributionController extends Controller
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
                $attributions = Attribution::get();
                return view('admin.assigner',compact('attributions'));
                
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
            $role = Role::where('name','Operateur')->first();

            $operators = User::query()
            ->whereNotNull('author_id')
            ->where('roles_id',$role->id)
            ->get();
            if ($operators) {
                $postes = Poste::get();
                if ($postes) {
                    return view('admin.createattribution', compact('operators','postes'));
                }
                
            }
        }return redirect('login'); 
            
        }else return redirect('login');
        
    }

    public function attribuer($operator)
    {
        if( Auth::check()){
        $user=$this->verifyAdmin();
        if ($user) {
            
            $assigner = Assigner::where('user_id',$operator)->pluck('poste_id');
            $postes = Poste::whereNotIn('id',$assigner)->get();
            if ($postes) {
                return view('admin.createattribution', compact('operator','postes'));
            }
            
        
        }return redirect('login'); 
            
        }else return redirect('login');
    }
    public function attribuer_store(Request $request)
    {
        if( Auth::check()){
        $user=$this->verifyAdmin();
        if ($user) {
            $request->validate([
                'poste_id' => 'required',
                'user_id' => 'required',
            ]);
            
            $data = $request->all();
            $assigner = Assigner::where('user_id',$data['user_id'])->pluck('poste_id');
            
            
            $postes = Poste::whereNotIn('id',$assigner)->get();
            $exist_poste = Attribution::where('poste_id',$data['poste_id'])->where('user_id',$data['user_id'])->get();
            
            if ($exist_poste->isNotEmpty()) {
                return redirect()->route('attribuer.attribuer', [$data['user_id']])->with('error',"Cet opérateur a déjà ce poste ");
            }
            
            $attribution = Attribution::create([
                'poste_id' => $data['poste_id'], 
                'user_id' => $data['user_id'],
            ]);
            if ($attribution) {
               return  redirect()->route('attribuer.attribuer', [$data['user_id']])->with( ['postes' => $postes] )->with('message',"Enregistrer ");
            }else return redirect()->route('attribuer.attribuer', [$data['user_id']])->with('error',"Cet opérateur a déjà ce poste ");
        }return redirect('login'); 
            
        }else return redirect('login');
    }

    public function verifyAdmin()
    {
        $admin = app(AuthController::class);
        $result = $admin->adminCheck();
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
        $user=$this->verifyAdmin();
        if ($user) {
            $request->validate([
                'poste_id' => 'required',
                'user_id' => 'required',
            ]);
            
            $data = $request->all();

            $exist_poste = Attribution::where('poste_id',$data['poste_id'])->where('user_id',$data['user_id'])->get();
            if ($exist_poste) {
                return redirect('admin/attribuer/create')->with('error',"Cet opérateur a déjà ce poste ");
            }

            $attribution = Attribution::create([
                'poste_id' => $data['poste_id'], 
                'user_id' => $data['user_id'],
            ]);
            if ($attribution) {
                return redirect('admin/attribuer/create')->with('message',"Enregistré avec succès");
            }else return redirect('admin/attribuer/create')->with('error',"Cet opérateur a déjà ce poste ");
        }return redirect('login'); 
            
        }else return redirect('login');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attribution  $attribution
     * @return \Illuminate\Http\Response
     */
    public function show(Attribution $attribution)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attribution  $attribution
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribution $attribution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attribution  $attribution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attribution $attribution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attribution  $attribution
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attribution $attribution)
    {
        //
    }
}
