<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-color: #f5f6fa;
      font-family: 'Rubik', sans-serif;
    }
  </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-100">
  <div class="container mx-auto px-4">
    <div class="flex flex-col items-center min-h-[75vh] rounded-lg shadow-lg bg-white overflow-hidden p-8 md:w-1/2 mx-auto">

      <!-- Logo -->
      <div class="mb-6">
        <img src="{{ $logoPath ? asset('storage/' . $logoPath) : asset('images/default-logo.png') }}" alt="Logo" class="h-16 mx-auto">

   
      </div>

      <!-- Title -->
      <h2 class="text-4xl font-extrabold text-blue-600 mb-8 tracking-wide">Welcome back</h2>

      <!-- Login Form -->
      <form action="{{ route('authenticate') }}" method="POST" class="space-y-6 w-full">
        @csrf

        <div>
          <label for="email" class="block mb-2 text-sm font-semibold text-gray-700">Email</label>
          <input type="email" id="email" name="email" placeholder="Email"
                 class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
          @error('email')
            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="password" class="block mb-2 text-sm font-semibold text-gray-700">Password</label>
          <input type="password" id="password" name="password" placeholder="Password"
                 class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
          @error('password')
            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <button type="submit"
                class="w-full bg-gradient-to-r from-blue-500 to-blue-700 text-white font-semibold rounded-lg py-2 hover:from-blue-600 hover:to-blue-800 transition">
          Sign in
        </button>
      </form>
    </div>
  </div>
</body>

</html>
