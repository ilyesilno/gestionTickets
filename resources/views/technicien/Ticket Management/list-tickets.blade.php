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
@extends('layout.technicien-layout')
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
  <div class="list-tickets">
    <div class="content pt-6 w-[95%] mx-auto my-5 flex flex-col gap-11">
      <div class="list-tickets w-full bg-gray-100 rounded-lg border border-gray-200 p-5 flex flex-col gap-6">
        <div class="header flex items-center justify-between">
          <h1 class="text-2xl font-medium ">List Tickets</h1>
          <form action="{{ route('search-tech-tickets') }}" method="GET"
            class="flex justify-between items-center p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50">
            @csrf
            <input type="text" name="search" placeholder="Search tickets..." class="bg-gray-50 outline-none text-sm ml-4"
              required />
            <button type="submit"
              class="ml-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg">Search</button>
          </form>

        </div>
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
                Créer par
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                Opération
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tickets as $ticket)
              <tr>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <a href="{{ route('show-tech-ticket', ['id' => $ticket->id]) }}" class="hover:underline">
                    {{ Str::limit($ticket->sujet, 15) }}
                  </a>
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <a href="{{ route('show-tech-ticket', ['id' => $ticket->id]) }}" class="hover:underline">
                    {{ Str::limit($ticket->description, 20) }}
                  </a>
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <span
                    class="{{ isset($statutColor[$ticket->getStatut('status_id')])
                        ? $statutColor[$ticket->getStatut('status_id')][0] .
                            ' ' .
                            $statutColor[$ticket->getStatut('status_id')][1] .
                            ' rounded-lg px-2 py-1 font-semibold text-nowrap'
                        : '' }}">
                    {{ $ticket->getStatut('status_id') }}
                  </span>
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  <span
                    class="{{ isset($prioriteColor[$ticket->getPriorite('priorite_id')])
                        ? $prioriteColor[$ticket->getPriorite('priorite_id')][0] .
                            ' ' .
                            $prioriteColor[$ticket->getPriorite('priorite_id')][1] .
                            ' rounded-lg px-2 py-1 font-semibold'
                        : '' }}">
                    {{ $ticket->getPriorite('priorite_id') }}
                  </span>

                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $ticket->getCategorie('categorie_id') }}
                </td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $ticket->getUser('user_id') }}
                </td>
                <td
                  class="px-6 py-3 text-base font-medium border border-gray-400 tracking-wider grid grid-cols-1 gap-2 text-center">
                  <a href="{{ route('edit-tech-ticket', ['id' => $ticket->id]) }}"
                    class="text-white text-base font-medium bg-[#4DA845] rounded-lg">Edit</a>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <div>
          {{ $tickets->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection
