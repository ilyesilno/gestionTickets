@php
  $statutColor = [
      'Créer' => ['bg-[#4DBD75]', 'text-[#256B3D]'],
      'En Cours' => ['bg-[#20A8D8]', 'text-[#0F4C75]'],
      'Fermé' => ['bg-[#F86C6B]', 'text-[#92231A]'],
      'Problème' => ['bg-[#F8991D]', 'text-[#5E4B15]'],
  ];

  $prioriteColor = [
      'Haut' => ['bg-[#F86C6B]', 'text-[#92231A]'],
      'Moyen' => ['bg-[#F8991D]', 'text-[#5E4B15]'],
      'Faible' => ['bg-[#20A8D8]', 'text-[#0F4C75]'],
  ];

@endphp
@extends('layout.employe-layout')
@section('content')
  @if (session()->has('warning'))
    <div id="Alert" class="py-4 px-4 text-lg font-semibold text-white bg-red-600 absolute right-1 top-1 m-2">
      {{ session('warning') }}
    </div>
  @endif
  <div class="main">
    <div class="content pt-6 w-[95%] mx-auto my-5 flex flex-col gap-11">
      <div class="dashboard w-full bg-gray-100 rounded-lg border border-gray-200 p-5 flex flex-col gap-6">
        <div class="dashHeader flex justify-between">
          <h1 class="text-2xl font-medium ">
            Tableau de bord
          </h1>
          <div class="relative">
            <button type="button" id="notifBtn"
              class="w-12 h-12 flex items-center justify-center rounded-full text-white text-sm font-semibold border-none outline-none bg-gray-600 hover:bg-gray-700 active:bg-gray-600">
              <svg xmlns="http://www.w3.org/2000/svg" width="20px" class="cursor-pointer fill-[#fff]"
                viewBox="0 0 371.263 371.263">
                <path
                  d="M305.402 234.794v-70.54c0-52.396-33.533-98.085-79.702-115.151.539-2.695.838-5.449.838-8.204C226.539 18.324 208.215 0 185.64 0s-40.899 18.324-40.899 40.899c0 2.695.299 5.389.778 7.964-15.868 5.629-30.539 14.551-43.054 26.647-23.593 22.755-36.587 53.354-36.587 86.169v73.115c0 2.575-2.096 4.731-4.731 4.731-22.096 0-40.959 16.647-42.995 37.845-1.138 11.797 2.755 23.533 10.719 32.276 7.904 8.683 19.222 13.713 31.018 13.713h72.217c2.994 26.887 25.869 47.905 53.534 47.905s50.54-21.018 53.534-47.905h72.217c11.797 0 23.114-5.03 31.018-13.713 7.904-8.743 11.797-20.479 10.719-32.276-2.036-21.198-20.958-37.845-42.995-37.845a4.704 4.704 0 0 1-4.731-4.731zM185.64 23.952c9.341 0 16.946 7.605 16.946 16.946 0 .778-.12 1.497-.24 2.275-4.072-.599-8.204-1.018-12.336-1.138-7.126-.24-14.132.24-21.078 1.198-.12-.778-.24-1.497-.24-2.275.002-9.401 7.607-17.006 16.948-17.006zm0 323.358c-14.431 0-26.527-10.3-29.342-23.952h58.683c-2.813 13.653-14.909 23.952-29.341 23.952zm143.655-67.665c.479 5.15-1.138 10.12-4.551 13.892-3.533 3.773-8.204 5.868-13.353 5.868H59.89c-5.15 0-9.82-2.096-13.294-5.868-3.473-3.772-5.09-8.743-4.611-13.892.838-9.042 9.282-16.168 19.162-16.168 15.809 0 28.683-12.874 28.683-28.683v-73.115c0-26.228 10.419-50.719 29.282-68.923 18.024-17.425 41.498-26.887 66.528-26.887 1.198 0 2.335 0 3.533.06 50.839 1.796 92.277 45.929 92.277 98.325v70.54c0 15.809 12.874 28.683 28.683 28.683 9.88 0 18.264 7.126 19.162 16.168z"
                  data-original="#000000"></path>
              </svg>
            </button>
            <div id="notifications"
              class='absolute right-0 shadow-lg bg-white py-2 z-[1000] min-w-full rounded-lg w-[410px] max-h-[500px] overflow-auto hidden'>
              <div class="flex items-center justify-between my-4 px-4">
                <form action="{{ route('employe-tout-effacer') }}" method="post">
                  @csrf
                  @method('delete')
                  <input type="submit" class="text-xs text-gray-500 cursor-pointer" value="Tout effacer" />
                </form>

                <form action="{{ route('employe-markAllAsRead') }}" method="post">
                  @csrf
                  <input type="submit" class="text-xs text-gray-500 cursor-pointer" value="Tout marquer comme lu" />
                </form>
              </div>
              <ul class="divide-y">
                @foreach ($notifications as $notification)
                  <li
                    class='py-4 px-4 hover:bg-gray-50 text-black text-sm cursor-pointer @if (!$notification->markAsRead) bg-gray-100 @endif'>
                    <a href="{{ route('show-employe-ticket', ['id' => $notification->ticket_id]) }}"
                      class=" flex items-center justify-between">
                      <div class="notif flex gap-3 items-center">
                        <div
                          class="notRead size-3 rounded-full @if ($notification->markAsRead) bg-green-500 @else bg-red-500 @endif">
                        </div>
                        <div class="ml-6">
                          <h3 class="text-sm text-[#333] font-semibold">{{ $notification->message }}</h3>
                          <p class="text-xs text-gray-500 leading-3 mt-2">{{ $notification->created_at }}</p>
                        </div>
                      </div>
                      <form action="{{ route('employe-markAsRead', ['id' => $notification->id]) }}" method="post">
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

        <div class="cards grid grid-cols-4 gap-4">
          <div class="card bg-[#4DBD75] p-7 border border-[#389457] rounded-lg">
            <div class="number text-xl text-white font-medium">
              {{ $tickets->where('statut_id', 1)->count() }}
            </div>
            <div class="text text-xl text-white font-medium">
              Tickets {{ $statuts->where('id', 1)->first()->nom }}
            </div>
          </div>

          <div class="card bg-[#20A8D8] p-7 border border-[#177EA1] rounded-lg">
            <div class="number text-xl text-white font-medium">
              {{ $tickets->whereNotNull('assigned_to')->count() }}
            </div>
            <div class="text text-xl text-white font-medium">
              Tickets Attribués
            </div>
          </div>

          <div class="card bg-[#F86C6B] p-7 border border-[#F6302E] rounded-lg">
            <div class="number text-xl text-white font-medium">
              {{ $tickets->where('statut_id', 3)->count() }}
            </div>
            <div class="text text-xl text-white font-medium">
              Tickets {{ $statuts->where('id', 3)->first()->nom }}
            </div>
          </div>

          <div class="card bg-[#F8991D] p-7 border border-[#795627] rounded-lg">
            <div class="number text-xl text-white font-medium">
              {{ $tickets->where('statut_id', 4)->count() }}
            </div>
            <div class="text text-xl text-white font-medium">
              Tickets {{ $statuts->where('id', 4)->first()->nom }}
            </div>
          </div>
        </div>

      </div>
      <div class="recent-tickets w-full bg-gray-100 rounded-lg border border-gray-200 p-5 flex flex-col gap-6">
        <h1 class="text-2xl font-medium">Tickets Attribués Récemment</h1>
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                Sujet
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                Description
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                Statut
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                Priorité
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                Catégorie
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                Attribué à
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($lastTickets->take(2) as $lastTicket)
              <tr>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <a href="{{ route('show-employe-ticket', ['id' => $lastTicket->id]) }}" class="hover:underline">
                    {{ Str::limit($lastTicket->sujet, 15) }}
                  </a>
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <a href="{{ route('show-employe-ticket', ['id' => $lastTicket->id]) }}" class="hover:underline">
                    {{ Str::limit($lastTicket->description, 20) }}
                  </a>
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <span></span><span
                    class="{{ isset($statutColor[$lastTicket->getStatut('status_id')])
                        ? $statutColor[$lastTicket->getStatut('status_id')][0] .
                            ' ' .
                            $statutColor[$lastTicket->getStatut('status_id')][1] .
                            ' rounded-lg px-2 py-1 font-semibold text-nowrap'
                        : '' }}">
                    {{ $lastTicket->getStatut('status_id') }}
                  </span>
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <span
                    class="{{ isset($prioriteColor[$lastTicket->getPriorite('priorite_id')])
                        ? $prioriteColor[$lastTicket->getPriorite('priorite_id')][0] .
                            ' ' .
                            $prioriteColor[$lastTicket->getPriorite('priorite_id')][1] .
                            ' rounded-lg px-2 py-1 font-semibold'
                        : '' }}">
                    {{ $lastTicket->getPriorite('priorite_id') }}
                  </span>

                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $lastTicket->getCategorie('categorie_id') }}
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $lastTicket->getAssignedTo('assigned_to') }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <div class="flex justify-end mt-2">
          <a href="{{ route('employe-list-tickets') }}"
            class="py-2 px-4 bg-black text-white font-medium rounded-md hover:shadow-md">
            Afficher tout
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection
