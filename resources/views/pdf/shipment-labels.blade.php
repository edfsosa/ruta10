<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Etiquetas</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 5px;
            width: 80mm;
            /* Forzamos ancho real del rollo térmico */
        }

        .label {
            border: 1px dashed #000;
            width: 100%;
            padding: 5px 5px;
            box-sizing: border-box;
            margin-bottom: 5px;
            text-align: center;
            page-break-inside: avoid;
        }

        .label h4 {
            margin: 2px 0;
            font-size: 12px;
        }

        .barcode {
            margin: 5px 0;
        }

        .barcode img {
            width: 100%;
            height: auto;
            image-rendering: pixelated;
        }

        .footer {
            margin-top: 4px;
            font-size: 10px;
        }
    </style>
</head>

<body>

    @foreach ($items as $item)
        @for ($i = 1; $i <= $item->quantity; $i++)
            <div class="label">
                <h4>Producto: {{ $item->productType->name }}</h4>
                <h4>Remitente: {{ $item->shipment->sender->full_name }}</h4>
                <h4>Destinatario: {{ $item->shipment->receiver->full_name }}</h4>
                <h4>{{ $shipment->tracking_number }}<br>
                    {{ $i }}/{{ $item->quantity }}</h4>

                <div class="barcode">
                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($item->barcode, 'C128', 2, 40) }}"
                        alt="barcode">
                </div>

                <div class="footer">
                    
                </div>
            </div>
        @endfor
    @endforeach

    <script>
        window.onload = function() {
            window.print();
        };
    </script>

</body>

</html>
