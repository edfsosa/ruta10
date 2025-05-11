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

    html, body {
      width: 55mm;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Arial', sans-serif;
      font-size: 10px;
    }

    .label {
      width: 55mm;
      height: 45mm;
      padding: 2mm;
      margin-bottom: 2mm; /* separación de 0.2cm entre etiquetas */
      box-sizing: border-box;
      border: 1px dashed #000;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      text-align: center;
      page-break-inside: avoid;
    }

    .label h4 {
      margin: 0.5mm 0;
      font-size: 11px;
      line-height: 1.2;
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

    .footer {
      font-size: 8px;
      margin: 0;
    }
  </style>
</head>

<body>
  @foreach ($items as $item)
    @for ($i = 1; $i <= $item->quantity; $i++)
      <div class="label">
        <div>
          <h4>Producto: {{ $item->productType->name }}</h4>
          <h4>Remitente: {{ $item->shipment->sender->full_name }}</h4>
          <h4>Destinatario: {{ $item->shipment->receiver->full_name }}</h4>
          <h4>{{ $shipment->tracking_number }} / {{ $i }}/{{ $item->quantity }}</h4>
        </div>

        <div class="barcode">
          <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($item->barcode, 'C128', 2, 40) }}" alt="barcode">
        </div>

        <div class="footer">
          {{ now()->format('d/m/Y H:i') }}
        </div>
      </div>
    @endfor
  @endforeach

  <script>
    window.onload = function() { window.print(); };
  </script>
</body>

</html>