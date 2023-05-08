<?php

namespace App\Http\Controllers;


use toastr;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Ligne;
use App\Models\Poste;
use App\Models\Shift;
use App\Models\Assigner;
use App\Models\Sequence;
use App\Models\Attribution;
use App\Models\Posteproduit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\NodeVisitor\FirstFindingVisitor;

class AssignerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $result = $this->verifyAdmin();
            if ($result) {
                $assigners = Assigner::get();
                $sequences = Sequence::orderBy('id', 'DESC')->paginate(10);

                $carbon = Carbon::setLocale('fr');

                return view('admin.assigner', compact('sequences', 'carbon'));
            } else return redirect('login');
        } else return redirect('login');
    }

    /**
     * Show the form for creating a new resource.
     *@param App\Models\User $operator
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {

        if (Auth::check()) {
            $user = $this->verifyAdmin();
            if ($user) {
                $the_operator = $id;
                $role = Role::where('name', 'Operateur')->first();
                $operators = User::query()
                    ->whereNotNull('author_id')
                    ->where('roles_id', $role->id)
                    ->get();
                if ($operators) {
                    $lignes = Ligne::get();
                    if ($lignes) {
                        $postes = Poste::get();
                        if ($postes) {
                            $shifts = Shift::get();
                            return view('admin.createassigner', compact('operators', 'lignes', 'postes', 'shifts', 'the_operator'));
                        }
                    }
                }
            }
            return redirect('login');
        } else return redirect('login');
    }


    public function verifyAdmin()
    {
        $admin = app(AuthController::class);
        $result = $admin->adminCheck();
        return  $result;
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,)
    {

        if (Auth::check()) {
            $user = $this->verifyAdmin();
            if ($user) {
                $request->validate([
                    'poste_id' => 'required',
                    'ligne_id' => 'required',
                    'user_id' => 'required',
                    'date_end' => 'required',
                    'shift_id' => 'required',
                ]);

                //'author_id' date_start
                $data = $request->all();


                /*$exist = Assigner::where('user_id',$data['user_id'])->
                            where('ligne_id',$data['ligne_id'])->
                            where('poste_id',$data['poste_id'])->first();
                if ($exist) {
                    return redirect('admin/assiger/create')->with('error',"Ce poste est assigner existe déjà");
                }else {*/
                $assigner = Assigner::create([
                    'poste_id' => $data['poste_id'],
                    'ligne_id' => $data['ligne_id'],
                    'user_id' => $data['user_id'],
                    'date_end' => $data['date_end'],
                    'shift_id' => $data['shift_id'],
                    'author_id' => $user->id,
                    'date_start' => date_create('now')->format('Y-m-d H:i:s'),
                ]);
                if ($assigner) {
                    $update_statuts = User::find($data['user_id']);
                    if ($update_statuts) {
                        $update_statuts->update([
                            'affected' => True,
                        ]);
                        if ($update_statuts) {
                            return redirect('admin/assiger/create')->with('message', "Enregistré avec succès");
                        } else  return redirect('admin/assiger/create')->with('error', "Une erreur s'est produite");
                    }
                }
                //}

            }
            return redirect('login');
        } else return redirect('login');
    }


    public function assignerPoste($sequence_id)
    {
        if (Auth::check()) {
            $user = $this->verifyAdmin();
            if ($user) {
                /* $postes = Poste::get();
                $reception_id = Poste::where('title','Réception')->pluck('id');
                $receptions = Attribution::where('poste_id',$reception_id)->get();
                //dd($receptions);

                $depelliculage_id = Poste::where('title','Dépelliculage')->pluck('id');
                $depelliculages = Attribution::where('poste_id',$depelliculage_id)->get();
                
                $cuisson_id = Poste::where('title','Cuisson')->pluck('id');
                $cuissons = Attribution::where('poste_id',$cuisson_id)->get();
                
                $calibrage_id = Poste::where('title','Calibrage')->pluck('id');
                $calibrages = Attribution::where('poste_id',$calibrage_id)->get();
                
                $fragilisation_id = Poste::where('title','Fragilisation')->pluck('id');
                $fragilisations = Attribution::where('poste_id',$fragilisation_id)->get();
                
                $refroidissement_id = Poste::where('title','Refroidissement')->pluck('id');
                $refroidissements = Attribution::where('poste_id',$refroidissement_id)->get();
                
                $decorticage_id = Poste::where('title','Décorticage')->pluck('id');
                $decorticages = Attribution::where('poste_id',$decorticage_id)->get();
                
                $sechage_id = Poste::where('title','Séchage')->pluck('id');
                $sechages = Attribution::where('poste_id',$sechage_id)->get();
                
                $classification_id = Poste::where('title','Classification')->pluck('id');
                $classifications = Attribution::where('poste_id',$classification_id)->get();
                
                $conditionnement_id = Poste::where('title','Conditionnement')->pluck('id');
                $conditionnements = Attribution::where('poste_id',$conditionnement_id)->get();
                
                $stockage_id = Poste::where('title','Stockage')->pluck('id');
                $stockages = Attribution::where('poste_id',$stockage_id)->get();*/

                $sequence = Sequence::where('id', $sequence_id)->first();


                //  $posteproduits =Posteproduit::where('produit_id',$sequence->getObjectif?->getProduit->id)->get();/* */
                //  dd($posteproduits);
                $posteproduits = Posteproduit::select('poste_id')
                    ->distinct()
                    ->where('produit_id', $sequence->getObjectif?->getProduit->id)
                    ->get();
                // dd($posteproduits);

                //$posteproduit_ids = Posteproduit::where('produit_id',$sequence->getObjectif?->getProduit->id)->pluck('poste_id');

                /* $assigners = Assigner::where('shift_id',$sequence->shift_id)->get();
                dd($assigners); */
                $the_postes = Attribution::whereIn('poste_id', $posteproduits)->get();
                //    dd($the_postes);

                /*
                dd($the_postes);$the_postes = Poste::whereIn('id',$posteproduits)->with('users')->get();
                $the_postes = Attribution::join('posteproduits', 'attributions.poste_id', '=', 'posteproduits.poste_id')
                 ->where('posteproduits.produit_id', $sequence->getObjectif?->getProduit->id)
                 ->select('attributions.*')->distinct()->get();

                dd($posteproduits);
                */

                //On contôle si c'est une assignation  a été créée à la date du jour
                $assignersnow = Assigner::where('sequence_id', $sequence->id)->whereIn('poste_id', $posteproduits)->get();
                $assigners = Assigner::where('sequence_id', $sequence->id)->get();




                    // $assigners1 = Assigner::find($id);
                    // $seqy=$assigners1->sequence_id;
                    // $sequence1 = Sequence::where('id', $seqy)->first();
                    // $posteproduits1 = Posteproduit::select('poste_id')
                    //                     ->distinct()
                    //                     ->where('produit_id', $sequence1->getObjectif?->getProduit->id)
                    //                     ->get();
                    // $the_postes1 = Attribution::whereIn('poste_id', $posteproduits1)->get();



                //dd($assigners);
                // dd($posteproduits);
                return view('admin.assignerposte', compact(
                    'assigners',
                    'assignersnow',
                    'sequence_id',
                    'sequence',
                    'the_postes',
                    'posteproduits'
                ));
            } else return redirect('login');
        } else return redirect('login');
    }

    public function editt($id)
    {


        if (Auth::check()) {
            $user = $this->verifyAdmin();
            if ($user) {

                $assigners = Assigner::find($id);
                //dd($assigners);
                $seqy=$assigners->sequence_id;
                $sequence = Sequence::where('id', $seqy)->first();

                $posteproduits = Posteproduit::select('poste_id')
                    ->distinct()
                    ->where('produit_id', $sequence->getObjectif?->getProduit->id)
                    ->get();
                // dd($posteproduits);

                //$posteproduit_ids = Posteproduit::where('produit_id',$sequence->getObjectif?->getProduit->id)->pluck('poste_id');

                $the_postes = Attribution::whereIn('poste_id', $posteproduits)->get();


               // $assigners = Assigner::where('sequence_id', $sequence->id)->get();

                
                
                return view('admin.assignerposteedit', compact('assigners', 'the_postes'));
            } else return redirect('login');
        } else return redirect('login');

       
        
     
    }

    public function reconduire($sequence)
    {
        if (Auth::check()) {
            $user = $this->verifyAdmin();
            if ($user) { /**/
                $sequence = Sequence::find($sequence);
                $exist = Assigner::where('sequence_id', $sequence->id)->get();
                if ($exist->isNotEmpty()) {
                    return redirect()->route('assigner.assignerposte', [$sequence->id])->with('error', "Cette séquence a déjà des opérateurs assignés");
                }
                $assigner = Assigner::where('shift_id', $sequence->shift_id)
                    ->whereDate('created_at', Carbon::yesterday())
                    ->latest('created_at')
                    ->get();

                if ($assigner->isEmpty()) {
                    return redirect()->route('assigner.assignerposte', [$sequence->id])->with('error', "Ce shift n'a pas été utilisé dans les dernières 24 H");
                }

                $new_assigner = "";
                foreach ($assigner as $key) {

                    $new_assigner = new Assigner();
                    $new_assigner->poste_id = $key['poste_id'];
                    $new_assigner->user_id =  $key['user_id'];
                    $new_assigner->sequence_id = $sequence->id;
                    $new_assigner->ligne_id = $sequence->getLigne->id;
                    $new_assigner->shift_id = $sequence->getShift->id;
                    $new_assigner->author_id = $user->id;
                    $new_assigner->save();
                }



                /* 
                    $origin = new OrigineProd();
                    foreach ($data as $column => $value) {
                        if($column != '_token'){
                            $origin->$column = $value;
                        }
                    }
                    $origin->save();
                        'poste_id'=>$poste->id,
                        'user_id'=>$data['user_id'],
                        'sequence_id'=>$sequence_id,
                        'ligne_id' => $sequence->ligne_id,
                        'shift_id' => $sequence->shift_id,
                        'author_id'=> $user->id
                $startOfWeek = Carbon::now()->startOfWeek();
                $endOfWeek = Carbon::now()->endOfWeek();
                $assigner = Assigner::where('shift_id',$sequence->shift_id)
                            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                            ->latest('created_at')
                            ->get(); */
                if ($new_assigner) {
                    return redirect()->route('assigner.assignerposte', [$sequence->id])->with('message', "Les opérateurs ont été reconduis");
                } else return redirect()->route('assigner.assignerposte', [$sequence->id])->with('error', "Une erreur s'est produite");
            } else return redirect('login');
        } else return redirect('login');
    }

    public function assignerPostecreate(Request $request, $sequence_id)
    {
        if (Auth::check()) {
            $user = $this->verifyAdmin();
            if ($user) {

                $request->validate([
                    'poste' => 'required',
                    'user_id' => 'required',
                ]);
                $data = $request->all();

                $poste = Poste::where('title', $data['poste'])->first();
                if ($poste) {
                    $today =  Carbon::today();

                    //On contôle si la séquence a été créée à la date du jour
                    $sequence = Sequence::where('id', $sequence_id)->whereDate('created_at', $today)->first();

                    if ($sequence) {
                        $operateur_exist = Assigner::where('user_id', $data['user_id'])->where('sequence_id', $sequence_id)
                            ->where('poste_id', $poste->id)
                            ->first();
                        if ($operateur_exist) {
                            return redirect()->route('assigner.assignerposte', [$sequence_id])->with('error', "L'opérateur a occupe déjà ce poste ");
                        }
                        $assigner = Assigner::create([
                            'poste_id' => $poste->id,
                            'user_id' => $data['user_id'],
                            'sequence_id' => $sequence_id,
                            'ligne_id' => $sequence->ligne_id,
                            'shift_id' => $sequence->shift_id,
                            'author_id' => $user->id

                        ]);

                        if ($assigner) {

                            $operateur = User::find($data['user_id']);
                            $update = $operateur->update([
                                'affected' => True,
                            ]);



                            toastr()->success('Enregistrer avec succès!', 'Félicitation');
                            return redirect()->back();

                            //return redirect()->route('assigner.assignerposte', [$sequence_id]);

                            // return redirect()->route('assigner.assignerposte', [$sequence_id])->with('message',"Enregistrer avec succès");
                        } else return redirect()->route('assigner.assignerposte', [$sequence_id])->with('error', "L'assignation a rencontré un problème");
                    } else {
                        return redirect()->route('assigner.assignerposte', [$sequence_id])->with('error', "Cette séquence est antérieure à la date du jour");
                    }
                }
            } else return redirect('login');
        } else return redirect('login');
    }


    public function liste_operateur_assigner($sequence)
    {
        if (Auth::check()) {
            $user = $this->verifyAdmin();
            if ($user) {
                $sequence = Sequence::where('id', $sequence)->first();

                $posteproduits = Posteproduit::select('poste_id')
                    ->distinct()
                    ->where('produit_id', $sequence->getObjectif?->getProduit->id)
                    ->get();
                // dd($posteproduits);

                //$posteproduit_ids = Posteproduit::where('produit_id',$sequence->getObjectif?->getProduit->id)->pluck('poste_id');

                $the_postes = Attribution::whereIn('poste_id', $posteproduits)->get();


                $assigners = Assigner::where('sequence_id', $sequence->id)->get();
                //dd($assigners);
                return view('planning.listeoperateur', compact('assigners', 'the_postes'));
            } else return redirect('login');
        } else return redirect('login');
    }

    public function update_operateur(Request $request, Assigner $assigner)
    {
        if (Auth::check()) {
            $user = $this->verifyAdmin();
            if ($user) {
                $request->validate([
                    'user_id' => 'required',
                ]);
                $data = $request->all();

                $update = $assigner->update([
                    'user_id' => $data['user_id'],
                    'author_id' => $user->id
                ]);

                if ($update) {
                    $operateur = User::find($data['user_id']);
                    $update = $operateur->update([
                        'affected' => True,
                    ]);
                    $sequence = Sequence::where('id', $assigner->sequence_id)->first();

                    $posteproduits = Posteproduit::select('poste_id')
                        ->distinct()
                        ->where('produit_id', $sequence->getObjectif?->getProduit->id)
                        ->get();

                    $the_postes = Attribution::whereIn('poste_id', $posteproduits)->get();


                    $assigners = Assigner::where('sequence_id', $sequence->id)->get();
                    if ($posteproduits) {
                        session()->flash('message', 'Modifier avec succès');
                        return view('planning.listeoperateur', compact('assigners', 'the_postes'));
                    } else {
                        session()->flash('erreor', 'Une erreur s\'est produite');
                        return view('planning.listeoperateur', compact('assigners', 'the_postes'));
                    }
                }
            } else return redirect('login');
        } else return redirect('login');
    }

    public function update_operateur_on(Request $request, Assigner $assigner)
    {
        if (Auth::check()) {
            $user = $this->verifyAdmin();
            if ($user) {
                $request->validate([
                    'user_id' => 'required',
                ]);
                $data = $request->all();

                $update = $assigner->update([
                    'user_id' => $data['user_id'],
                    'author_id' => $user->id
                ]);

                if ($update) {
                    $operateur = User::find($data['user_id']);
                    $update = $operateur->update([
                        'affected' => True,
                    ]);
                    $sequence = Sequence::where('id', $assigner->sequence_id)->first();

                    $posteproduits = Posteproduit::select('poste_id')
                        ->distinct()
                        ->where('produit_id', $sequence->getObjectif?->getProduit->id)
                        ->get();

                    $the_postes = Attribution::whereIn('poste_id', $posteproduits)->get();


                    $assigners = Assigner::where('sequence_id', $sequence->id)->get();
                    if ($posteproduits) {
                        toastr()->success('Modifier avec succès!', 'Notification');
                        //return redirect()->back();
                        return redirect()->route('assigner.assignerposte', [$sequence->id]);
                       // return view('admin.assignerposte', compact('assigners', 'the_postes'));
                    } else {
                        toastr()->error('Une erreur s\'est produite!', 'Erreur');
                        //session()->flash('erreor', 'Une erreur s\'est produite');
                        //return view('planning.listeoperateur', compact('assigners', 'the_postes'));
                        return redirect()->back();
                    }
                }
            } else return redirect('login');
        } else return redirect('login');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assigner  $assigner
     * @return \Illuminate\Http\Response
     */
    public function show(Assigner $assigner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assigner  $assigner
     * @return \Illuminate\Http\Response
     */
    public function edit(Assigner $assigner)
    {

        if (Auth::check()) {
            $user = $this->verifyAdmin();
            if ($user) {
            }
            return redirect('login');
        } else return redirect('login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assigner  $assigner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assigner $assigner)
    {
        if (Auth::check()) {
            $user = $this->verifyAdmin();
            if ($user) {
                $request->validate([
                    'poste' => 'required',
                    'user_id' => 'required',
                ]);
                $data = $request->all();

                $poste = Poste::where('title', $data['poste'])->first();
                if ($poste) {


                    $update = $assigner->update([
                        'poste_id' => $poste->id,
                        'user_id' => $data['user_id'],

                    ]);

                    if ($update) {

                        $operateur = User::find($data['user_id']);
                        $update = $operateur->update([
                            'affected' => True,
                        ]);

                        return redirect()->route('assigner.assignerposte', [$assigner->getSequence->id])->with('message', "Enregistrer avec succès");
                    } else return redirect()->route('assigner.assignerposte',)->with('error', "L'assignation a rencontré un problème");
                }
            }
            return redirect('login');
        } else return redirect('login');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assigner  $assigner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assigner $assigner)
    {
        //
    }
}
