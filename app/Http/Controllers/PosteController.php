<?php

namespace App\Http\Controllers;

use App\Models\Poste;
use App\Models\Assigner;
use App\Models\Posteproduit;
use App\Models\Produit;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosteController extends Controller
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
            $postes = Poste::get();
            /* dd($postes); */
            return view('admin.poste',compact('postes'));
            
        }else return redirect('login');
    
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
        if( Auth::check()){
        $result = $this->verifyAdmin();
        if($result){
            $assigns = Assigner::where('poste_id',$id)->get();
            if ($assigns) {
                return view('admin.listeoperatorposte', compact('assigns'));
            }

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
            $produits = Produit::get();
            $sections = Section::get();
            return view('admin.createposte',compact('produits','sections'));
        }return redirect('login'); 
    
        }else return redirect('login');
        
    }

    public function createSection()
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                return view('admin.sectioncreate');
            }else return redirect('login');
        }else return redirect('login');
    }
    public function storeSection(Request $request)
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                $request->validate([
                    'designation' => 'required',
                ]);
                $data = $request->all();
                $exist = Section::where('designation',$data['designation'])->first();
                if ($exist) {
                    return redirect()->route('poste.createSection')->with('error',"Cette section existe déjà");
                }else{
                    $section = Section::create([
                        'designation'=>$data['designation']
                    ]);
                    if ($section) {
                        return redirect()->route('poste.createSection')->with('message',"Enregistré avec succès");
                    }else {
                        return redirect()->route('poste.createSection')->with('error',"Une erreur s'est produite");
                    }
                }
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
        $user=$this->verifyAdmin();
        if ($user) {
                
            $request->validate([
                'title' => 'required',
                'produit_id'=> 'required',
                'section_id'=> 'required',
            ]);
            
            $data = $request->all();
            $exist = Poste::where('title',$data['title'])->first();
            if (isset($exist)) {
                $posteproduit = Posteproduit::where('produit_id', $data['produit_id'])->where('poste_id',$exist->id)->first();
                if ($posteproduit) {
                    if (isset($data['nov'])==1) {
                        return redirect()->route('poste.create')->with('error',"Ce poste existe déjà");
                    }
                    return redirect()->route('produit.createposte', [$data['produit_id']])->with('error',"Ce poste existe déjà");
                }
            }else{
                $poste = Poste::create([
                    'title'=>$data['title'],
                    'section_id'=>$data['section_id']
                ]);
                if ($poste) {
                    $create_poste_produit = Posteproduit::create([
                        'produit_id'=>$data['produit_id'],
                        'poste_id'=>$poste->id
                    ]);
                    if ($create_poste_produit) {
                        if (isset($data['nov'])==1) {
                            return redirect()->route('poste.create')->with('message',"Enregistrer avec succès");
                        }
                        return redirect()->route('produit.createposte', [$data['produit_id']])->with('message',"Enregistrer avec succès");
                    }
                }else {
                    
                    if (isset($data['nov'])==1) {
                        return redirect()->route('poste.create')->with('error',"Une erreur s'est produite");
                    }
                    return redirect()->route('produit.createposte', [$data['produit_id']])->with('error',"Une erreur s'est produite");
                }
            }

        }return redirect('login'); 
    
        }else return redirect('login');
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
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                $produits = Produit::get();
                $poste_produits=Posteproduit::select('produit_id')
                    ->distinct()
                    ->where('poste_id', $poste->id)
                    ->get();
                $sections = Section::get();
                //dd($poste_produits);
                return view('admin.createposte',compact('produits','poste','poste_produits','sections'));
            }return redirect('login'); 
    
        }else return redirect('login');
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
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                
            $request->validate([
                'title' => 'required',
                'designation' => 'required',
            ]);
            
            $data = $request->all();
                $poste_update = $poste->update([
                    'title'=>$data['title'],
                    'designation'=>$data['designation']
                ]);
            if ($poste_update) {
                return redirect()->route('poste.index')->with('message',"Modifier avec succès");
            }

            }return redirect('login'); 
    
        }else return redirect('login');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Poste  $poste
     * @return \Illuminate\Http\Response
     */
    public function destroy(Poste $poste)
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                
                $result = $poste->delete();
        
                return redirect()->route('poste.index')->with('message','Supprimer avec succès');
            }else return redirect('login');
        }else return redirect('login');
    }
}
