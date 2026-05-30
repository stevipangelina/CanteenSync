<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

<!-- Toggle -->
<div class="toggle-btn" onclick="toggleSidebar()">
    ☰
</div>

<!-- Sidebar -->
<div id="sidebar" class="sidebar">

    <!-- Logo -->
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}">
        <h3>Tanistech Canteen</h3>
    </div>

    <!-- Menu -->
    <div class="menu">

        <a href="{{ route('dashboard') }}" 
           class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
           Pilih Kantin
        </a>

        <a href="{{ route('riwayat') }}" 
           class="menu-item {{ request()->routeIs('riwayat') ? 'active' : '' }}">
           Riwayat Pesanan
        </a>

        <a href="{{ route('profil') }}" 
           class="menu-item {{ request()->routeIs('profil') ? 'active' : '' }}">
           Profil
        </a>

    </div>

</div>

<!-- Main -->
<div class="main-content">

    <h1>Selamat Datang<br>Tanistech Canteen</h1>

    <p class="subtitle">Pilih Kantin Tujuan Anda:</p>

    <div class="card-container">

        <div class="card">
            <img src="{{ asset('images/kantin-a.png') }}">
            <h3>Kantin A</h3>
            <button>Lihat Menu</button>
        </div>

        <div class="card">
            <img src="{{ asset('images/kantin-b.png') }}">
            <h3>Kantin B</h3>
            <button>Lihat Menu</button>
        </div>

        <div class="card">
            <img src="{{ asset('images/kantin-c.png') }}">
            <h3>Kantin C</h3>
            <button>Lihat Menu</button>
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
