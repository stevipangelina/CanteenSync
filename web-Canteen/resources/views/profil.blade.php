<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>

    <link rel="stylesheet" href="{{ asset('css/profil.css') }}">
</head>
<body>

<div class="toggle-btn" onclick="toggleSidebar()">
    ☰
</div>

<div id="sidebar" class="sidebar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}">
    </div>
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

<div class="main-content">
    <h1>Profil</h1>
    <div class="profile-card">
        <div class="profile-icon">
            👤
        </div>

        <form>
            <div class="form-row">
                <div class="form-group">
                    <label>Nama User</label>
                    <div class="input-box">
                        <input type="text" value="Tanistechlabs">
                        <span>✎</span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-box">
                        <input type="text" value="Tanistechlabs2026">
                        <span>✎</span>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Email</label>
                    <div class="input-box">
                        <input type="email" value="Tanistechlabs@gmail.com">
                        <span>✎</span>
                    </div>
                </div>

                <div class="form-group">
                    <label>No. handphone</label>
                    <div class="input-box">
                        <input type="text" value="09876543210">
                        <span>✎</span>
                    </div>
                </div>

            </div>
            <button type="submit" class="save-btn">
                Simpan Perubahan
            </button>

            <br>

            <button type="button" class="logout-btn">
                Logout
            </button>
        </form>
    </div>
</div>

<script>
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("hide");
}
</script>
</body>
</html>