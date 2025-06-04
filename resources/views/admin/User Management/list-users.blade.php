@extends('layout.admin-layout')
@section('content')
  <div class="list-users">
    <div class="content pt-6 w-[95%] mx-auto my-5 flex flex-col gap-11">
      <div class="lis-users w-full bg-gray-100 rounded-lg border border-gray-200 p-5 flex flex-col gap-6">
        <h1 class="text-2xl font-medium ">List Users</h1>
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                ID
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                Nom Complet
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                Email
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                Role
              </th>
              <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium border border-gray-400 uppercase tracking-wider">
                Operation
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
              <tr>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $user->id }}</td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $user->nom_complet }}</td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $user->email }}</td>
                <td class="px-6 py-3 text-left text-xs font-medium border border-gray-400 tracking-wider">
                  {{ $user->getRole('role_id') }}</td>
                <td class="px-6 py-3 text-base font-medium border border-gray-400 tracking-wider flex justify-center">
                  <form action="{{ route('delete-user', ['id' => $user->id]) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="text-white text-base px-5 font-medium bg-[#DC3544] rounded-lg">
                      Delete
                    </button>
                  </form>
                  <a href="{{route('modifier-mdp', ['id' => $user->id])}}" class="ml-2">
                  <button type="submit" class="text-white text-base px-5 font-medium bg-[#DC3544] rounded-lg">
                    modifier
                  </button>
                </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <div>
          {{ $users->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection
