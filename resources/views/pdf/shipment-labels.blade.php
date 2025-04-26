<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Etiquetas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .label {
            border: 1px solid #000;
            padding: 15px;
            margin-bottom: 30px;
            width: 300px;
            height: 180px;
            text-align: center;
            page-break-inside: avoid;
        }

        .label h4 {
            margin: 0 0 10px 0;
        }

        .barcode {
            margin-top: 10px;
        }

        .footer {
            margin-top: 5px;
            font-size: 10px;
        }
    </style>
</head>

<body>
    @foreach ($items as $item)
        @for ($i = 1; $i <= $item->quantity; $i++)
            <div class="label">
                <h4>{{ $item->productType->name }}</h4>

                {{-- Código de barras --}}
                <div class="barcode">
                    {!! DNS1D::getBarcodeHTML($item->barcode, 'C128', 2, 50) !!}
                </div>

                {{-- Info de tracking y numeración --}}
                <div class="footer">
                    {{ $shipment->tracking_number }}<br>
                    {{ $i }}/{{ $item->quantity }}
                </div>
            </div>
        @endfor
    @endforeach
</body>

</html>
