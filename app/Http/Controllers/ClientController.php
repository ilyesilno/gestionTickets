<?php

namespace App\Http\Controllers;

use App\Models\abonnement;
use App\Models\Statut;
use App\Models\Ticket;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Commentaire;
use App\Models\Historique;
use App\Models\Notification;
use App\Models\Sla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function createHistorique($ticketId, $action)
    {
        Historique::create([
            'ticket_id' => $ticketId,
            'action' => $action
        ]);
    }

    public function dashboard()
    {
        $userId = auth()->id();
        $tickets = Ticket::where('user_id', auth()->id())->get();
        $abonnements = abonnement::where('status', 'active')
            ->whereHas('produit', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get();



        $produits = Produit::where('user_id', auth()->id());
        $lastTickets = Ticket::where('user_id', auth()->id())
            ->orderBy('updated_at', 'desc')->get();
        $notifications = Notification::whereHas('ticket', function ($query) use ($tickets) {
            $query->whereIn('id', $tickets->pluck('id'));
        })->orderBy('created_at', 'DESC')->get();
        return view('client.client-dashboard', compact('tickets', 'lastTickets', 'notifications', 'produits', 'abonnements'));
    }
    public function listTickets()
    {
        $tickets = Ticket::where('user_id', auth()->id())->paginate(5);

        return view('client.Ticket Management.list-tickets', compact('tickets',));
    }
    public function storeTicket(Request $request)
    {


        $validatedData = $request->validate([
            'abonnement_id' => 'required',
            'sujet' => 'required|string',
            'description' => 'required|string',
            'priorite' => 'required|string',
            'categorie' => 'required|string',
        ]);


        $ticket = Ticket::create([
            'abonnement_id' => $validatedData["abonnement_id"],
            'sujet' => $validatedData["sujet"],
            'description' => $validatedData["description"],
            'user_id' => auth()->id(),
            'priorite' => $validatedData["priorite"],
            'categorie' => $validatedData["categorie"],
        ]);

        $action = 'Creation de ticket #' . $ticket->id;

        $this->createHistorique($ticket->id, $action);



        return redirect()->route('client-list-tickets')->with("success", "Le ticket a été ajouté avec succès");
    }
    public function afficherTicket($id)
    {
        $ticket = Ticket::where('id', $id)->first();
        $produit = Produit::where('user_id', $ticket->user_id)->get()->first();
        $abonnement = abonnement::where('produitID', $produit->id)->get()->first();
        $sla = Sla::where('id', $abonnement->slaID)->get()->first();

        $commentaires = Commentaire::where('ticket_id', $id)->get();
        return view('client.Ticket Management.show-ticket', compact('ticket', 'produit', 'sla', 'commentaires'));
    }

    public function getSlaDurations($id)
    {
        $qualification = Ticket::where('id', $id)->first()->duree_qualification;

        $resolution = Ticket::where('id', $id)->first()->duree_resolution;



        return response()->json(['qualification' => $qualification, 'resolution' => $resolution]);
    }
    public function editTicket($id)
    {
        $ticket = Ticket::where('id', $id)->first();
        return view('client.Ticket Management.edit-ticket', compact('ticket',));
    }
    public function updateTicket(Request $request, $id)
    {
        $ticket = Ticket::where('id', $id)->first();

        $validatedData = $request->validate([
            'sujet' => 'required|string',
            'description' => 'required|string',

        ]);

        $ticket->update($validatedData);

        return redirect()->route('client-list-tickets')->with("success", "Le ticket a été modifié avec succès");
    }

    public function closeTicket($id)
    {
        $ticket = Ticket::where('id', $id)->first();

        $ticket->statut = 'ferme';

        $ticket->save();


        return redirect()->route('client-list-tickets')->with("success", "Le ticket a été cloture avec succès");
    }
    public function deleteTicket($id)
    {
        $ticket = Ticket::where('id', $id)->first();

        $ticket->delete();

        return back()->with('warning', 'Le ticket a été supprimé');
    }
    public function clientSearch(Request $request)
    {
        $search = $request->input('search');
        $tickets = Ticket::where('user_id', auth()->id())
            ->where('sujet', 'like', '%' . $search . '%')
            ->paginate(5);

        return view('client.Ticket Management.list-tickets', compact('tickets',));
    }

    //! Comment Management
    public function storeclientComment(Request $request, $id)
    {
        $validatedData = $request->validate([
            'commentaire' => 'required|string',
        ]);
        Commentaire::create([
            'commentaire' => $validatedData["commentaire"],
            'user_id' => auth()->id(),
            'ticket_id' => $id
        ]);
        return back()->with('success', 'Le commentaire a été ajouté');
    }
    public function deleteclientComment($id)
    {
        $commentaire = Commentaire::where('id', $id)->first();
        $commentaire->delete();
        return back()->with('warning', 'Le commentaire a été supprimé');
    }
    //! Notification Management
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)->first();
        $notification->markAsRead = true;
        $notification->save();

        return redirect()->route('client-dashboard')->with('success', 'Notification marquée comme lue avec succès.');
    }
    public function markAllAsRead()
    {
        $tickets = Ticket::where('user_id', auth()->id())->get();

        $notifications = Notification::whereHas('ticket', function ($query) use ($tickets) {
            $query->whereIn('id', $tickets->pluck('id'));
        })->get();

        foreach ($notifications as $notification) {
            $notification->markAsRead = true;
            $notification->save();
        }

        return redirect()->route('client-dashboard')->with('success', 'Notifications marquées comme lues avec succès.');
    }

    public function toutEffacer()
    {
        $tickets = Ticket::where('user_id', auth()->id())->get();

        $notifications = Notification::whereHas('ticket', function ($query) use ($tickets) {
            $query->whereIn('id', $tickets->pluck('id'));
        })->get();
        if (count($notifications)) {
            foreach ($notifications as $notification) {
                $notification->delete();
            }
            return redirect()->route('client-dashboard')->with('success', 'Toutes les notifications ont été effacées avec succès');
        } else {
            return back()->with("warning", "Vous n'avez pas de notification à effacer");
        }
    }


    //! Profile Management
    public function profile()
    {
        $currentUser = auth()->user();
        return view('client.profile', compact('currentUser'));
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
        return redirect()->route('client-profile')->with('success', 'Your profile info has been updated');
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
        $user->User::save();

        return redirect()->route('client-profile')->with('success', 'Your password has been updated');
    }
}
