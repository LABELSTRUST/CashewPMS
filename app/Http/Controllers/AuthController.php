<?php

namespace App\Http\Controllers;

use App\Models\Admin_member;
use App\Models\Admin_Role;
use App\Models\User;
use App\Models\Assigner;
use App\Models\Attribution;
use App\Models\General_admin;
use App\Models\MatierePremiere;
use App\Models\OperatorSequence;
use App\Models\Produit;
use App\Models\Role;
use App\Models\Secteur;
use App\Models\Stock;
use App\Models\User_Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.accueil');
    }
    /** Admin Général */

    public function create_general_admin()
    {
        return view('auth.creategene_admin');
    }


    public function verifyAdminGeneral()
    {
        if(Auth::check()){
            $user = auth()->user();
            
            $general_admin = General_admin::where('user_id',$user->id)->first();
            if ($general_admin && $general_admin != null) {
                return $user;
            }else return redirect("login");
            
        }else return redirect("login");
    }

    
    public function verifyAdminMember()
    {
        if(Auth::check()){
            $user = auth()->user();
            
            $admin_member = Admin_member::where('user_id',$user->id)->first();
            if ($admin_member && $admin_member != null) {
                return $user;
            }else return redirect("login");
        }else return redirect("login");
    }
    

    public function register_general_admin(Request $request)
    {

                
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'repeat_password'=>'required|same:password',
            'avatar' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title'=> 'required',
        ]);
        
        $data = $request->all();
        $exist = User::where('email', $data['email'])->first();
        if ($exist) {
            return redirect()->route('gene_admin.create')->with('error',"Cet email existe déjà");
        }
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('public/avatars', $filename);

            $admin_gene = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'username'=>$data['username'],
                'password' =>$data['password']= Hash::make($data['password']),
                'avatar'=>$filename
            ]);
           
            if ($admin_gene) {
                $role = Admin_Role::where('name','Directeur Général')->first();
                if ($role) {
    
                    $user_role = User_Role::create([
                        'user_id'=>$admin_gene->id,
                        'role_id'=>$role->id
                    ]);
                    if ($user_role) {
                        $gene_member = General_admin::create([
                            'user_id'=>$admin_gene->id,
                            'title'=>$data['title']
                        ]);
                        if ($gene_member) {
                            return redirect()->route('gene_admin.create')->with('message',"Enregistrer avec succès");
    
                        }return redirect()->route('gene_admin.create')->with('error',"Une erreur sur l'admin général");
    
                    }return redirect()->route('gene_admin.create')->with('error',"Une erreur sur le role");
    
                }else return redirect()->route('gene_admin.create')->with('error',"Une erreur s'est produite");
            }else return redirect()->route('gene_admin.create')->with('error',"Une erreur s'est produite");
                
        }


            
    }

    public function admin_dash()
    {
        if(Auth::check()){
            $user = auth()->user();
            $general_admin = General_admin::where('user_id',$user->id)->first();
            if ($general_admin) {
                return view('admin_member.dashboard',compact('general_admin'));
            }else {
                $admin_member = Admin_member::where('user_id',$user->id)->first();
              
                return view('admin_member.member_dashboard',compact('admin_member'));
            }
        }return redirect("login");
    }


    public function Login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('username', 'password');
        
        
        if (Auth::attempt($credentials)) {
            
            
            $user = auth()->user();
           
            $general_admin = General_admin::where('user_id',$user->id)->first();
            if ($general_admin) {
                return redirect()->intended('admin_dash');
            }else {

                $admin_member = Admin_member::where('user_id',$user->id)->first();
                if ($admin_member) {
                    
                    return redirect()->intended('admin_dash');
                }else {
                    return redirect()->intended('dashboard')->withSuccess('Signed in');
                }
            }

            
        } else return redirect("login")->with('error','Login details are not valid');
    }

    public function registration()
    {
        return view('auth.register');
    }

    public function operatorCheck()
    {
        if(Auth::check()){
            $user = auth()->user();
            if ($user->getRole?->name === "Operateur") {
                return $user;
            }
        }else {
            return redirect("login");
        }
    }
    

    public function Admin_memberCheck()
    {
        if(Auth::check()){
            $user = auth()->user();
            $admin_member = Admin_member::where('user_id',$user->id)->first();
            if ($admin_member) {
                return $user;
            }
        }else {
            return redirect("login");
        }
    }

    
    public function Register(Request $request)
    {  
        if( Auth::check()){
            $user=$this->Admin_memberCheck();
            if ($user instanceof \App\Models\User) {
                $request->validate([
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'username' => 'required|unique:users',
                    'password' => 'required|min:6',
                    'roles_id' =>'required',
                    'departement_id'=>'required',
                    'designation'=>'required',
                    'avatar' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                   
                ]);

                $data = $request->all();
                
                $create = $this->create($data,$user->id);
                if ($create) {
                
                    $secteur = Secteur::create([
                        'designation'=>$data['designation'],
                        'departement_id'=>$data['departement_id'],
                        'user_id'=>$create->id,
                    ]);

                    
                    if ($request->hasFile('avatar')) {
                        $avatar = $request->file('avatar');
                        $filename = time() . '.' . $avatar->getClientOriginalExtension();
                        $avatar->storeAs('public/avatars', $filename);
                       
                        $update = $create->update(['avatar'=>$filename]);
                    }
                    
                    return redirect('admin/create/operator')->with('message'," Enregistrer avec succès");
                
                    
                }else {
                    return redirect('admin/create/operator')->with('error',"Un champ est mal renseigné");
                }

            }else {
                $user=$this->verifyAdminGeneral();
                if ($user instanceof \App\Models\User) {
                    $request->validate([
                        'name' => 'required',
                        'email' => 'required|email|unique:users',
                        'username' => 'required|unique:users',
                        'password' => 'required|min:6',
                        'roles_id' =>'required',
                        'departement_id'=>'required',
                        'designation'=>'required',
                        'avatar' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                       
                    ]);
    
                    $data = $request->all();
                    
                    $create = $this->create($data,$user->id);
                    if ($create) {
                        
                        $secteur = Secteur::create([
                            'designation'=>$data['designation'],
                            'departement_id'=>$data['departement_id'],
                            'user_id'=>$create->id,
                        ]);
                        
                    
                        if ($request->hasFile('avatar')) {
                            $avatar = $request->file('avatar');
                            $filename = time() . '.' . $avatar->getClientOriginalExtension();
                            $avatar->storeAs('public/avatars', $filename);
                        
                            $update = $create->update(['avatar'=>$filename]);
                        }

                        
                        return redirect('admin/create/operator')->with('message'," Enregistrer avec succès");
                    
                        
                    }else {
                        return redirect('admin/create/operator')->with('error',"Un champ est mal renseigné");
                    }
                }else {
                    $user = $this->adminCheck();
                    
                    if ($user) {
                        $request->validate([
                            'name' => 'required',
                            'email' => 'required|email|unique:users',
                            'username' => 'required|unique:users',
                            'password' => 'required|min:6',
                            'roles_id' =>'required',
                            'departement_id'=>'required',
                            'designation'=>'required',
                            'avatar' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                           
                        ]);
        
                        $data = $request->all();
                        
                        $create = $this->create($data,$user->id);
                        if ($create) {
                        
                            $secteur = Secteur::create([
                                'designation'=>$data['designation'],
                                'departement_id'=>$data['departement_id'],
                                'user_id'=>$create->id,
                            ]);
                    
                            if ($request->hasFile('avatar')) {
                                $avatar = $request->file('avatar');
                                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                                $avatar->storeAs('public/avatars', $filename);
                            
                                $update = $create->update(['avatar'=>$filename]);
                            }
                            
                            return redirect('admin/create/operator')->with('message'," Enregistrer avec succès");
                        
                            
                        }else {
                            return redirect('admin/create/operator')->with('error',"Un champ est mal renseigné");
                        }
                    }return redirect("login");
                }
            }
        }return redirect("login");
    }

    
    public function create( array $data, $author_id = null)
    {
        
            if ($author_id != null) {
                
                return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'username'=>$data['username'],
                    'roles_id' => $data['roles_id'],
                    'password' =>$data['password']= Hash::make($data['password']),
                    'author_id' =>$author_id,
                ]);
            }else {
                return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'username'=>$data['username'],
                    'roles_id' => $data['roles_id'],
                    'password' =>$data['password']= Hash::make($data['password']),
                ]);
                
            }
        
        
    } 

    
    public function dashboard()
    {
        if(Auth::check()){
            $user = auth()->user();
            if($user->getRole?->name == "Magasinier"){
                $matieres = MatierePremiere::get();
                return view('auth.dashboard',compact('matieres'))->With('success', 'Voys êtes connecté(e)');
            }
            if($user->getRole?->name == "Operateur"){
                $operator = OperatorSequence::whereDate('created_at',Carbon::today())
                            ->where('user_id',$user->id )
                            ->orderBy('id','DESC')->first();
                            
                //$response  = session::put('sequence' , $operator->sequence_id);
                
                if ($operator) {
                    $response  = session::put('sequence' , $operator->sequence_id); //dd($response);
                    return view('auth.dashboard')->With('success', 'Voys êtes connecté(e)');
                }else {
                    return redirect()->route('sequence.operateurSequence');
                }
            }
            if ($user->roles_id == null) {
                $admin_member = $user;
                return view('admin_member.member_dashboard',compact('admin_member'))->With('success', 'Voys êtes connecté(e)');
                
            }
            
            return view('auth.dashboard')->With('success', 'Voys êtes connecté(e)');
        } 
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    
    public function signOut() {
        Session::flush();
        Auth::logout();
        return Redirect('login');
        
  
    }


    public function createOperator()
    {
        if(Auth::check()){
            $user=$this->Admin_memberCheck();
            
            if ($user instanceof \App\Models\User) {
                $roles = Role::get();
                if ($roles) {
                    
                    $admin_member = $user;
                    $departements = Admin_Role::get();
                    return view('admin.createoperator', compact('roles','departements','admin_member'));
                }
            }else {
                
                $user=$this->verifyAdminGeneral();
                if ($user instanceof \App\Models\User) {
                    $roles = Role::get();
                    if ($roles) {
                        $admin_member = $user;
                        $departements = Admin_Role::get();
                        return view('admin.createoperator', compact('roles','departements','admin_member'));
                    }
                }else return redirect("login");
            }

        }else {
            return redirect("login");
        }
    }

    public function adminCheck()
    {
        if(Auth::check()){
            $user = auth()->user();
            if ($user->getRole?->name === "Admin" || $user->getRole?->name === "Superadmin" ) {
                return $user;
            }
        }else {
            return redirect("login");
        }
    }

    public function listeposte($operator)
    {
        if(Auth::check()){
            $user = $this->adminCheck();
            if ($user) {
                $assigners = Assigner::where('user_id',$operator)->orderBy('id', 'desc')->get();
                if ($assigners->isNotEmpty()) {
                    return view('admin.poste', compact('assigners'));
                }else {
                    $attributions = Attribution::where('user_id',$operator)->orderBy('id', 'desc')->get();
                    if ($attributions->isNotEmpty()) {
                        return view('admin.poste', compact('attributions'));
                    }else return view('admin.poste', compact('assigners'));
                }
            }else return redirect("login");

        }else return redirect("login");
        
    }

    public function insertOperator(Request $request)
    {
        if(Auth::check()){
            $user = $this->adminCheck();
            if ($user) {

                $request->validate([
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'username' => 'required|unique:users',
                    'password' => 'required|min:6',
                    'roles_id' => 'required',
                ]);

                    
                $data = $request->all();
                $check = $this->create($data, $user->id);
                if ($check) {
                    return redirect('admin/create/operator')->with('message','Enregistré avec succès');
                }else {
                    return redirect('admin/create/operator')->with('error',"Un champ est mal renseigné");
                }
                
            }return redirect('login');
        }return redirect('login');
    }

    public function listOperateur()
    {
        if(Auth::check()){
            $user = $this->adminCheck();
            if ($user) {
                $role = Role::where('name','Operateur')->first();
                $magasinier = Role::where('name','Magasinier')->first();
                $operators = User::query()
                    ->whereNotNull('author_id')
                    ->orderBy('id','DESC')
                    ->whereNotNull('roles_id')
                    ->get();
                $opera = $operators->pluck('id');
             /* 
                $geneUser = General_admin::pluck('user_id');
                dd($geneUser);
                $adminUser = Admin_member::pluck('user_id');
                $operators = User::whereNotIn('id', $geneUser)->whereNotIn('id', $adminUser)->get();

                dd($operators); */
                //$operators1 = Assigner::whereIn('user_id',$opera)->get();'operators1'dd($operators);

                return view('admin.listoperator',compact('operators'));
            }else {
                $user=$this->verifyAdminGeneral();
                if ($user instanceof \App\Models\User) {
                    $role = Role::where('name','Operateur')->first();
                    $magasinier = Role::where('name','Magasinier')->first();
                    $operators = User::query()
                        ->whereNotNull('author_id')
                        ->orderBy('id','DESC')
                        ->whereNotNull('roles_id')
                        ->get();
                    $opera = $operators->pluck('id');
                    $admin_member = $user;
                    return view('admin_operation.listeoperators',compact('operators','admin_member'));
                }else {
                    $user=$this->Admin_memberCheck();
                    if ($user instanceof \App\Models\User) {
                        $role = Role::where('name','Operateur')->first();
                        $magasinier = Role::where('name','Magasinier')->first();
                        $operators = User::query()
                            ->whereNotNull('author_id')
                            ->orderBy('id','DESC')
                            ->whereNotNull('roles_id')
                            ->get();
                        $opera = $operators->pluck('id');
                        $admin_member = $user;
                        return view('admin_operation.listeoperators',compact('operators','admin_member'));
                    }else return redirect('login');
                }
            }
        }else return redirect('login');
    }

    

    //Magasinier
   
    public function magasinierCheck()
    {
        if(Auth::check()){
            $user = auth()->user();
            if ($user->getRole?->name === "Magasinier") {
                return $user;
            }
        }else {
            return redirect("login");
        }
    }

    public function rawmaterial()
    {
        if(Auth::check()){
            $magasinier = $this->magasinierCheck();
            $produits = Produit::get();
            if ($magasinier) {
                return view('inventaire.dash',compact('produits'));
            }

        }
    }


}
