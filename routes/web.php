<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LigneController;
use App\Http\Controllers\PosteController;
use App\Http\Controllers\AssignerController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\SequenceController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('welcome');
    return view('auth.login');
});



Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard'); 
Route::get('login', [AuthController::class, 'index'])->name('auth.login');// la page login
Route::post('login/user', [AuthController::class, 'Login'])->name('login.log'); // action login
Route::get('registration', [AuthController::class, 'registration'])->name('reg.registration');// la page register
Route::post('registration/user', [AuthController::class, 'Register'])->name('auth.registration'); // action du formulaire
Route::get('signout', [AuthController::class, 'signOut'])->name('signout');

//Création des opérateur par l'administrateur

Route::get('admin/create/operator', [AuthController::class, 'createOperator'])->name('create.operator');
Route::post('admin/create/operators', [AuthController::class, 'insertOperator'])->name('operateur.register');
Route::get('admin/operators', [AuthController::class, 'listOperateur'])->name('operateur.list');


// Admin  Lignes 

Route::get('/admin/lignes', [LigneController::class, 'index'])->name('ligne.index');
Route::get('/admin/ligne/create', [LigneController::class, 'create'])->name('ligne.create');
Route::post('/admin/ligne', [LigneController::class, 'store'])->name('ligne.store');

//Admin produit
Route::get('/admin/produits', [ProduitController::class, 'index'])->name('produit.index');
Route::get('/admin/produit/create', [ProduitController::class, 'create'])->name('produit.create');
Route::post('/admin/produit', [ProduitController::class, 'store'])->name('produit.store');


Route::get('/admin/postes', [PosteController::class, 'index'])->name('poste.index');
Route::get('/admin/poste/create', [PosteController::class, 'create'])->name('poste.create');
Route::post('/admin/poste', [PosteController::class, 'store'])->name('poste.store');
Route::get('/admin/poste/operateurs/{id}', [PosteController::class, 'listeOperator'])->name('poste.operateors');


// Admin Assignation

Route::get('/admin/assigers', [AssignerController::class, 'index'])->name('assiger.index');
Route::get('/admin/assiger/create', [AssignerController::class, 'create'])->name('assigner.create');
Route::get('/admin/assiger/create/{id}', [AssignerController::class, 'create'])->name('assiger.create');
Route::post('/admin/assiger', [AssignerController::class, 'store'])->name('assigner.store');


// Admin Shifts

Route::get('/admin/shifts', [ShiftController::class, 'index'])->name('shift.index');
Route::get('/admin/shift/create', [ShiftController::class, 'create'])->name('shift.create');
Route::post('/admin/shift', [ShiftController::class, 'store'])->name('shift.store');



//Admin production
Route::get('/admin/productions', [ProductionController::class, 'index'])->name('production.index');
Route::get('/admin/production/create', [ProductionController::class, 'create'])->name('production.create');
Route::get('/admin/production/create/{id}', [ProductionController::class, 'create'])->name('produit.production');
Route::post('/admin/production', [ProductionController::class, 'store'])->name('production.store');


//Admin Client

Route::get('/admin/clients', [ClientController::class, 'index'])->name('client.index');
Route::get('/admin/client/create', [ClientController::class, 'create'])->name('client.create');
Route::post('/admin/client', [ClientController::class, 'store'])->name('client.store');

//Admin commande

Route::get('/admin/commandes', [CommandeController::class, 'index'])->name('commande.index');
Route::get('/admin/commande/create', [CommandeController::class, 'create'])->name('commande.create');
Route::get('/admin/commande/create/{client}', [CommandeController::class, 'create'])->name('commande.create');
Route::post('/admin/commande', [CommandeController::class, 'store'])->name('commande.store');


//Planning 


Route::get('/admin/plannings', [PlanningController::class, 'index'])->name('planning.index');
Route::get('/admin/planning/create/', [PlanningController::class, 'create'])->name('plannings.create');
Route::get('/admin/planning/edit/{planning}', [PlanningController::class, 'edit'])->name('planning.edit');
Route::post('/admin/planning', [PlanningController::class, 'store'])->name('planning.store');
Route::get('/admin/planning/sequence/{sequence_plan}', [PlanningController::class, 'sequenceadd'])->name('planning.sequenceadd');
Route::put('/admin/planning/add/sequence/{sequence_plan}', [PlanningController::class, 'addsequence'])->name('planning.addsequence');
Route::put('/admin/planning/update/{planning}', [PlanningController::class, 'update'])->name('planning.update');

//Admin séquence


Route::get('/admin/sequences', [SequenceController::class, 'index'])->name('sequence.index');
Route::get('/admin/sequence/create/', [SequenceController::class, 'create'])->name('sequence.create');
Route::post('/admin/sequence', [SequenceController::class, 'store'])->name('sequence.store');
Route::get('/admin/sequence/edit/{sequence}', [SequenceController::class, 'edit'])->name('sequence.edit');
Route::post('/admin/sequence/update/{sequence}', [SequenceController::class, 'update'])->name('sequence.update');


//admin/planning/create//