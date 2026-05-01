<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan</title>

    <link rel="stylesheet" href="{{ asset('css/riwayat.css') }}">
</head>
<body>

<div class="toggle-btn" onclick="toggleSidebar()">☰</div>
<div id="sidebar" class="sidebar">

    <div class="logo">
        <img src="{{ asset('images/logo.png') }}">
    </div>

    <div class="menu">
        <a href="{{ route('dashboard') }}" class="menu-item">Pilih Kantin</a>

        <a href="{{ route('riwayat') }}" 
           class="menu-item active">
           Riwayat Pesanan
        </a>

        <a href="{{ route('profil') }}" class="menu-item">Profil</a>
    </div>

</div>

<!-- Main -->
<div class="main-content">

    <h1>Riwayat Pemesanan<br>Makanan Kantin</h1>

    <!-- Filter -->
    <div class="filter">
<div class="filter">
        <div>
            <label>Pilih Kantin :</label>
            <select class="filter-select">
                <option>All</option>
                <option>Kantin A</option>
                <option>Kantin B</option>
                <option>Kantin C</option>
            </select>
        </div>
        <div>
            <label>Status :</label>
            <select class="filter-select">
                <option>All</option>
                <option>Menunggu</option>
                <option>Diproses</option>
                <option>Dibatalkan</option>
                <option>Selesai</option>
            </select>
        </div>

</div>
    </div>

    <!-- Card Container -->
    <div class="riwayat-container">

        <!-- Card -->
        <div class="riwayat-card">
            <div class="status menunggu">⏳ Menunggu</div>
            <h3>Kantin A</h3>
            <p>ID Pesanan : K01</p>
            <p>Menu : Es Teh, Dimsum Ayam</p>
            <p>Total : Rp. 20000</p>
            <p>Metode Pembayaran : E-Wallet</p>
            <p>Reservasi Waktu Ambil : 15 Menit</p>
        </div>

        <div class="riwayat-card">
            <div class="status diproses">🔄 Diproses</div>
            <h3>Kantin B</h3>
            <p>ID Pesanan : K01</p>
            <p>Menu : Es Teh, Nasi Soto Ayam</p>
            <p>Total : Rp. 20000</p>
            <p>Metode Pembayaran : Dine-In</p>
            <p>Reservasi Waktu Ambil : 10 Menit</p>
        </div>

        <div class="riwayat-card">
            <div class="status dibatalkan">❌ Dibatalkan</div>
            <h3>Kantin B</h3>
            <p>ID Pesanan : K01</p>
            <p>Menu : Es Jeruk, Nasi Goreng</p>
            <p>Total : Rp. 20000</p>
            <p>Metode Pembayaran : E-Wallet</p>
            <p>Reservasi Waktu Ambil : 20 Menit</p>
        </div>

        <div class="riwayat-card">
            <div class="status selesai">✔ Selesai</div>
            <h3>Kantin C</h3>
            <p>ID Pesanan : K01</p>
            <p>Menu : Air Mineral, Bakso Komplit</p>
            <p>Total : Rp. 17000</p>
            <p>Metode Pembayaran : E-Wallet</p>
            <p>Reservasi Waktu Ambil : 10 Menit</p>
        </div>

    </div>

</div>

<script>
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("hide");
}
</script>

</body>
</html>
