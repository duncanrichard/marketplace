<h3>Pengajuan Event Baru</h3>
<p><strong>Judul:</strong> {{ $event->judul }}</p>
<p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}</p>
<p><strong>Lokasi:</strong> {{ $event->lokasi }}</p>
<p><strong>Oleh:</strong> {{ $event->user->name }}</p>

<p>Silakan verifikasi atau tolak pengajuan ini:</p>

<a href="{{ $verifyUrl }}" 
   style="display:inline-block; padding:10px 20px; background-color:green; color:white; text-decoration:none; margin-right:10px;">
   ✅ Verifikasi
</a>

<a href="{{ $rejectUrl }}" 
   style="display:inline-block; padding:10px 20px; background-color:red; color:white; text-decoration:none;">
   ❌ Tolak
</a>
