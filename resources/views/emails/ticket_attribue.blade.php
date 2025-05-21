<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Ticket Assigned</title>
</head>

<body>
  <div class="max-w-xl mx-auto bg-white p-8 rounded shadow-lg">
    <h2 class="text-2xl font-bold mb-4">Nouveau ticket attribué</h2>
    <p class="mb-4">Bonjour,</p>
    <p class="mb-4">Un nouveau ticket vous a été attribué. Voici les détails :</p>
    <ul class="list-disc pl-6 mb-4">
      <li><span class="font-bold">ID du ticket :</span> {{ $ticket->id }}</li>
      <li><span class="font-bold">Sujet :</span> {{ $ticket->sujet }}</li>
    </ul>
    <p class="mb-4">Consultez votre tableau de bord pour plus de détails.</p>
    <a href="{{ route('show-tech-ticket', ['id' => $ticket->id]) }}"
      class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded inline-block mb-4">Voir le ticket</a>
    <p>Merci.</p>
  </div>

</body>

</html>
