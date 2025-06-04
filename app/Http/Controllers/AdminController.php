<?php

namespace App\Http\Controllers;

use App\Mail\TicketAttribuer;
use App\Models\Role;
use App\Models\Agent;
use App\Models\WebsiteSetting;
use App\Models\User;
use App\Models\abonnement;
use App\Models\Ticket;
use App\Models\Produit;
use App\Models\Sla;
use App\Models\Commentaire;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function dashboard()
    {
        // $statuts = Statut::all();
        $usersmdp = User::where('mot_de_passe_oublie', true)->get();
        $tickets = Ticket::all();
        return view('admin.admin-dashboard', compact('tickets',"usersmdp"));
    }


  

    
     //!/* agent Management */
    
     public function suiviAgent(Request $request)
     {
         $agents = User::where('role_id', 2)->get(); // Tous les utilisateurs avec le rôle "agent"
         $selectedAgent = null;
         $agentData = null;
     
         if ($request->has('agent_id')) {
             $selectedAgent = User::find($request->input('agent_id'));
     
             if ($selectedAgent) {
                 $agentData = Agent::where('user_id', $selectedAgent->id)->first();
             }
         }
     
         return view('admin.Agent Management.suivi-agent', compact('agents', 'selectedAgent', 'agentData'));
     }
     
          
     //!/* sla Management */

     public function listslas()
     {
         $currentUserId = Auth::id();
         $slas = sla::paginate(5); // Automatically paginates
     
         return view('admin.Sla Management.liste-sla', compact('slas'));
     }
     public function createsla()
     {   
         return view('admin.Sla Management.create-sla');
     }
     public function storesla(Request $request)
     {
         $validatedData = $request->validate([
             'nom' => 'required|string',
             'duree_qualification' => 'required|int',
             'duree_resolution' => 'required|int'
 
         ]); 
         
         sla::create([
             'nom' => $validatedData['nom'],
             'duree_qualification' => $validatedData['duree_qualification'],
             'duree_resolution' => $validatedData['duree_resolution'],

         ]);
         return back()->with('success', 'Vous avez bien créé un sla');
     }
     public function deletesla($id)
     {
         $sla = sla::findOrFail($id);
         $sla->delete();
     
         return redirect()->back()->with("warning", "Le sla a été supprimé avec succès");
     }

     public function showLoginForm()
     {
         $logoPath = WebsiteSetting::getValue('login_logo') ?? 'default-logo.png'; // fallback si pas de logo
         return view('auth.login', compact('logoPath'));
     }
    public function Logo()
    {
        $logoPath = WebsiteSetting::getValue('login_logo');
        return view('admin.Logo Management.Logo', compact('logoPath'));
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|max:2048',
        ]);
    
        $path = $request->file('logo')->store('logos', 'public');
    
        WebsiteSetting::setValue('login_logo', $path);
    
        return back()->with('success', 'Le logo a été mis à jour avec succès !');
    }
      //!/* produit Management */

      public function listProduits()
      {
          $currentUserId = Auth::id();
          $produits = Produit::paginate(5); // Automatically paginates
      
          return view('admin.Produit Management.list-produit', compact('produits'));
      }
      public function createproduit()
      {   
          $users = User::where('role_id', 3)->get();
          return view('admin.Produit Management.create-produit',compact('users'));
      }
      public function storeproduit(Request $request)
      {
          $validatedData = $request->validate([
              'nom' => 'required|string',

          ]); 
          
          Produit::create([
              'nom' => $validatedData['nom'],
              'user_id' => $request->user_id,

          ]);
          return back()->with('success', 'Vous avez bien créé un produit.');
      }
      public function deleteProduit($id)
      { 
          $produit = Produit::findOrFail($id);
          $produit->delete();
      
          return redirect()->back()->with("warning", "Le produit a été supprimé avec succès");
      }
  //!/* abonnement Management */

  public function listAbonnements()
  {
      $abonnements = Abonnement::paginate(10); 
  
      return view('admin.Abonnement Management.liste-abonnement',compact('abonnements'));
  }
  public function createAbonnement()
  {
      $slas = Sla::all();
      $produits = Produit::all();
      return view('admin.Abonnement Management.create-abonnement', compact('produits', 'slas'));
  }
  public function storeabonnement(Request $request)
  {
      $validatedData = $request->validate([
          'date_debut' => 'required|date',
          'date_fin' => 'required|date',
          'produitID' => 'required|integer',
          'slaID' => 'required|integer'

      ]);

      abonnement::create([
           'date_debut' => $validatedData['date_debut'],
          'date_fin' => $validatedData['date_fin'],
          'produitID' => $validatedData['produitID'],
          'slaID' => $validatedData['slaID'],
      ]);
      return back()->with('success', 'Vous avez bien créé un abonnement');
  }
  public function deleteabonnement($id)
  {
      $abonnement = abonnement::findOrFail($id);
      $abonnement->delete();
  
      return redirect()->back()->with("warning", "L'abonnement a été supprimé avec succès");
  }
    //!/* User Management */


    //envoi de la demande du changement du mdp
    public function mdpdemande()
    {

        return view('auth.mdpoublie');
    }
    //changement status mdpoublie
    public function mdprequest(request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->mot_de_passe_oublie = true;
            $user->save();
            return redirect()->back()->with('success', 'Une demande de réinitialisation a été envoyé.');
        } else {
            return redirect()->back()->with('error', 'Aucun utilisateur trouvé avec cet email.');
        };
        return view("auth.login");
    }
    //changement du mot de passe par ladmin
    public function changementmdp(request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::find($id);
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->mot_de_passe_oublie = false;
            $user->save();
            return redirect()->route('login')->with('success', 'le mot de passe a été réinitialisé avec succès.');
        } else {
            return redirect()->back()->with('error', 'Aucune demande de réinitialisation trouvée.');
        
    }
    }   
    public function pageChangementMdp($id){

        $user = User::findOrFail($id);
        return view('admin.motdepasseManagement.modifier-mdp',compact('user'));
    }
       
    public function UpdateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.User Management.update-user', compact('user', 'roles'));
    } 
    public function PutUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'password' => 'nullable|string|min:8',
        ]);

        $user->update([
            
            'password' => $request->input('password') ? Hash::make($request->input('password')) : $user->password,
        ]);

        return redirect()->route('list-users')->with('success', 'Le mot de passe a été mis à jour avec succès');
    }

    public function createUser()
    {
        $roles = Role::all();
        return view('admin.User Management.create-user', compact('roles'));
    }
    public function storeUser(Request $request)
    {
        $validatedData = $request->validate([
            'nom_complet' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|integer',
        ]);

        User::create([
            'nom_complet' => $validatedData['nom_complet'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role_id' => $validatedData['role_id'],
        ]);
        return back()->with('success', 'Vous avez bien créé un compte');
    }
    public function listUsers()
    {
        $currentUserId = Auth::id();
        $users = User::where('id', '!=', $currentUserId)->paginate(5);
        return view('admin.User Management.list-users', compact('users'));
    }
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->role_id == 2) {
            Ticket::where('assigned_to', $id)->update(['assigned_to' => null]);
        } elseif ($user->role_id == 3) {
            Ticket::where('user_id', $id)->delete();
        }

        $user->delete();

        return redirect()->back()->with("warning", "L'utilisateur a été supprimé");
    }
    //!/* Statut Management */
    public function listStatuts()
    {
        $statuts = Statut::all();
        return view('admin.Statut Management.list-statuts', compact('statuts'));
    }
    public function storeStatut(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string',
        ]);
        Statut::create(['nom' => $validatedData["nom"]]);
        return redirect()->route('list-statuts')->with("success", "Le statut a été ajouté avec succès");
    }
    public function editStatut($id)
    {
        $statut = Statut::where('id', $id)->first();
        return view('admin.Statut Management.edit-statut', compact('statut'));
    }
    public function updateStatut(Request $request, $id)
    {
        $statut = Statut::where('id', $id);
        $validatedData = $request->validate([
            'nom' => 'required|string'
        ]);
        $statut->update(['nom' => $validatedData['nom']]);
        return redirect()->route('list-statuts')->with("success", "Le statut a été modifié avec succès");
    }
    public function deleteStatut($id)
    {
        $statut = Statut::where('id', $id);
        $statut->delete();
        return redirect()->back()->with("warning", "Le statut a été supprimé");
    }
    //!/* Priorite Management */
    public function listPriorites()
    {
        $priorites = Priorite::all();
        return view('admin.Priorite Management.list-priorites', compact('priorites'));
    }
    public function storePriorite(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string',
        ]);
        Priorite::create(['nom' => $validatedData["nom"]]);
        return redirect()->route('list-priorites')->with("success", "Le priorite a été ajouté avec succès");
    }
    public function editPriorite($id)
    {
        $priorite = Priorite::where('id', $id)->first();
        return view('admin.Priorite Management.edit-priorite', compact('priorite'));
    }
    public function updatePriorite(Request $request, $id)
    {
        $priorite = Priorite::where('id', $id);
        $validatedData = $request->validate([
            'nom' => 'required|string'
        ]);
        $priorite->update(['nom' => $validatedData['nom']]);
        return redirect()->route('list-priorites')->with("success", "Le priorite a été modifié avec succès");
    }
    public function deletePriorite($id)
    {
        $priorite = Priorite::where('id', $id);
        $priorite->delete();
        return redirect()->back()->with("warning", "Le priorite a été supprimé");
    }
    //!/* Category Management */
    public function listCategories()
    {
        $categories = Categorie::all();
        return view('admin.Category Management.list-categories', compact('categories'));
    }
    public function storeCategorie(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string',
        ]);
        Categorie::create(['nom' => $validatedData["nom"]]);
        return redirect()->route('list-categories')->with("success", "Le categorie a été ajouté avec succès");
    }
    public function editCategorie($id)
    {
        $categorie = Categorie::where('id', $id)->first();
        return view('admin.Category Management.edit-categorie', compact('categorie'));
    }
    public function updateCategorie(Request $request, $id)
    {
        $categorie = Categorie::where('id', $id);
        $validatedData = $request->validate([
            'nom' => 'required|string'
        ]);
        $categorie->update(['nom' => $validatedData['nom']]);
        return redirect()->route('list-categories')->with("success", "Le categorie a été modifié avec succès");
    }
    public function deleteCategorie($id)
    {
        $categorie = Categorie::where('id', $id);
        $categorie->delete();
        return redirect()->back()->with("warning", "Le categorie a été supprimé");
    }
    //!/* Ticket Management */
    public function listAllTickets()
    {
        $tickets = Ticket::paginate(5);
        return view('admin.Ticket Management.list-all-tickets', compact('tickets'));
    }
    public function showTicket($id)
    {
        $ticket = Ticket::where('id', $id)->first();
        $commentaires = Commentaire::where('ticket_id', $id)->get();
        return view('admin.Ticket Management.ticket', compact('ticket', 'commentaires'));
    }
    public function editTicket($id)
    {
        $ticket = Ticket::where('id', $id)->first();
        $statuts = Statut::all();
        $priorites = Priorite::all();
        $categories = Categorie::all();
        $users = User::where('role_id', 2)->get();
        return view('admin.Ticket Management.edit-ticket', compact('ticket', 'statuts', 'priorites', 'categories', 'users'));
    }

    public function updateTicket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validatedData = $request->validate([
            'sujet' => 'required|string',
            'description' => 'required|string',
            'priorite_id' => 'required',
            'statut_id' => 'required',
            'categorie_id' => 'required',
            'assigned_to' => 'nullable',
        ]);

        $originalAssignedTo = $ticket->getOriginal('assigned_to');

        if ($request->has('assigned_to') && $request->assigned_to != $originalAssignedTo) {
            $notification = new Notification();
            $notification->user_id = $ticket->user_id;
            $notification->ticket_id = $ticket->id;
            $notification->message = 'Votre ticket a été attribué';
            $notification->type = 'ticket_attribué';
            $notification->save();

            $techSupport = User::findOrFail($request->assigned_to);
            $techSupportEmail = $techSupport->email;
            Mail::to($techSupportEmail)->send(new TicketAttribuer($ticket));
        }

        $ticket->update($validatedData);

        return redirect()->route('list-all-tickets')->with("success", "Le ticket a été modifié avec succès");
    }
    public function deleteTicket($id)
    {
        $ticket = Ticket::where('id', $id)->first();

        $ticket->delete();

        return back()->with('warning', 'Le ticket a été supprimé');
    }
    public function adminSearch(Request $request)
    {
        $search = $request->input('search');
        $tickets = Ticket::where('sujet', 'like', '%' . $search . '%')
            ->paginate(5);
        return view('admin.Ticket Management.list-all-tickets', compact('tickets'));
    }


    //!/* Comment Management */
    public function storeComment(Request $request, $id)
    {
        $validatedData = $request->validate([
            'commentaire' => 'required|string',
        ]);
        Commentaire::create([
            'commentaire' => $validatedData["commentaire"],
            'user_id' => auth()->id(),
            'ticket_id' => $id
        ]);
        $notification = new Notification();
        $notification->user_id = auth()->id();
        $notification->ticket_id = $id;
        $notification->message = 'Votre ticket a été commenter';
        $notification->type = 'ticket_comment';
        $notification->save();

        return back()->with('success', 'Le commentaire a été ajouté');
    }
    public function deleteComment($id)
    {
        $commentaire = Commentaire::where('id', $id)->first();
        $commentaire->delete();
        return back()->with('warning', 'Le commentaire a été supprimé');
    }

    //! Profile Management
    public function profile()
    {
        $currentUser = auth()->user();
        return view('admin.profile', compact('currentUser'));
    }
    public function updateInfo(Request $request)
    {
        $validatedData = $request->validate([
            'nom_complet' => 'required|string',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);
        $user = Auth::user();
        $user->nom_complet = $validatedData['nom_complet'];
        $user->email = $validatedData['email'];
        $user->save();
        return redirect()->route('profile')->with('success', 'Your profile info has been updated');
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile')->with('success', 'Your password has been updated');
    }
}
