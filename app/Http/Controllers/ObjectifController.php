<?php

namespace App\Http\Controllers;

use App\Models\Objectif;
use App\Models\Produit;
use App\Models\Sequence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ObjectifController extends Controller
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
                
                $sequences = Sequence::get();
                $objectifs = Objectif::all();
                if ($objectifs) {
                    $formatted_objectifs = $objectifs->map(function ($objectif) {
                        $objectif->obj_date_start = Carbon::createFromFormat('Y-m-d', $objectif->obj_date_start);
                        $objectif->obj_date_end = Carbon::createFromFormat('Y-m-d', $objectif->obj_date_end);
                        $objectif->formatted_date = $objectif->obj_date_start->format('M-d') . " - " . $objectif->obj_date_end->format('M-d') . ", " .  $objectif->obj_date_end->year;
                        return $objectif;
                    });
                    return view('objectif.index',['objectifs' => $formatted_objectifs,'sequences'=>$sequences]);
                }
            }else  return redirect('login');
        }else  return redirect('login');
    }

    
    public function verifyAdmin()
    {
        $admin = app(AuthController::class);
        $result = $admin->adminCheck();
        return  $result;
    }

    public function genarateCode($column = null, $table)
    {
        if ($column != null) {
            $length = $column;
        }else $length = 4;
		
		// Initialisation des caractères utilisables
		$characters = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
		$key_password = array_rand($characters, $length);

		for ($i = 0; $i < $length; $i++) {
			$password_tab[] = $characters[$key_password[$i]];
		}

		$generated_code = strtoupper(implode("", $password_tab));

        
        $existingCode = $table::where('id_target', $generated_code)->first();
        while ($existingCode) {
            $generated_code = $this->genarateCode($length,$table);
            $existingCode = $table::where('id_target', $generated_code)->first();
        }

		return $generated_code;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( Auth::check()){
            $user = $this->verifyAdmin();
            if($user){
                $produits = Produit::get();
                /*$obj = new Objectif();
                $tb = $obj->tableName();
                dd($tb);*/
                return view('objectif.create',compact('produits'));
            }else  return redirect('login');
        }else  return redirect('login');

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
            $user = $this->verifyAdmin();
            if($user){
                
                $validator = Validator::make($request->all(), [
                    'date_start' => 'required',
                    'date_end' => 'required',
                    'qte_totale' => 'required',
                    'produit_id'=> 'required',
                    'unit_measure'=> 'required'
                ]);
                //dd($request->all());
                if ($validator->fails()) {
                    return redirect()->route('objectif.create')->withErrors($validator)->withInput();
                }
                $data = $request->all();
                $column = 6;
                $id_target = $this->genarateCode($column,Objectif::class);
                
                if ($id_target) {
                    $objectif = Objectif::create([
                        'obj_date_start' =>$data['date_start'],
                        'obj_date_end'=>$data['date_end'],
                        'qte_totale'=>$data['qte_totale'],
                        'produit_id'=>$data['produit_id'],
                        'unit_measure'=>$data['unit_measure'],
                        'id_target'=>$id_target,
                        'obj_remain_quantity'=>$data['qte_totale']
                    ]);
                    if ($objectif) {
                        return redirect()->route('objectif.create')->with('message',"Enregistrer avec succès");
                    }else return redirect()->route('objectif.create')->with('error',"Une erreur s'est produite");
                    
                }else return redirect()->route('objectif.create')->with('error',"Une erreur sur le target");


            }else  return redirect('login');
        }else  return redirect('login');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Objectif  $objectif
     * @return \Illuminate\Http\Response
     */
    public function show(Objectif $objectif)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Objectif  $objectif
     * @return \Illuminate\Http\Response
     */
    public function edit(Objectif $objectif)
    {
        if( Auth::check()){
            $user = $this->verifyAdmin();
            if($user){
                $produits = Produit::get();
                /*$obj = new Objectif();
                $tb = $obj->tableName();
                dd($tb);*/
                return view('objectif.create',compact('produits','objectif'));
            }else  return redirect('login');
        }else  return redirect('login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Objectif  $objectif
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Objectif $objectif)
    {
        if( Auth::check()){
            $user = $this->verifyAdmin();
            if($user){
                
                $validator = Validator::make($request->all(), [
                    'date_start' => 'required',
                    'date_end' => 'required',
                    'qte_totale' => 'required',
                    'produit_id'=> 'required',
                    'unit_measure'=> 'required'
                ]);
                //dd($request->all());
                $sequence = Sequence::where('objectif_id',$objectif->id)->first();
                if ($sequence) {
                    return redirect()->route('objectif.edit',[$objectif->id])->with('error',"Cet objectif est déjà en production");
                }
                if ($validator->fails()) {
                    return redirect()->route('objectif.edit',[$objectif->id])->withErrors($validator)->withInput();
                }
                $data = $request->all();
                
                $update = $objectif->update([
                    'obj_date_start' =>$data['date_start'],
                    'obj_date_end'=>$data['date_end'],
                    'qte_totale'=>$data['qte_totale'],
                    'produit_id'=>$data['produit_id'],
                    'obj_remain_quantity'=>$data['qte_totale'],
                    'unit_measure'=>$data['unit_measure']
                ]);
                if ($update) {
                    return redirect()->route('objectif.edit',[$objectif->id])->with('message',"Modifier avec succès");
                }else return redirect()->route('objectif.edit',[$objectif->id])->with('error',"Une erreur s'est produite");
            }else  return redirect('login');
        }else  return redirect('login');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Objectif  $objectif
     * @return \Illuminate\Http\Response
     */
    public function destroy(Objectif $objectif)
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                
                $result = $objectif->delete();
        
                return redirect()->route('objectif.index')->with('message','Supprimer avec succès');
            }else return redirect('login');
        }else return redirect('login');
    }
}
