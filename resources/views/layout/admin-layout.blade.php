<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gestion des tickets</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@100;200;300;400;500;600;800;900&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Rubik', sans-serif;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
      width: 10px;
    }

    ::-webkit-scrollbar-track {
      background-color: #f3f4f6;
    }

    ::-webkit-scrollbar-thumb {
      background: #a0aec0;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #718096;
    }
  </style>
</head>

<body class="h-screen overflow-hidden bg-white">
  <div class="flex h-full w-full">
    <!-- Sidebar -->
    <nav class="w-1/5 bg-gray-50 text-gray-700 flex flex-col justify-between py-8 shadow border-r border-gray-200">
      <div>
        <h2 class="text-4xl font-extrabold text-center mb-12 text-blue-600 tracking-wide">Gesticket</h2>
        <ul class="space-y-2 text-base font-semibold">

          <!-- Tableau de bord -->
          <li
            class="px-8 py-3 rounded-lg cursor-pointer transition-colors duration-300
            hover:bg-blue-100 hover:text-blue-700
            {{ request()->route()->getName() === 'admin-dashboard' ? 'bg-blue-200 text-blue-800' : '' }}">
            <a href="{{ route('admin-dashboard') }}" class="flex items-center gap-3">
              <i class="fa-solid fa-house fa-lg"></i>
              <span>Tableau de bord</span>
            </a>
          </li>

          <!-- Utilisateurs -->
          <li
            class="relative px-8 py-3 rounded-lg cursor-pointer transition-colors duration-300
            hover:bg-purple-100 hover:text-purple-700
            {{ (request()->route()->getName() === 'list-users' || request()->route()->getName() === 'create-user') ? 'bg-purple-200 text-purple-800' : '' }}">
            <div id="userManagementDropdown" tabindex="0" role="button"
              class="flex items-center gap-3 select-none">
              <i class="fa-solid fa-users fa-lg"></i>
              <span>Utilisateurs</span>
              <i id="userManagementChevronDown"
                class="fa-solid fa-chevron-down ml-auto transition-transform duration-300 text-gray-400"></i>
            </div>
            <ul id="userManagementDropdownContent"
              class="hidden absolute top-full right-0 w-full bg-white text-gray-700 rounded-b-lg shadow-md z-20 border border-t-0 border-gray-200">
              <li><a href="{{ route('list-users') }}" class="block px-6 py-2 hover:bg-gray-100">Liste des utilisateurs</a></li>
              <li><a href="{{ route('create-user') }}" class="block px-6 py-2 hover:bg-gray-100">Créer un utilisateur</a></li>
            </ul>
          </li>

          <!-- Produits -->
          <li
            class="relative px-8 py-3 rounded-lg cursor-pointer transition-colors duration-300
            hover:bg-pink-100 hover:text-pink-700
            {{ (request()->route()->getName() === 'list-produits' || request()->route()->getName() === 'create-produit') ? 'bg-pink-200 text-pink-800' : '' }}">
            <div id="produitDropdown" tabindex="0" role="button"
              class="flex items-center gap-3 select-none">
              <i class="fa-solid fa-id-card fa-lg"></i>
              <span>Produits</span>
              <i id="produitChevronDown"
                class="fa-solid fa-chevron-down ml-auto transition-transform duration-300 text-gray-400"></i>
            </div>
            <ul id="produitDropdownContent"
              class="hidden absolute top-full right-0 w-full bg-white text-gray-700 rounded-b-lg shadow-md z-20 border border-t-0 border-gray-200">
              <li><a href="{{ route('list-produits') }}" class="block px-6 py-2 hover:bg-gray-100">Liste des produits</a></li>
              <li><a href="{{ route('create-produit') }}" class="block px-6 py-2 hover:bg-gray-100">Créer un produit</a></li>
            </ul>
          </li>

          <!-- Agents -->
<li
class="px-8 py-3 rounded-lg cursor-pointer transition-colors duration-300
hover:bg-indigo-100 hover:text-indigo-700
{{ request()->route()->getName() === 'agents.index' ? 'bg-indigo-200 text-indigo-800' : '' }}">
<a href="{{ route('agents.index') }}" class="flex items-center gap-3">
  <i class="fa-solid fa-user-shield fa-lg"></i>
  <span>Agents</span>
