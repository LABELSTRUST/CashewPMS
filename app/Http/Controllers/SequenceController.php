<?php

namespace App\Http\Controllers;

use App\Models\Planning;
use App\Models\Sequence;
use Illuminate\Http\Request;

class SequenceController extends Controller
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
            $sequences = Sequence::get();
            return view('admin.sequences',compact('sequences'));
            
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
    { $user=$this->verifyAdmin();
        if ($user) {
            $plannings = Planning::get();
            return view('admin.createsequence', compact('plannings'));
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
                'quantity' => 'required',
                'date_start' => 'required',
                'date_end' => 'required',
                'quantity_do'=> 'required',
            ]);
            $data = $request->all();
            $sequence = Sequence::create([
                'quantity' => $data['quantity'], 
                'date_start' => $data['date_start'],
                'date_end' => $data['date_end'],
                'quantity_do'=> $data['quantity_do'],
                //'date_start'=> date_create('now')->format('Y-m-d H:i:s'),
            ]);
            if ($sequence) {
                return redirect('admin/sequence/create')->with('message',"Enregistré avec succès");
            }else return redirect('admin/sequence/create')->with('error',"Une erreur s'est produite");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sequence  $sequence
     * @return \Illuminate\Http\Response
     */
    public function show(Sequence $sequence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sequence  $sequence
     * @return \Illuminate\Http\Response
     */
    public function edit(Sequence $sequence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sequence  $sequence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sequence $sequence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sequence  $sequence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sequence $sequence)
    {
        //
    }
}
