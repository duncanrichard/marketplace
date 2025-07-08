<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Telah Berakhir</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fff9e6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            max-width: 600px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            border-radius: 12px;
        }
        .card-header {
            background-color: #ffdd57;
            color: #333;
            font-weight: 600;
            font-size: 1.25rem;
        }
        .btn-back {
            text-decoration: none;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="card text-center">
    <div class="card-header">
        Event Telah Berakhir
    </div>
    <div class="card-body">
        <p class="card-text mb-4">
            Maaf, formulir pendaftaran Pra Member untuk event <strong>{{ $event->judul }}</strong> tidak tersedia karena event telah selesai pada tanggal 
            <strong>{{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d F Y') }}</strong>.
        </p>
        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-back">Kembali</a>
    </div>
</div>

</body>
</html>
