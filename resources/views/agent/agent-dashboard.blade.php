@php
$statutColor = [
    'ouvert' => ['bg-gradient-to-r from-blue-300 to-blue-500', 'text-blue-900'],
    'en cours' => ['bg-gradient-to-r from-purple-300 to-purple-500', 'text-purple-900'],
    'resolu' => ['bg-gradient-to-r from-green-300 to-green-500', 'text-green-900'],
    'ferme' => ['bg-gradient-to-r from-yellow-300 to-yellow-500', 'text-yellow-900'],
];

  $prioriteColor = [
      'Haut' => ['bg-[#F86C6B]', 'text-[#92231A]'],
      'Moyen' => ['bg-[#F8991D]', 'text-[#5E4B15]'],
      'Faible' => ['bg-[#20A8D8]', 'text-[#0F4C75]'],
  ];

@endphp
@extends('layout.agent-layout')
@section('content')
  @if (session()->has('warning'))
    <div id="Alert" class="py-4 px-4 text-lg font-semibold text-white bg-red-600 absolute right-1 top-1 m-2">
      {{ session('warning') }}
    </div>
  @endif
  <div class="main">
    <div class="content pt-6 w-[95%] mx-auto my-5 flex flex-col gap-11">
      <div class="dashboard w-full bg-gray-100 rounded-lg border border-gray-200 p-5 flex flex-col gap-6">
        <div class="dashHeader flex justify-between">
          <h1 class="text-2xl font-medium ">
            Tableau de bord
          </h1>
        </div>
        <div class="cards grid grid-cols-4 gap-8">
        <div class="card p-3 rounded-lg border-2 border-purple-400 bg-gradient-to-br from-purple-100 via-purple-50 to-purple-100 shadow-md">
          <div class="number text-3xl text-purple-700 font-extrabold">
              {{ $tickets->count() }}
            </div>
            <div class="text text-lg text-purple-900 font-semibold mt-2">
              Tickets Attribués
            </div>
          </div>

          {{-- <div class="card bg-[#F86C6B] p-7 border border-[#F6302E] rounded-lg">
            <div class="number text-xl text-white font-medium">
              {{ $tickets->where('statut', 'resolved')->count() }}
            </div>
            <div class="text text-xl text-white font-medium">
              Tickets complétés
            </div>
          </div> --}}

          <div class="card p-3 rounded-lg border-2 border-green-400 bg-gradient-to-br from-green-100 via-green-50 to-green-100 shadow-md">
            <div class="number text-3xl text-green-700 font-extrabold">
              {{ $ticketsPerSupport->count() }}
            </div>
            <div class="text text-lg text-green-900 font-semibold mt-2">
              Tickets de support N{{ $agent->support_level }}
            </div>
          </div>
        </div>
        </div>
      </div>
      <div class="recent-tickets w-full bg-gray-100 rounded-lg border border-gray-200 p-5 flex flex-col gap-6">
        <h1 class="text-2xl font-medium">Tickets Attribués </h1>
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
                Créer par
              </th>
            </tr>
          </thead>
          
          <tbody>
            @foreach ($tickets->take(2) as $ticket)
              <tr >
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <a href="{{ route('show-agent-ticket', ['id' => $ticket->id]) }}" class="hover:underline">
                    {{ Str::limit($ticket->sujet, 15) }}
                  </a>
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <a href="{{ route('show-agent-ticket', ['id' => $ticket->id]) }}" class="hover:underline">
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
              </tr>
            @endforeach
          </tbody>
        </table>
        <div class="flex justify-end mt-2">
          <a href="{{ route('agent-list-tickets') }}" class="py-2 px-4 bg-black text-white font-medium rounded-md hover:shadow-md">
            Afficher tout
          </a>
        </div>
      </div>
      <div class="recent-tickets w-full bg-gray-100 rounded-lg border border-gray-200 p-5 flex flex-col gap-6">
        <h1 class="text-2xl font-medium">Tickets de support </h1>
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
                Créer par
              </th>
            </tr>
          </thead>
          
          <tbody>
            @foreach ($ticketsPerSupport->take(2) as $ticket)
              <tr >
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <a href="{{ route('show-agent-ticket', ['id' => $ticket->id]) }}" class="hover:underline">
                    {{ Str::limit($ticket->sujet, 15) }}
                  </a>
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <a href="{{ route('show-agent-ticket', ['id' => $ticket->id]) }}" class="hover:underline">
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
              </tr>
            @endforeach
          </tbody>
        </table>
        <div class="flex justify-end mt-2">
          <a href="{{ route('agent-list-tickets') }}" class="py-2 px-4 bg-black text-white font-medium rounded-md hover:shadow-md">
            Afficher tout
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection
