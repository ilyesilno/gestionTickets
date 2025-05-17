<?php

namespace App\Http\Controllers;

use App\Models\Statut;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Priorite;
use App\Models\Categorie;
use App\Models\Commentaire;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TechController extends Controller
{
    public function dashboard()
    {
        $tickets = Ticket::where('assigned_to', auth()->id())->get();
        $agent = User::where('id',auth()->id())->get();
        return view('technicien.technicien-dashboard', compact('tickets','agent'));
    }

    //! Ticket Méthode
    public function listTickets()
    {
        $tickets = Ticket::where('assigned_to', auth()->id())->paginate(5);
        $statuts = Statut::all();
        $priorites = Priorite::all();
        $categories = Categorie::all();
        return view('technicien.Ticket Management.list-tickets', compact('tickets', 'statuts', 'priorites', 'categories'));
    }
    public function afficherTicket($id)
    {
        $ticket = Ticket::where('id', $id)->first();
        $commentaires = Commentaire::where('ticket_id', $id)->get();
        return view('technicien.Ticket Management.show-ticket', compact('ticket', 'commentaires'));
    }
    public function editTicket($id)
    {
        $ticket = Ticket::where('id', $id)->first();
        $statuts = Statut::all();
        return view('technicien.Ticket Management.edit-ticket', compact('ticket', 'statuts'));
    }
    public function updateTicket(Request $request, $id)
    {
        $ticket = Ticket::where('id', $id)->first();

        $validatedData = $request->validate([
            'statut_id' => 'required',
        ]);

        $ticket->update($validatedData);

        return redirect()->route('tech-list-tickets')->with("success", "Le ticket a été modifié avec succès");
    }
    public function techSearch(Request $request)
    {
        $search = $request->input('search');
        $tickets = Ticket::where('assigned_to', auth()->id())
            ->where('sujet', 'like', '%' . $search . '%')
            ->paginate(5);
        return view('technicien.Ticket Management.list-tickets', compact('tickets'));
    }

    //! Comment Management
    public function storeTechComment(Request $request, $id)
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
    public function deleteTechComment($id)
    {
        $commentaire = Commentaire::where('id', $id)->first();
        $commentaire->delete();
        return back()->with('warning', 'Le commentaire a été supprimé');
    }

    //! Profile Management
    public function profile()
    {
        $currentUser = auth()->user();
        return view('technicien.profile', compact('currentUser'));
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
        return redirect()->route('tech-profile')->with('success', 'Your profile info has been updated');
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

        return redirect()->route('tech-profile')->with('success', 'Your password has been updated');
    }
}
