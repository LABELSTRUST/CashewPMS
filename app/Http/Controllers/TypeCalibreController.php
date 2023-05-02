<?php

namespace App\Http\Controllers;

use App\Models\Calibreuse;
use App\Models\TypeCalibre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TypeCalibreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_calibrage = 1;
                $calibres = TypeCalibre::orderBy('id','DESC')->paginate(20);
                return view('calibrage.listetypecallibre',compact('calibres','etape_calibrage'));
            }else return redirect('login');
        }else return redirect('login');
    }

    
    public function graderindex()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_calibrage = 1;
                $calibres = Calibreuse::orderBy('id','DESC')->paginate(20);
                return view('calibrage.listecalibreuse',compact('calibres','etape_calibrage'));
            }else return redirect('login');
        }else return redirect('login');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_calibrage = 1;
                return view('calibrage.createtype',compact('etape_calibrage'));
            }else return redirect('login');
        }else return redirect('login');

    }

    public function creategrader()
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_calibrage = 1;
                return view('calibrage.creategrader',compact('etape_calibrage'));
            }else return redirect('login');
        }else return redirect('login');
    }

    public function storegrader(Request $request)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $validator = Validator::make($request->all(), [
                    'designation' => 'required',
                ]);
                //dd($request->all());
                if ($validator->fails()) {
                    return redirect()->route('calibrage.gradercreate')->withErrors($validator)->withInput();
                }
                $data = $request->all();
                $column = 3;
                $code = $this->genarateCode($column,Calibreuse::class,'code_calibreuse');

                $calibre = Calibreuse::create([
                    'code_calibreuse'=>$code,
                    'designation'=>$data['designation']
                ]);
               if ($calibre) {
                    return redirect()->route('calibrage.gradercreate')->with('message',"Enregistrer avec succès");
               }return redirect()->route('calibrage.gradercreate')->with('error',"Une erreur s'est produite");
            }else return redirect('login');
        }else return redirect('login');
    }

    public function editgrader(Calibreuse $grader)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_calibrage = 1;
                return view('calibrage.creategrader',compact('grader','etape_calibrage'));
            }else return redirect('login');
        }else return redirect('login');
    }

    public function updategrader(Request $request, Calibreuse $grader)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $request->validate([
                    'designation' => 'required',
                ]);
                $data = $request->all();
                $update = $grader->update([
                    'designation'=>$data['designation']
                ]);
                if ($update) {
                    return redirect()->route('calibrage.graderedit',$grader->id)->with('message',"Modifier avec succès");
                }else {
                    return redirect()->route('calibrage.graderedit',$grader->id)->with('error','Une erreur s\'est produite');
                }

            }else return redirect('login');
        }else return redirect('login');
    }

    
    public function verifyOperator()
    {
        $magasinier = app(AuthController::class);
        $result = $magasinier->operatorCheck();
        return  $result;
    }

    
    public function genarateCode($column = null, $table,$attribut)
    {
        if ($column != null) {
            $length = $column;
        }else $length = 2;
		
		// Initialisation des caractères utilisables
		$characters = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
		$key_password = array_rand($characters, $length);

		for ($i = 0; $i < $length; $i++) {
			$password_tab[] = $characters[$key_password[$i]];
		}

		$generated_code = strtoupper(implode("", $password_tab));

        
        $existingCode = $table::where($attribut, $generated_code)->first();
        while ($existingCode) {
            $generated_code = $this->genarateCode($length,$table,$attribut);
            $existingCode = $table::where($attribut, $generated_code)->first();
        }

		return $generated_code;
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
            $user=$this->verifyOperator();
            if ($user) {
                $validator = Validator::make($request->all(), [
                    'designation' => 'required',
                    'code_calibre'=> 'required',
                ]);
                //dd($request->all());
                if ($validator->fails()) {
                    return redirect()->route('calibrage.create')->withErrors($validator)->withInput();
                }
                $data = $request->all();
                $existe = TypeCalibre::where('code_calibre',$data['code_calibre'])->first();
                if ($existe) {
                    return redirect()->route('calibrage.create')->with('error',"Ce code existe déjà");
                }
                /* $column = 2;
                $code = $this->genarateCode($column,TypeCalibre::class,'code_calibre'); */
                $code = strtoupper($data['code_calibre']);
                $calibre = TypeCalibre::create([
                    'code_calibre'=>$code,
                    'designation'=>$data['designation']
                ]);
               if ($calibre) {
                   return redirect()->route('calibrage.create')->with('message',"Enregistrer avec succès");
               }else return redirect()->route('calibrage.create')->with('error',"Une erreur s'est produite");
            }else return redirect('login');
        }else return redirect('login');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TypeCalibre  $typeCalibre
     * @return \Illuminate\Http\Response
     */
    public function show(TypeCalibre $typeCalibre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TypeCalibre  $typeCalibre
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeCalibre $typeCalibre)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $etape_calibrage = 1;
                return view('calibrage.createtype',compact('typeCalibre','etape_calibrage'));
            }else return redirect('login');
        }else return redirect('login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TypeCalibre  $typeCalibre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeCalibre $typeCalibre)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                $request->validate([
                    'designation' => 'required',
                ]);
                $data = $request->all();
                $update = $typeCalibre->update([
                    'designation'=>$data['designation']
                ]);
                if ($update) {
                    return redirect()->route('calibrage.edit',$typeCalibre->id)->with('message',"Modifier avec succès");
                }else {
                    return redirect()->route('calibrage.edit',$typeCalibre->id)->with('error','Une erreur s\'est produite');
                }

            }else return redirect('login');
        }else return redirect('login');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeCalibre  $typeCalibre
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeCalibre $typeCalibre)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                
                $result = $typeCalibre->delete();
        
                return redirect()->route('calibrage.listetype')->with('message','Supprimer avec succès');
            }else return redirect('login');
        }else return redirect('login');
    }

    public function deletegrader(Calibreuse $grader)
    {
        if( Auth::check()){
            $user=$this->verifyOperator();
            if ($user) {
                
                $result = $grader->delete();
        
                return redirect()->route('calibrage.graderindex')->with('message','Supprimer avec succès');
            }else return redirect('login');
        }else return redirect('login');
    }
}
