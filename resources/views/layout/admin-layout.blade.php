<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

  @vite('resources/css/app.css')
  @vite(['resources/js/app.js'])
  <title>Gestion des tickets</title>
  <style>
    @import url(https://fonts.googleapis.com/css2?family=Rubik:wght@100;200;300;400;500;600;800;900&display=swap);

    body {
      font-family: 'Rubik', sans-serif;
    }

    body,
    html {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
      width: 100%;
      height: 100%;
    }


    li:hover i:first-child {
      color: #20A8D8
    }

    ::-webkit-scrollbar {
      width: 10px;
    }

    ::-webkit-scrollbar-track {
      background-color: rgb(243, 244, 246);
    }

    ::-webkit-scrollbar-thumb {
      background: #888;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #555;
    }
  </style>
</head>

<body>
  <div class="container flex w-full h-full">
    <div class="w-[20%] border-r-2 flex bg-[#2F353A] text-white">
      <div class="sidebar mt-5 flex flex-col justify-between my-6 w-full text-[#C8CACB]">
        <div class="menuItems flex-1">
          <h2 class="text-4xl text-center font-semibold mb-10 text-white">Gesticket</h2>
          <ul class="flex flex-col text-lg font-medium">
            <li
              class="cursor-pointer block px-7 py-3.5 {{ request()->route()->getName() === 'admin-dashboard' ? 'bg-white text-black' : 'hover:bg-[#3A4248] hover:text-white' }}">
              <span class="flex items-center gap-2">
                <i class="fa-solid fa-house"></i>
                <a href="{{ route('admin-dashboard') }}">
                  Tableau de bord
                </a>
              </span>
            </li>
            <li
              class="cursor-pointer block px-7 py-3.5
              {{ request()->route()->getName() === 'list-users' || request()->route()->getName() === 'create-user'
                  ? 'bg-white text-black'
                  : 'hover:bg-[#3A4248] hover:text-white' }} relative">

              <span id="userManagementDropdown" class="flex items-center gap-2 ">
                <i class="fa-solid fa-users"></i>
                <span href="#" class="block">
                  Utilisateurs
                </span>
                <i class="fa-solid fa-chevron-down" id="userManagementChevronDown"></i>
              </span>

              <ul id="userManagementDropdownContent"
                class="dropdownLinks hidden absolute top-full right-0 bg-white text-black w-full shadow-md">
                <li>
                  <a href="{{ route('list-users') }}" class="block px-4 py-2 hover:bg-gray-100">
                    Liste des utilisateurs
                  </a>
                </li>
                <li>
                  <a href="{{ route('create-user') }}" class="block px-4 py-2 hover:bg-gray-100">
                    Créer un utilisateur
                  </a>
                </li>
              </ul>
            </li>
            <li
              class="cursor-pointer block px-7 py-3.5
              {{ request()->route()->getName() === 'list-statuts' || request()->route()->getName() === 'edit-statut'
                  ? 'bg-white text-black'
                  : 'hover:bg-[#3A4248] hover:text-white' }}">

              <span class="flex items-center gap-2">
                <i class="fa-solid fa-gears"></i>
                <a href="{{ route('list-statuts') }}" class="block">
                  Statuts
                </a>
              </span>

            </li>
            <li
              class="cursor-pointer block px-7 py-3.5
              {{ request()->route()->getName() === 'list-priorites' || request()->route()->getName() === 'edit-priorite'
                  ? 'bg-white text-black'
                  : 'hover:bg-[#3A4248] hover:text-white' }}">

              <span class="flex items-center gap-2">
                <i class="fa-solid fa-gears"></i>
                <a href="{{ route('list-priorites') }}" class="block">
                  Priorités
                </a>
              </span>

            </li>
            <li
              class="cursor-pointer block px-7 py-3.5
              {{ request()->route()->getName() === 'list-categories' || request()->route()->getName() === 'edit-categorie'
                  ? 'bg-white text-black'
                  : 'hover:bg-[#3A4248] hover:text-white' }}">

              <span class="flex items-center gap-2">
                <i class="fa-solid fa-tags"></i>
                <a href="{{ route('list-categories') }}" class="block">
                  Catégories
                </a>
              </span>
            </li>
            <li
              class="cursor-pointer block px-7 py-3.5
            {{ request()->route()->getName() === 'list-all-tickets' ||
            request()->route()->getName() === 'search-all-tickets' ||
            request()->route()->getName() === 'edit-ticket' ||
            request()->route()->getName() === 'show-ticket'
                ? 'bg-white text-black'
                : 'hover:bg-[#3A4248] hover:text-white' }}">
              <span class="flex items-center gap-2">
                <i class="fa-solid fa-circle-question"></i>
                <a href="{{ route('list-all-tickets') }}" class="block">
                  Tickets
                </a>
              </span>
            </li>
          </ul>
        </div>
        <ul class="text-lg font-medium">
          <li
            class="cursor-pointer block px-7 py-3.5
          {{ request()->route()->getName() === 'profile' ? 'bg-white text-black' : 'hover:bg-[#3A4248] hover:text-white' }}">
            <span class="flex items-center gap-2">
              <i class="fa-solid fa-user"></i>
              <a href="{{ route('profile') }}" class="block">
                Profile
              </a>
            </span>
          </li>
          <li class="cursor-pointer block px-7 py-3.5 hover:bg-[#3A4248] hover:text-white">
            <span class="flex items-center gap-2">
              <i class="fa-solid fa-right-from-bracket"></i>
              <a href="{{ route('logout') }}" class="block">
                Se déconnecter
              </a>
            </span>
          </li>
        </ul>

      </div>
    </div>
    <div class="w-[80%] h-full overflow-y-scroll">
      @yield('content')
    </div>
  </div>


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      let userDropdown = document.getElementById('userManagementDropdown');
      let userDropdownContent = document.getElementById('userManagementDropdownContent');
      let userChevronDown = document.getElementById('userManagementChevronDown');

      userDropdown.addEventListener('click', function(event) {
        event.stopPropagation();
        userDropdownContent.classList.toggle('hidden');
        userChevronDown.classList.toggle('rotate-180');
      });

      document.addEventListener('click', function(event) {
        userDropdownContent.classList.add('hidden');
        userChevronDown.classList.remove('rotate-180');
      });
    });

  </script>

</body>

</html>
