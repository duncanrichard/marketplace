<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pendaftaran Pra Member - Klinik Kecantikan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, #e6fafd 50%, #fff 50%);
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      flex-direction: column;
    }

    .event-header {
      background: linear-gradient(to right, #00d4d4, #00e6e6);
      color: white;
      padding: 35px 30px;
      border-radius: 20px;
      margin-bottom: 40px;
      box-shadow: 0 10px 30px rgba(0, 212, 212, 0.3);
      width: 90%;
      max-width: 500px;
      text-align: center;
      overflow: hidden;
    }

    .marquee-container {
      width: 100%;
      overflow: hidden;
      position: relative;
    }

    .event-title-marquee {
      display: inline-block;
      white-space: nowrap;
      font-size: 24px;
      font-weight: bold;
      animation: scroll-left 12s linear infinite;
    }

    @keyframes scroll-left {
      0% { transform: translateX(100%); }
      100% { transform: translateX(-100%); }
    }

    .form-box {
      background: #00e6e6;
      width: 90%;
      max-width: 400px;
      padding: 40px 30px;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      color: #fff;
      text-align: center;
    }

    .form-box .icon-header {
      background: #fff;
      border-radius: 50%;
      width: 80px;
      height: 80px;
      margin: 0 auto 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      border: 4px solid #00cccc;
    }

    .form-box .icon-header i {
      font-size: 36px;
      color: #00cccc;
    }

    .form-box h2 {
      font-size: 18px;
      margin-bottom: 30px;
      letter-spacing: 1px;
      text-transform: uppercase;
    }

    .input-group {
      position: relative;
      margin-bottom: 20px;
    }

    .input-group input,
    .input-group textarea {
      width: 100%;
      padding: 12px 45px 12px 40px;
      border-radius: 30px;
      border: none;
      outline: none;
      background: #fff;
      color: #333;
      font-size: 14px;
    }

    .input-group textarea {
      resize: none;
      height: 80px;
    }

    .input-group i {
      position: absolute;
      left: 15px;
      top: 12px;
      color: #00cccc;
      font-size: 16px;
    }

    .submit-btn {
      width: 100%;
      border: none;
      background: #fff;
      color: #00cccc;
      font-weight: bold;
      font-size: 15px;
      padding: 10px;
      border-radius: 30px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .submit-btn:hover {
      background: #ccfafa;
    }

    @media (max-width: 576px) {
      .event-title-marquee {
        font-size: 20px;
      }
    }
  </style>
</head>
<body>

  <div class="event-header">
    <div class="marquee-container">
      <div class="event-title-marquee">
        {{ $event->judul }}
      </div>
    </div>
    <p class="mt-3 mb-1"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d F Y') }}</p>
    <p class="mb-1"><strong>Lokasi:</strong> {{ $event->lokasi }}</p>
    <p class="mb-1"><strong>Brand:</strong> {{ $event->brand->nama ?? '-' }}</p>
  </div>

  <div class="form-box">
    <div class="icon-header">
      <i class="fas fa-user"></i>
    </div>
    <h2>Formulir Pra Member</h2>

    @if(session('success'))
      <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('pra-member.store', $event->id) }}">
      @csrf

      <div class="input-group">
        <i class="fas fa-user"></i>
        <input type="text" name="nama" id="nama" placeholder="Nama Lengkap" required autocomplete="off" value="{{ old('nama') }}">
      </div>

      <div class="input-group">
        <i class="fas fa-phone"></i>
        <input type="number" name="telepon" id="telepon" placeholder="Nomor HP" required min="0" autocomplete="off" value="{{ old('telepon') }}">
      </div>

      <div class="input-group">
        <i class="fas fa-envelope"></i>
        <input type="email" name="email" id="email" placeholder="Email (Opsional)" autocomplete="off" value="{{ old('email') }}">
      </div>

      <div class="input-group">
        <i class="fas fa-comment"></i>
        <textarea name="keterangan" id="keterangan" placeholder="Catatan Tambahan" autocomplete="off">{{ old('keterangan') }}</textarea>
      </div>

      <button type="submit" class="submit-btn">KIRIM PENDAFTARAN</button>
    </form>
  </div>

  @if(session('duplicate'))
<!-- Modal Jika Sudah Mendaftar -->
<div class="modal fade" id="duplicateModal" tabindex="-1" aria-labelledby="duplicateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-warning">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title" id="duplicateModalLabel">Peringatan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        Halo <strong>{{ session('nama') }}</strong>, Anda sudah mendaftar sebagai <strong>Pra Member</strong> untuk event ini.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

{{-- Bootstrap JS (pastikan ini sudah ada atau tambahkan jika belum) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const modal = new bootstrap.Modal(document.getElementById('duplicateModal'));
    modal.show();
  });
</script>
@endif

</body>
</html>
