<?php

use App\Http\Controllers\Admin_memberController;
use App\Http\Controllers\Admin_RoleController;
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
use App\Http\Controllers\AttributionController;
use App\Http\Controllers\CalibrageController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\ConditionnementController;
use App\Http\Controllers\CuiseurController;
use App\Http\Controllers\DecorticageController;
use App\Http\Controllers\DepelliculageController;
use App\Http\Controllers\FourController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\FragilisationController;
use App\Http\Controllers\General_adminController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\MatierePremiereController;
use App\Http\Controllers\ObjectifController;
use App\Http\Controllers\OrigineProdConfigController;
use App\Http\Controllers\ReceptionController;
use App\Http\Controllers\RefroidissementController;
use App\Http\Controllers\SechageController;
use App\Http\Controllers\TypeCalibreController;
use App\Models\TypeCalibre;
use Dompdf\Frame;

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
    return view('auth.accueil');
});

Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('admin_dash', [AuthController::class, 'admin_dash'])->name('admin_dash'); 
Route::get('login', [AuthController::class, 'index'])->name('auth.login');// la page login
Route::post('login/user', [AuthController::class, 'Login'])->name('login.log'); // action login
Route::get('registration', [AuthController::class, 'registration'])->name('reg.registration');// la page register
Route::post('registration/user', [AuthController::class, 'Register'])->name('auth.registration'); // action du formulaire
Route::get('signout', [AuthController::class, 'signOut'])->name('signout');


/** Admin général */
Route::get('/general/admin/create', [AuthController::class, 'create_general_admin'])->name('gene_admin.create'); 
Route::post('/general/admin/create', [AuthController::class, 'register_general_admin'])->name('gene_admin.register'); 
Route::get('/general/operation/admin/create', [General_adminController::class, 'create_operation_Director'])->name('gene_admin.create_operator');
Route::post('/general/operation/admin/store', [General_adminController::class, 'store_operation_Director'])->name('gene_admin.store_operator');

/**Admin role */
Route::get('/general/admin/role/index', [Admin_RoleController::class, 'index'])->name('admin_role.index');
Route::get('/general/admin/role/create', [Admin_RoleController::class, 'create'])->name('admin_role.create');
Route::post('/general/admin/role/store', [Admin_RoleController::class, 'store'])->name('admin_role.store'); 
Route::get('/general/admin/role/edit/{admin_Role}', [Admin_RoleController::class, 'edit'])->name('admin_role.edit');
Route::post('/general/admin/role/update/{admin_Role}', [Admin_RoleController::class, 'update'])->name('admin_role.update');

/** Admin Opération */
Route::get('/admin/operation/client/create', [Admin_memberController::class, 'create_client'])->name('admin_operation.create_client');
Route::post('/admin/operation/client/store', [Admin_memberController::class, 'storeClient'])->name('admin_operation.store_client');


Route::get('/admin/operation/objectif/index', [Admin_memberController::class, 'objectif_index'])->name('admin_operation.objectif_index');
Route::get('/admin/operation/objectif/create', [Admin_memberController::class, 'objectif_create'])->name('admin_operation.objectif_create');



//Création des opérateur par l'administrateur

Route::get('/admin/create/operator', [AuthController::class, 'createOperator'])->name('create.operator');
Route::post('/admin/create/operators', [AuthController::class, 'insertOperator'])->name('operateur.register');
Route::get('/admin/operators', [AuthController::class, 'listOperateur'])->name('operateur.list');
//postes d'un opérateur
Route::get('/admin/operateur/poste/{operator}', [AuthController::class, 'listeposte'])->name('poste.listeposte');


//inventaire Magasinier

