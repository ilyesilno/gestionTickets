@extends('layout.client-layout')

@section('content')
  @if ($errors->any())
    <div id="Alert" class="py-4 px-4 text-lg font-semibold bg-red-600 text-white absolute right-1 top-1 m-2">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="modifierTicket">
    <div class="content pt-6 w-[95%] mx-auto my-5 flex flex-col gap-11">
      <div class="modifierTicket w-full bg-gray-100 rounded-lg border border-gray-200 p-5 flex flex-col gap-6 h-[90%] overflow-y-scroll">
        <h1 class="text-2xl font-medium mb-5">Modifier Ticket</h1>

        <form action="{{ route('update-client-ticket', ['id' => $ticket->id]) }}" method="POST">
          @csrf
          @method('put')

          <div class="mb-3">
            <label for="sujet" class="block mb-2 text-sm font-medium text-gray-900">Sujet</label>
            <input type="text" name="sujet" id="sujet" value="{{ old('sujet', $ticket->sujet) }}"
              class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5" />
            @error('sujet')
              <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
          </div>

          <div class="mb-3">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
            <textarea name="description" id="description"
              class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 resize-vertical">{{ old('description', $ticket->description) }}</textarea>
            @error('description')
              <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
          </div>

          {{-- 
          <div class="mb-3">
            <label for="priorite_id" class="block mb-2 text-sm font-medium text-gray-900">Priorité</label>
            <select name="priorite_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5">
              @foreach ($priorites as $priorite)
                <option value="{{ $priorite->id }}" @selected(old('priorite_id', $ticket->priorite_id) == $priorite->id)>{{ $priorite->nom }}</option>
              @endforeach
            </select>
            @error('priorite_id')
              <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
          </div>

          <div class="mb-3">
            <label for="statut_id" class="block mb-2 text-sm font-medium text-gray-900">Statut</label>
            <select name="statut_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5">
              @foreach ($statuts as $statut)
                <option value="{{ $statut->id }}" @selected(old('statut_id', $ticket->statut_id) == $statut->id)>{{ $statut->nom }}</option>
              @endforeach
            </select>
            @error('statut_id')
              <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
          </div>

          <div class="mb-3">
            <label for="categorie_id" class="block mb-2 text-sm font-medium text-gray-900">Catégorie</label>
            <select name="categorie_id" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5">
              @foreach ($categories as $categorie)
                <option value="{{ $categorie->id }}" @selected(old('categorie_id', $ticket->categorie_id) == $categorie->id)>{{ $categorie->nom }}</option>
              @endforeach
            </select>
            @error('categorie_id')
              <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
          </div>
          --}}

          <button type="submit"
            class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            Modifier Ticket
          </button>
        </form>
      </div>
    </div>
  </div>
@endsection
