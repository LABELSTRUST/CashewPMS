<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( Auth::check()){
            $user = $this->verifyOperator();
            if($user){
                $grades = Grade::get();
                $etape_classification = 1;
                return view('classification.grades',compact('grades','etape_classification'));
                
            }else return redirect('login');
            
        }else return redirect('login');
    }

    
    public function verifyOperator()
    {
        $magasinier = app(AuthController::class);
        $result = $magasinier->operatorCheck();
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
            $user = $this->verifyOperator();
            if($user){
                $etape_classification = 1;

                return view('classification.creategrade',compact('etape_classification'));
            }else return redirect('login');
        }else return redirect('login');
    }

    
    public function codeGrade($code = null)
    {
        DB::beginTransaction();
    
        try {
            $lastCode = Grade::select('code')
                ->where('code', 'like', 'PG%')
                ->orderByDesc('code')
                ->lockForUpdate()
                ->first();
    
            if ($lastCode) {
                $lastNumber = intval(preg_replace('/\D/', '', $lastCode->code)) + 1;
            } else {
                $lastNumber = 1;
            }
    
            $newCode = 'PG' . str_pad($lastNumber, 3, '0', STR_PAD_LEFT);
    
            DB::commit();
    
            return $newCode;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
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
        if (Auth::check()) {
            $user = $this->verifyOperator();
            if ($user) {
                $request->validate([
                    'designation' => 'required',
                ]);
    
                $data = $request->all();
                $data['code'] = $this->codeGrade();
    
                $produit = Grade::create($data);
    
                if ($produit) {
                    return redirect()->route('classification.creategrade')->with('message', "Enregistré avec succès");
                } else {
                    return redirect()->route('classification.creategrade')->with('error', "Une erreur est survenue");
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
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function show(Grade $grade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function edit(Grade $grade)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_classification = 1;
                
                return view('classification.creategrade',compact('etape_classification','grade'));
            }else return redirect('login');
        }else return redirect('login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grade $grade)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $request->validate([
                    'designation' => 'required',
                ]);
                $data = $request->all();
                $update = $grade->update([
                    'designation'=>$data['designation']
                ]);
                if ($update) {
                    return redirect()->route('classification.editgrade',$grade->id)->with('message',"Modifier avec succès");
                }else {
                    return redirect()->route('classification.editgrade',$grade->id)->with('error','Une erreur s\'est produite');
                }

            }else return redirect('login');
        }else return redirect('login');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grade $grade)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                
                $result = $grade->delete();
        
                return redirect()->route('classification.grades')->with('message','Supprimer avec succès');
            }else return redirect('login');
        }else return redirect('login');
    }
}
