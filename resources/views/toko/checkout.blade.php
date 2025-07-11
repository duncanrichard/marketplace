<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Checkout - Toko Sembako Richard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f5f5f5;
      font-family: 'Segoe UI', sans-serif;
    }
    .container {
      max-width: 900px;
    }
    .checkout-box {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    .table th, .table td {
      vertical-align: middle;
    }
  </style>
</head>
<body>

<div class="container my-5">
  <div class="checkout-box">
    <h2 class="mb-4">🧾 Checkout Pembelian</h2>

    <div id="checkout-cart" class="mb-4"></div>

    <h4 class="mb-3">🧍‍♂️ Data Pembeli</h4>
    <form method="POST" action="{{ route('checkout.submit') }}" onsubmit="return handleFormSubmit()">
      @csrf
      <input type="hidden" name="items" id="cartItemsInput">

      <div class="row g-3">
        <div class="col-md-6">
          <label>Kode Booking</label>
          <input type="text" name="kode_booking" id="kodeBooking" class="form-control" readonly>
        </div>
        <div class="col-md-3">
          <label>Tanggal Order</label>
          <input type="text" name="tanggal_order" id="tanggalOrder" class="form-control" readonly>
        </div>
          <div class="col-md-3">
          <label>Tanggal Pengiriman</label>
          <input type="date" name="tanggal_pengiriman" id="tanggalPengiriman" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Nama Lengkap</label>
          <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>No. HP / WA</label>
          <input type="text" name="telepon" class="form-control" required>
        </div>
        <div class="col-12">
          <label>Alamat Pengiriman</label>
          <textarea name="alamat" rows="3" class="form-control" required></textarea>
        </div>
        <div class="col-12">
          <label>Metode Pembayaran</label>
          <select name="metode" class="form-select" required>
            <option value="">-- Pilih Metode --</option>
            <option>Transfer Bank</option>
            <option>COD (Bayar di Tempat)</option>
            <option>E-Wallet</option>
          </select>
        </div>
      </div>

      <div class="mt-4 text-end">
        <button type="submit" class="btn btn-success btn-lg">
          <i class="fas fa-money-check-alt me-2"></i>Bayar Sekarang
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  const cartData = JSON.parse(localStorage.getItem('checkoutCart') || '[]');
  const cartContainer = document.getElementById("checkout-cart");

  if (cartData.length === 0) {
    cartContainer.innerHTML = `
      <div class='alert alert-warning'>
        Keranjang kosong. <a href='/' class='text-decoration-underline'>Kembali ke toko</a>
      </div>`;
    document.querySelector("form").style.display = "none";
  } else {
    let total = 0;
    const table = document.createElement("table");
    table.className = "table table-bordered table-striped";

    table.innerHTML = `
      <thead class="table-success text-center">
        <tr>
          <th>Nama Produk</th>
          <th>Harga</th>
          <th>Qty</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        ${cartData.map(item => {
          const subtotal = item.qty * item.price;
          total += subtotal;
          return `
            <tr>
              <td>${item.name}</td>
              <td class="text-end">Rp ${item.price.toLocaleString()}</td>
              <td class="text-center">${item.qty}</td>
              <td class="text-end">Rp ${subtotal.toLocaleString()}</td>
            </tr>`;
        }).join("")}
        <tr>
          <td colspan="3" class="text-end fw-bold">Total</td>
          <td class="text-end fw-bold text-success">Rp ${total.toLocaleString()}</td>
        </tr>
      </tbody>
    `;
    cartContainer.appendChild(table);
  }

  // Generate kode booking dan tanggal otomatis
  function generateKodeBooking() {
    const now = new Date();
    const random = Math.floor(1000 + Math.random() * 9000);
    return 'INV' +
      now.getFullYear().toString().slice(-2) +
      (now.getMonth() + 1).toString().padStart(2, '0') +
      now.getDate().toString().padStart(2, '0') +
      random;
  }

  document.getElementById("kodeBooking").value = generateKodeBooking();
 const now = new Date();
  const dd = String(now.getDate()).padStart(2, '0');
  const mm = String(now.getMonth() + 1).padStart(2, '0'); // bulan dimulai dari 0
  const yyyy = now.getFullYear();

  const todayFormatted = `${dd}-${mm}-${yyyy}`; // atau pakai "/" jika ingin "dd/mm/yyyy"
  document.getElementById("tanggalOrder").value = todayFormatted;

  function handleFormSubmit() {
    document.getElementById("cartItemsInput").value = JSON.stringify(cartData);
    localStorage.removeItem('checkoutCart');
    return true;
  }
</script>

</body>
</html>
