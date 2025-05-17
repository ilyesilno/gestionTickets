@extends('layout.technicien-layout')
@section('content')
  @if (session()->has('success'))
    <div id="Alert" class="py-4 px-4 text-lg font-semibold text-white bg-green-600 absolute right-1 top-1 m-2">
      {{ session('success') }}
    </div>
  @endif
  @if ($errors->any())
    <div id="Alert" class="py-4 px-4 text-lg font-semibold bg-red-600 text-white absolute right-1 top-10 m-2">
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
        <h1 class="text-xl font-medium">Informations sur le profil</h1>
        <p class="text-sm">Mettez à jour les informations de profil et l'adresse e-mail de votre compte</p>
        <form action="{{ route('tech-updateInfo') }}" method="POST">
          @csrf
          @method('put')
          <div class="mb-3">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
            <input type="text" name="nom_complet" id="name" value="{{ $currentUser->nom_complet }}"
              class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5" />
          </div class="mb-3">
          <div class="mb-3">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
            <input type="text" name="email" id="email" value="{{ $currentUser->email }}"
              class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5" />
          </div>
          <button type="submit"
            class="text-white bg-gray-800 hover:bg-gray-900 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            Save
          </button>
        </form>
      </div>
      <div class="updatePassword w-full bg-gray-100 rounded-lg border border-gray-200 p-5 flex flex-col gap-6">
        <h1 class="text-xl font-medium ">Modifier le mot de passe</h1>
        <p class="text-sm">Assurez-vous d'utiliser un mot de passe long et aléatoire</p>
        <form action="{{ route('employe-changePassword') }}" method="POST">
          @csrf
          @method('put')
          <div class="mb-3">
            <label for="current_password" class="block mb-2 text-sm font-medium text-gray-900">Current Password</label>
            <input type="password" name="current_password" id="current_password"
              class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5" />
            @error('current_password')
              <span>{{ $message }}</span>
            @enderror
          </div class="mb-3">
          <div class="mb-3">
            <label for="new_password" class="block mb-2 text-sm font-medium text-gray-900">New Password</label>
            <input type="password" name="new_password" id="new_password"
              class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5" />
            @error('new_password')
              <span>{{ $message }}</span>
            @enderror
          </div class="mb-3">
          <div class="mb-3">
            <label for="new_password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Confirm Password</label>
            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
              class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5" />
          </div class="mb-3">
          <button type="submit"
            class="text-white bg-gray-800 hover:bg-gray-900 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            Save
          </button>
        </form>
      </div>
    </div>
  </div>
@endsection
