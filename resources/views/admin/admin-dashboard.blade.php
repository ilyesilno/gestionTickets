@php
$statutColor = [
    'ouvert' => ['bg-gradient-to-r from-blue-300 to-blue-500', 'text-blue-900'],
    'en cours' => ['bg-gradient-to-r from-purple-300 to-purple-500', 'text-purple-900'],
    'resolu' => ['bg-gradient-to-r from-green-300 to-green-500', 'text-green-900'],
    'ferme' => ['bg-gradient-to-r from-yellow-300 to-yellow-500', 'text-yellow-900'],
];

$prioriteColor = [
    'Haut' => ['bg-gradient-to-r from-red-300 to-red-500', 'text-red-900'],
    'Moyen' => ['bg-gradient-to-r from-yellow-300 to-yellow-500', 'text-yellow-900'],
    'Faible' => ['bg-gradient-to-r from-cyan-300 to-cyan-500', 'text-cyan-900'],
];
@endphp

@extends('layout.admin-layout')

@section('content')
<div class="main bg-gray-50 min-h-screen py-8">
<div class="content w-[95%] mx-auto flex flex-col gap-12">

  <div class="dashboard bg-white rounded-xl p-6 shadow-md">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">
      Tableau de bord
    </h1>

    <div class="cards grid grid-cols-4 gap-8">
      <div class="card p-7 rounded-lg border-2 border-blue-400 bg-gradient-to-br from-blue-100 via-blue-50 to-blue-100 shadow-md">
        <div class="number text-3xl text-blue-700 font-extrabold">
          {{ $tickets->where('statut', 'ouvert')->count() }}
        </div>
        <div class="text text-lg text-blue-900 font-semibold mt-2">
          Tickets Ouverts
        </div>
      </div>
      <div class="card p-7 rounded-lg border-2 border-purple-400 bg-gradient-to-br from-purple-100 via-purple-50 to-purple-100 shadow-md">
        <div class="number text-3xl text-purple-700 font-extrabold">
          {{ $tickets->where('statut', 'en cours')->count() }}
        </div>
        <div class="text text-lg text-purple-900 font-semibold mt-2">
          Tickets en traitement
        </div>
      </div>
      <div class="card p-7 rounded-lg border-2 border-green-400 bg-gradient-to-br from-green-100 via-green-50 to-green-100 shadow-md">
        <div class="number text-3xl text-green-700 font-extrabold">
          {{ $tickets->where('statut', 'resolu')->count() }}
        </div>
        <div class="text text-lg text-green-900 font-semibold mt-2">
          Tickets Résolus
        </div>
      </div>
      <div class="card p-7 rounded-lg border-2 border-yellow-400 bg-gradient-to-br from-yellow-100 via-yellow-50 to-yellow-100 shadow-md">
        <div class="number text-3xl text-yellow-700 font-extrabold">
          {{ $tickets->where('statut', 'ferme')->count() }}
        </div>
        <div class="text text-lg text-yellow-900 font-semibold mt-2">
          Tickets Fermés
        </div>
      </div>
    </div>
  </div>

  <div class="recent-mdp bg-white rounded-xl p-6 shadow-md ">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tickets Récents</h1>
    <div class="overflow-x-auto rounded-lg border border-gray-200">
      <table class="min-w-full divide-y divide-gray-200 text-gray-700">
        <thead class="bg-gray-100 uppercase text-xs font-semibold tracking-wider">
          <tr>
            <th class="px-6 py-3 border border-gray-200 text-left">Sujet</th>
            <th class="px-6 py-3 border border-gray-200 text-left">Description</th>
            <th class="px-6 py-3 border border-gray-200 text-left">Statut</th>
            <th class="px-6 py-3 border border-gray-200 text-left">Priorité</th>
            <th class="px-6 py-3 border border-gray-200 text-left">Catégorie</th>
            <th class="px-6 py-3 border border-gray-200 text-left">Nom de l'employé</th>
            <th class="px-6 py-3 border border-gray-200 text-left">Email de l'employé</th>
            <th class="px-6 py-3 border border-gray-200 text-left">Attribué à</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach ($tickets->take(3) as $ticket)
          <tr>
            <td class="px-6 py-3 border border-gray-200 text-xs font-medium tracking-wide">
              <a href="{{ route('show-ticket', ['id'=>$ticket->id]) }}" class="hover:underline text-blue-600">
                {{ Str::limit($ticket->sujet, 20) }}
              </a>
            </td>
            <td class="px-6 py-3 border border-gray-200 text-xs tracking-wide">
              <a href="{{ route('show-ticket', ['id'=>$ticket->id]) }}" class="hover:underline text-gray-700">
                {{ Str::limit($ticket->description, 30) }}
              </a>
            </td>
            <td class="px-6 py-3 border border-gray-200 text-xs font-semibold">
              <span class="inline-block rounded-lg px-2 py-1 text-xs
                {{ $statutColor[$ticket->statut][0] ?? '' }} {{ $statutColor[$ticket->statut][1] ?? '' }}">
                {{ ucfirst($ticket->statut) }}
              </span>
            </td>
            <td class="px-6 py-3 border border-gray-200 text-xs font-semibold">
              <span class="inline-block rounded-lg px-2 py-1 text-xs
                {{ $prioriteColor[$ticket->priorite][0] ?? '' }} {{ $prioriteColor[$ticket->priorite][1] ?? '' }}">
                {{ ucfirst($ticket->priorite) }}
              </span>
            </td>
            <td class="px-6 py-3 border border-gray-200 text-xs tracking-wide">
              {{ $ticket->categorie }}
            </td>
            <td class="px-6 py-3 border border-gray-200 text-xs tracking-wide">
              {{ $ticket->getUser('user_id') }}
            </td>
            <td class="px-6 py-3 border border-gray-200 text-xs tracking-wide">
              {{ $ticket->getUserEmail('user_id') }}
            </td>
            <td class="px-6 py-3 border border-gray-200 text-xs tracking-wide">
              {{ $ticket->getAssignedTo('assigned_to') }}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="flex justify-end mt-4">
      <a href="{{ route('list-all-tickets') }}" 
         class="py-2 px-5 bg-gradient-to-r from-blue-400 to-cyan-500 text-white font-semibold rounded-lg shadow hover:from-cyan-500 hover:to-blue-400 transition">
        Afficher tout
      </a>
    </div>
  </div>
  <div class="recent-mdp bg-white rounded-xl p-6 shadow-md w-1/2">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 w-1/2">Mots de passe</h1>
    <div class="overflow-x-auto rounded-lg border border-gray-200 ">
      <table class="min-w-full divide-y divide-gray-200 text-gray-700">
        <thead class="bg-gray-100 uppercase text-xs font-semibold tracking-wider">
          <tr>
            <th class="px-6 py-3 border border-gray-200 text-left">Email</th>
            <th class="px-6 py-3 border border-gray-200 text-left">Nom</th>
        
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach ($usersmdp as $usermdp)
          <tr>
   

  
            <td class="px-6 py-3 border border-gray-200 text-xs tracking-wide">
              {{ $usermdp->email }}
            </td>
            <td class="px-6 py-3 border border-gray-200 text-xs tracking-wide">
              {{ $usermdp->name }}
            </td>
        
            <td class="px-6 py-3 border border-gray-200 text-xs tracking-wide">
              <a href="{{ route('modifier-mdp', ['id' => $usermdp->id]) }}" class="text-blue-600 hover:underline">
                Modifier mot de passe
              </a>  
     
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
 
    </div>
  </div>
</div>
</div>


</div>
</div>
@endsection

