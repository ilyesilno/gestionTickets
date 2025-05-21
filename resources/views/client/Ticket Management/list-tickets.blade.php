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
@extends('layout.client-layout')
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
          <h1 class="text-2xl font-medium ">List Tickets</h1>
          <button id="openCreerTicketModalBtn" 
            class="py-2 px-4 bg-black text-white font-medium rounded-md hover:shadow-md">Ajouter un
            ticket</button>
        </div>
        <div class="header flex items-center justify-end">
          <form action="{{ route('search-client-tickets') }}" method="GET"
            class="flex justify-between items-center p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50">
            @csrf
            <input type="text" name="search" placeholder="Search tickets..."
              class="bg-gray-50 outline-none text-sm ml-4" required />
            <button type="submit"
              class="ml-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg">Search</button>
          </form>
        </div>
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
                Niveau support
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                Attribué à
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                Opération
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tickets as $ticket)
              <tr>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <a href="{{ route('show-client-ticket', ['id' => $ticket->id]) }}" class="hover:underline">
                    {{ Str::limit($ticket->sujet, 15) }}
                  </a>
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <a href="{{ route('show-client-ticket', ['id' => $ticket->id]) }}" class="hover:underline">
                    {{ Str::limit($ticket->description, 20) }}
                  </a>
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <span
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
                    class="">
                    {{ $ticket->priorite }}
                  </span>
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <span
                    class="">
                    {{ $ticket->categorie }}
                  </span>

                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  N{{ $ticket->support_level }}
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $ticket->getAssignedTo('assigned_to') }}
                </td>
                @if($ticket->statut == 'resolu')
                <td
                  class="px-6 py-3 text-base font-medium border border-gray-400 tracking-wider grid grid-cols-1 gap-2 text-center">
                  <a href="{{ route('close-client-ticket', ['id' => $ticket->id]) }}"
                    class="text-white text-base font-medium bg-[#4DA845] rounded-lg">Ferme ticket</a>
                </td>
                @endif
              </tr>
            @endforeach
          </tbody>
        </table>
        <div>
          {{ $tickets->links() }}
        </div>
      </div>
    </div>
  </div>

  {{-- Creer Ticket --}}
  <div id="creerTicketModal" class="modal hidden fixed inset-0 z-50 overflow-hidden bg-gray-500 bg-opacity-50">
    <div class="modal-content relative bg-white shadow-md mx-auto my-20 w-1/3 p-6 rounded-lg">
      <span class="close text-3xl absolute top-0 right-0 mt-2 mr-4 text-gray-900 cursor-pointer">&times;</span>
      <h2 class="text-xl font-bold mb-4">Créer un nouveau ticket</h2>
      <form id="creerTicketsForm" action="{{ route('store-ticket') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label for="sujet" class="block mb-2 text-sm font-medium text-gray-900">Sujet</label>
          <input type="text" name="sujet" id="sujet"
            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5" />
          @error('sujet')
            <span>{{ $message }}</span>
          @enderror
        </div>
        <div class="mb-3">
          <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
          <input type="text" name="description" id="description"
            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 resize-vertical" />
          @error('description')
            <span>{{ $message }}</span>
          @enderror
        </div>
        <div class="mb-3">
          <label for="priorite_id" class="block mb-2 text-sm font-medium text-gray-900">Priorite</label>
          <select name="priorite"
            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5">
            <option disabled selected>Selectionner une priorité</option>
              <option value="basse">Basse
              </option>
              <option value="basse">Moyenne
              </option>
              <option value="basse">Haute
              </option>
          </select>
          
        </div>
        <div class="mb-3">
          <label for="categorie_id" class="block mb-2 text-sm font-medium text-gray-900">Categorie</label>
          <select name="categorie"
            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5">
            <option disabled selected>Selectionner une catégorie</option>
              <option value="bug">
                Bug
              </option>
              <option value="question">
                Question
              </option>
          </select>
        </div>
        <button type="submit"
          class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
          Ajouter un Ticket
        </button>
      </form>
    </div>
  </div>
@endsection
