<?php

namespace App\Http\Controllers;

use App\Models\Admin_Role;
use App\Models\General_admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Admin_RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( Auth::check()){
            $user=$this->verifyAdminGeneral();
            if ($user) {
                $general_admin = General_admin::where('user_id',$user->id)->first();
                $roles = Admin_Role::orderBy('id','DESC')->paginate(20);

                return view('admin_role.index',compact('roles','general_admin'));
                
            }else return redirect('login');
            
        }else return redirect('login');
    }
    
    public function verifyAdminGeneral()
    {
        $magasinier = app(AuthController::class);
        $result = $magasinier->verifyAdminGeneral();
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
            $user=$this->verifyAdminGeneral();
            if ($user) {
                $general_admin = General_admin::where('user_id',$user->id)->first();
              

                return view('admin_role.create',compact('general_admin'));
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
        if (Auth::check()) {
            $user = $this->verifyAdminGeneral();
            if ($user) {
                $general_admin = General_admin::where('user_id',$user->id)->first();
                $request->validate([
                    'designation' => 'required',
                ]);
    
                $data = $request->all();
                $exist = Admin_Role::where('designation',$data['designation'])->first();
                if ($exist) {
                    return redirect()->route('admin_role.create')->with('error', "Ce poste existe déjà");
                }
    
                $role = Admin_Role::create($data);
    
                if ($role) {
                    return redirect()->route('admin_role.create')->with('message', "Enregistré avec succès");
                } else {
                    return redirect()->route('admin_role.create')->with('error', "Une erreur est survenue");
                }
            } else {
                return redirect('login');
            }
        } else {
            return redirect('login');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin_Role  $admin_Role
     * @return \Illuminate\Http\Response
     */
    public function show(Admin_Role $admin_Role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin_Role  $admin_Role
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin_Role $admin_Role)
    {
        if( Auth::check()){
            $user = $this->verifyAdminGeneral();
            if ($user) {
                
                $general_admin = General_admin::where('user_id',$user->id)->first();
                
                return view('admin_role.create',compact('general_admin','admin_Role'));
            }else return redirect('login');
        }else return redirect('login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin_Role  $admin_Role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin_Role $admin_Role)
    {
        if( Auth::check()){
            $user=$this->verifyAdminGeneral();
            if ($user) {
                $request->validate([
                    'designation' => 'required',
                ]);
                $data = $request->all();
                $update = $admin_Role->update([
                    'designation'=>$data['designation']
                ]);
                if ($update) {
                    return redirect()->route('admin_role.edit',$admin_Role->id)->with('message',"Modifier avec succès");
                }else {
                    return redirect()->route('admin_role.edit',$admin_Role->id)->with('error','Une erreur s\'est produite');
                }

            }else return redirect('login');
        }else return redirect('login');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin_Role  $admin_Role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin_Role $admin_Role)
    {
        //
    }
}
