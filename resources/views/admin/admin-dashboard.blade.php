@php
  $statutColor = [
      'open' => ['bg-[#4DBD75]', 'text-[#256B3D]'],
      'process' => ['bg-[#20A8D8]', 'text-[#0F4C75]'],
      'resolved' => ['bg-[#F86C6B]', 'text-[#92231A]'],
      'closed' => ['bg-[#F8991D]', 'text-[#5E4B15]'],
  ];

  $prioriteColor = [
      'Haut' => ['bg-[#F86C6B]', 'text-[#92231A]'],
      'Moyen' => ['bg-[#F8991D]', 'text-[#5E4B15]'],
      'Faible' => ['bg-[#20A8D8]', 'text-[#0F4C75]'],
  ];

@endphp
@extends('layout.admin-layout')
@section('content')
  <div class="main">
    <div class="content pt-6 w-[95%] mx-auto my-5 flex flex-col gap-11">
      <div class="dashboard w-full bg-gray-100 rounded-lg border border-gray-200 p-5 flex flex-col gap-6">
        <h1 class="text-2xl font-medium ">
          Tableau de bord
        </h1>
        <div class="cards grid grid-cols-4 gap-4">

          <div class="card bg-[#4DBD75] p-7 border border-[#389457] rounded-lg">
            <div class="number text-xl text-white font-medium">
              {{ $tickets->where('statut', 'ouvert')->count() }}
            </div>
            <div class="text text-xl text-white font-medium">
               Tickets Ouverts
            </div>
          </div>
          <div class="card bg-[#20A8D8] p-7 border border-[#177EA1] rounded-lg">
            <div class="number text-xl text-white font-medium">
              {{ $tickets->where('statut', 'process')->count() }}
            </div>
            <div class="text text-xl text-white font-medium">
               Tickets en traitement
            </div>
          </div>
          <div class="card bg-[#F86C6B] p-7 border border-[#F6302E] rounded-lg">
            <div class="number text-xl text-white font-medium">
              {{ $tickets->where('statut', 'resolved')->count() }}
            </div>
            <div class="text text-xl text-white font-medium">
               Tickets resolus
            </div>
          </div>
          <div class="card bg-[#F8991D] p-7 border border-[#795627] rounded-lg">
            <div class="number text-xl text-white font-medium">
              {{ $tickets->where('statut', 'closed')->count() }}
            </div>
            <div class="text text-xl text-white font-medium">
               Tickets ferme
            </div>
          </div>
        </div>
      </div>
      <div class="recent-tickets w-full bg-gray-100 rounded-lg border border-gray-200 p-5 flex flex-col gap-6">
        <h1 class="text-2xl font-medium">Tickets Récents</h1>
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                Sujet
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                Description
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                Statut
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                Priorité
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                Catégorie
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                Nom de l'employé
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                Email de l'employé
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                Attribué à
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tickets->take(3) as $ticket)
              <tr>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <a href="{{ route('show-ticket', ['id'=>$ticket->id]) }}" class="hover:underline">
                    {{ Str::limit($ticket->sujet, 15) }}
                  </a>
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <a href="{{ route('show-ticket', ['id'=>$ticket->id]) }}" class="hover:underline">
                    {{ Str::limit($ticket->description, 20) }}
                  </a>
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <span></span><span
                    class="{{ isset($statutColor[$ticket->statut])
                        ? $statutColor[$ticket->statut][0] .
                            ' ' .
                            $statutColor[$ticket->statut][1] .
                            ' rounded-lg px-2 py-1 font-semibold text-nowrap'
                        : '' }}">
                    {{ $ticket->statut }}
                  </span>
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <span
                    class="{{ isset($prioriteColor[$ticket->priorite])
                        ? $prioriteColor[$ticket->priorite][0] .
                            ' ' .
                            $prioriteColor[$ticket->priorite][1] .
                            ' rounded-lg px-2 py-1 font-semibold'
                        : '' }}">
                    {{ $ticket->priorite }}
                  </span>

                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $ticket->categorie }}
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $ticket->getUser('user_id') }}
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $ticket->getUserEmail('user_id') }}
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $ticket->getAssignedTo('assigned_to')}}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <div class="flex justify-end mt-2">
          <a href="{{ route('list-all-tickets') }}" class="py-2 px-4 bg-black text-white font-medium rounded-md hover:shadow-md">
            Afficher tout</a>
        </div>
      </div>
    </div>
  </div>
@endsection
