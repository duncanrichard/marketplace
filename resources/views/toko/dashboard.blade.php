{{-- File: resources/views/toko/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Toko SembakoKu</title>
  <link rel="icon" href="{{ asset('logo/logo toko sembako.jpeg') }}" type="image/jpeg">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(to right, #fdfbfb, #ebedee);
      font-family: 'Segoe UI', sans-serif;
    }
    .navbar-brand { font-size: 1.5rem; }
.shadow-text {
  text-shadow: 2px 2px 8px rgba(0,0,0,0.6);
}
.hero-banner {
  background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
              url('https://images.unsplash.com/photo-1582272992250-a7f1c98aa5ae?ixlib=rb-4.0.3&auto=format&fit=crop&w=1650&q=80') center/cover no-repeat;
  padding: 100px 0;
  color: #fff;
  border-radius: 12px;
  margin-bottom: 40px;
}


    .product-card {
      transition: 0.3s ease;
      border: none;
      border-radius: 12px;
      overflow: hidden;
      position: relative;
    }
    .product-card:hover {
      transform: scale(1.02);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }
    .product-card img {
      height: 180px;
      object-fit: cover;
      border-bottom: 1px solid #ddd;
      width: 100%;
    }
    .badge-new {
      position: absolute;
      top: 10px;
      left: 10px;
      background-color: #28a745;
      color: white;
      padding: 4px 8px;
      font-size: 0.75rem;
      border-radius: 5px;
    }
    .cart-icon {
      position: relative;
      cursor: pointer;
    }
    .cart-icon .badge {
      position: absolute;
      top: -8px;
      right: -10px;
      background: red;
      color: white;
      padding: 4px 7px;
      border-radius: 50%;
      font-size: 12px;
    }
    footer {
      margin-top: 60px;
      background-color: #212529;
    }
   @media (max-width: 576px) {
  .modal .modal-dialog {
    margin: 1rem;
  }

  .modal .modal-content {
    padding: 1rem;
  }

  .modal-body img {
    max-height: 200px !important;
    object-fit: cover;
  }

  .modal-body .list-group-item {
    font-size: 0.9rem;
  }
}

html {
  scroll-behavior: smooth;
}

  </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
  <div class="container">
<a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ url('/') }}">
  <img src="{{ asset('logo/logo toko sembako.jpeg') }}" alt="Logo" style="height: 36px;">
  <span class="text-white">Toko SembakoKu</span>
</a>

    <div class="ms-auto d-flex align-items-center gap-3">
      <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#modalCariPesanan">Cek Pesanan</button>
      <div class="cart-icon" data-bs-toggle="modal" data-bs-target="#cartModal">
        <span class="text-white fs-5"><i class="fas fa-shopping-cart"></i></span>
        <span class="badge" id="cart-count">0</span>
      </div>
    </div>
  </div>
</nav>

{{-- Hero --}}
<div class="hero-banner text-center animate__animated animate__fadeInDown">
  <div class="container py-5">
    <h1 class="display-3 fw-bold animate__animated animate__fadeInUp animate__delay-1s shadow-text">
      Belanja Sembako Praktis & Terjangkau
    </h1>
    <p class="lead mt-4 fs-4 animate__animated animate__fadeInUp animate__delay-2s shadow-text">
      Muarah • Mudah • Antar ke Rumah
    </p>
    <a href="#produk" class="btn btn-light btn-lg mt-4 animate__animated animate__fadeInUp animate__delay-3s fw-semibold shadow">
      Mulai Belanja <i class="fas fa-arrow-right ms-2"></i>
    </a>
  </div>
</div>



{{-- Flash Message --}}
@if(session('success'))
  <div class="container mt-3">
    <div class="alert alert-success text-center">
      {{ session('success') }}
    </div>
  </div>
@endif
<div class="container pb-5"  id="produk">
  <div class="row">
    {{-- Sidebar Filter --}}
    <div class="col-md-3" style="margin-top: 95px;">

      <div class="card mb-4">
        <div class="card-header bg-success text-white">Filter Produk</div>
        <div class="card-body">
          <form method="GET" action="{{ url('/') }}">
            <div class="mb-3">
              <label for="kategori" class="form-label">Kategori</label>
              <select class="form-select" name="kategori" id="kategori">

                <option value="">-- Semua --</option>
                @foreach($kategoris as $kat)
                  <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                @endforeach
              </select>
            </div>
            <button type="submit" class="btn btn-success w-100">Terapkan</button>
          </form>
        </div>
      </div>
    </div>