Route::post('/inventaire/geolocalisation', [ReceptionController::class, 'storeGeo'])->name('geolocalisation');
Route::get('inventaire/matiereprem/dash', [AuthController::class, 'rawmaterial'])->name('inventaire.dash');
Route::get('/inventaire/receptions/', [ReceptionController::class, 'index'])->name('inventaire.index');
Route::get('/inventaire/reception/create/{type}', [ReceptionController::class, 'create'])->name('inventaire.create');
Route::get('/inventaire/reception/edit/{type}', [ReceptionController::class, 'modifOrigin'])->name('inventaire.edit');
Route::get('/inventaire/reception/fiche/{reception}', [ReceptionController::class, 'fiche'])->name('reception.fiche');
Route::get('/pdf/reception/fiche/{reception}', [ReceptionController::class, 'imprimer'])->name('imprimer.fiche');
Route::get('/lot/pms/get', [ReceptionController::class, 'LotPMS'])->name('reception.lot_pms');
Route::post('/inventaire/reception/stock/transfert/{stock}', [ReceptionController::class, 'transfererstock'])->name('reception.transfert');
Route::get('/inventaire/articles/receptionner/{id_article}', [ReceptionController::class, 'stock_receptionner'])->name('stock_receptionner');
Route::get('/inventaire/generate_qr', [ReceptionController::class, 'generate_qr'])->name('generate_qr');


Route::post('/inventaire/reception/store', [ReceptionController::class, 'store'])->name('reception.store');
Route::get('/page/accueil', [ReceptionController::class, 'pageaccueil'])->name('pageaccueil');

Route::get('/inventaire/matiere/produit/create', [ProduitController::class, 'createMatierePremiere'])->name('matierepremiere.create');
Route::get('/inventaire/produits', [ProduitController::class, 'listeMatierePremiere'])->name('matierepremiere.index');
Route::get('/inventaire/produits/kor/{origin}', [ReceptionController::class, 'processusKor'])->name('processus.index');

Route::post('/session/store', [ReceptionController::class, 'add_session'])->name('add_data_session');
Route::post('/session/store/origin/data', [ReceptionController::class, 'add_session_recep'])->name('add_session_recep');
Route::get('/session/get/data', [ReceptionController::class, 'get_default_th'])->name('get_default_th');
Route::get('/session/get/data/kor', [ReceptionController::class, 'get_kor'])->name('get_kor');
Route::get('/code/get/data/quality/{reception}', [ReceptionController::class, 'getInfoQuality'])->name('get_data_quality');

Route::post('/inventaire/produit/origin', [OrigineProdConfigController::class, 'registerOrigin'])->name('processus.register');

// Expédition

Route::get('/inventaire/dispatchs', [ReceptionController::class, 'dispatchStock'])->name('reception.dispatchs');
Route::get('/inventaire/search/issue', [ReceptionController::class, 'issue'])->name('reception.issue');
Route::get('/inventaire/stocks/grade/{grade}', [ReceptionController::class, 'stockbygrade'])->name('reception.stockbygrade');
Route::post('/inventaire/search/issue/search', [ReceptionController::class, 'searchissue'])->name('reception.searchissue');
Route::post('/inventaire/exit/stock', [ReceptionController::class, 'exit_stocks'])->name('reception.exit_stocks');
Route::get('/inventaire/exit/ticket/{sortie}', [ReceptionController::class, 'ticket'])->name('reception.ticket');
Route::get('/inventaire/exit/index', [ReceptionController::class, 'liste_sortie'])->name('reception.liste_sortie');





//Matière Première

Route::get('/inventaire/matierepremieres/{inventconfig}', [MatierePremiereController::class, 'index'])->name('matiere.index');
Route::get('/inventaire/matierepremiere/expedition', [MatierePremiereController::class, 'inv_expedition'])->name('matiere.expedition_inv');
Route::get('/inventaire/matierepremiere/create', [MatierePremiereController::class, 'create'])->name('matiere.create');
Route::post('/inventaire/matierepremiere/store', [MatierePremiereController::class, 'store'])->name('matiere.store');
Route::get('/inventaire/matierepremiere/matieres', [MatierePremiereController::class, 'listeMatiere'])->name('matiere.listeMatiere');
Route::get('/inventaire/produit_fini_index/produits', [MatierePremiereController::class, 'produit_fini_index'])->name('produit_fini_index');

Route::get('/inventaire/articles/monpdf/', [ReceptionController::class, 'monpdf'])->name('monpdf');




// Admin  Lignes 

Route::get('/admin/lignes', [LigneController::class, 'index'])->name('ligne.index');
Route::get('/admin/ligne/create', [LigneController::class, 'create'])->name('ligne.create');
Route::get('/admin/ligne/edit/{ligne}', [LigneController::class, 'edit'])->name('ligne.edit');
Route::post('/admin/ligne', [LigneController::class, 'store'])->name('ligne.store');
Route::post('/admin/ligne/update/{ligne}', [LigneController::class, 'update'])->name('ligne.update');
Route::get('/admin/ligne/update/{ligne}', [LigneController::class, 'destroy'])->name('ligne.delete');

