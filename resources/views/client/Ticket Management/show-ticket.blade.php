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
  @if ($errors->any())
    <div id="Alert" class="py-4 px-4 text-lg font-semibold bg-red-600 text-white absolute right-1 top-1 m-2">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <div class="ticket">
    <div class="content pt-6 w-[95%] mx-auto my-5 flex flex-col gap-11">
      <div
        class="ticket w-full bg-gray-100 rounded-lg border border-gray-200 p-5 flex flex-col gap-6 h-[90%] overflow-y-scroll">
        <h1 class="text-2xl font-medium mb-5">Ticket</h1>
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
              {{ $ticket->statut }}
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

          <tr>
            <th scope="col"
              class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider bg-gray-50">
              Assigned to
            </th>
            <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
              {{ $ticket->getAssignedTo('assigned_to') }}
            </td>
          </tr>
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
        </table>

      </div>
    </div>
  </div>
  {{-- Create Comment --}}
  <div id="createCommentModal" class="modal hidden fixed inset-0 z-50 overflow-hidden bg-gray-500 bg-opacity-50">
    <div class="modal-content relative bg-white shadow-md mx-auto my-20 w-96 p-6 rounded-lg">
      <span class="close text-3xl absolute top-0 right-0 mt-2 mr-4 text-gray-900 cursor-pointer">&times;</span>
      <h2 class="text-xl font-bold mb-4">Créer un nouveau comment</h2>
      <form id="createCommentForm" action="{{ route('client-store-comment', ['id' => $ticket->id]) }}" method="POST">
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
