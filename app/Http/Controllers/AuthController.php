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

    /**{!! Form::open(['route' => 'users.store', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
        {!! Form::label('avatar', 'Avatar') !!}
        {!! Form::file('avatar', ['class' => 'form-control']) !!}
    </div>
    <!-- autres champs du formulaire ici -->
    {!! Form::submit('Ajouter utilisateur', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}

    $avatar = $request->file('avatar');
    $filename = time() . '.' . $avatar->getClientOriginalExtension();
    $path = public_path('avatars/' . $filename);
    Image::make($avatar)->resize(300, 300)->save($path);

 */

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
                            'user_id'=>$admin_gene->id
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
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();

        $admin =  Role::where('name','Admin')->first();
        
        if ($admin) {
            $data['roles_id'] =  $admin->id;
            
            $check = $this->create($data);
            if ($check) {
                return redirect("dashboard")->with('message'," Bienvenu");
            }
            
        }else {
            return redirect('registration')->with('error',"Un champ est mal renseigné");
        }

         
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
            $user = $this->adminCheck();
            
            if ($user) {
                $roles = Role::get();
                if ($roles) {
                    return view('admin.createoperator', compact('roles'));
                }
            }else return redirect("login");

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
            
                //$operators1 = Assigner::whereIn('user_id',$opera)->get();'operators1'dd($operators);

                return view('admin.listoperator',compact('operators'));
            }return redirect('login');
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
