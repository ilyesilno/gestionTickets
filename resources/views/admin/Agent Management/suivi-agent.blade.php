@extends('layout.admin-layout')

@section('content')
<h2 class="text-3xl font-bold text-gray-900 mb-8">Suivi d’un Agent</h2>

<form method="GET" action="{{ route('admin.suivi.agent') }}" class="mb-10 max-w-md">
    <label for="agent_id" class="block mb-3 font-semibold text-gray-700">Choisir un agent :</label>
    <select name="agent_id" id="agent_id" class="w-full rounded-lg border border-gray-300 p-3 text-gray-800 focus:border-indigo-500 focus:ring focus:ring-indigo-300 cursor-pointer" onchange="this.form.submit()">
        <option value="">-- Sélectionner un agent --</option>
        @foreach ($agents as $agent)
            <option value="{{ $agent->id }}" {{ request('agent_id') == $agent->id ? 'selected' : '' }}>
                {{ $agent->nom_complet }}
            </option>
        @endforeach
    </select>
</form>

@if ($selectedAgent && $agentData)
    <h3 class="text-2xl font-semibold mb-6 text-gray-900">Statistiques de {{ $selectedAgent->nom_complet }}</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 max-w-6xl">

        <div class="card max-w-xs p-6 rounded-xl border-2 border-pink-400 bg-gradient-to-br from-pink-100 via-pink-50 to-pink-100 shadow-lg">
            <div class="text-sm text-pink-700 font-semibold truncate break-words" title="{{ $selectedAgent->email }}">
                {{ $selectedAgent->email }}
            </div>
            <div class="text-lg text-pink-900 font-bold mt-3 uppercase tracking-wide">
                Email
            </div>
        </div>

        <div class="card max-w-xs p-6 rounded-xl border-2 border-teal-400 bg-gradient-to-br from-teal-100 via-teal-50 to-teal-100 shadow-lg">
            <div class="text-4xl text-teal-700 font-extrabold">
                {{ $agentData->support_level }}
            </div>
            <div class="text-lg text-teal-900 font-bold mt-3 uppercase tracking-wide">
                Support Level
            </div>
        </div>

        <div class="card max-w-xs p-6 rounded-xl border-2 border-yellow-400 bg-gradient-to-br from-yellow-100 via-yellow-50 to-yellow-100 shadow-lg">
            <div class="text-4xl text-yellow-700 font-extrabold">
                {{ $agentData->ticket_resolu }}
            </div>
            <div class="text-lg text-yellow-900 font-bold mt-3 uppercase tracking-wide">
                Tickets Résolus
            </div>
        </div>

        <div class="card max-w-xs p-6 rounded-xl border-2 border-purple-400 bg-gradient-to-br from-purple-100 via-purple-50 to-purple-100 shadow-lg">
            <div class="text-4xl text-purple-700 font-extrabold">
                {{ $agentData->ticket_escale }}
            </div>
            <div class="text-lg text-purple-900 font-bold mt-3 uppercase tracking-wide">
                Tickets Escaladés
            </div>
        </div>

    </div>
@elseif (request('agent_id'))
    <p class="text-red-600 font-semibold mt-6 max-w-md">Aucune donnée trouvée pour cet agent.</p>
@endif
@endsection
