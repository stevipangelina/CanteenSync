<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Menu Kantin</title>
    <link rel="stylesheet" href="{{ asset('css/kelola_menu.css') }}">
</head>

<body>

<div class="toggle-btn" onclick="toggleSidebar()">
    ☰
</div>

<div class="page-wrapper">
    <div class="sidebar">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>
        <a href="/menu/{{ $id }}" class="menu-btn active">
            Kelola Menu
        </a>
        <a href="{{ route('pesanan-masuk', ['id_kantin' => $id]) }}" class="menu-btn">
            Pesanan Masuk
        </a>
        <a href="{{ route('kantin.riwayat', ['id_kantin' => $id]) }}" class="menu-btn">
            Riwayat Penjualan
        </a>
    </div>

    <div class="content">
        <div class="home-icon">
            🏠
        </div>
        <div class="title">
            <h1>
                Kelola Menu <br>
                {{ $kantin->nama_kantin }}
            </h1>
        </div>

        <div class="filter">
            <form method="GET" action="{{ route('kantin.menu.index', ['id' => $id]) }}">
                <label>Kategori :</label>
                <select name="kategori" onchange="this.form.submit()">
                    <option value="">All</option>
                    <option value="makanan" @if($kategori == 'makanan') selected @endif>Makanan</option>
                    <option value="minuman" @if($kategori == 'minuman') selected @endif>Minuman</option>
                    <option value="snack" @if($kategori == 'snack') selected @endif>Snack</option>
                </select>
            </form>
        </div>

        <div class="table-header">
            <div>Foto</div>
            <div>Nama Menu</div>
            <div>Harga</div>
            <div>Stok</div>
            <div>Aksi</div>
        </div>

        @foreach($menu as $m)
        <div class="card-menu">
            <div>
                <img src="{{ asset('gambar_menu/'.$m->gambar) }}">
            </div>
            <div class="nama-menu">
                {{ $m->nama_menu }}
            </div>
            <div>
                RP. {{ number_format($m->harga) }}
            </div>
            <div>
                {{ $m->stok }}
            </div>
            <div class="aksi">
                <a href="{{ route('kantin.menu.edit', [$id, $m->id_menu]) }}">
                    <button class="btn btn-edit">✏ Edit</button>
                </a>

                <form action="{{ route('kantin.menu.delete', [$id, $m->id_menu]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-hapus"
                        onclick="return confirm('Apakah yakin menghapusnya?')">
                        🗑 Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach

        <!-- ADD MENU -->
        <div class="add-menu">
            <a href="{{ route('kantin.menu.create', $id) }}">
                <button class="btn-add">Add New Menu</button>
            </a>
        </div>

    </div>

</div>

<script>
function toggleSidebar() {
    document.querySelector(".sidebar").classList.toggle("hide");
}
</script>

</body>
</html>