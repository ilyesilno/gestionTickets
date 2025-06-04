<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gestion des tickets - Agent</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@100;200;300;400;500;600;800;900&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gestion des tickets - Agent</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@100;200;300;400;500;600;800;900&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Rubik', sans-serif;
    }

    /* Custom scrollbar */
    /* Custom scrollbar */
    ::-webkit-scrollbar {
      width: 10px;
    }

    ::-webkit-scrollbar-track {
      background-color: #f3f4f6;
      background-color: #f3f4f6;
    }

    ::-webkit-scrollbar-thumb {
      background: #a0aec0;
      border-radius: 10px;
      background: #a0aec0;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #718096;
      background: #718096;
    }
  </style>
</head>

<body class="h-screen overflow-hidden bg-white">
  <div class="flex h-full w-full">
    <!-- Sidebar -->
    <nav class="w-1/6 bg-gray-50 text-gray-700 flex flex-col justify-between py-8 shadow border-r border-gray-200">
      <div>
        <h2 class="text-4xl font-extrabold text-center mb-12 text-blue-600 tracking-wide">Gesticket</h2>
        <ul class="space-y-2 text-base font-semibold">

          <!-- Dashboard -->
          <li
            class="px-8 py-3 rounded-lg cursor-pointer transition-colors duration-300
            hover:bg-blue-100 hover:text-blue-700
            {{ request()->route()->getName() === 'agent-dashboard' ? 'bg-blue-200 text-blue-800' : '' }}">
            <a href="{{ route('agent-dashboard') }}" class="flex items-center gap-3">
              <i class="fa-solid fa-house fa-lg"></i>
              <span>Dashboard</span>
            </a>
          </li>

          <!-- Tickets -->
          <li
            class="px-8 py-3 rounded-lg cursor-pointer transition-colors duration-300
            hover:bg-blue-100 hover:text-blue-700
            {{ in_array(request()->route()->getName(), ['agent-list-tickets', 'edit-agent-ticket', 'search-agent-tickets', 'show-agent-ticket']) ? 'bg-cyan-200 text-cyan-800' : '' }}">
            <a href="{{ route('agent-list-tickets') }}" class="flex items-center gap-3">
              <i class="fa-solid fa-circle-question fa-lg"></i>
              <span>Tickets</span>
            </a>

          <!-- Tickets -->
          <li
            class="px-8 py-3 rounded-lg cursor-pointer transition-colors duration-300
            hover:bg-blue-100 hover:text-blue-700
            {{ in_array(request()->route()->getName(), ['agent-list-tickets', 'edit-agent-ticket', 'search-agent-tickets', 'show-agent-ticket']) ? 'bg-cyan-200 text-cyan-800' : '' }}">
            <a href="{{ route('agent-list-tickets') }}" class="flex items-center gap-3">
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
          {{ request()->route()->getName() === 'agent-profile' ? 'bg-blue-100 hover:text-blue-700' : '' }}">
          <a href="{{ route('agent-profile') }}" class="flex items-center gap-3">
            <i class="fa-solid fa-user fa-lg"></i>
            Profile
          </a>
        </li>
        <li
          class="cursor-pointer rounded-lg px-5 py-3 hover:bg-blue-100 hover:text-blue-700 transition-colors">
          <a href="{{ route('logout') }}" class="flex items-center gap-3">
            <i class="fa-solid fa-right-from-bracket fa-lg"></i>
            Se déconnecter
          </a>
        </li>
      </ul>
    </nav>

    <!-- Content Area -->
    <main class="w-5/6 h-full overflow-y-auto p-8 bg-white">
      @yield('content')
    </main>
    </main>
  </div>
</body>

</html>
