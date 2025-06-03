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
      <div
        class="ticket w-full bg-gray-100 rounded-lg border border-gray-200 p-5 flex flex-col gap-6 h-[90%] overflow-y-scroll">
        <h1 class="text-2xl font-medium mb-5">Ticket</h1>
        @if(!isset($ticket->assigned_to) && $ticket->statut != 'resolu' && $ticket->statut != 'ferme' )
        <div class="flex justify-end mt-3">
          <a href="{{ route('selfasign-agent-ticket',['id' => $ticket->id]) }}"
            class="inline-block bg-gradient-to-br from-green-400 via-green-500 to-green-100 text-black px-5 py-2 rounded-md font-semibold hover:shadow-lg transition-shadow">
            Prendre ticket
          </a>
        </div>
                @endif
        <div class="cards grid grid-cols-2 gap-4">
          <div class="card p-7 rounded-lg border-2 border-light-400 bg-gradient-to-br from-gray-400 via-gray-50 to-white-100 shadow-md text-center">
              <div class="number text-3xl text-light-700 font-extrabold ">
                <span id="qualificationValue"></span> {{$sla->duree_qualification * 60 }} mins
              </div>
              <div class="text text-lg text-light-900 font-semibold mt-2">
                Duree de qualification 
              </div>
            </div>
            <div class="card p-7 rounded-lg border-2 border-light-400 bg-gradient-to-br from-gray-100 via-gray-50 to-white-100 shadow-md text-center">
              <div class="number text-3xl text-light-700 font-extrabold">
                <span id="resolutionValue"></span> {{$sla->duree_resolution * 24}} hrs
              </div>
              <div class="text text-lg text-light-900 font-semibold mt-2">
                Duree  de traitement 
              </div>
            </div>
          </div>
        <table class="min-w-full divide-y divide-gray-200">
          <tr>
            <th scope="col"
              class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider bg-gray-50">
              ID
            </th>
            <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
              {{ $ticket->id }}
            </td>
          </tr>
          <tr>
            <th scope="col"
              class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider bg-gray-50">
              Created at
            </th>
            <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
              {{ $ticket->created_at }}
            </td>
          </tr>
          <tr>
            <th scope="col"
              class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider bg-gray-50">
              Sujet
            </th>
            <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
              {{ $ticket->sujet }}
            </td>
          </tr>
          <tr>
            <th scope="col"
              class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider bg-gray-50">
              Description
            </th>
            <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
              {{ $ticket->description }}
            </td>
          </tr>
          <tr>
            <th scope="col"
              class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider bg-gray-50">
              Statut
            </th>
            <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
              {{ $ticket->statut}}
            </td>
          </tr>
          <tr>
            <th scope="col"
              class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider bg-gray-50">
              Priorite
            </th>
            <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
              {{ $ticket->priorite }}
            </td>
          </tr>
          <tr>
            <th scope="col"
              class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider bg-gray-50">
              Categorie
            </th>
            <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
              {{ $ticket->categorie }}
            </td>
          </tr>
          @if($ticket->assigned_to == auth()->id())
          <tr class="relative">
            <th scope="col"
              class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider bg-gray-50">
              Commentaires
            </th>
           
            <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
              @if ($commentaires->count() > 0)
                @foreach ($commentaires as $commentaire)
                  <div class="bg-gray-100 mb-2 rounded-lg">
                    <span class="text-gray-500 font-semibold uppercase flex gap-2">
                      <span>Par : {{ $commentaire->getUser('user_id') }}</span>
                      <span>({{ $commentaire->created_at }})</span>


                    </span>
                    <p class="text-gray-700">{{ $commentaire->commentaire }}</p>
                  </div>
                @endforeach
              @else
                <p>Pas de commentaire</p>
              @endif

              <button
                class="py-1 px-2 border border-black rounded-full absolute right-1 top-1 flex justify-center items-center"
                id="openCreateCommentModalBtn">
                <i class="fa-solid fa-plus text-sm"></i>
              </button>
            </td>
          </tr>
          @endif

        </table>
        @if($ticket->assigned_to == auth()->id())
        <div class="flex justify-between mt-2">
          <a href="{{ route('resolve-agent-ticket',$ticket->id) }}" class="py-2 px-4 bg-green-500 text-white font-medium rounded-md hover:shadow-md">
            résoudre le ticket
          </a>
          <a href="{{ route('escalate-agent-ticket',$ticket->id) }}" class="py-2 px-4 bg-orange-500 text-white font-medium rounded-md hover:shadow-md">
            Escaller vers N{{ $ticket->support_level+ 1 }}
          </a>
        </div>
        @endif
      </div>
      <div
        class="ticket w-full bg-gray-100 rounded-lg border border-gray-200 p-5 flex flex-col gap-6 h-[90%] overflow-y-scroll">
        <h1 class="text-2xl font-medium mb-5">Produit</h1>
        <table class="min-w-full divide-y divide-gray-200">
          <tr>
            <th scope="col"
              class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider bg-gray-50">
              ID
            </th>
            <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
              {{ $produit->id }}
            </td>
          </tr>
          <tr>
            <th scope="col"
              class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider bg-gray-50">
              Nom d'application
            </th>
            <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
              {{ $produit->nom }}
            </td>
          </tr>
          
          </tr>
          

        </table>

      </div>

      <div class="card mt-4">
        <div class="card-header">
            <h4>Attached Documents</h4>
        </div>
        <div class="card-body">
            @if($ticket->documents->isNotEmpty())
                <ul class="list-group">
                    @foreach($ticket->documents as $document)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ Storage::disk('public')->url($document->chemin) }}" target="_blank">
                                <i class="fas fa-file-alt me-2"></i> {{ $document->nom_fichier }}
                            </a>
                            <form action="{{ route('tickets.remove-document', $document->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>Aucun document n'est attaché à ce ticket.</p>
            @endif
        </div>
    </div>
    </div>
  </div>
  {{-- Create Comment --}}
  <div id="createCommentModal" class="modal hidden fixed inset-0 z-50 overflow-hidden bg-gray-500 bg-opacity-50">
    <div class="modal-content relative bg-white shadow-md mx-auto my-20 w-96 p-6 rounded-lg">
      <span class="close text-3xl absolute top-0 right-0 mt-2 mr-4 text-gray-900 cursor-pointer">&times;</span>
      <h2 class="text-xl font-bold mb-4">Créer un nouveau comment</h2>
      <form id="createCommentForm" action="{{ route('agent-store-comment', ['id' => $ticket->id]) }}" method="POST">
        @csrf
        <div class="mb-4">
          <label for="commentaire" class="block mb-2 text-sm font-medium text-gray-900">Nom du comment :</label>
          <input type="text" id="commentaire" name="commentaire"
            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5">
        </div>
        <button type="submit"
          class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md">Créer</button>
      </form>
    </div>
  </div>
@endsection
