<?php

namespace App\Http\Controllers;

use App\Models\Admin_member;
use App\Models\Client;
use App\Models\Objectif;
use App\Models\Produit;
use App\Models\Sequence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin_memberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    
    public function Admin_memberCheck()
    {
        $admin_member = app(AuthController::class);
        $result = $admin_member->Admin_memberCheck();
        return  $result;
    }
    
    public function create_client()
    {
        if( Auth::check()){
            $user=$this->Admin_memberCheck();
            if ($user instanceof \App\Models\User) {
                $admin_member = $user;
                return view('admin_operation.createclient', compact('admin_member'));
            }else return redirect('login');
        }else return redirect('login');
    }

    public function create_fournisseur()
    {
        if( Auth::check()){
            $user=$this->Admin_memberCheck();
            if ($user instanceof \App\Models\User) {
                $admin_member = $user;
                return view('admin_operation.createsuplier', compact('admin_member'));
            }else return redirect('login');
        }else return redirect('login');
    }
    
    public function verifyAdminGeneral()
    {
        $magasinier = app(AuthController::class);
        $result = $magasinier->verifyAdminGeneral();
        return  $result;
    }

    

    public function clientindex()
    {
        if( Auth::check()){
            $user=$this->Admin_memberCheck();
            if ($user instanceof \App\Models\User) {
                $clients = Client::orderBy('id','DESC')->paginate(20);
                $admin_member = $user;
                return view('admin_operation.client_index', compact('admin_member','clients'));
            }else {
                $user=$this->verifyAdminGeneral();
                if ($user instanceof \App\Models\User) {
                    $clients = Client::orderBy('id','DESC')->paginate(20);
                    $admin_member = $user;
                    return view('admin_operation.client_index', compact('admin_member','clients'));
                }else return redirect('login');
            }
        }else return redirect('login');
    }

    

    public function objectif_index()
    {
        if( Auth::check()){
            $user=$this->Admin_memberCheck();
            if ($user instanceof \App\Models\User) {
                $admin_member = $user;
                
                $sequences = Sequence::get();
                $objectifs = Objectif::all();
                if ($objectifs) {
                    $formatted_objectifs = $objectifs->map(function ($objectif) {
                        $objectif->obj_date_start = Carbon::createFromFormat('Y-m-d', $objectif->obj_date_start);
                        $objectif->obj_date_end = Carbon::createFromFormat('Y-m-d', $objectif->obj_date_end);
                        $objectif->formatted_date = $objectif->obj_date_start->format('M-d') . " - " . $objectif->obj_date_end->format('M-d') . ", " .  $objectif->obj_date_end->year;
                        return $objectif;
                    });
                    return view('admin_operation.objectif_index',['objectifs' => $formatted_objectifs,'sequences'=>$sequences,'admin_member'=>$admin_member]);
                }
            }else {
                $user=$this->verifyAdminGeneral();
                if ($user instanceof \App\Models\User) {

                    $admin_member = $user;
                
                    $sequences = Sequence::get();
                    $objectifs = Objectif::all();
                    if ($objectifs) {
                        $formatted_objectifs = $objectifs->map(function ($objectif) {
                            $objectif->obj_date_start = Carbon::createFromFormat('Y-m-d', $objectif->obj_date_start);
                            $objectif->obj_date_end = Carbon::createFromFormat('Y-m-d', $objectif->obj_date_end);
                            $objectif->formatted_date = $objectif->obj_date_start->format('M-d') . " - " . $objectif->obj_date_end->format('M-d') . ", " .  $objectif->obj_date_end->year;
                            return $objectif;
                        });
                        return view('admin_operation.objectif_index',['objectifs' => $formatted_objectifs,'sequences'=>$sequences,'admin_member'=>$admin_member]);
                    }

                }else return redirect('login'); 
            }
        }else return redirect('login');
    }

    public function objectif_create()
    {
        if( Auth::check()){
            $user=$this->Admin_memberCheck();
            if ($user instanceof \App\Models\User) {
                $admin_member = $user;
                $produits = Produit::get();
                $clients = Client::get();
                return view('admin_operation.objectif_create',compact('admin_member','produits','clients'));
            }else {
                $user=$this->verifyAdminGeneral();
                if ($user instanceof \App\Models\User) {
                    $admin_member = $user;
                    $produits = Produit::get();
                    $clients = Client::get();
                    return view('admin_operation.objectif_create',compact('admin_member','produits','clients'));
                }else return redirect('login');
            }
        }else return redirect('login');
    }

    public function storeClient(Request $request)
    {
        if( Auth::check()){
            $user=$this->Admin_memberCheck();
            if ($user instanceof \App\Models\User) {
                    
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
                    return redirect()->route('admin_operation.create_client')->with('error',"Ce code existe déjà");
                }
                $exist = Client::where('tel',$data['tel'])->first();
                if ($exist) {
                    return redirect()->route('admin_operation.create_client')->with('error',"Ce numéro de téléphone existe déjà");
                }

                $exist = Client::where('email',$data['email'])->first();
                if (isset($exist)) {
                    return redirect()->route('admin_operation.create_client')->with('error',"Ce Client existe déjà");
                }else{

                    $client = $this->create_client($data['email'],$data['name'],$data['country'],$data['tel'],$data['adresse'],$data['first_name'],$data['company'],$data['postal_code'],$data['position'],$data['city'],$data['categorie'], $data['code']);
                    if ($client) {
                        return redirect()->route('admin_operation.create_client')->with('message',"Enregistrer avec succès");
                    }else return redirect()->route('admin_operation.create_client')->with('error',"Une erreur s'est produite");
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin_member  $admin_member
     * @return \Illuminate\Http\Response
     */
    public function show(Admin_member $admin_member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin_member  $admin_member
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin_member $admin_member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin_member  $admin_member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin_member $admin_member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin_member  $admin_member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin_member $admin_member)
    {
        //
    }
}
