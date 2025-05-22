@extends('layout.admin-layout')
@section('content')
  <div class="list-abonnement">
    <div class="content pt-6 w-[95%] mx-auto my-5 flex flex-col gap-11">
      <div class="lis-users w-full bg-gray-100 rounded-lg border border-gray-200 p-5 flex flex-col gap-6">
        <h1 class="text-2xl font-medium ">List abonnements</h1>
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                ID
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                date debut
            </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                date fin
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                status
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                produit
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($abonnements as $abonnement)
              <tr>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $abonnement->id }}</td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $abonnement->date_debut }}</td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $abonnement->date_fin }}</td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $abonnement->status}}</td>
                  <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                    {{ $abonnement->getProduit()}}</td>
                <td class="px-6 py-3 text-base font-medium border border-gray-400 tracking-wider flex justify-center">
                  <form action="{{ route('delete-abonnement', ['id' => $abonnement->id]) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="text-white text-base px-5 font-medium bg-[#DC3544] rounded-lg">
                      Delete
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <div>
          {{ $abonnements->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection
