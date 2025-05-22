@extends('layout.admin-layout') {{-- Assure-toi que ce layout existe --}}

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">
    <h1 class="text-3xl font-bold text-blue-600 mb-6">Changer le logo</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Affichage du logo actuel --}}
    <div class="mb-6">
        <p class="font-semibold mb-2">Logo actuel :</p>
        <img src="{{ $logoPath ? asset('storage/' . $logoPath) : asset('images/default-logo.png') }}" alt="Logo" class="h-16 mx-auto">
    </div>

    {{-- Formulaire de mise à jour du logo --}}
    <form action="{{ route('admin.settings.updateLogo') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        {{-- Pas besoin de @method('PUT') si c'est une route POST --}}
        <div>
            <label for="logo" class="block font-semibold text-gray-700 mb-2">Nouveau logo (PNG, JPG, max 2MB)</label>
            <input type="file" id="logo" name="logo"
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
    
        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded transition">
            Mettre à jour le logo
        </button>
    </form>
    
</div>
@endsection