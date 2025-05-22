@extends('layout.admin-layout')

@section('content')
    <h2>Suivi d’un Agent</h2>

    <form method="GET" action="{{ route('admin.suivi.agent') }}" class="mb-4">
        <label for="agent_id">Choisir un agent :</label>
        <select name="agent_id" id="agent_id" class="form-control" onchange="this.form.submit()">
            <option value="">-- Sélectionner un agent --</option>
            @foreach ($agents as $agent)
                <option value="{{ $agent->id }}" {{ request('agent_id') == $agent->id ? 'selected' : '' }}>
                    {{ $agent->nom_complet }}
                </option>
            @endforeach
        </select>
    </form>

    @if ($selectedAgent && $agentData)
        <h4>Statistiques de {{ $selectedAgent->nom_complet }}</h4>
        <ul>
            <li><strong>Email :</strong> {{ $selectedAgent->email }}</li>
            <li><strong>Support level :</strong> {{ $agentData->support_level }}</li>
            <li><strong>Tickets résolus :</strong> {{ $agentData->ticket_resolu }}</li>
            <li><strong>Tickets escaladés :</strong> {{ $agentData->ticket_escale }}</li>
        </ul>
    @elseif (request('agent_id'))
        <p class="text-danger">Aucune donnée trouvée pour cet agent.</p>
    @endif
@endsection
