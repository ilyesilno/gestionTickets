@extends('layout.agent-layout')

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

        <form action="{{ route('update-agent-ticket', ['id' => $ticket->id]) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label for="statut_id" class="block mb-2 text-sm font-medium text-gray-900">Statut</label>
            <select name="statut_id" id="statut_id"
              class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5">
              @foreach ($statuts as $statut)
                <option value="{{ $statut->id }}" @if ($statut->id == $ticket->statut_id) selected @endif>
                  {{ $statut->nom }}
                </option>
              @endforeach
            </select>
            @error('statut_id')
              <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
          </div>

          <button type="submit"
            class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            Modifier Ticket
          </button>
        </form>
      </div>
    </div>
  </div>
@endsection
