<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Statut;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Commentaire;
use App\Models\Notification;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    public function dashboard()
    {
        $tickets = Ticket::where('assigned_to', auth()->id())->get();
        $user = User::where('id',auth()->id())->first();
        $agent = Agent::where('user_id',$user->id)->first();
        $ticketsPerSupport =  Ticket::where('support_level',$agent->support_level,)
        ->where('statut','!=','resolu')
        ->where('statut','!=','ferme')
        ->get();


        return view('agent.agent-dashboard', compact('tickets','agent','ticketsPerSupport'));
    }

    //! Ticket Méthode
    public function listTickets()
    {
        $user = User::where('id',auth()->id())->first();
        $agent = Agent::where('user_id',$user->id)->first();
        $tickets = Ticket::where('support_level', $agent->support_level)
        ->where('statut','!=','ferme')->where('statut','!=','resolu')->paginate(5);

        return view('agent.Ticket Management.list-tickets', compact('tickets', ));
    }
    public function afficherTicket($id)
    {
        $ticket = Ticket::where('id', $id)->first();

        $commentaires = Commentaire::where('ticket_id', $id)->get();
        $produit = Produit::where('user_id',$ticket->user_id)->get()->first();
        return view('agent.Ticket Management.show-ticket', compact('ticket', 'commentaires','produit'));
    }
    public function editTicket($id)
    {
        $ticket = Ticket::where('id', $id)->first();
        return view('agent.Ticket Management.edit-ticket', compact('ticket', ));
    }
    public function updateTicket(Request $request, $id)
    {
        $ticket = Ticket::where('id', $id)->first();

        $validatedData = $request->validate([
            'statut_id' => 'required',
        ]);

        $ticket->update($validatedData);

        return redirect()->route('agent-list-tickets')->with("success", "Le ticket a été modifié avec succès");
    }

    public function selfassignTicket($id)
    {
        $ticket = Ticket::where('id', $id)->first();
        $ticket->assigned_to = auth()->id();
        $ticket->statut = 'en cours';
        $ticket->save();
        return view('agent.Ticket Management.edit-ticket', compact('ticket'));
    }

    public function escalateTicket($id)
    {
        $ticket = Ticket::where('id', $id)->first();
        $level = 1;
        if ($ticket ->support_level == 1){
            $level = 2;
        }elseif($ticket ->support_level == 2){
            $level = 3;
        }

        $ticket->support_level = $level;
        $ticket->assigned_to = null;
        $ticket->statut = 'en cours';
        $ticket->save();
        $notification = new Notification();
        $notification->user_id = auth()->id();
        $notification->ticket_id = $id;
        $notification->message = 'Votre ticket a été éscalé';
        $notification->type = 'ticket_comment';
        $notification->save();
        return redirect()->route('agent-list-tickets')->with("success", "Le ticket a été modifié avec succès");
    }

    public function resolveTicket($id)
    {
        $ticket = Ticket::where('id', $id)->first();
        

        $ticket->assigned_to = null;
        $ticket->statut = 'resolu';
        $ticket->save();
        $notification = new Notification();
        $notification->user_id = auth()->id();
        $notification->ticket_id = $id;
        $notification->message = 'Votre ticket #'.$id.'a été résolu';
        $notification->type = 'ticket_comment';
        $notification->save();
        return redirect()->route('agent-list-tickets')->with("success", "Le ticket a été résolu avec succès");
    }

    public function agentSearch(Request $request)
    {
        $search = $request->input('search');
        $tickets = Ticket::where('assigned_to', auth()->id())
            ->where('sujet', 'like', '%' . $search . '%')
            ->paginate(5);
        return view('agent.Ticket Management.list-tickets', compact('tickets'));
    }

    //! Comment Management
    public function storeagentComment(Request $request, $id)
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
    public function deleteagentComment($id)
    {
        $commentaire = Commentaire::where('id', $id)->first();
        $commentaire->delete();
        return back()->with('warning', 'Le commentaire a été supprimé');
    }

    //! Profile Management
    public function profile()
    {
        $currentUser = auth()->user();
        return view('agent.profile', compact('currentUser'));
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
        return redirect()->route('agent-profile')->with('success', 'Your profile info has been updated');
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

        return redirect()->route('agent-profile')->with('success', 'Your password has been updated');
    }
}