{{-- Daftar Produk --}}
<div class="col-md-9">

  <div class="text-center mb-4">
    <h2 class="fw-bold text-success">Produk Terbaru</h2>
    <p class="text-muted">Stok lengkap mulai dari beras, gula, minyak hingga kebutuhan harian lainnya</p>
  </div>

  <div class="row">
    @forelse ($produks as $produk)
      <div class="col-6 col-md-4 mb-4">
        <div class="card product-card shadow-sm h-100" style="cursor: pointer; position: relative;">

          <span class="badge-new">Baru</span>
          @php
            $gambar = $produk->foto && file_exists(public_path('storage/' . $produk->foto))
                      ? asset('storage/' . $produk->foto)
                      : asset('images/default-product.jpg');
          @endphp

          <img src="{{ $gambar }}" alt="{{ $produk->nama }}" class="w-100" style="height: 180px; object-fit: cover;">

          <div class="card-body">
            <h5 class="card-title">{{ $produk->nama }}</h5>
            <p class="mb-1 text-muted"><i class="fas fa-tags"></i> {{ $produk->kategori->nama ?? '-' }}</p>
            <p class="text-success fw-bold">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
           <div class="d-grid gap-2">
<button class="btn btn-outline-success mt-3"
  onclick="addToCartAndCloseModal(${data.produk.id}, '${data.produk.nama}', ${data.produk.harga})">
  <i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang
</button>

  <button class="btn btn-outline-primary"
  onclick="showDetail(event, {{ $produk->id }})">
  <i class="fas fa-info-circle me-1"></i> Detail
</button>
 
</div>

          </div>
        </div>
      </div>
    @empty
      <div class="col-12 text-center">
        <p class="text-muted">Belum ada produk tersedia.</p>
      </div>
    @endforelse
  </div>

  {{-- Pagination --}}
  <div class="d-flex justify-content-center mt-4">
    {{ $produks->links('pagination::bootstrap-5') }}
  </div>
</div>



{{-- Modal Keranjang --}}
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title"><i class="fas fa-shopping-cart"></i> Keranjang Belanja</h5>
        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body" id="cart-items"><p class="text-muted">Keranjang masih kosong.</p></div>
      <div class="modal-footer">
        <button class="btn btn-success" id="checkoutBtn" disabled>Checkout</button>
        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

{{-- Modal Cari Pesanan --}}
<div class="modal fade" id="modalCariPesanan" tabindex="-1" aria-labelledby="modalCariPesananLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formCariPesanan" class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title">🔍 Cek Status Pesanan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <label for="kodeBookingInput" class="form-label">Masukkan Kode Booking</label>
        <input type="text" id="kodeBookingInput" class="form-control" required>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Cari</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </form>
  </div>
</div>

{{-- Modal Hasil Pesanan --}}
<div class="modal fade" id="modalPesanan" tabindex="-1" aria-labelledby="modalPesananLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">📦 Detail Pesanan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body" id="hasilPesanan">
        <p class="text-muted">Memuat data...</p>
      </div>
    </div>
  </div>
</div>

{{-- Modal Detail Produk --}}
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">

    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="detailModalLabel">Detail Produk</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body" id="detailContent">
        <p class="text-muted">Memuat data...</p>
      </div>
    </div>
  </div>
</div>


{{-- Footer --}}
<footer class="text-white text-center py-3 bg-dark">
  &copy; {{ date('Y') }} <strong>Toko SembakoKu By.Richard</strong>. Semua hak dilindungi.
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
let cart = JSON.parse(localStorage.getItem('cart') || '[]');

// Tambah ke Keranjang
function addToCart(e, id, name, price) {
  if (e) e.stopPropagation(); // Hindari trigger modal
  const existing = cart.find(item => item.id === id);
  if (existing) {
    existing.qty += 1;
  } else {
    cart.push({ id, name, price, qty: 1 });
  }
  saveCart(); updateCartCount(); updateCartModal();
}

