@php
  $statutColor = [
      'Créer' => ['bg-[#4DBD75]', 'text-[#256B3D]'],
      'En Cours' => ['bg-[#20A8D8]', 'text-[#0F4C75]'],
      'Fermé' => ['bg-[#F86C6B]', 'text-[#92231A]'],
      'Problème' => ['bg-[#F8991D]', 'text-[#5E4B15]'],
  ];

  $prioriteColor = [
      'Haut' => ['bg-[#F86C6B]', 'text-[#92231A]'],
      'Moyen' => ['bg-[#F8991D]', 'text-[#5E4B15]'],
      'Faible' => ['bg-[#20A8D8]', 'text-[#0F4C75]'],
  ];

@endphp
@extends('layout.technicien-layout')
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
        <div class="cards grid grid-cols-3 gap-4">
          <div class="card bg-[#4DBD75] p-7 border border-[#389457] rounded-lg">
            <div class="number text-xl text-white font-medium">
              {{ $tickets->count() }}
            </div>
            <div class="text text-xl text-white font-medium">
              Tous les tickets
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

          <div class="card bg-[#F8991D] p-7 border border-[#795627] rounded-lg">
            <div class="number text-xl text-white font-medium">
              {{ $tickets->where('statut', 4)->count() }}
            </div>
            <div class="text text-xl text-white font-medium">
              Ticket Problème
            </div>
          </div>
        </div>
      </div>
      <div class="recent-tickets w-full bg-gray-100 rounded-lg border border-gray-200 p-5 flex flex-col gap-6">
        <h1 class="text-2xl font-medium">Tickets Attribués Récemment</h1>
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
                  <a href="{{ route('show-tech-ticket', ['id' => $ticket->id]) }}" class="hover:underline">
                    {{ Str::limit($ticket->sujet, 15) }}
                  </a>
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <a href="{{ route('show-tech-ticket', ['id' => $ticket->id]) }}" class="hover:underline">
                    {{ Str::limit($ticket->description, 20) }}
                  </a>
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <span></span><span
                    class="{{ isset($statutColor[$ticket->getStatut('status_id')])
                        ? $statutColor[$ticket->getStatut('status_id')][0] .
                            ' ' .
                            $statutColor[$ticket->getStatut('status_id')][1] .
                            ' rounded-lg px-2 py-1 font-semibold text-nowrap'
                        : '' }}">
                    {{ $ticket->getStatut('status_id') }}
                  </span>
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <span
                    class="{{ isset($prioriteColor[$ticket->getPriorite('priorite_id')])
                        ? $prioriteColor[$ticket->getPriorite('priorite_id')][0] .
                            ' ' .
                            $prioriteColor[$ticket->getPriorite('priorite_id')][1] .
                            ' rounded-lg px-2 py-1 font-semibold'
                        : '' }}">
                    {{ $ticket->getPriorite('priorite_id') }}
                  </span>

                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $ticket->getCategorie('categorie_id') }}
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $ticket->getUser('user_id') }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <div class="flex justify-end mt-2">
          <a href="{{ route('tech-list-tickets') }}" class="py-2 px-4 bg-black text-white font-medium rounded-md hover:shadow-md">
            Afficher tout
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection
