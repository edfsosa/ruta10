<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Seguimiento</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-6 rounded shadow w-full max-w-md">
        <h1 class="text-xl font-bold mb-4 text-center">Detalle del Envío</h1>

        <div class="mb-4">
            <p><strong>N° Seguimiento:</strong> {{ $shipment->tracking_number }}</p>
            <p><strong>Tipo de Servicio:</strong> {{ $shipment->getServiceTypeLabelAttribute() }}</p>
            <p><strong>Estado actual:</strong> {{ ucfirst($shipment->getStatusLabelAttribute()) }}</p>
            <p><strong>Remitente:</strong> {{ $shipment->sender->full_name ?? $shipment->sender->company_name }}</p>
            <p><strong>Origen:</strong>
                {{ $shipment->origin_agency->city->name ?? $shipment->pickup_address->city->name }}</p>
            <p><strong>Destinatario:</strong> {{ $shipment->receiver->full_name ?? $shipment->receiver->company_name }}
            </p>
            <p><strong>Destino:</strong>
                {{ $shipment->destination_agency->city->name ?? $shipment->delivery_address->city->name }}</p>
        </div>

        <h2 class="font-bold mb-2">Historial de Estados</h2>
        <ul class="space-y-2">
            <li class="p-2 bg-gray-50 rounded">
                <strong>Pendiente</strong>
                <span class="text-sm text-gray-600">
                    ({{ $shipment->created_at->format('d/m/Y H:i') }}) - {{ $shipment->created_at->diffForHumans() }}
                </span>
            </li>
            @foreach ($shipment->histories as $history)
                <li class="p-2 bg-gray-50 rounded">
                    <strong>{{ ucfirst($history->getStatusLabelAttribute()) }}</strong>
                    <span class="text-sm text-gray-600">
                        ({{ $history->created_at->format('d/m/Y H:i') }})
                        - {{ $history->created_at->diffForHumans() }}
                    </span>
                </li>
            @endforeach
        </ul>

        <div class="mt-4">
            <a href="{{ route('tracking.form') }}" class="text-blue-500 hover:underline">Consultar otro envío</a>
        </div>
    </div>

</body>

</html>