</a>
</li>

          

          <!-- Abonnement -->
          <li
            class="relative px-8 py-3 rounded-lg cursor-pointer transition-colors duration-300
            hover:bg-green-100 hover:text-green-700
            {{ (request()->route()->getName() === 'list-abonnements' || request()->route()->getName() === 'create-abonnement') ? 'bg-green-200 text-green-800' : '' }}">
            <div id="abonnementDropdown" tabindex="0" role="button"
              class="flex items-center gap-3 select-none">
              <i class="fa-solid fa-money-check-alt fa-lg"></i>
              <span>Abonnement</span>
              <i id="abonnementChevronDown"
                class="fa-solid fa-chevron-down ml-auto transition-transform duration-300 text-gray-400"></i>
            </div>
            <ul id="abonnementDropdownContent"
              class="hidden absolute top-full right-0 w-full bg-white text-gray-700 rounded-b-lg shadow-md z-20 border border-t-0 border-gray-200">
              <li><a href="{{ route('list-abonnements') }}" class="block px-6 py-2 hover:bg-gray-100">Liste des abonnements</a></li>
              <li><a href="{{ route('create-abonnement') }}" class="block px-6 py-2 hover:bg-gray-100">Créer un abonnement</a></li>
            </ul>
          </li>

          <!-- SLA -->
          <li
            class="relative px-8 py-3 rounded-lg cursor-pointer transition-colors duration-300
            hover:bg-yellow-100 hover:text-yellow-700
            {{ (request()->route()->getName() === 'liste-slas' || request()->route()->getName() === 'create-sla') ? 'bg-yellow-200 text-yellow-800' : '' }}">
            <div id="slaDropdown" tabindex="0" role="button"
              class="flex items-center gap-3 select-none">
              <i class="fa-solid fa-money-check-alt fa-lg"></i>
              <span>SLA</span>
              <i id="slaChevronDown"
                class="fa-solid fa-chevron-down ml-auto transition-transform duration-300 text-gray-400"></i>
            </div>
            <ul id="slaDropdownContent"
              class="hidden absolute top-full right-0 w-full bg-white text-gray-700 rounded-b-lg shadow-md z-20 border border-t-0 border-gray-200">
              <li><a href="{{ route('list-slas') }}" class="block px-6 py-2 hover:bg-gray-100">Liste des SLAs</a></li>
              <li><a href="{{ route('create-sla') }}" class="block px-6 py-2 hover:bg-gray-100">Créer un SLA</a></li>
            </ul>
          </li>

          <!-- Tickets -->
          <li
            class="px-8 py-3 rounded-lg cursor-pointer transition-colors duration-300
            hover:bg-cyan-100 hover:text-cyan-700
            {{ in_array(request()->route()->getName(), ['list-all-tickets', 'search-all-tickets', 'edit-ticket', 'show-ticket']) ? 'bg-cyan-200 text-cyan-800' : '' }}">
            <a href="{{ route('list-all-tickets') }}" class="flex items-center gap-3">
              <i class="fa-solid fa-circle-question fa-lg"></i>
              <span>Tickets</span>
            </a>
          </li>
        </ul>
      </div>

      <!-- Footer -->
      <ul class="text-base font-semibold text-gray-500 border-t border-gray-200 pt-6 mx-8 space-y-2">
        <li
          class="cursor-pointer rounded-lg px-5 py-3 hover:bg-gray-200 hover:text-gray-700 transition-colors
          {{ request()->route()->getName() === 'profile' ? 'bg-gray-300 text-gray-800' : '' }}">
          <a href="{{ route('profile') }}" class="flex items-center gap-3">
            <i class="fa-solid fa-user fa-lg"></i>
            Profile
          </a>
        </li>
        <li
          class="cursor-pointer rounded-lg px-5 py-3 hover:bg-gray-200 hover:text-gray-700 transition-colors">
          <a href="{{ route('logout') }}" class="flex items-center gap-3">
            <i class="fa-solid fa-right-from-bracket fa-lg"></i>
            Se déconnecter
          </a>
        </li>
      </ul>
    </nav>

    <!-- Content Area -->
    <main class="w-4/5 h-full overflow-y-auto p-8 bg-white">
      @yield('content')
    </main>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      function setupDropdown(toggleId, contentId, chevronId) {
        const toggle = document.getElementById(toggleId);
        const content = document.getElementById(contentId);
        const chevron = document.getElementById(chevronId);
  
        toggle.addEventListener('click', function (event) {
          event.stopPropagation();
          content.classList.toggle('hidden');
          chevron.classList.toggle('rotate-180');
        });
      }
  
      setupDropdown('userManagementDropdown', 'userManagementDropdownContent', 'userManagementChevronDown');
      setupDropdown('produitDropdown', 'produitDropdownContent', 'produitChevronDown');
      setupDropdown('abonnementDropdown', 'abonnementDropdownContent', 'abonnementChevronDown');
      setupDropdown('slaDropdown', 'slaDropdownContent', 'slaChevronDown');
  
      // Clic ailleurs ferme les dropdowns et remet la flèche dans l'état initial
      document.addEventListener('click', function () {
        document.querySelectorAll('#userManagementDropdownContent, #produitDropdownContent, #abonnementDropdownContent, #slaDropdownContent')
          .forEach(dropdown => dropdown.classList.add('hidden'));
        document.querySelectorAll('.fa-chevron-down').forEach(icon => icon.classList.remove('rotate-180'));
      });
    });
  </script>
   </body> </html> ```