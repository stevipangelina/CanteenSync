<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

<div class="toggle-btn" onclick="toggleSidebar()">
    ☰
</div>

<div id="sidebar" class="sidebar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}">
        <h3>Tanistech Canteen</h3>
    </div>

    <div class="menu">
            <select onchange="redirectKantin(this.value)">
                <option value="">
                    Pilih Kantin
                </option>
                <option value="{{ url('/kantin/1') }}">
                    Kantin A
                </option>
                <option value="{{ url('/kantin/2') }}">
                    Kantin B
                </option>
                <option value="{{ url('/kantin/3') }}">
                    Kantin C
                </option>
            </select>

            <a href="{{ route('riwayat') }}">
                <button>Riwayat Pesanan</button>
            </a>
            <a href="{{ route('profil') }}">
                <button>Profile</button>
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
            <h3>Kantin Nusantara</h3>
            <a href="{{ route('lihat.menu', ['id' => 1]) }}">
                <button>Lihat Menu</button>
            </a>
        </div>
        <div class="card">
            <img src="{{ asset('images/kantin-b.png') }}">
            <h3>Kantin Sehat</h3>
            <a href="{{ route('lihat.menu', ['id' => 2]) }}">
                <button>Lihat Menu</button>
            </a>
        </div>
        <div class="card">
            <img src="{{ asset('images/kantin-c.png') }}">
            <h3>Kantin Gaul</h3>
            <a href="{{ route('lihat.menu', ['id' => 3]) }}">
                <button>Lihat Menu</button>
            </a>
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
