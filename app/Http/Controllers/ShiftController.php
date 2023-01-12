<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

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
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shift $shift)
    {
        //
    }
}
