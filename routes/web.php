<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Middleware\ClientMiddleware;
use App\Http\Middleware\AgentMiddleware;

Route::middleware('auth')->group(function () {
    //! Admin
    // Route::middleware('admin')->group(function () {
        Route::get('/admin-dashboard', [AdminController::class, 'dashboard'])->name('admin-dashboard');

         //? sla Management
         Route::get('/list-slas', [AdminController::class, 'listslas'])->name('list-slas');
         Route::get('/create-sla', [AdminController::class, 'createsla'])->name('create-sla');
         Route::post('/store-sla', [AdminController::class, 'storesla'])->name('store-sla');
         Route::delete('/delete-sla/{id}', [AdminController::class, 'deletesla'])->name('delete-sla');
                                     
       //? produits Management
         Route::get('/list-produits', [AdminController::class, 'listproduits'])->name('list-produits');
         Route::get('/create-produit', [AdminController::class, 'createproduit'])->name('create-produit');
         Route::post('/store-produit', [AdminController::class, 'storeproduit'])->name('store-produit');
         Route::delete('/delete-produit/{id}', [AdminController::class, 'deleteproduit'])->name('delete-produit');
         
         //? abonnement Management
         Route::get('/list-abonnements', [AdminController::class, 'listAbonnements'])->name('list-abonnements');
         Route::get('/create-abonnement', [AdminController::class, 'createabonnement'])->name('create-abonnement');
         Route::post('/store-abonnement', [AdminController::class, 'storeabonnement'])->name('store-abonnement');
         Route::delete('/delete-abonnement/{id}', [AdminController::class, 'deleteabonnement'])->name('delete-abonnement');

        //? User Management
        Route::get('/list-users', [AdminController::class, 'listUsers'])->name('list-users');
        Route::get('/create-user', [AdminController::class, 'createUser'])->name('create-user');
        Route::post('/store-user', [AdminController::class, 'storeUser'])->name('store-user');
        Route::delete('/delete-user/{id}', [AdminController::class, 'deleteUser'])->name('delete-user');

        //? Statut Management
        Route::get('/list-statuts', [AdminController::class, 'listStatuts'])->name('list-statuts');
        Route::post('/store-statut', [AdminController::class, 'storeStatut'])->name('store-statut');
        Route::get('/edit-statut/{id}', [AdminController::class, 'editStatut'])->name('edit-statut');
        Route::put('/update-statut/{id}', [AdminController::class, 'updateStatut'])->name('update-statut');
        Route::delete('/delete-statut/{id}', [AdminController::class, 'deleteStatut'])->name('delete-statut');

        //? Priorite Management
        Route::get('/list-priorites', [AdminController::class, 'listPriorites'])->name('list-priorites');
        Route::post('/store-priorite', [AdminController::class, 'storePriorite'])->name('store-priorite');
        Route::get('/edit-priorite/{id}', [AdminController::class, 'editPriorite'])->name('edit-priorite');
        Route::put('/update-priorite/{id}', [AdminController::class, 'updatePriorite'])->name('update-priorite');
        Route::delete('/delete-priorite/{id}', [AdminController::class, 'deletePriorite'])->name('delete-priorite');

        //? Categorie Management
        Route::get('/list-categories', [AdminController::class, 'listCategories'])->name('list-categories');
        Route::post('/store-categorie', [AdminController::class, 'storeCategorie'])->name('store-categorie');
        Route::get('/edit-categorie/{id}', [AdminController::class, 'editCategorie'])->name('edit-categorie');
        Route::put('/update-categorie/{id}', [AdminController::class, 'updateCategorie'])->name('update-categorie');
        Route::delete('/delete-categorie/{id}', [AdminController::class, 'deleteCategorie'])->name('delete-categorie');

        //? Ticket Management
        Route::get('/list-all-tickets', [AdminController::class, 'listAllTickets'])->name('list-all-tickets');
        Route::get('/list-all-tickets/search', [AdminController::class, 'adminSearch'])->name('search-all-tickets');
        Route::get('/ticket/{id}', [AdminController::class, 'showTicket'])->name('show-ticket');
        Route::get('/edit-ticket/{id}', [AdminController::class, 'editTicket'])->name('edit-ticket');
        Route::put('/update-ticket/{id}', [AdminController::class, 'updateTicket'])->name('update-ticket');
        Route::delete('/delete-ticket/{id}', [AdminController::class, 'deleteTicket'])->name('delete-ticket');

        //? Comment Management
        Route::post('/store-comment/{id}', [AdminController::class, 'storeComment'])->name('store-comment');
        Route::delete('/delete-comment/{id}', [AdminController::class, 'deleteComment'])->name('delete-comment');

        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
        Route::put('/update-profile', [AdminController::class, 'updateInfo'])->name('updateInfo');
        Route::put('/change-password', [AdminController::class, 'changePassword'])->name('changePassword');
    });

    //! Client
    Route::middleware(ClientMiddleware::class)->group(function () {
        Route::get('/client-dashboard', [ClientController::class, 'dashboard'])->name('client-dashboard');

        Route::post('/client-markAsRead/{id}', [ClientController::class, 'markAsRead'])->name('client-markAsRead');
        Route::post('/client-markAllAsRead', [ClientController::class, 'markAllAsRead'])->name('client-markAllAsRead');
        Route::delete('/client-toutEffacer', [ClientController::class, 'toutEffacer'])->name('client-tout-effacer');

        //? Ticket Management
        Route::get('/client/list-tickets', [ClientController::class, 'listTickets'])->name('client-list-tickets');
        Route::get('/client/list-tickets/search', [ClientController::class, 'clientSearch'])->name('search-client-tickets');
        Route::post('/client/store-ticket', [ClientController::class, 'storeTicket'])->name('store-ticket');
        Route::get('/client/ticket/{id}', [ClientController::class, 'afficherTicket'])->name('show-client-ticket');
        Route::get('/client/edit-ticket/{id}', [ClientController::class, 'editTicket'])->name('edit-client-ticket');
        Route::put('/client/update-ticket/{id}', [ClientController::class, 'updateTicket'])->name('update-client-ticket');
        Route::delete('/client/delete-ticket/{id}', [ClientController::class, 'deleteTicket'])->name('delete-client-ticket');


        //? Comment Management
        Route::post('/client/store-comment/{id}', [ClientController::class, 'storeclientComment'])->name('client-store-comment');
        Route::delete('/client/delete-comment/{id}', [ClientController::class, 'deleteclientComment'])->name('client-delete-comment');

        //? Profile Management
        Route::get('/client/profile', [ClientController::class, 'profile'])->name('client-profile');
        Route::put('/client/update-profile', [ClientController::class, 'updateInfo'])->name('client-updateInfo');
        Route::put('/client/change-password', [ClientController::class, 'changePassword'])->name('client-changePassword');
    });

    //! Agent
    Route::middleware(AgentMiddleware::class)->group(function () {
        Route::get('/agent-dashboard', [AgentController::class, 'dashboard'])->name('agent-dashboard');

        Route::get('/agent/list-tickets', [AgentController::class, 'listTickets'])->name('agent-list-tickets');
        Route::get('/agent/ticket/{id}', [AgentController::class, 'afficherTicket'])->name('show-agent-ticket');
        Route::get('/agent/edit-ticket/{id}', [AgentController::class, 'editTicket'])->name('edit-agent-ticket');
        Route::get('/agent/selfasign-ticket/{id}', [AgentController::class, 'selfassignTicket'])->name('selfasign-agent-ticket');
        
        Route::put('/agent/update-ticket/{id}', [AgentController::class, 'updateTicket'])->name('update-agent-ticket');
        Route::get('/agent/list-tickets/search', [AgentController::class, 'agentSearch'])->name('search-agent-tickets');

        Route::get('/agent/escalate-ticket/{id}', [AgentController::class, 'escalateTicket'])->name('escalate-agent-ticket');
        Route::get('/agent/resolve-ticket/{id}', [AgentController::class, 'resolveTicket'])->name('resolve-agent-ticket');

        //? Comment Management
        Route::post('/agent/store-comment/{id}', [AgentController::class, 'storeagentComment'])->name('agent-store-comment');
        Route::delete('/agent/delete-comment/{id}', [AgentController::class, 'deleteagentComment'])->name('agent-delete-comment');

        //? Profile Management
        Route::get('/agent/profile', [AgentController::class, 'profile'])->name('agent-profile');
        Route::put('/agent/update-profile', [AgentController::class, 'updateInfo'])->name('agent-updateInfo');
        Route::put('/agent/change-password', [AgentController::class, 'changePassword'])->name('agent-changePassword');

        //? Comment Management
        Route::post('/agent/store-comment/{id}', [AgentController::class, 'storeagentComment'])->name('agent-store-comment');
        Route::delete('/agent/delete-comment/{id}', [AgentController::class, 'deleteagentComment'])->name('agent-delete-comment');


    });


// });

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/authenticate', [AuthController::class, 'login'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::middleware('RedirectBasedOnRole')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    // });
});