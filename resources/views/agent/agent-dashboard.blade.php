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
    <div id="Alert"
      class="fixed top-4 right-4 z-50 py-3 px-5 bg-red-600 text-white font-semibold rounded shadow-md animate-fade-in">
      {{ session('warning') }}
    </div>
  @endif

  <div class=" mx-auto px-6 py-8">
    <!-- Dashboard Header -->
    <div class="mb-10">
      <h1 class="text-3xl font-bold text-gray-800">Tableau de bord</h1>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-12">
      <div
        class="p-5 rounded-lg border-2 border-purple-400 bg-gradient-to-br from-purple-100 via-purple-50 to-purple-100 shadow-md">
        <div class="text-4xl font-extrabold text-purple-700">{{ $tickets->count() }}</div>
        <div class="mt-2 text-lg font-semibold text-purple-900">Tickets Attribués</div>
      </div>

      <div
        class="p-5 rounded-lg border-2 border-green-400 bg-gradient-to-br from-green-100 via-green-50 to-green-100 shadow-md">
        <div class="text-4xl font-extrabold text-green-700">{{ $ticketsPerSupport->count() }}</div>
        <div class="mt-2 text-lg font-semibold text-green-900">Tickets de support N{{ $agent->support_level }}</div>
      </div>

      {{-- Tu peux décommenter et personnaliser si tu veux plus de cartes --}}
      {{-- <div
        class="p-5 rounded-lg border-2 border-red-400 bg-gradient-to-br from-red-100 via-red-50 to-red-100 shadow-md">
        <div class="text-4xl font-extrabold text-red-700">{{ $tickets->where('statut', 'resolu')->count() }}</div>
        <div class="mt-2 text-lg font-semibold text-red-900">Tickets complétés</div>
      </div> --}}
    </div>

    <!-- Tickets Tables -->
    <section class="mb-14">
      <h2 class="text-2xl font-semibold text-gray-700 mb-6">Tickets Attribués</h2>
      <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              @foreach (['Sujet', 'Description', 'Statut', 'Priorité', 'Catégorie', 'Créer par'] as $header)
                <th scope="col"
                  class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                  {{ $header }}
                </th>
              @endforeach
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($tickets->take(2) as $ticket)
              <tr>
                <td class="px-6 py-3 border border-gray-300 text-sm font-medium text-gray-700">
                  <a href="{{ route('show-agent-ticket', ['id' => $ticket->id]) }}"
                    class="hover:underline">{{ Str::limit($ticket->sujet, 15) }}</a>
                </td>
                <td class="px-6 py-3 border border-gray-300 text-sm text-gray-600">
                  <a href="{{ route('show-agent-ticket', ['id' => $ticket->id]) }}"
                    class="hover:underline">{{ Str::limit($ticket->description, 20) }}</a>
                </td>
                <td class="px-6 py-3 border border-gray-300 text-sm">
                  <span
                    class="{{ $statutColor[$ticket->statut][0] ?? '' }} {{ $statutColor[$ticket->statut][1] ?? '' }} rounded-lg px-2 py-1 font-semibold whitespace-nowrap">
                    {{ $ticket->statut }}
                  </span>
                </td>
                <td class="px-6 py-3 border border-gray-300 text-sm">
                  <span
                    class="{{ $prioriteColor[$ticket->priorite][0] ?? '' }} {{ $prioriteColor[$ticket->priorite][1] ?? '' }} rounded-lg px-2 py-1 font-semibold">
                    {{ $ticket->priorite }}
                  </span>
                </td>
                <td class="px-6 py-3 border border-gray-300 text-sm text-gray-700">{{ $ticket->categorie }}</td>
                <td class="px-6 py-3 border border-gray-300 text-sm text-gray-700">
                  {{ $ticket->getUser('user_id') }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="flex justify-end mt-3">
        <a href="{{ route('agent-list-tickets') }}"
          class="inline-block bg-black text-white px-5 py-2 rounded-md font-semibold hover:shadow-lg transition-shadow">
          Afficher tout
        </a>
      </div>
    </section>

    <section>
      <h2 class="text-2xl font-semibold text-gray-700 mb-6">Tickets de support</h2>
      <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              @foreach (['Sujet', 'Description', 'Statut', 'Priorité', 'Catégorie', 'Créer par'] as $header)
                <th scope="col"
                  class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border border-gray-300">
                  {{ $header }}
                </th>
              @endforeach
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($ticketsPerSupport->take(2) as $ticket)
              <tr>
                <td class="px-6 py-3 border border-gray-300 text-sm font-medium text-gray-700">
                  <a href="{{ route('show-agent-ticket', ['id' => $ticket->id]) }}"
                    class="hover:underline">{{ Str::limit($ticket->sujet, 15) }}</a>
                </td>
                <td class="px-6 py-3 border border-gray-300 text-sm text-gray-600">
                  <a href="{{ route('show-agent-ticket', ['id' => $ticket->id]) }}"
                    class="hover:underline">{{ Str::limit($ticket->description, 20) }}</a>
                </td>
                <td class="px-6 py-3 border border-gray-300 text-sm">
                  <span
                    class="{{ $statutColor[$ticket->statut][0] ?? '' }} {{ $statutColor[$ticket->statut][1] ?? '' }} rounded-lg px-2 py-1 font-semibold whitespace-nowrap">
                    {{ $ticket->statut }}
                  </span>
                </td>
                <td class="px-6 py-3 border border-gray-300 text-sm">
                  <span
                    class="{{ $prioriteColor[$ticket->priorite][0] ?? '' }} {{ $prioriteColor[$ticket->priorite][1] ?? '' }} rounded-lg px-2 py-1 font-semibold">
                    {{ $ticket->priorite }}
                  </span>
                </td>
                <td class="px-6 py-3 border border-gray-300 text-sm text-gray-700">{{ $ticket->categorie }}</td>
                <td class="px-6 py-3 border border-gray-300 text-sm text-gray-700">
                  {{ $ticket->getUser('user_id') }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="flex justify-end mt-3">
        <a href="{{ route('agent-list-tickets') }}"
          class="inline-block bg-black text-white px-5 py-2 rounded-md font-semibold hover:shadow-lg transition-shadow">
          Afficher tout
        </a>
      </div>
    </section>
  </div>
@endsection
