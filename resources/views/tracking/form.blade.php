<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimiento de Envío</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-6 rounded shadow w-full max-w-md">
        <h1 class="text-xl font-bold mb-4 text-center">Consulta de Envío</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('tracking.track') }}" method="POST" class="space-y-4">
            @csrf
            <input type="text" name="tracking_number" placeholder="Número de seguimiento"
                class="w-full border p-2 rounded" required>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                Consultar
            </button>
        </form>
    </div>

</body>

</html>
