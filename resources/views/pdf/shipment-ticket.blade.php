<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $shipment->tracking_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: monospace;
            font-size: 12px;
            width: 164pt;
            /* 58mm */
            padding: 5px;
        }

        .ticket {
            width: 100%;
        }

        .text-center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
            font-size: 16px;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 4px 0;
        }

        .section {
            margin-bottom: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 1px 2px;
            word-wrap: break-word;
        }

        img {
            max-width: 150pt;
            height: auto;
            display: block;
            margin: 0 auto 4px auto;
        }

        .signature {
            height: 20px;
            border-bottom: 1px solid #000;
            margin: 4px 0;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <div class="text-center">
            <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" width="100" height="auto">
            <div class="bold">Ruta 10 SRL</div>
            <div>Transporte de cargas</div>
            <div>Carios c/ Av. La Victoria</div>
            <div>Asunción, Paraguay</div>
            <div>Tel: 021 504 018</div>
            <div class="bold">Ticket {{ $shipment->tracking_number }}</div>
        </div>

        <div class="line"></div>

        <div class="section">
            <div>Fecha: {{ date('d/m/Y', strtotime($shipment->created_at)) }}</div>
            <div>Hora: {{ date('H:i', strtotime($shipment->created_at)) }}</div>
            <div>Tipo: {{ $shipment->getServiceTypeLabelAttribute() }}</div>
            <div>Pago: {{ $shipment->payment_method }}</div>
            <div>Transportista: {{ $shipment->driver->user->name }}</div>
            <div>Obs: {{ $shipment->notes }}</div>
        </div>

        <div class="line"></div>

        <div class="section">
            <div>Remitente: {{ $shipment->sender->full_name }}</div>

            @if ($shipment->service_type === 'agency_to_agency' || $shipment->service_type === 'agency_to_door')
                <div>Agencia: {{ $shipment->origin_agency->name }}</div>
            @elseif ($shipment->service_type === 'door_to_agency' || $shipment->service_type === 'door_to_door')
                <div>Dirección: {{ $shipment->pickup_address->address }}</div>
                <div>Ciudad: {{ $shipment->pickup_address->city->name }}</div>
            @endif

            <div>Tel: {{ $shipment->sender->phone }}</div>
        </div>

        <div class="section">
            <div>Destinatario: {{ $shipment->receiver->full_name }}</div>

            @if ($shipment->service_type === 'agency_to_agency' || $shipment->service_type === 'door_to_agency')
                <div>Agencia: {{ $shipment->destination_agency->name }}</div>
            @elseif ($shipment->service_type === 'agency_to_door' || $shipment->service_type === 'door_to_door')
                <div>Dirección: {{ $shipment->delivery_address->address }}</div>
                <div>Ciudad: {{ $shipment->delivery_address->city->name }}</div>
            @endif

            <div>Tel: {{ $shipment->receiver->phone }}</div>
        </div>

        <div class="line"></div>

        @if ($shipment->items->count())
            <div class="section">
                <table>
                    @foreach ($shipment->items as $item)
                        <tr>
                            <td colspan="2">{{ $item->productType->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>x{{ $item->quantity }}</td>
                            <td>{{ $item->unit_price }}</td>
                            <td style="text-align: right;">
                                {{ number_format($item->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif

        <div class="line"></div>

        <div class="section">
            <div><strong>Total:</strong> {{ number_format($shipment->items->sum('total_price'), 0, ',', '.') }} Gs
            </div>
        </div>

        <div class="line"></div>

        <div class="section"><br>
            <div class="signature"></div>
            <div class="text-center">Firma remitente</div>

            <br>
            <div class="signature"></div>
            <div class="text-center">Firma destinatario</div>

            <br>
            <div class="signature"></div>
            <div class="text-center">Firma transportista</div>
        </div>

        <div class="line"></div>

        <div class="text-center">¡Gracias por la confianza!</div>
        <br>
        <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($shipment->tracking_number, 'C128') }}"
            alt="barcode" />

    </div>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