//Admin produit
Route::get('/admin/produits', [ProduitController::class, 'index'])->name('produit.index');
Route::get('/admin/produit/create', [ProduitController::class, 'create'])->name('produit.create');
Route::post('/admin/produit', [ProduitController::class, 'store'])->name('produit.store');
Route::get('/admin/produit/edit/{produit}', [ProduitController::class, 'edit'])->name('produit.edit');
Route::post('/admin/produit/update/{produit}', [ProduitController::class, 'update'])->name('produit.update');
Route::get('/admin/poste/produit/{produit}', [ProduitController::class, 'createposte'])->name('produit.createposte');
Route::get('/admin/delete/produit/{produit}', [ProduitController::class, 'destroy'])->name('produit.destroy');


// Admin poste
Route::get('/admin/postes', [PosteController::class, 'index'])->name('poste.index');
Route::get('/admin/poste/create', [PosteController::class, 'create'])->name('poste.create');
Route::get('/admin/section/create', [PosteController::class, 'createSection'])->name('poste.createSection');
Route::get('/admin/poste/edit/{poste}', [PosteController::class, 'edit'])->name('poste.edit');
Route::get('/admin/poste/destroy/{poste}', [PosteController::class, 'destroy'])->name('poste.destroy');
Route::post('/admin/poste', [PosteController::class, 'store'])->name('poste.store');
Route::post('/admin/section', [PosteController::class, 'storeSection'])->name('poste.storeSection');
Route::post('/admin/poste/update/{poste}', [PosteController::class, 'update'])->name('poste.update');
Route::get('/admin/poste/operateurs/{id}', [PosteController::class, 'listeOperator'])->name('poste.operateors');



// Admin Assignation

Route::get('/admin/assigners', [AssignerController::class, 'index'])->name('assigner.index');
Route::get('/admin/assigner/create', [AssignerController::class, 'create'])->name('assigner.create');
Route::get('/admin/assigner/create/{id}', [AssignerController::class, 'create'])->name('assigner.creates');
Route::post('/admin/assigner', [AssignerController::class, 'store'])->name('assigner.store');
Route::get('/admin/assigner/poste/{sequence_id}', [AssignerController::class, 'assignerPoste'])->name('assigner.assignerposte');
Route::post('/admin/assigner/poste/{sequence_id}', [AssignerController::class, 'assignerPostecreate'])->name('assigner.assignerPostecreate');
Route::get('/admin/assigner/poste/operateur/{sequence_id}', [AssignerController::class, 'liste_operateur_assigner'])->name('assigner.poste_operateur');
Route::post('/admin/assigner/poste/operateur/update/{assigner}', [AssignerController::class, 'update_operateur'])->name('assigner.update_operateur');
Route::get('/admin/assigner/poste/edit/{id}', [AssignerController::class, 'editt'])->name('operateur.edit');
Route::post('/admin/assigner/poste/operateur/updated/{assigner}', [AssignerController::class, 'update_operateur_on'])->name('assigner.update_operateur_on');



Route::get('/admin/assigner/poste/reconduire/{sequence}', [AssignerController::class, 'reconduire'])->name('reconduire');

//


// Admin Shifts

Route::get('/admin/shifts', [ShiftController::class, 'index'])->name('shift.index');
Route::get('/admin/shift/create', [ShiftController::class, 'create'])->name('shift.create');
Route::post('/admin/shift', [ShiftController::class, 'store'])->name('shift.store');
Route::get('/admin/shift/edit/{shift}', [ShiftController::class, 'edit'])->name('shift.edit');
Route::post('/admin/shift/update/{shift}', [ShiftController::class, 'update'])->name('shift.update');
Route::get('/admin/shift/delete/{shift}', [ShiftController::class, 'destroy'])->name('shift.destroy');



