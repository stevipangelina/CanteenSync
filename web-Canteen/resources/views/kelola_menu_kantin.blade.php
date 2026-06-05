<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Menu Kantin</title>

    <link rel="stylesheet" href="{{ asset('css/kelola_menu.css') }}">
</head>

<body>

<!-- TOGGLE -->
<div class="toggle-btn" onclick="toggleSidebar()">
    ☰
</div>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <div class="logo">
            <img src="{{ asset('images/logo.png') }}">
        </div>

        <div class="menu-sidebar">

            <a href="#">
                <button>Kelola Menu</button>
            </a>

            <a href="#">
                <button>Pesanan Masuk</button>
            </a>

            <a href="#">
                <button>Riwayat Penjualan</button>
            </a>

        </div>

    </div>

    <!-- CONTENT -->
    <div class="content">

        <!-- HOME -->
        <div class="home-icon">
            🏠
        </div>

        <!-- TITLE -->
        <div class="title">

            <h1>
                Kelola Menu <br>
                {{ $kantin->nama_kantin }}
            </h1>

        </div>

        <!-- FILTER -->
        <div class="filter">

            <form method="GET">

                <label>Kategori :</label>

                <select
                    name="kategori"
                    onchange="this.form.submit()"
                >

                    <option value="">Makanan</option>

                    <option value="makanan"
                        @if($kategori == 'makanan') selected @endif>
                        Makanan
                    </option>

                    <option value="minuman"
                        @if($kategori == 'minuman') selected @endif>
                        Minuman
                    </option>

                    <option value="snack"
                        @if($kategori == 'snack') selected @endif>
                        Snack
                    </option>

                </select>

            </form>

        </div>

        <!-- HEADER -->
        <div class="table-header">

            <div>Foto</div>
            <div>Nama Menu</div>
            <div>Harga</div>
            <div>Stok</div>
            <div>Aksi</div>

        </div>

        <!-- DATA MENU -->
        @foreach($menu as $m)

        <div class="card-menu">

            <!-- FOTO -->
            <div>
                <img src="{{ asset('gambar_menu/'.$m->gambar) }}">
            </div>

            <!-- NAMA -->
            <div class="nama-menu">
                {{ $m->nama_menu }}
            </div>

            <!-- HARGA -->
            <div>
                RP. {{ number_format($m->harga) }}
            </div>

            <!-- STOK -->
            <div>
                {{ $m->stok }}
            </div>

            <!-- AKSI -->
            <div class="aksi">

                <!-- EDIT -->
                <a href="{{ route('kantin.menu.edit', [$id, $m->id_menu]) }}">

                    <button class="btn btn-edit">
                        ✏ Edit
                    </button>

                </a>

                <!-- HAPUS -->
                <form
                    action="{{ route('kantin.menu.delete', [$id, $m->id_menu]) }}"
                    method="POST"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-hapus"
                        onclick="return confirm('Apakah yakin menghapusnya?')"
                    >
                        🗑 Hapus
                    </button>

                </form>

            </div>

        </div>

        @endforeach

        <!-- ADD MENU -->
        <div class="add-menu">

            <a href="{{ route('kantin.menu.create', $id) }}">

                <button class="btn-add">
                    Add New Menu
                </button>

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