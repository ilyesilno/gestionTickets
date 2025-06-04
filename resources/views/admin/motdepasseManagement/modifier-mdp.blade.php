@extends('layout.admin-layout')
@section('content')
<div class="main bg-gray-50 min-h-screen py-8">
<div class="content w-[95%] mx-auto flex flex-col gap-12">

    <div class="dashboard bg-white rounded-xl p-6 shadow-md">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">
            Modifier mot de passe
        </h1>

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
    </div>
<h1></h1>
<form action="{{route('update-mdp', ['id' => $user->id])}}" method="POST" class="bg-white rounded-lg shadow-md p-6 space-y-4">
<label class="text-lg font-semibold">Modifier le mot de passe de l'utilisateur : <span class="text-blue-600">{{ $user->nom_complet }}</span></label>
@csrf
@method('PUT')
<label>nouveau mot de passe</label>
<input type="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5" placeholder="Nouveau mot de passe" required>
<label>Confirmer mot de passe</label>
<input type="password" name="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5" placeholder="Confirmer mot de passe" required>
<button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
    Modifier mot de passe
</button>   

</form>
</div>
</div>
</div>
@endsection
@section('scripts')
<script>
    // Afficher l'alerte de succès pendant 3 secondes
    setTimeout(function() {
        document.getElementById('Alert').style.display = 'none';
    }, 3000);
</script>
<script>
    // Afficher l'alerte d'erreur pendant 3 secondes
    setTimeout(function() {
        document.getElementById('Alert').style.display = 'none';
    }, 3000);
</script>
<script>
    // Afficher l'alerte de succès pendant 3 secondes
    setTimeout(function() {
        document.getElementById('Alert').style.display = 'none';
    }, 3000);
</script>
<script>
    // Afficher l'alerte d'erreur pendant 3 secondes
    setTimeout(function() {
        document.getElementById('Alert').style.display = 'none';
    }, 3000);
</script>   