//Admin production
Route::get('/admin/productions', [ProductionController::class, 'index'])->name('production.index');
Route::get('/admin/production/create', [ProductionController::class, 'create'])->name('production.create');
Route::get('/admin/production/create/{id}', [ProductionController::class, 'create'])->name('produit.production');
Route::post('/admin/production', [ProductionController::class, 'store'])->name('production.store');



//Admin Client

Route::get('/admin/clients', [ClientController::class, 'index'])->name('client.index');
Route::get('/admin/client/create', [ClientController::class, 'create'])->name('client.create');
Route::get('/admin/client/edit/{client}', [ClientController::class, 'edit'])->name('client.edit');
Route::post('/admin/client/update/{client}', [ClientController::class, 'update'])->name('client.update');
Route::post('/admin/client', [ClientController::class, 'store'])->name('client.store');
Route::get('/admin/client/details/{client}', [ClientController::class, 'client_details'])->name('client.client_details');

//Fournisseur
Route::get('/supplier/suppliers', [FournisseurController::class, 'index'])->name('supplier.index');
Route::get('/supplier/create', [FournisseurController::class, 'create'])->name('supplier.create');
Route::post('/supplier/store', [FournisseurController::class, 'store'])->name('supplier.store');
Route::get('/supplier/edit/{fournisseur}', [FournisseurController::class, 'edit'])->name('supplier.edit');
Route::post('/supplier/update/{fournisseur}', [FournisseurController::class, 'update'])->name('supplier.update');
Route::get('/supplier/details/{supplier}', [FournisseurController::class, 'supplier_details'])->name('supplier.supplier_details');

//Admin commande

Route::get('/admin/commandes', [CommandeController::class, 'index'])->name('commande.index');
Route::get('/admin/commande/create', [CommandeController::class, 'create'])->name('commande.create');
/* Route::get('/admin/commande/create/{client}', [CommandeController::class, 'create'])->name('commande.create'); */
Route::post('/admin/commande', [CommandeController::class, 'store'])->name('commande.store');


//Objectif objectif.create

Route::get('/admin/objectifs', [ObjectifController::class, 'index'])->name('objectif.index');
Route::get('/admin/objectif/create', [ObjectifController::class, 'create'])->name('objectif.create');
Route::get('/admin/objectif/create/{objectif}', [ObjectifController::class, 'edit'])->name('objectif.edit');
Route::post('/admin/objectif/create/store', [ObjectifController::class, 'store'])->name('objectif.store');
Route::post('/admin/objectif/update/{objectif}', [ObjectifController::class, 'update'])->name('objectif.update');
Route::post('/admin/objectif/delete/{objectif}', [ObjectifController::class, 'destroy'])->name('objectif.destroy');



//Planning 


Route::get('/admin/plannings', [PlanningController::class, 'index'])->name('planning.index');
Route::get('/admin/planning/create/', [PlanningController::class, 'create'])->name('plannings.create');
Route::get('/admin/planning/edit/{planning}', [PlanningController::class, 'edit'])->name('planning.edit');
Route::post('/admin/planning', [PlanningController::class, 'store'])->name('planning.store');
Route::get('/admin/planning/sequence/{sequence_plan}', [PlanningController::class, 'sequenceadd'])->name('planning.sequenceadd');
Route::post('/admin/planning/add/sequence', [PlanningController::class, 'addsequence'])->name('planning.addsequence');
Route::put('/admin/planning/update/{planning}', [PlanningController::class, 'update'])->name('planning.update');
Route::get('/admin/planning/showsequence/{planning}', [PlanningController::class, 'showSequence'])->name('showSequence.index');
Route::get('/admin/planning/commande/{commande_id}', [PlanningController::class, 'getcommande'])->name('getcommande');
Route::get('/admin/planning/planifier/{objectif}', [PlanningController::class, 'plannifier'])->name('plannifier');

//Admin séquence


Route::get('/admin/sequences', [SequenceController::class, 'index'])->name('sequence.index');
Route::get('/admin/sequence/create/', [SequenceController::class, 'create'])->name('sequence.create');
Route::post('/admin/sequence', [SequenceController::class, 'store'])->name('sequence.store');
Route::get('/admin/sequence/edit/{sequence}', [SequenceController::class, 'edit'])->name('sequence.edit');
Route::put('/admin/sequence/update/{sequence}', [SequenceController::class, 'update'])->name('sequence.update');
Route::get('/admin/sequence/delete/{sequence}', [SequenceController::class, 'destroy'])->name('sequence.destroy');


