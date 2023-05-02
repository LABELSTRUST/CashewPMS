<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->verifyAdmin();
        if($result){
            $shifts = Shift::get();
            return view('admin.shifts',compact('shifts'));
            
        }else return redirect('login');
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
        $user=$this->verifyAdmin();
        if ($user) {
            return view('admin.createshift');
        }return redirect('login'); 
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
                'time_open' => 'required',
                'time_close' => 'required',
            ]);
            
        //'author_id' date_start
            $data = $request->all();
            $exist = Shift::where('title',$data['title'])->first();
            if ($exist) {
                return redirect('admin/shift/create')->with('error',"Ce Shift existe déjà");
            }else {
                $shift = Shift::create([
                    'title' => $data['title'], 
                    'time_open' => $data['time_open'],
                    'time_close' => $data['time_close'],
                ]);
                if ($shift) {
                    return redirect('admin/shift/create')->with('message',"Enregistré avec succès");
                }
            }

        }return redirect('login'); 
    
        }else return redirect('login');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function show(Shift $shift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function edit(Shift $shift)
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                return view('admin.createshift',compact('shift'));

            }return redirect('login'); 
    
        }else return redirect('login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shift $shift)
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                    
                $request->validate([
                    'title' => 'required',
                    'time_open' => 'required',
                    'time_close' => 'required',
                ]);
                
                $data = $request->all();

                $update = $shift->update([
                    'title' => $data['title'], 
                    'time_open' => $data['time_open'],
                    'time_close' => $data['time_close'],
                ]);
                
                if ($update) {
                    return redirect()->route('shift.edit',[$shift->id])->with('message',"Modifier avec succès");
                }else return redirect()->route('shift.edit',[$shift->id])->with('error',"Une erreur s'est produite");

            }else return redirect('login');
    
        }else return redirect('login');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shift $shift)
    {
        if( Auth::check()){
            $user=$this->verifyAdmin();
            if ($user) {
                
                $result = $shift->delete();
        
                return redirect()->route('shift.index')->with('message','Supprimer avec succès');
            }else return redirect('login');
        }else return redirect('login');
    }
}
