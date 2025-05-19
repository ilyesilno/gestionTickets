<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
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
              class="cursor-pointer block px-7 py-3.5 {{ request()->route()->getName() === 'agent-dashboard' ? 'bg-white text-black' : 'hover:bg-[#3A4248] hover:text-white' }}">
              <span class="flex items-center gap-2">
                <i class="fa-solid fa-house"></i>
                <a href="{{ route('agent-dashboard') }}">
                  Dashboard
                </a>
              </span>
            </li>
            <li
              class="cursor-pointer block px-7 py-3.5
            {{ request()->route()->getName() === 'agent-list-tickets' ||
            request()->route()->getName() === 'edit-agent-ticket' ||
            request()->route()->getName() === 'search-agent-tickets' ||
            request()->route()->getName() === 'show-agent-ticket'
                ? 'bg-white text-black'
                : 'hover:bg-[#3A4248] hover:text-white' }}">
              <span class="flex items-center gap-2">
                <i class="fa-solid fa-circle-question"></i>
                <a href="{{ route('agent-list-tickets') }}" class="block">
                  Tickets
                </a>
              </span>
            </li>
          </ul>
        </div>
        <ul class="text-lg font-medium">
          <li
            class="cursor-pointer block px-7 py-3.5
          {{ request()->route()->getName() === 'agent-profile' ? 'bg-white text-black' : 'hover:bg-[#3A4248] hover:text-white' }}">
            <span class="flex items-center gap-2">
              <i class="fa-solid fa-user"></i>
              <a href="{{ route('agent-profile') }}" class="block">
                Profile
              </a>
            </span>
          </li>
          <li class="cursor-pointer block px-7 py-3.5 hover:bg-[#3A4248] hover:text-white">
            <span class="flex items-center gap-2">
              <i class="fa-solid fa-right-from-bracket"></i>
              <a href="{{ route('logout') }}" class="block">
                Log out
              </a>
            </span>
          </li>
        </ul>

      </div>
    </div>
    <div class="w-full h-full overflow-y-scroll">
      @yield('content')
    </div>
  </div>
  <script>
    const notifBtn = document.getElementById('notifBtn')
    const notifications = document.getElementById('notifications')

    notifBtn.addEventListener('click', function(event) {
      if (notifications.classList.contains('hidden')) {
        notifications.classList.remove('hidden');
        notifications.classList.add('block');
      } else {
        notifications.classList.remove('block');
        notifications.classList.add('hidden');
      }
    });


  </script>
</body>

</html>