//Admin attribution 
Route::get('/admin/attribuers', [AttributionController::class, 'index'])->name('attribuer.index');
Route::get('/admin/attribuer/create/', [AttributionController::class, 'create'])->name('attribuer.create');
Route::get('/admin/attribuer/create/{operator}', [AttributionController::class, 'attribuer'])->name('attribuer.attribuer');
Route::post('/admin/attribuer', [AttributionController::class, 'store'])->name('attribuer.store');
Route::post('/admin/attribuer/poste', [AttributionController::class, 'attribuer_store'])->name('attribuer.attribuer_store');


//Opérateur ///////
Route::get('/operateur/dash/', [ReceptionController::class, 'operator_stock'])->name('operator_stock');
Route::get('/operateur/dash/stock', [ReceptionController::class, 'stock_dispo_op'])->name('stock_dispo_op');

//calibrage
Route::get('/operateur/stock/processus/{stock}', [CalibrageController::class, 'processusCalibrage'])->name('processusCalibrage');
Route::post('/operateur/stock/processus/store', [CalibrageController::class, 'store'])->name('processuscalibrage.store');
Route::get('/operateur/stock/calibre/liste/{stock}', [CalibrageController::class, 'index'])->name('calibrage.index');
Route::get('/operateur/stock/calibre/valider', [CalibrageController::class, 'ajouterValider'])->name('calibrage.ajouterValider');
Route::get('/operateur/show/{calibrage}', [CalibrageController::class, 'show'])->name('calibrage.show');
Route::post('/operateur/show/controle/{calibrage}', [CalibrageController::class, 'controleQualite'])->name('calibrage.controlequalite');
Route::get('/operateur/calibre/rapport', [CalibrageController::class, 'rapport'])->name('calibrage.rapport');
Route::get('/operateur/calibre/details/{calibrage}', [CalibrageController::class, 'calibragedetail'])->name('calibrage.calibragedetail');
Route::post('/operateur/calibre/enreg/rapport', [CalibrageController::class, 'registerRapport'])->name('calibrage.registerRapport');
Route::get('/operateur/calibre/transfert/{calibrage}', [CalibrageController::class, 'calibrageTransfert'])->name('calibrage.calibrageTransfert');
Route::post('/session/calibrage/store', [CalibrageController::class, 'add_session'])->name('calibrage.add_data_session');
Route::get('/session/calibrage/get/data', [CalibrageController::class, 'get_default_th'])->name('calibrage.get_default_th');
Route::get('/session/calibrage/get/data/kor', [CalibrageController::class, 'get_kor'])->name('calibrage.get_kor');
Route::post('/calibrage/store/localisation', [CalibrageController::class, 'storelocation'])->name('calibrage.storelocation');
Route::post('/calibrage/store/weight/caliber', [CalibrageController::class, 'session_add_weight'])->name('calibrage.session_add_weight');
Route::post('/calibrage/store/weight/register', [CalibrageController::class, 'registercalibrage'])->name('calibrage.registercalibrage');
Route::post('/calibrage/store/weight/name/controller', [CalibrageController::class, 'addNameController'])->name('calibrage.addNameController');
Route::get('/calibrage/search/issue', [CalibrageController::class, 'issue'])->name('calibrage.issue');
Route::post('/calibrage/search/issue/search', [CalibrageController::class, 'searchissue'])->name('calibrage.searchissue');



