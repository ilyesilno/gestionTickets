@extends('layout.admin-layout')
@section('content')
  <div class="list-sla">
    <div class="content pt-6 w-[95%] mx-auto my-5 flex flex-col gap-11">
      <div class="lis-users w-full bg-gray-100 rounded-lg border border-gray-200 p-5 flex flex-col gap-6">
        <h1 class="text-2xl font-medium ">List SLAs</h1>
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                ID
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                    nom
            </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                duree qualification (en hrs)
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                duree resolution (en jrs)
              </th>
       
            </tr>
          </thead>
          <tbody>
            @foreach ($slas as $sla)
              <tr>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $sla->id }}</td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $sla->nom }}</td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $sla->duree_qualification }}</td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $sla->duree_resolution}}</td>
               
                <td class="px-6 py-3 text-base font-medium border border-gray-400 tracking-wider flex justify-center">
                  <form action="{{ route('delete-sla', ['id' => $sla->id]) }}" method="POST">
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
          {{ $slas->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection
