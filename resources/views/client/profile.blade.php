@extends('layout.client-layout')

@section('content')
  {{-- Alertes succès et erreurs --}}
  @if (session()->has('success'))
    <div id="Alert" 
         class="py-4 px-4 text-lg font-semibold text-white bg-green-600 fixed right-4 top-4 rounded shadow-lg z-50">
      {{ session('success') }}
    </div>
  @endif

  @if ($errors->any())
    <div id="Alert" 
         class="py-4 px-4 text-lg font-semibold bg-red-600 text-white fixed right-4 top-4 rounded shadow-lg z-50 max-w-xs">
      <ul class="list-disc list-inside">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="main">
    <div class="content pt-6 w-[95%] mx-auto my-5 flex flex-col gap-11">

      {{-- Infos profil --}}
      <div class="profileInfo w-full bg-gray-100 rounded-lg border border-gray-200 p-6 flex flex-col gap-6">
        <h1 class="text-xl font-medium">Informations sur le profil</h1>
        <p class="text-sm text-gray-600">Mettez à jour les informations de profil et l'adresse e-mail de votre compte</p>
        <form action="{{ route('client-updateInfo') }}" method="POST" class="space-y-4">
          @csrf
          @method('put')
          <div>
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nom complet</label>
            <input type="text" name="nom_complet" id="name" value="{{ old('nom_complet', $currentUser->nom_complet) }}"
              class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 focus:ring-sky-500 focus:border-sky-500" required />
          </div>
          <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $currentUser->email) }}"
              class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 focus:ring-sky-500 focus:border-sky-500" required />
          </div>
          <button type="submit"
            class="text-white bg-gray-800 hover:bg-gray-900 font-medium rounded-lg text-sm px-5 py-2.5 transition">
            Enregistrer
          </button>
        </form>
      </div>

      {{-- Changer mot de passe --}}
      <div class="updatePassword w-full bg-gray-100 rounded-lg border border-gray-200 p-6 flex flex-col gap-6">
        <h1 class="text-xl font-medium">Modifier le mot de passe</h1>
        <p class="text-sm text-gray-600">Assurez-vous d'utiliser un mot de passe long et aléatoire</p>
        <form action="{{ route('client-changePassword') }}" method="POST" class="space-y-4">
          @csrf
          @method('put')
          <div>
            <label for="current_password" class="block mb-2 text-sm font-medium text-gray-900">Mot de passe actuel</label>
            <input type="password" name="current_password" id="current_password"
              class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 focus:ring-sky-500 focus:border-sky-500" required />
            @error('current_password')
              <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
            @enderror
          </div>
          <div>
            <label for="new_password" class="block mb-2 text-sm font-medium text-gray-900">Nouveau mot de passe</label>
            <input type="password" name="new_password" id="new_password"
              class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 focus:ring-sky-500 focus:border-sky-500" required />
            @error('new_password')
              <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
            @enderror
          </div>
          <div>
            <label for="new_password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Confirmer le nouveau mot de passe</label>
            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
              class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 focus:ring-sky-500 focus:border-sky-500" required />
          </div>
          <button type="submit"
            class="text-white bg-gray-800 hover:bg-gray-900 font-medium rounded-lg text-sm px-5 py-2.5 transition">
            Enregistrer
          </button>
        </form>
      </div>
    </div>
  </div>

  {{-- Script pour masquer les alertes automatiquement --}}
  <script>
    setTimeout(() => {
      const alert = document.getElementById('Alert');
      if (alert) {
        alert.style.transition = 'opacity 0.5s ease';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
      }
    }, 5000);
  </script>
@endsection