Route::get('/operateur/calibre/list', [TypeCalibreController::class, 'index'])->name('calibrage.listetype');
Route::get('/operateur/calibre/create', [TypeCalibreController::class, 'create'])->name('calibrage.create');
Route::post('/operateur/calibre/store', [TypeCalibreController::class, 'store'])->name('calibrage.store');
Route::get('/operateur/calibre/edit/{typeCalibre}', [TypeCalibreController::class, 'edit'])->name('calibrage.edit');
Route::post('/operateur/calibre/update/{typeCalibre}', [TypeCalibreController::class, 'update'])->name('calibrage.update');
Route::get('/operateur/calibre/destroy/{typeCalibre}', [TypeCalibreController::class, 'destroy'])->name('calibrage.delete');
Route::get('/operateur/sequences/connexion', [SequenceController::class, 'operateurSequence'])->name('sequence.operateurSequence');
Route::get('/operateur/sequence/connecter/{sequence}', [SequenceController::class, 'OperateurConnecter'])->name('sequence.OperateurConnecter');
Route::get('/operateur/calibre/grader/create', [TypeCalibreController::class, 'creategrader'])->name('calibrage.gradercreate');
Route::post('/operateur/calibre/grader/store', [TypeCalibreController::class, 'storegrader'])->name('calibrage.graderstore');
Route::get('/operateur/calibre/grader/index', [TypeCalibreController::class, 'graderindex'])->name('calibrage.graderindex');
Route::get('/operateur/calibre/grader/edit/{grader}', [TypeCalibreController::class, 'editgrader'])->name('calibrage.graderedit');
Route::post('/operateur/calibre/grader/update/{grader}', [TypeCalibreController::class, 'updategrader'])->name('calibrage.graderupdate');
Route::get('/operateur/calibre/grader/destroy/{grader}', [TypeCalibreController::class, 'deletegrader'])->name('calibrage.deletegrader');


//fragilisation 

Route::get('/operateur/fragilisation/stocks', [CalibrageController::class, 'stock_calib_liste'])->name('fragilisation.stock_calib_liste');
Route::get('/operateur/fragilisation/cuiseur', [CuiseurController::class, 'create'])->name('cuiseur.create');
Route::get('/operateur/fragilisation/cuiseur/{cuiseur}', [CuiseurController::class, 'edit'])->name('cuiseur.edit');
Route::post('/operateur/fragilisation/cuiseur/{cuiseur}', [CuiseurController::class, 'update'])->name('cuiseur.update');
Route::get('/operateur/fragilisation/cuiseurs', [CuiseurController::class, 'index'])->name('cuiseur.index');
Route::post('/operateur/fragilisation/cuiseurs/store', [CuiseurController::class, 'store'])->name('cuiseur.store');
Route::get('/operateur/fragilisation/cuiseur/destroy/{cuiseur}', [CuiseurController::class, 'cuiseurdestroy'])->name('cuiseur.destroy');
Route::get('/operateur/fragilisation/process/{stock}', [CuiseurController::class, 'processFragilisation'])->name('fragilisation.process');
Route::post('/operateur/fragilisation/process/confirm/weigth', [FragilisationController::class, 'confirm_weigth'])->name('fragilisation.confirm_weigth');
Route::post('/operateur/fragilisation/process/store', [FragilisationController::class, 'store'])->name('fragilisation.store');
Route::get('/operateur/fragilisation/index/{stock}', [FragilisationController::class, 'index'])->name('fragilisation.index');
Route::get('/operateur/fragilisation/transfert/{fragilisation}', [FragilisationController::class, 'FragilisationTransfert'])->name('fragilisation.transfert');
Route::get('/operateur/fragilisation/rapport', [FragilisationController::class, 'fragilisationRapport'])->name('fragilisation.rapport');
Route::get('/operateur/fragilisation/show/{fragilisation}', [FragilisationController::class, 'show'])->name('fragilisation.show');
Route::post('/operateur/fragilisation/rapport', [FragilisationController::class, 'registerRapport'])->name('fragilisation.registerrapport');
Route::get('/operateur/fragilisation/endCounting/{fragilisation_id}', [FragilisationController::class, 'endCounting'])->name('fragilisation.endCounting');


//Refroidissement 

Route::get('/operateur/refroidissement/stocks', [FragilisationController::class, 'stock_fragil_liste'])->name('cooling.stock_fragil_liste');
Route::get('/operateur/refroidissement/create/{fragilisation}', [RefroidissementController::class, 'create'])->name('cooling.create');
Route::get('/operateur/cooling/index/', [RefroidissementController::class, 'index'])->name('cooling.index');
Route::post('/operateur/cooling/store', [RefroidissementController::class, 'store'])->name('cooling.store');
Route::get('/operateur/cooling/transfert/{cooling}', [RefroidissementController::class, 'coolingTransfert'])->name('cooling.coolingTransfert');
Route::get('/operateur/cooling/rapport/', [RefroidissementController::class, 'rapport'])->name('cooling.rapport');
Route::post('/operateur/cooling/rapport/store', [RefroidissementController::class, 'registerRapport'])->name('cooling.registerRapport');
Route::get('/operateur/cooling/detail/{cooling}', [RefroidissementController::class, 'coolingdetails'])->name('cooling.coolingdetails');
Route::get('/operateur/cooling/endCounting/{cooling}', [RefroidissementController::class, 'endCounting'])->name('cooling.endCounting');
Route::get('/operateur/cooling/shelling/stock', [RefroidissementController::class, 'stock_cooling_liste'])->name('shelling.stock_cooling_liste');


