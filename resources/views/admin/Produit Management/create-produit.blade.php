@extends('layout.admin-layout')
@section('content')
  @if (session()->has('success'))
    <div id="Alert" class="py-4 px-4 text-lg font-semibold text-white bg-green-600 absolute right-1 top-1 m-2">
      {{ session('success') }}
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
  <div class="main">
    <div class="content pt-6 w-[95%] mx-auto my-5 flex flex-col gap-11">
      <div class="profileInfo w-full bg-gray-100 rounded-lg border border-gray-200 p-5 flex flex-col gap-6">
        <h1 class="text-xl text-center font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
          Créer un produit
        </h1>
        <form class="space-y-4 md:space-y-6" action="{{ route('store-produit') }}" method="post">
          @csrf
          <div>
            <label for="nom" class="block mb-2 text-sm font-medium text-gray-900">Nom produit</label>
            <input type="text" name="nom" id="nom"
              class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5"
              placeholder="gestion de ticket  " />
          </div>

          <div>
            <label for="roles" class="block mb-2 text-sm font-medium text-gray-900">Client</label>
            <select name="user_id" id="user_id"
              class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-3">
              <option>Selectionner un client</option>
              @foreach ($users as $user)
                <option value="{{ $user->id }}">
                  {{ $user->nom_complet }} -
                  {{ $user->email }} </option>
              @endforeach
            </select>
          </div>
          
          <button type="submit"
            class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            Créer un produit
          </button>
        </form>
      </div>
    </div>
  </div>
@endsection
