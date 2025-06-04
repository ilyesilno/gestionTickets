<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Mot de passe oublié</title>
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

      <!-- Title -->
      <h2 class="text-3xl font-extrabold text-blue-600 mb-6 tracking-wide">Mot de passe oublié</h2>

      <!-- Password Reset Form -->
      <form action="{{ route('mdp-request') }}" method="POST" class="space-y-6 w-full">
        @csrf
        @method('put')

        <div>
          <label for="email" class="block mb-2 text-sm font-semibold text-gray-700">Email</label>
          <input type="email" id="email" name="email" placeholder="Votre adresse email" required
                 class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
          @error('email')
            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <button type="submit"
                class="w-full bg-gradient-to-r from-blue-500 to-blue-700 text-white font-semibold rounded-lg py-2 hover:from-blue-600 hover:to-blue-800 transition">
          Envoyer la demande
        </button>

        <div class="text-center mt-4">
          <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Retour à la connexion</a>
        </div>
      </form>

    </div>
  </div>
</body>
</html>