// Décorticage 

Route::get('/operateur/shelling/process/{cooling}', [DecorticageController::class, 'process'])->name('shelling.process');
Route::post('/operateur/shelling/process', [DecorticageController::class, 'createProcess'])->name('shelling.createProcess');
Route::get('/operateur/shellings/index', [DecorticageController::class, 'index'])->name('shelling.index');
Route::get('/operateur/shellings/index/{cooling}', [DecorticageController::class, 'listBycaliber'])->name('shelling.listBycaliber');
Route::get('/operateur/shelling/rapport/', [DecorticageController::class, 'shellingRapport'])->name('shelling.shellingRapport');
Route::post('/operateur/shelling/rapport/register', [DecorticageController::class, 'registerRapport'])->name('shelling.registerRapport');
Route::post('/operateur/shelling/store', [DecorticageController::class, 'store'])->name('shelling.store');
Route::get('/operateur/shelling/transfert/{shelling}', [DecorticageController::class, 'shellingTransfert'])->name('shelling.transfert');
Route::get('/operateur/shelling/detail/{shelling}', [DecorticageController::class, 'shellingdetails'])->name('shelling.shellingdetails');


//Séchage 

Route::get('/operateur/drying/stock', [DecorticageController::class, 'stock_drying_liste'])->name('drying.stock_drying_liste');
Route::get('/operateur/drying/four/create', [FourController::class, 'create'])->name('drying.createfour');
Route::post('/operateur/drying/four/store', [FourController::class, 'store'])->name('drying.storefour');
Route::get('/operateur/drying/four/fourindex', [FourController::class, 'index'])->name('drying.fourindex');
Route::get('/operateur/drying/four/edit/{four}', [FourController::class, 'edit'])->name('drying.fouredit');
Route::post('/operateur/drying/four/update/{four}', [FourController::class, 'update'])->name('drying.fourupdate');
Route::get('/operateur/drying/four/destroy/{four}', [FourController::class, 'destroy'])->name('drying.fourdestroy');

Route::get('/operateur/drying/create/{shelling}', [SechageController::class, 'create'])->name('drying.create');
Route::post('/operateur/drying/create/store', [SechageController::class, 'store'])->name('drying.store');
Route::get('/operateur/drying/endCounting/{drying_id}', [SechageController::class, 'endCounting'])->name('drying.endCounting');
Route::get('/operateur/drying/second/endCounting/{drying_id}', [SechageController::class, 'endsecondCounting'])->name('drying.endsecondCounting');
Route::get('/operateur/first/drying/', [SechageController::class, 'firstDrying'])->name('drying.firstDrying');
Route::get('/operateur/drying/second/index', [SechageController::class, 'index'])->name('drying.index');
Route::get('/operateur/second/drying/{drying}', [SechageController::class, 'createSecondDrying'])->name('drying.createseconddrying'); 
Route::post('/operateur/second/drying/store', [SechageController::class, 'storeSecondDeying'])->name('drying.storesecond');
Route::post('/operateur/second/drying/getloss', [SechageController::class, 'getLoss'])->name('drying.getLoss');
Route::post('/operateur/second/drying/registerfinal', [SechageController::class, 'registerSecondDrying'])->name('drying.registerSecondDrying'); /**/
Route::get('/operateur/second/drying/stock/general', [SechageController::class, 'listeSecondDraying'])->name('drying.listeDraying');
Route::get('/operateur/second/drying/stock/general/{drying}', [SechageController::class, 'transfertSeconddrying'])->name('drying.transfert');
Route::get('/operateur/drying/rapport', [SechageController::class, 'dryingRapport'])->name('drying.rapport');
Route::get('/operateur/drying/detail/{drying}', [SechageController::class, 'dryindetails'])->name('drying.details');
Route::post('/operateur/drying/rapport/register', [SechageController::class, 'registerRapport'])->name('drying.registerRapport');
Route::post('/operateur/drying/add_weight', [SechageController::class, 'add_weight'])->name('drying.add_weight');



