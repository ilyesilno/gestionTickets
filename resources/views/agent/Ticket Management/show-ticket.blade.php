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

@extends('layout.agent-layout')

@section('content')
  @if (session()->has('success'))
    <div id="Alert" class="py-4 px-4 text-lg font-semibold text-white bg-green-600 absolute right-1 top-1 m-2">
      {{ session('success') }}
    </div>
  @endif
  @if (session()->has('warning'))
    <div id="Alert" class="py-4 px-4 text-lg font-semibold text-white bg-red-600 absolute right-1 top-1 m-2">
      {{ session('warning') }}
    </div>
  @endif

  <div class="list-tickets">
    <div class="content pt-6 w-[95%] mx-auto my-5 flex flex-col gap-11">
      <div class="list-tickets w-full bg-gray-100 rounded-lg border border-gray-200 p-5 flex flex-col gap-6">
        <div class="header flex items-center justify-between">
          <h1 class="text-2xl font-medium">List Tickets</h1>
          <form action="{{ route('search-agent-tickets') }}" method="GET"
            class="flex justify-between items-center p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50">
            <input type="text" name="search" placeholder="Search tickets..." class="bg-gray-50 outline-none text-sm ml-4" required />
            <button type="submit"
              class="ml-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg">Search</button>
          </form>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">Sujet</th>
              <th class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">Description</th>
              <th class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">Statut</th>
              <th class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">Priorité</th>
              <th class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">Catégorie</th>
              <th class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">Créer par</th>
              <th class="px-6 py-3 text-center text-xs font-medium border border-gray-400 uppercase tracking-wider">Opération</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($tickets as $ticket)
              <tr>
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
                  <span
                    class="{{ $statutColor[$ticket->statut][0] ?? '' }} {{ $statutColor[$ticket->statut][1] ?? '' }} rounded-lg px-2 py-1 font-semibold whitespace-nowrap">
                    {{ $ticket->statut }}
                  </span>
                </td>

                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <span
                    class="{{ $prioriteColor[$ticket->priorite][0] ?? '' }} {{ $prioriteColor[$ticket->priorite][1] ?? '' }} rounded-lg px-2 py-1 font-semibold">
                    {{ $ticket->priorite }}
                  </span>
                </td>

                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $ticket->categorie }}
                </td>

                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $ticket->getUser('user_id') }}
                </td>

                <td class="px-6 py-3 text-center text-xs font-medium border border-gray-400 tracking-wider">
                  @if (!isset($ticket->assigned_to) && $ticket->statut != 'resolu')
                    <a href="{{ route('selfasign-agent-ticket', ['id' => $ticket->id]) }}"
                      class="text-white bg-[#4DA845] rounded-lg px-3 py-1 inline-block hover:bg-[#3A8A32] transition">
                      Prendre ticket
                    </a>
                  @else
                    <span class="text-gray-500 italic">Aucune opération</span>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="mt-4">
          {{ $tickets->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection
