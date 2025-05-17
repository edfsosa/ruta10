<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiquetas {{ $shipment->tracking_number }}</title>
    <style>
        /* Tamaño de etiqueta adhesiva: 55mm × 45mm */
        @page {
            size: 55mm 45mm;
            margin: 0;
        }

        html,
        body {
            width: 55mm;
            margin: 0;
            padding: 0;
            background: none;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #000;
        }

        .label {
            width: 55mm;
            height: 45mm;
            padding: 2mm;
            margin-bottom: 2mm;
            /* separación de 0.2cm entre etiquetas */
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: left;
            page-break-inside: avoid;

            /* Sutil sombreado en lugar de borde */
            border: none;
            border-radius: 2mm;
            box-shadow: 0 0 1mm rgba(0, 0, 0, 0.1);
        }

        .label h4 {
            margin: 0.5mm 0;
            font-size: 9px;
            line-height: 1.2;
            font-weight: normal;
        }

        .barcode {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 1mm 0;
        }

        .barcode img {
            max-width: 100%;
            max-height: 100%;
            image-rendering: pixelated;
        }

        .header {
            font-size: 11px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1mm;
        }

        .footer {
            font-size: 7px;
            color: #555;
            text-align: center;
        }
    </style>
</head>

<body>
    @foreach ($items as $item)
        {{-- Reemplazamos el @for por un @foreach sobre la relación barcodes --}}
        @foreach ($item->barcodes as $barcodeRecord)
            <div class="label">
                <div>
                    <div class="header">{{ $shipment->tracking_number }}</div>
                    <h4><strong>De:</strong> {{ $shipment->sender->full_name }}</h4>

                    @if ($shipment->service_type === 'agency_to_agency' || $shipment->service_type === 'agency_to_door')
                        <h4><strong>Agencia Origen:</strong> {{ $shipment->origin_agency->city->name }}</h4>
                    @else
                        <h4><strong>Origen:</strong> {{ $shipment->pickup_address->city->name }}</h4>
                    @endif

                    <h4><strong>Para:</strong> {{ $shipment->receiver->full_name }}</h4>

                    @if ($shipment->service_type === 'agency_to_agency' || $shipment->service_type === 'door_to_agency')
                        <h4><strong>Agencia Destino:</strong> {{ $shipment->destination_agency->city->name }}</h4>
                    @else
                        <h4><strong>Destino:</strong> {{ $shipment->delivery_address->city->name }}</h4>
                    @endif

                    <h4><strong>Servicio:</strong> {{ $shipment->service_type_label }}</h4>
                    <h4><strong>Producto:</strong> {{ $item->productType->name }} ({{ $loop->iteration }}/{{ $item->quantity }})</h4>
                </div>

                <div class="barcode">
                    {{-- Ahora usamos el código de la tabla barcodes --}}
                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($barcodeRecord->barcode, 'C128', 2, 40) }}" alt="barcode">
                </div>

                <div class="footer">
                    <p>www.ruta10srl.com</p>
                </div>
            </div>
        @endforeach
    @endforeach

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>


</html>