// Update Jumlah Item
function updateQty(id, value) {
  const item = cart.find(i => i.id === id);
  if (item) {
    item.qty = Math.max(1, parseInt(value));
    saveCart(); updateCartCount(); updateCartModal();
  }
}

// Hapus Item
function removeFromCart(id) {
  cart = cart.filter(i => i.id !== id);
  saveCart(); updateCartCount(); updateCartModal();
}

// Simpan Keranjang ke LocalStorage
function saveCart() {
  localStorage.setItem('cart', JSON.stringify(cart));
}

// Tampilkan Jumlah di Icon Cart
function updateCartCount() {
  const count = cart.reduce((sum, item) => sum + item.qty, 0);
  document.getElementById("cart-count").textContent = count;
}

// Tampilkan Isi Keranjang
function updateCartModal() {
  const container = document.getElementById("cart-items");
  const checkoutBtn = document.getElementById("checkoutBtn");
  container.innerHTML = "";

  if (cart.length === 0) {
    container.innerHTML = "<p class='text-muted'>Keranjang masih kosong.</p>";
    checkoutBtn.disabled = true;
    return;
  }

  checkoutBtn.disabled = false;
  let total = 0;
  const table = document.createElement("table");
  table.className = "table table-bordered table-sm align-middle";
  table.innerHTML = `
    <thead class="table-success text-center">
      <tr>
        <th>Nama</th><th>Harga</th><th>Qty</th><th>Total</th><th>Aksi</th>
      </tr>
    </thead>`;
  const tbody = document.createElement("tbody");

  cart.forEach(item => {
    const itemTotal = item.qty * item.price;
    total += itemTotal;
    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td>${item.name}</td>
      <td class="text-end">Rp ${item.price.toLocaleString()}</td>
      <td class="text-center">
        <input type="number" value="${item.qty}" class="form-control form-control-sm text-center" onchange="updateQty(${item.id}, this.value)">
      </td>
      <td class="text-end">Rp ${itemTotal.toLocaleString()}</td>
      <td class="text-center">
        <button class="btn btn-sm btn-danger" onclick="removeFromCart(${item.id})"><i class="fas fa-trash-alt"></i></button>
      </td>
    `;
    tbody.appendChild(tr);
  });

  table.appendChild(tbody);
  container.appendChild(table);

  const totalRow = document.createElement("div");
  totalRow.className = "text-end fw-bold fs-5 mt-3";
  totalRow.textContent = `Total: Rp ${total.toLocaleString()}`;
  container.appendChild(totalRow);
}

// 🚀 SHOW DETAIL PRODUK
function showDetail(e, id) {
  if (e?.stopPropagation) e.stopPropagation();

  const modalElement = document.getElementById("detailModal");
  const modalBody = document.getElementById("detailContent");
  modalBody.innerHTML = "<p class='text-muted'>Memuat data...</p>";

  fetch(`/produk/${id}`)
    .then(res => res.json())
    .then(data => {
      if (!data.success || !data.produk) {
        modalBody.innerHTML = "<div class='alert alert-danger'>Produk tidak ditemukan.</div>";
      } else {
        let html = `
          <div class="row flex-column flex-md-row">
            <div class="col-md-5 mb-3 text-center">
              <img src="${data.produk.gambar}" 
                   class="img-fluid rounded shadow-sm" 
                   style="max-height: 250px; object-fit: cover;" 
                   alt="${data.produk.nama}">
            </div>
            <div class="col-md-7">
              <h4 class="fw-bold text-success">${data.produk.nama}</h4>
              <p class="text-muted"><i class="fas fa-tags"></i> ${data.produk.kategori}</p>
              <p class="fs-5 fw-semibold text-success">Rp ${Number(data.produk.harga).toLocaleString()}</p>
              <p>${data.produk.deskripsi ?? '<em>Deskripsi tidak tersedia.</em>'}</p>
              <hr>
              <h6 class="fw-semibold text-muted">Spesifikasi:</h6>
              <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item"><strong>Berat:</strong> ${data.produk.detail?.berat ?? '-'}</li>
                <li class="list-group-item"><strong>Satuan:</strong> ${data.produk.detail?.satuan ?? '-'}</li>
                <li class="list-group-item"><strong>Kadaluarsa:</strong> ${data.produk.detail?.expired ?? '-'}</li>
                <li class="list-group-item"><strong>Produsen:</strong> ${data.produk.detail?.produsen ?? '-'}</li>
              </ul>
              <button class="btn btn-outline-success w-100"
                onclick="addToCartAndCloseModal(${data.produk.id}, '${data.produk.nama}', ${data.produk.harga})">
                <i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang
              </button>
            </div>
          </div>
        `;
        modalBody.innerHTML = html;
      }

      const modal = new bootstrap.Modal(modalElement);
      modal.show();
    })
    .catch(() => {
      modalBody.innerHTML = "<div class='alert alert-danger'>Gagal mengambil data produk.</div>";
      const modal = new bootstrap.Modal(modalElement);
      modal.show();
    });
}

function addToCartAndCloseModal(id, name, price) {
  addToCart(null, id, name, price);

  // Tutup modal setelah tambah ke keranjang
  const modalEl = document.getElementById("detailModal");
  const modal = bootstrap.Modal.getInstance(modalEl);
  if (modal) modal.hide();
}




// Checkout Button
document.getElementById("checkoutBtn").addEventListener("click", () => {
  if (cart.length === 0) return;
  localStorage.setItem('checkoutCart', JSON.stringify(cart));
  window.location.href = "/checkout";
});

// Cek Status Pesanan (AJAX)
document.getElementById("formCariPesanan").addEventListener("submit", function(e) {
  e.preventDefault();
  const kode = document.getElementById("kodeBookingInput").value;
  if (!kode.trim()) return;

  fetch("{{ route('pesanan.cari') }}", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": "{{ csrf_token() }}"
    },
    body: JSON.stringify({ kode_booking: kode })
  })
  .then(res => res.json())
  .then(data => {
    const hasil = document.getElementById("hasilPesanan");
    if (!data.success) {
      hasil.innerHTML = "<div class='alert alert-danger'>Pesanan tidak ditemukan.</div>";
    } else {
      let html = `
        <p><strong>Nama:</strong> ${data.pesanan.nama}</p>
        <p><strong>Telepon:</strong> ${data.pesanan.telepon}</p>
        <p><strong>Alamat:</strong> ${data.pesanan.alamat}</p>
        <p><strong>Tanggal Order:</strong> ${data.pesanan.tanggal_order}</p>
        <p><strong>Status:</strong> 
  <span class="badge ${getBadgeClass(data.pesanan.status)}">${data.pesanan.status}</span>
</p>


        <h5 class="mt-3">🧾 Item:</h5><ul class="list-group">`;
      data.items.forEach(item => {
        html += `<li class="list-group-item d-flex justify-content-between">
                  ${item.nama_produk} x ${item.qty}
                  <span>Rp ${item.total.toLocaleString()}</span>
                </li>`;
      });
      html += "</ul>";
      hasil.innerHTML = html;
    }
    new bootstrap.Modal(document.getElementById("modalPesanan")).show();
  });
});

// Inisialisasi saat halaman dimuat
updateCartCount();
updateCartModal();

// Kosongkan cart jika session clear_cart aktif
@if(session('clear_cart'))
  localStorage.removeItem('cart');
  localStorage.removeItem('checkoutCart');
  cart = [];
  updateCartCount();
  updateCartModal();
@endif
function getBadgeClass(status) {
  switch (status) {
    case 'Pesanan Di Proses':
      return 'bg-warning text-dark';
    case 'Pesanan Di Kirim':
      return 'bg-info text-dark';
    case 'Pesanan Selesai':
      return 'bg-success';
    default:
      return 'bg-secondary';
  }
}

</script>
<!-- jQuery (dibutuhkan oleh Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  // Inisialisasi Select2 setelah DOM siap
  $(document).ready(function() {
    $('#kategori').select2({
      placeholder: "Pilih kategori...",
      allowClear: true,
      width: '100%'
    });
  });
</script>


</body>
</html>
