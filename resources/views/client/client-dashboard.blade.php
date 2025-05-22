@php
    $statutColor = [
        'ouvert' => ['bg-gradient-to-r from-blue-300 to-blue-500', 'text-blue-900'],
        'en cours' => ['bg-gradient-to-r from-purple-300 to-purple-500', 'text-purple-900'],
        'resolu' => ['bg-gradient-to-r from-green-300 to-green-500', 'text-green-900'],
        'ferme' => ['bg-gradient-to-r from-yellow-300 to-yellow-500', 'text-yellow-900'],
    ];

    $prioriteColor = [
        'Haut' => ['bg-gradient-to-r from-red-300 to-red-500', 'text-red-900'],
        'Moyen' => ['bg-gradient-to-r from-yellow-300 to-yellow-500', 'text-yellow-900'],
        'Faible' => ['bg-gradient-to-r from-cyan-300 to-cyan-500', 'text-cyan-900'],
    ];
@endphp

@extends('layout.client-layout')

@section('content')
@if (session()->has('warning'))
    <div id="Alert" class="py-4 px-4 text-lg font-semibold text-white bg-red-600 fixed top-4 right-4 rounded shadow-lg z-50">
        {{ session('warning') }}
    </div>
@endif

<div class="main bg-gray-50 min-h-screen py-8">
    <div class="content w-[95%] mx-auto flex flex-col gap-12">

        {{-- Dashboard --}}
        <div class="dashboard bg-white rounded-xl p-6 shadow-md">
            <div class="dashHeader flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Tableau de bord</h1>
                <div class="relative">
                    <button type="button" id="notifBtn"
                        class="w-12 h-12 flex items-center justify-center rounded-full text-white text-sm font-semibold border-none outline-none bg-gray-600 hover:bg-gray-700 active:bg-gray-600">
                        {{ $notifications->where('markAsRead', false)->count() }}
                        &nbsp;
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" class="cursor-pointer fill-white" viewBox="0 0 371.263 371.263">
                            <path d="M305.402 234.794v-70.54c0-52.396-33.533-98.085-79.702-115.151.539-2.695.838-5.449.838-8.204C226.539 18.324 208.215 0 185.64 0s-40.899 18.324-40.899 40.899c0 2.695.299 5.389.778 7.964-15.868 5.629-30.539 14.551-43.054 26.647-23.593 22.755-36.587 53.354-36.587 86.169v73.115c0 2.575-2.096 4.731-4.731 4.731-22.096 0-40.959 16.647-42.995 37.845-1.138 11.797 2.755 23.533 10.719 32.276 7.904 8.683 19.222 13.713 31.018 13.713h72.217c2.994 26.887 25.869 47.905 53.534 47.905s50.54-21.018 53.534-47.905h72.217c11.797 0 23.114-5.03 31.018-13.713 7.904-8.743 11.797-20.479 10.719-32.276-2.036-21.198-20.958-37.845-42.995-37.845a4.704 4.704 0 0 1-4.731-4.731zM185.64 23.952c9.341 0 16.946 7.605 16.946 16.946 0 .778-.12 1.497-.24 2.275-4.072-.599-8.204-1.018-12.336-1.138-7.126-.24-14.132.24-21.078 1.198-.12-.778-.24-1.497-.24-2.275.002-9.401 7.607-17.006 16.948-17.006zm0 323.358c-14.431 0-26.527-10.3-29.342-23.952h58.683c-2.813 13.653-14.909 23.952-29.341 23.952zm143.655-67.665c.479 5.15-1.138 10.12-4.551 13.892-3.533 3.773-8.204 5.868-13.353 5.868H59.89c-5.15 0-9.82-2.096-13.294-5.868-3.473-3.772-5.09-8.743-4.611-13.892.838-9.042 9.282-16.168 19.162-16.168 15.809 0 28.683-12.874 28.683-28.683v-73.115c0-26.228 10.419-50.719 29.282-68.923 18.024-17.425 41.498-26.887 66.528-26.887 1.198 0 2.335 0 3.533.06 50.839 1.796 92.277 45.929 92.277 98.325v70.54c0 15.809 12.874 28.683 28.683 28.683 9.88 0 18.264 7.126 19.162 16.168z"/>
                        </svg>
                    </button>
                    <div id="notifications" class="absolute right-0 shadow-lg bg-white py-2 z-[1000] min-w-full rounded-lg w-[410px] max-h-[500px] overflow-auto hidden">
                        <div class="flex items-center justify-between my-4 px-4">
                            <form action="{{ route('client-tout-effacer') }}" method="post">
                                @csrf
                                @method('delete')
                                <input type="submit" class="text-xs text-gray-500 cursor-pointer" value="Tout effacer" />
                            </form>
                            <form action="{{ route('client-markAllAsRead') }}" method="post">
                                @csrf
                                <input type="submit" class="text-xs text-gray-500 cursor-pointer" value="Tout marquer comme lu" />
                            </form>
                        </div>
                        <ul class="divide-y">
                            @foreach ($notifications as $notification)
                                <li class="py-4 px-4 hover:bg-gray-50 text-black text-sm cursor-pointer @if (!$notification->markAsRead) bg-gray-100 @endif">
                                    <a href="{{ route('show-client-ticket', ['id' => $notification->ticket_id]) }}" class="flex items-center justify-between">
                                        <div class="notif flex gap-3 items-center">
                                            <div class="notRead size-3 rounded-full @if ($notification->markAsRead) bg-green-500 @else bg-red-500 @endif"></div>
                                            <div class="ml-6">
                                                <h3 class="text-sm text-[#333] font-semibold">{{ $notification->message }}</h3>
                                                <p class="text-xs text-gray-500 leading-3 mt-2">{{ $notification->created_at }}</p>
                                            </div>
                                        </div>
                                        <form action="{{ route('client-markAsRead', ['id' => $notification->id]) }}" method="post">
                                            @csrf
                                            <input type="submit" class="text-xs text-gray-500 cursor-pointer" value="Marquer comme lu" />
                                        </form>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Cards statistiques --}}
            <div class="cards grid grid-cols-4 gap-8">
                <div class="card p-7 rounded-lg border-2 border-blue-400 bg-gradient-to-br from-blue-100 via-blue-50 to-blue-100 shadow-md">
                    <div class="number text-3xl text-blue-700 font-extrabold">{{ $tickets->where('statut', 'ouvert')->count() }}</div>
                    <div class="text text-lg text-blue-900 font-semibold mt-2">Tickets Ouverts</div>
                </div>
                <div class="card p-7 rounded-lg border-2 border-purple-400 bg-gradient-to-br from-purple-100 via-purple-50 to-purple-100 shadow-md">
                    <div class="number text-3xl text-purple-700 font-extrabold">{{ $tickets->where('statut', 'en cours')->count() }}</div>
                    <div class="text text-lg text-purple-900 font-semibold mt-2">Tickets en traitement</div>
                </div>
                <div class="card p-7 rounded-lg border-2 border-green-400 bg-gradient-to-br from-green-100 via-green-50 to-green-100 shadow-md">
                    <div class="number text-3xl text-green-700 font-extrabold">{{ $tickets->where('statut', 'resolu')->count() }}</div>
                    <div class="text text-lg text-green-900 font-semibold mt-2">Tickets Résolus</div>
                </div>
                <div class="card p-7 rounded-lg border-2 border-yellow-400 bg-gradient-to-br from-yellow-100 via-yellow-50 to-yellow-100 shadow-md">
                    <div class="number text-3xl text-yellow-700 font-extrabold">{{ $tickets->where('statut', 'ferme')->count() }}</div>
                    <div class="text text-lg text-yellow-900 font-semibold mt-2">Tickets Fermés</div>
                </div>
            </div>
        </div>

        {{-- Derniers tickets --}}
        <div class="lastTickets bg-white rounded-xl p-6 shadow-md">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Derniers tickets</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-gray-700">
                    <thead class="bg-gray-100 uppercase text-xs font-semibold tracking-wider">
                        <tr>
                            <th class="px-6 py-3 border border-gray-200 text-left">Sujet</th>
                            <th class="px-6 py-3 border border-gray-200 text-left">Description</th>
                            <th class="px-6 py-3 border border-gray-200 text-left">Statut</th>
                            <th class="px-6 py-3 border border-gray-200 text-left">Priorité</th>
                            <th class="px-6 py-3 border border-gray-200 text-left">Catégorie</th>
                            <th class="px-6 py-3 border border-gray-200 text-left">Attribué à</th>
                            <th class="px-6 py-3 border border-gray-200 text-left">Niveau support</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($lastTickets->take(5) as $lastTicket)
                        <tr>
                            <td class="px-6 py-3 text-left text-sm font-medium border border-gray-400 truncate max-w-[200px]">{{ $lastTicket->sujet }}</td>
                            <td class="px-6 py-3 text-left text-xs font-normal border border-gray-400 max-w-[300px] break-words">{{ $lastTicket->description }}</td>
                            <td class="px-6 py-3 text-left text-xs font-semibold border border-gray-400">
                                <span class="{{ $statutColor[$lastTicket->statut][0] ?? '' }} {{ $statutColor[$lastTicket->statut][1] ?? '' }} rounded-lg px-2 py-1">
                                    {{ $lastTicket->statut }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-left text-xs font-semibold border border-gray-400">
                                <span class="{{ $prioriteColor[$lastTicket->priorite][0] ?? '' }} {{ $prioriteColor[$lastTicket->priorite][1] ?? '' }} rounded-lg px-2 py-1">
                                    {{ $lastTicket->priorite }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-left text-xs font-normal border border-gray-400">
                                {{ $lastTicket->categorie->nom ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-3 text-left text-xs font-normal border border-gray-400">
                                {{ $lastTicket->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-3 text-left text-xs font-normal border border-gray-400">
                                {{ $lastTicket->niveau_support ?? 'N/A' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Bouton pour créer un ticket --}}
        <div class="flex justify-end">
            <button id="openCreerTicketModalBtn"
                class="py-2 px-4 bg-sky-500 text-white font-medium rounded-md hover:shadow-md transition duration-300">
                Ajouter un ticket
            </button>
        </div>

    </div>
</div>

{{-- Modale création ticket (à adapter si tu as déjà le code) --}}
<div id="creerTicketModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg w-[600px] max-w-full p-6 relative">
        <button id="closeCreerTicketModalBtn" class="absolute top-4 right-4 text-gray-700 hover:text-gray-900 text-2xl font-bold">&times;</button>
        <h3 class="text-xl font-semibold mb-4">Créer un nouveau ticket</h3>
        <form action="{{ route('client-tickets.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="sujet" class="block mb-1 font-medium">Sujet</label>
                <input type="text" name="sujet" id="sujet" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block mb-1 font-medium">Description</label>
                <textarea name="description" id="description" rows="4" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400" required></textarea>
            </div>
            <div class="mb-4">
                <label for="categorie" class="block mb-1 font-medium">Catégorie</label>
                <select name="categorie_id" id="categorie" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400" required>
                    @foreach ($categories as $categorie)
                        <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="priorite" class="block mb-1 font-medium">Priorité</label>
                <select name="priorite" id="priorite" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-400" required>
                    <option value="Faible">Faible</option>
                    <option value="Moyen">Moyen</option>
                    <option value="Haut">Haut</option>
                </select>
            </div>
            <button type="submit" class="bg-sky-600 text-white px-4 py-2 rounded hover:bg-sky-700 transition">Créer</button>
        </form>
    </div>
</div>

{{-- Script pour ouvrir/fermer modale et notifications --}}
<script>
    document.getElementById('openCreerTicketModalBtn').addEventListener('click', () => {
        document.getElementById('creerTicketModal').classList.remove('hidden');
    });
    document.getElementById('closeCreerTicketModalBtn').addEventListener('click', () => {
        document.getElementById('creerTicketModal').classList.add('hidden');
    });

    // Notifications dropdown toggle
    const notifBtn = document.getElementById('notifBtn');
    const notifications = document.getElementById('notifications');
    notifBtn.addEventListener('click', () => {
        notifications.classList.toggle('hidden');
    });

    // Optionnel : fermer notifications quand clic à l'extérieur
    window.addEventListener('click', function(e) {
        if (!notifBtn.contains(e.target) && !notifications.contains(e.target)) {
            notifications.classList.add('hidden');
        }
    });
</script>

@endsection
