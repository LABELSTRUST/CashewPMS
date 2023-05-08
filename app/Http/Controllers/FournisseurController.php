<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FournisseurController extends Controller
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
                $suppliers = Fournisseur::get();
                return view('supplier.index',compact('suppliers'));
                
            }else {
                $user = $this->verifyMagasinier();
                if ($user) {
                    $suppliers = Fournisseur::get();
                    return view('supplier.index',compact('suppliers'));
                }else  {
                    
                    $user=$this->Admin_memberCheck();
                    if ($user instanceof \App\Models\User) {
                        $admin_member = $user;
                        $suppliers = Fournisseur::get();
                        return view('admin_operation.supplier_index',compact('suppliers','admin_member'));
                    }else{
                        $user=$this->verifyAdminGeneral();
                        if ($user instanceof \App\Models\User) {
                            $admin_member = $user;
                            $suppliers = Fournisseur::get();
                            return view('admin_operation.supplier_index',compact('suppliers','admin_member'));

                        }else return redirect('login');
                    }
                }
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
                return view('supplier.create');
            }else {
                $user = $this->verifyMagasinier();
                if ($user) {
                    return view('supplier.create');
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
                    'country'=>'required',
                    'tel'=>'required',
                    'adresse'=>'required',
                    'first_name'=>'required',
                    'company'=>'required',
                    'postal_code'=>'required',
                    'position'=>'required',
                    'city'=>'required',
                    'categorie'=>'required',
                    'name'=>'required'
                ]);
                
                $data = $request->all();
                $exist = Fournisseur::where('tel',$data['tel'])->first();
                if ($exist) {
                    return redirect()->route('supplier.create')->with('error',"Ce numéro de téléphone existe déjà");
                }

                $exist = Fournisseur::where('email',$data['email'])->first();
                if (isset($exist)) {
                    return redirect()->route('supplier.create')->with('error',"Ce Fournisseur existe déjà");
                }else{

                    $supplier = $this->create_supplier($data['email'],$data['country'],$data['tel'],$data['adresse'],$data['first_name'],$data['company'],$data['postal_code'],$data['position'],$data['city'],$data['categorie'],$data['name']);
                    if ($supplier) {
                        return redirect()->route('supplier.create')->with('message',"Enregistrer avec succès");
                    }else return redirect()->route('supplier.create')->with('error',"Une erreur s'est produite");
                }
    
            }else {
                $user = $this->verifyMagasinier();
                if ($user) {
                    $request->validate([
                        'email' => 'required',
                        'country'=>'required',
                        'tel'=>'required',
                        'adresse'=>'required',
                        'first_name'=>'required',
                        'company'=>'required',
                        'postal_code'=>'required',
                        'position'=>'required',
                        'city'=>'required',
                        'categorie'=>'required',
                        'name'=>'required'
                    ]);
                    
                    $data = $request->all();
                    $exist = Fournisseur::where('tel',$data['tel'])->first();
                    if ($exist) {
                        return redirect()->route('supplier.create')->with('error',"Ce numéro de téléphone existe déjà");
                    }
    
                    $exist = Fournisseur::where('email',$data['email'])->first();
                    if (isset($exist)) {
                        return redirect()->route('supplier.create')->with('error',"Ce Fournisseur existe déjà");
                    }else{
                        $supplier = $this->create_supplier($data['email'],$data['country'],$data['tel'],$data['adresse'],$data['first_name'],$data['company'],$data['postal_code'],$data['position'],$data['city'],$data['categorie'],$data['name']);
                        if ($supplier) {
                            return redirect()->route('supplier.create')->with('message',"Enregistrer avec succès");
                        }else return redirect()->route('supplier.create')->with('error',"Une erreur s'est produite");
                    }    

                } return redirect('login'); 
            }
           
        }else return redirect('login');
    }
    
    public function create_supplier($email,$country,$tel,$adresse,$first_name,$company,$postal_code,$position,$city,$categorie,$name)
    {
        $code = $this->codeSupplier();
        $supplier = Fournisseur::create([
            'email'=>$email,
            'country'=>$country,
            'tel'=>$tel,
            'adresse'=>$adresse,
            'first_name'=>$first_name,
            'company'=>$company,
            'postal_code'=>$postal_code,
            'code'=>$code,
            'position'=>$position,
            'city'=>$city,
            'categorie'=>$categorie,
            'name'=>$name
        ]);
        if ($supplier) {
            return $supplier;
        }

    }
    

    public function supplier_details(Fournisseur $supplier)
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                return view('supplier.supplier_details',compact('supplier'));
            }else {
                $user = $this->verifyMagasinier();
                if ($user) {
                    return view('supplier.supplier_details',compact('supplier'));
                }else  return redirect('login');
            }
        }else return redirect('login');
    }
    
    
    public function codeSupplier()
    {   
        $lastClient = Fournisseur::orderBy('id', 'desc')->first();
        $newId = ($lastClient) ? intval(substr($lastClient->code, 1)) + 1 : 1;
        $newCode = 'F' . $newId;
    
        return $newCode;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function show(Fournisseur $fournisseur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function edit(Fournisseur $fournisseur)
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                return view('supplier.create', compact('fournisseur'));
            }else {
                $user = $this->verifyMagasinier();
                if ($user) {
                    return view('supplier.create', compact('fournisseur'));
                }else return redirect('login');
            }
        }else return redirect('login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fournisseur $fournisseur)
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                $request->validate([
                    'email' => 'required',
                    'country'=>'required',
                    'tel'=>'required',
                    'adresse'=>'required',
                    'first_name'=>'required',
                    'company'=>'required',
                    'postal_code'=>'required',
                ]);
                
                $data = $request->all();
                $exist = Fournisseur::where('tel',$data['tel'])->first();
                if ($exist->id != $fournisseur->id) {
                    return redirect()->route('supplier.edit',$fournisseur->id)->with('error',"Ce numéro de téléphone existe déjà");
                }
                foreach($data as $column => $value) {
                    if ($column != '_token') {
                        $exist->update([$column => $value]);
                    }
                }

                return redirect()->route('supplier.edit',$fournisseur->id)->with('message',"Enregistré avec succès");

            }else {
                $user = $this->verifyMagasinier();
                if ($user) {
                    $request->validate([
                        'email' => 'required',
                        'country'=>'required',
                        'tel'=>'required',
                        'adresse'=>'required',
                        'first_name'=>'required',
                        'company'=>'required',
                        'postal_code'=>'required',
                    ]);
                    
                    $data = $request->all();
                    $exist = Fournisseur::where('tel',$data['tel'])->first();
                    if ($exist->id != $fournisseur->id) {
                        return redirect()->route('supplier.edit',$fournisseur->id)->with('error',"Ce numéro de téléphone existe déjà");
                    }
                    foreach($data as $column => $value) {
                        if ($column != '_token') {
                            $exist->update([$column => $value]);
                        }
                    }

                    return redirect()->route('supplier.edit',$fournisseur->id)->with('message',"Enregistré avec succès");

                }else return redirect('login');
            }
        }else return redirect('login');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fournisseur $fournisseur)
    {
        //
    }
}
