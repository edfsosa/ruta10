<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Etiquetas {{ $shipment->tracking_number }}</title>
  <style>
    /* Página exactamente 5.5 × 4.5 cm sin márgenes */
    @page {
      size: 5.5cm 4.5cm;
      margin: 0;
    }
    html, body {
      width: 5.5cm;
      height: 4.5cm;
      margin: 0;
      padding: 0;
    }
    * {
      box-sizing: border-box;
    }
    .label {
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 0.1cm;
      border: 1px dashed #000;
      font-family: 'Arial', sans-serif;
      font-size: 10px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .header h4 {
      margin: 0;
      font-size: 11px;
      line-height: 1.2;
    }
    .barcode {
      flex-grow: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0.1cm 0;
    }
    .barcode img {
      max-width: 100%;
      max-height: 100%;
      image-rendering: pixelated;
    }
    .footer {
      margin: 0;
      font-size: 8px;
      text-align: center;
    }
  </style>
</head>

<body>
  @foreach ($items as $item)
    @for ($i = 1; $i <= $item->quantity; $i++)
      <div class="label">
        <div class="header">
          <h4>Producto: {{ $item->productType->name }}</h4>
          <h4>Remitente: {{ $item->shipment->sender->full_name }}</h4>
          <h4>Destinatario: {{ $item->shipment->receiver->full_name }}</h4>
          <h4>{{ $shipment->tracking_number }} {{ $i }}/{{ $item->quantity }}</h4>
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
