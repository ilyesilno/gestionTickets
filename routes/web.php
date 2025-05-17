<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TechController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Middleware\EmployeMiddleware;
use App\Http\Middleware\TechnicienMiddleware;

Route::middleware('auth')->group(function () {
    //! Admin
    // Route::middleware('admin')->group(function () {
        Route::get('/admin-dashboard', [AdminController::class, 'dashboard'])->name('admin-dashboard');

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
    Route::middleware(EmployeMiddleware::class)->group(function () {
        Route::get('/employe-dashboard', [EmployeController::class, 'dashboard'])->name('employe-dashboard');

        Route::post('/employe-markAsRead/{id}', [EmployeController::class, 'markAsRead'])->name('employe-markAsRead');
        Route::post('/employe-markAllAsRead', [EmployeController::class, 'markAllAsRead'])->name('employe-markAllAsRead');
        Route::delete('/employe-toutEffacer', [EmployeController::class, 'toutEffacer'])->name('employe-tout-effacer');

        //? Ticket Management
        Route::get('/employe/list-tickets', [EmployeController::class, 'listTickets'])->name('employe-list-tickets');
        Route::get('/employe/list-tickets/search', [EmployeController::class, 'employeSearch'])->name('search-employe-tickets');
        Route::post('/employe/store-ticket', [EmployeController::class, 'storeTicket'])->name('store-ticket');
        Route::get('/employe/ticket/{id}', [EmployeController::class, 'afficherTicket'])->name('show-employe-ticket');
        Route::get('/employe/edit-ticket/{id}', [EmployeController::class, 'editTicket'])->name('edit-employe-ticket');
        Route::put('/employe/update-ticket/{id}', [EmployeController::class, 'updateTicket'])->name('update-employe-ticket');
        Route::delete('/employe/delete-ticket/{id}', [EmployeController::class, 'deleteTicket'])->name('delete-employe-ticket');


        //? Comment Management
        Route::post('/employe/store-comment/{id}', [EmployeController::class, 'storeEmployeComment'])->name('employe-store-comment');
        Route::delete('/employe/delete-comment/{id}', [EmployeController::class, 'deleteEmployeComment'])->name('employe-delete-comment');

        //? Profile Management
        Route::get('/employe/profile', [EmployeController::class, 'profile'])->name('employe-profile');
        Route::put('/employe/update-profile', [EmployeController::class, 'updateInfo'])->name('employe-updateInfo');
        Route::put('/employe/change-password', [EmployeController::class, 'changePassword'])->name('employe-changePassword');
    });

    //! Agent
    Route::middleware(TechnicienMiddleware::class)->group(function () {
        Route::get('/tech-dashboard', [TechController::class, 'dashboard'])->name('tech-dashboard');

        Route::get('/tech/list-tickets', [TechController::class, 'listTickets'])->name('tech-list-tickets');
        Route::get('/tech/ticket/{id}', [TechController::class, 'afficherTicket'])->name('show-tech-ticket');
        Route::get('/tech/edit-ticket/{id}', [TechController::class, 'editTicket'])->name('edit-tech-ticket');
        Route::put('/tech/update-ticket/{id}', [TechController::class, 'updateTicket'])->name('update-tech-ticket');
        Route::get('/tech/list-tickets/search', [TechController::class, 'techSearch'])->name('search-tech-tickets');


        //? Comment Management
        Route::post('/tech/store-comment/{id}', [TechController::class, 'storeTechComment'])->name('tech-store-comment');
        Route::delete('/tech/delete-comment/{id}', [TechController::class, 'deleteTechComment'])->name('tech-delete-comment');

        //? Profile Management
        Route::get('/tech/profile', [TechController::class, 'profile'])->name('tech-profile');
        Route::put('/tech/update-profile', [TechController::class, 'updateInfo'])->name('tech-updateInfo');
        Route::put('/tech/change-password', [TechController::class, 'changePassword'])->name('tech-changePassword');

        //? Comment Management
        Route::post('/tech/store-comment/{id}', [TechController::class, 'storeTechComment'])->name('tech-store-comment');
        Route::delete('/tech/delete-comment/{id}', [TechController::class, 'deleteTechComment'])->name('tech-delete-comment');


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