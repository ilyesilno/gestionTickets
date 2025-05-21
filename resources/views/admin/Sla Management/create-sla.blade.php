@extends('layout.admin-layout')
@section('content')
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
  <div class="main">
    <div class="content pt-6 w-[95%] mx-auto my-5 flex flex-col gap-11">
      <div class="profileInfo w-full bg-gray-100 rounded-lg border border-gray-200 p-5 flex flex-col gap-6">
        <h1 class="text-xl text-center font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
          Creer SLA
        </h1>
        <form class="space-y-4 md:space-y-6" action="{{ route('store-sla') }}" method="post">
          @csrf
          <div>
            <label for="nom" class="block mb-2 text-sm font-medium text-gray-900">Nom</label>
            <input type="text" name="nom" id="nom"
              class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5"
              placeholder="example: premium " />
          </div>
          <div>
            <label for="date_fin" class="block mb-2 text-sm font-medium text-gray-900">Duree qualification (en hrs)</label>
            <input type="number" name="duree_qualification" id="duree_qualification"
              class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5"
              placeholder="0" />
          </div>
          <div>
            <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Duree resolution (en jrs)</label>
            <input type="number" name="duree_resolution" id="duree_resolution" placeholder="0"
              class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5" />
          </div>
       

          <button type="submit"
            class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            Creer 
          </button>
        </form>
      </div>
    </div>
  </div>
@endsection
