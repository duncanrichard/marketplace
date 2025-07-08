<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Event</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            padding: 40px;
            text-align: center;
            color: #333;
        }
        .card {
            background: white;
            max-width: 500px;
            margin: auto;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .icon {
            font-size: 50px;
            margin-bottom: 15px;
        }
        .icon.success {
            color: #28a745;
        }
        .status-text {
            font-size: 20px;
            font-weight: bold;
        }
        .detail {
            margin-top: 15px;
            color: #666;
        }
        .status-badge {
            display: inline-block;
            margin-top: 10px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            background-color: {{ $status === 'Confirmed' ? '#d4edda' : '#f8d7da' }};
            color: {{ $status === 'Confirmed' ? '#155724' : '#721c24' }};
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon success">✅</div>
        <div class="status-text">
            @if($alreadyProcessed)
                Event ini <u>sudah</u> diproses sebelumnya.
            @else
                Anda telah berhasil <u>{{ strtoupper($status) }}</u> event ini.
            @endif
        </div>
        <div class="status-badge">{{ strtoupper($status) }}</div>
        <div class="detail">
            <p><strong>Nama Event :</strong> {{ $event->judul }}</p>
            <p><strong>Tanggal :</strong> {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}</p>
            <p><strong>Lokasi :</strong> {{ $event->lokasi }}</p>
        </div>
    </div>
</body>
</html>
