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
          <h1 class="text-2xl font-medium">List Tickets</h1>
          <button id="openCreerTicketModalBtn" 
            class="py-2 px-4 bg-black text-white font-medium rounded-md hover:shadow-md">
            Ajouter un ticket
          </button>
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
              <th class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">Sujet</th>
              <th class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">Description</th>
              <th class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">Statut</th>
              <th class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">Priorité</th>
              <th class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">Catégorie</th>
              <th class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">Niveau support</th>
              <th class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">Attribué à</th>
              <th class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">Opération</th>
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
                  @php
                    $statut = strtolower($ticket->statut);
                    $statutClasses = $statutColor[$statut] ?? [];
                  @endphp
                  <span class="{{ implode(' ', $statutClasses) }} rounded-lg px-2 py-1 font-semibold whitespace-nowrap">
                    {{ ucfirst($ticket->statut) }}
                  </span>
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  @php
                    $priorite = ucfirst($ticket->priorite);
                    $prioriteClasses = $prioriteColor[$priorite] ?? [];
                  @endphp
                  <span class="{{ implode(' ', $prioriteClasses) }} rounded-lg px-2 py-1 font-semibold whitespace-nowrap">
                    {{ $priorite }}
                  </span>
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ ucfirst($ticket->categorie) }}
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  N{{ $ticket->support_level }}
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $ticket->getAssignedTo('assigned_to') }}
                </td>
                <td class="px-6 py-3 text-base font-medium border border-gray-400 tracking-wider text-center">
                  @if (strtolower($ticket->statut) === 'resolved' || strtolower($ticket->statut) === 'resolu')
                    <a href="{{ route('close-client-ticket', ['id' => $ticket->id]) }}"
                      class="text-white text-base font-medium bg-[#4DA845] rounded-lg px-3 py-1 inline-block">
                      Fermer ticket
                    </a>
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

  {{-- Créer Ticket Modal --}}
  <div id="creerTicketModal" class="modal hidden fixed inset-0 z-50 overflow-hidden bg-gray-500 bg-opacity-50">
    <div class="modal-content relative bg-white shadow-md mx-auto my-20 w-1/3 p-6 rounded-lg">
      <button class="close absolute top-2 right-4 text-3xl font-bold text-gray-900 cursor-pointer">&times;</button>
      <h2 class="text-xl font-bold mb-4">Créer un nouveau ticket</h2>
      <form id="creerTicketsForm" action="{{ route('store-ticket') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="sujet" class="block mb-2 text-sm font-medium text-gray-900">Sujet</label>
            <input type="text" name="sujet" id="sujet"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5" />
            @error('sujet')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
            <textarea name="description" id="description" rows="5"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 resize-vertical"></textarea>
            @error('description')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="priorite" class="block mb-2 text-sm font-medium text-gray-900">Priorité</label>
            <select name="priorite" id="priorite"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5">
                <option disabled selected>Sélectionner une priorité</option>
                <option value="basse">Basse</option>
                <option value="moyenne">Moyenne</option>
                <option value="haute">Haute</option>
            </select>
            @error('priorite')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="categorie" class="block mb-2 text-sm font-medium text-gray-900">Catégorie</label>
            <select name="categorie" id="categorie"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5">
                <option disabled selected>Sélectionner une catégorie</option>
                <option value="bug">Bug</option>
                <option value="question">Question</option>
                <option value="autre">Autre</option>
            </select>
            @error('categorie')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>
    
        {{-- New: Document Upload Field --}}
        <div class="mb-3">
            <label for="documents" class="block mb-2 text-sm font-medium text-gray-900">
                Joindre des documents (Max 3 fichiers, 5MB chacun)
            </label>
            <input type="file" name="documents[]" id="documents" multiple
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" />
            <p class="mt-1 text-sm text-gray-500" id="file_input_help">
                Types autorisés : PDF, JPG, PNG, JPEG, DOC, DOCX, XLS, XLSX.
            </p>
            @error('documents.*') {{-- Wildcard for individual file errors --}}
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
            @error('documents') {{-- Error for total file count --}}
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>
    
        <button type="submit"
            class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            Ajouter un Ticket
        </button>
    </form>
    </div>
  </div>

  {{-- Script pour ouvrir/fermer le modal --}}
  <script>
    document.getElementById('openCreerTicketModalBtn').addEventListener('click', function () {
      document.getElementById('creerTicketModal').classList.remove('hidden');
    });
    document.querySelector('#creerTicketModal .close').addEventListener('click', function () {
      document.getElementById('creerTicketModal').classList.add('hidden');
    });
    window.addEventListener('click', function(event) {
      const modal = document.getElementById('creerTicketModal');
      if (event.target === modal) {
        modal.classList.add('hidden');
      }
    });
  </script>
@endsection
