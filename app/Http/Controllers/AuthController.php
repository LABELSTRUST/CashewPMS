<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Assigner;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }

    
    public function Login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                        ->withSuccess('Signed in');
        }
  
        return redirect("login")->withSuccess('Login details are not valid');
    }

    public function registration()
    {
        return view('auth.register');
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
        $this->adminCheck();

        $roles = Role::get();
        if ($roles) {
            return view('admin.createoperator', compact('roles'));
        }
    }

    public function adminCheck()
    {
        if(Auth::check()){
            $user = auth()->user();
            if ($user->getRole->name === "Admin" || $user->getRole->name === "Superadmin" ) {
                return $user;
            }
        }else {
            return redirect("login");
        }
    }

    public function insertOperator(Request $request)
    {
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
            
            $check = $this->create($data,$user->id);
            if ($check) {
                return redirect('admin/create/operator')->with('message','Enregistré avec succès');
            }else {
                return redirect('admin/create/operator')->with('error',"Un champ est mal renseigné");
            }
            
        }
    }

    public function listOperateur()
    {
        $user = $this->adminCheck();
        if ($user) {
            $operators = User::query()
                ->whereNotNull('author_id')
                ->get();
            $opera = $operators->pluck('id');
           
            //$operators1 = Assigner::whereIn('user_id',$opera)->get();'operators1'

            return view('admin.listoperator',compact('operators'));
        }
    }

}
