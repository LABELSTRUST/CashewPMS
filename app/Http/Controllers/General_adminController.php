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

class General_adminController extends Controller
{

    
    public function verifyAdminGeneral()
    {
        $magasinier = app(AuthController::class);
        $result = $magasinier->verifyAdminGeneral();
        return  $result;
    }

    public function create_operation_Director()
    {
        if( Auth::check()){
            $user=$this->verifyAdminGeneral();
    
            // Vérifier si $user est une instance de User
            if ($user instanceof \App\Models\User) {
               
                $general_admin = General_admin::where('user_id',$user->id)->first();
                if ($general_admin) {
                    $roles = Admin_Role::get();
                   
                    return view('admin_member.create_operation_director',compact('general_admin','roles'));
                }
    
            } else {
                // Rediriger l'utilisateur vers la page de connexion
                return redirect('login');
            }
        } else {
            // Rediriger l'utilisateur vers la page de connexion
            return redirect('login');
        }
    }


    public function store_operation_Director(Request $request)
    {
        if( Auth::check()){
            $user=$this->verifyAdminGeneral();
            if ($user instanceof \App\Models\User) {
                
                $request->validate([
                    'name' => 'required',
                    'roles_id' => 'required',
                    'email' => 'required|email|unique:users',
                    'username' => 'required|unique:users',
                    'password' => 'required|min:6',
                    'avatar' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'title' =>'required'
                ]);
                
                $data = $request->all();
                $exist = User::where('email', $data['email'])->first();
                if ($exist) {
                    return redirect()->route('gene_admin.create_operator')->with('error',"Cet email existe déjà");
                }

                $general_admin = General_admin::where('user_id',$user->id)->first();
                if ($general_admin) {
                    if ($request->hasFile('avatar')) {
                        $avatar = $request->file('avatar');
                        $filename = time() . '.' . $avatar->getClientOriginalExtension();
                        $avatar->storeAs('public/avatars', $filename);
                       /*  if () { */

                       
                            $admin_member = $this->create_operationer($data['name'],$data['email'],$data['username'],$data['password'],$data['roles_id'],$user,$data['title']);
                            if ($admin_member) {
                                
                                $update = $admin_member->update(['avatar'=>$filename]);
                                if ($update) {
                                    return redirect()->route('gene_admin.create_operator')->with('message',"Enregistrer avec succès");
                                }else return redirect()->route('gene_admin.create_operator')->with('error',"Erreur sur l'avatar");
                            }
                        /* }else return redirect()->route('gene_admin.create_operator')->with('error',"Erreur sur l'enregistrement de l'avatar"); */
                    }else {
                        $admin_member = $this->create_operationer($data['name'],$data['email'],$data['username'],$data['password'],$data['roles_id'],$user,$data['title']);
                        if ($admin_member) {
                            return redirect()->route('gene_admin.create_operator')->with('message',"Enregistrer avec succès");
                        }else return redirect()->route('gene_admin.create_operator')->with('error',"Erreur sur l'avatar");
                    }
                }else {
                    $admin_member_connect = Admin_member::where('user_id',$user->id)->first();
                    if ($admin_member_connect) {
                        if ($request->hasFile('avatar')) {
                            $avatar = $request->file('avatar');
                            $filename = time() . '.' . $avatar->getClientOriginalExtension();
                            $avatar->storeAs('public/avatars', $filename);
                            $admin_member = $this->create_operationer($data['name'],$data['email'],$data['username'],$data['password'],$data['roles_id'],$user,$data['title']);
                            if ($admin_member) {
                                $update = $admin_member->update(['avatar'=>$filename]);
                                if ($update) {
                                    return redirect()->route('gene_admin.create_operator')->with('message',"Enregistrer avec succès");
                                }else return redirect()->route('gene_admin.create_operator')->with('error',"Erreur sur l'avatar");
                            }
                        }else {
                            $admin_member = $this->create_operationer($data['name'],$data['email'],$data['username'],$data['password'],$data['roles_id'],$user,$data['title']);
                            if ($admin_member) {
                                return redirect()->route('gene_admin.create_operator')->with('message',"Enregistrer avec succès");
                            }else return redirect()->route('gene_admin.create_operator')->with('error',"Erreur sur l'avatar");
                        }
                    }return back();
                }
            }
        }else return redirect('login');
    }

    public function create_operationer($name,$email,$username,$password,$roles_id,$user,$title)
    {

        $admin_member = User::create([
            'name' => $name,
            'email' => $email,
            'username'=>$username,
            'password' =>$password= Hash::make($password),
            'author_id' =>$user->id
        ]);

        if ($admin_member) {
            $user_role = User_Role::create([
                'user_id'=>$admin_member->id,
                'role_id'=>$roles_id
            ]);
            if ($user_role) {
                $gene_member = Admin_member::create([
                    'user_id'=>$admin_member->id,
                    'title'=>$title
                ]);
                if ($gene_member) {
                    return $admin_member;
                }
            }
        }

    }
    
    
}