Route::get('/operateur/unskinning/stocks', [SechageController::class, 'stock_unskinning_liste'])->name('drying.stock_unskinning_liste');

/** Dépelliculage */
Route::get('/operateur/unskinning/index', [DepelliculageController::class, 'index'])->name('unskinning.index');
Route::get('/operateur/unskinning/create/{drying}', [DepelliculageController::class, 'create'])->name('unskinning.create');
Route::post('/operateur/unskinning/store', [DepelliculageController::class, 'store'])->name('unskinning.store');
Route::post('/operateur/unskinning/second/{unskinning}', [DepelliculageController::class, 'unskinning_second'])->name('unskinning.unskinning_second');
Route::get('/operateur/unskinning/transfert/{unskinning}', [DepelliculageController::class, 'transfert'])->name('unskinning.transfert');
Route::get('/operateur/unskinning/rapport', [DepelliculageController::class, 'unskinningrapport'])->name('unskinning.rapport');
Route::get('/operateur/unskinning/details/{unskinning}', [DepelliculageController::class, 'dryindetails'])->name('unskinning.detail');
Route::post('/operateur/unskinning/raport', [DepelliculageController::class, 'registerRapport'])->name('unskinning.registerRapport');

/**Classification */


Route::get('/operateur/classification/stocks', [DepelliculageController::class, 'stock_classification_liste'])->name('classification.stock_classification_liste');
Route::get('/operateur/grades', [GradeController::class, 'index'])->name('classification.grades');
Route::get('/operateur/grade/creategrade', [GradeController::class, 'create'])->name('classification.creategrade');
Route::get('/operateur/grade/edit/{grade}', [GradeController::class, 'edit'])->name('classification.editgrade');
Route::post('/operateur/grade/store', [GradeController::class, 'store'])->name('classification.storegrade');
Route::post('/operateur/grade/update/{grade}', [GradeController::class, 'update'])->name('classification.updategrade');
Route::get('/operateur/grade/destroy/{grade}', [GradeController::class, 'destroy'])->name('classification.gradedestroy');
Route::get('/operateur/classification/create/{unskinning}', [ClassificationController::class, 'create'])->name('classification.create');
Route::post('/operateur/classification/store', [ClassificationController::class, 'store'])->name('classification.store');
Route::get('/operateur/classifications', [ClassificationController::class, 'index'])->name('classification.index');
Route::get('/operateur/classification/transfert/{classification}', [ClassificationController::class, 'transfert'])->name('classification.transfert');
Route::get('/operateur/classification/raport', [ClassificationController::class, 'classificationrapport'])->name('classification.rapport');
Route::post('/operateur/classification/raport', [ClassificationController::class, 'registerRapport'])->name('classification.registerRapport');
Route::get('/operateur/classification/details/{classification}', [ClassificationController::class, 'classificationdetails'])->name('classification.details');

// Conditionnement

Route::get('/operateur/conditioning/stocks', [ClassificationController::class, 'stock_conditioning_liste'])->name('conditioning.stocks');
Route::get('/operateur/conditioning/create/{classification}', [ConditionnementController::class, 'create'])->name('conditioning.create');
Route::post('/operateur/conditioning/store', [ConditionnementController::class, 'store'])->name('conditioning.store');
Route::get('/operateur/conditionings', [ConditionnementController::class, 'index'])->name('conditioning.index');
Route::get('/operateur/conditioning/transfert/{conditioning}', [ConditionnementController::class, 'transfert'])->name('conditioning.transfert');
Route::get('/operateur/conditioning/rapport', [ConditionnementController::class, 'conditioningrapport'])->name('conditioning.rapport');
Route::post('/operateur/conditioning/rapport', [ConditionnementController::class, 'registerRapport'])->name('conditioning.registerRapport');
Route::get('/operateur/conditioning/details/{conditioning}', [ConditionnementController::class, 'conditioningdetails'])->name('conditioning.details');

