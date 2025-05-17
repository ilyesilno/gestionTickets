<?php

namespace App\Http\Controllers;

use App\Models\Statut;
use App\Models\Ticket;
use App\Models\Priorite;
use App\Models\Categorie;
use App\Models\Commentaire;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeController extends Controller
{
    public function dashboard()
    {
        $tickets = Ticket::where('user_id', auth()->id())->get();
        $lastTickets = Ticket::where('user_id', auth()->id())
            ->where('assigned_to', '!=', null)
            ->orderBy('updated_at', 'desc')->get();
        $statuts = Statut::all();
        $notifications = Notification::whereHas('ticket', function ($query) use ($tickets) {
            $query->whereIn('id', $tickets->pluck('id'));
        })->orderBy('created_at', 'DESC')->get();
        return view('employe.employe-dashboard', compact('tickets', 'lastTickets', 'statuts', 'notifications'));
    }
    public function listTickets()
    {
        $tickets = Ticket::where('user_id', auth()->id())->paginate(5);
        $statuts = Statut::all();
        $priorites = Priorite::all();
        $categories = Categorie::all();
        return view('employe.Ticket Management.list-tickets', compact('tickets', 'statuts', 'priorites', 'categories'));
    }
    public function storeTicket(Request $request)
    {
        $validatedData = $request->validate([
            'sujet' => 'required|string',
            'description' => 'required|string',
            'priorite_id' => 'required|string',
            'categorie_id' => 'required|string',
        ]);
        Ticket::create([
            'sujet' => $validatedData["sujet"],
            'description' => $validatedData["description"],
            'user_id' => auth()->id(),
            'priorite_id' => $validatedData["priorite_id"],
            'statut_id' => 1,
            'categorie_id' => $validatedData["categorie_id"],
        ]);
        return redirect()->route('employe-list-tickets')->with("success", "Le ticket a été ajouté avec succès");
    }
    public function afficherTicket($id)
    {
        $ticket = Ticket::where('id', $id)->first();
        $commentaires = Commentaire::where('ticket_id', $id)->get();
        return view('employe.Ticket Management.show-ticket', compact('ticket', 'commentaires'));
    }
    public function editTicket($id)
    {
        $ticket = Ticket::where('id', $id)->first();
        $statuts = Statut::all();
        $priorites = Priorite::all();
        $categories = Categorie::all();
        return view('employe.Ticket Management.edit-ticket', compact('ticket', 'statuts', 'priorites', 'categories'));
    }
    public function updateTicket(Request $request, $id)
    {
        $ticket = Ticket::where('id', $id)->first();

        $validatedData = $request->validate([
            'sujet' => 'required|string',
            'description' => 'required|string',
            'priorite_id' => 'required',
            'statut_id' => 'required',
            'categorie_id' => 'required',
        ]);

        $ticket->update($validatedData);

        return redirect()->route('employe-list-tickets')->with("success", "Le ticket a été modifié avec succès");
    }
    public function deleteTicket($id)
    {
        $ticket = Ticket::where('id', $id)->first();

        $ticket->delete();

        return back()->with('warning', 'Le ticket a été supprimé');
    }
    public function employeSearch(Request $request)
    {
        $search = $request->input('search');
        $tickets = Ticket::where('user_id', auth()->id())
            ->where('sujet', 'like', '%' . $search . '%')
            ->paginate(5);
        $statuts = Statut::all();
        $priorites = Priorite::all();
        $categories = Categorie::all();
        return view('employe.Ticket Management.list-tickets', compact('tickets', 'statuts', 'priorites', 'categories'));
    }

    //! Comment Management
    public function storeEmployeComment(Request $request, $id)
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
    public function deleteEmployeComment($id)
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

        return redirect()->route('employe-dashboard')->with('success', 'Notification marquée comme lue avec succès.');
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

        return redirect()->route('employe-dashboard')->with('success', 'Notifications marquées comme lues avec succès.');
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
            return redirect()->route('employe-dashboard')->with('success', 'Toutes les notifications ont été effacées avec succès');
        } else {
            return back()->with("warning", "Vous n'avez pas de notification à effacer");
        }
    }


    //! Profile Management
    public function profile()
    {
        $currentUser = auth()->user();
        return view('employe.profile', compact('currentUser'));
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
        return redirect()->route('employe-profile')->with('success', 'Your profile info has been updated');
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

        return redirect()->route('employe-profile')->with('success', 'Your password has been updated');
    }
}
