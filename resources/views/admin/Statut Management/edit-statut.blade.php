@extends('layout.admin-layout')
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
  <div class="edit-statut">
    <div class="content pt-6 w-[95%] mx-auto my-5 flex flex-col gap-11">
      <div class="edit-statut w-full bg-gray-100 rounded-lg border border-gray-200 p-5 flex flex-col gap-6">
        <h1 class="text-2xl font-medium">Edit Statut</h1>
        <form id="editStatusForm" action="{{ route('update-statut', ['id'=>$statut->id]) }}" method="POST">
          @csrf
          @method('put')
          <div class="mb-4">
            <label for="nom" class="block mb-2 text-sm font-medium text-gray-900">Nom du statut :</label>
            <input type="text" id="nom" name="nom" value="{{ $statut->nom }}"
              class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5">
          </div>
          <button type="submit"
            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md">Save</button>
        </form>
      </div>
    </div>
  </div>

@endsection