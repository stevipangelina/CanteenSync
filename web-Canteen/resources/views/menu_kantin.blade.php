<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kantin {{ $id }}</title>
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
</head>

<body>

<div class="sidebar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Kantin">
    </div>

    <h2>Kategori :</h2>
    <div class="kategori">
        <a href="/kantin/{{ $id }}">Makanan Utama</a>
        <a href="/kantin/{{ $id }}?kategori=minuman">Minuman</a>
        <a href="/kantin/{{ $id }}?kategori=snack">Snack</a>
    </div>
    <a href="{{ url('/dashboard') }}" class="btn-back">← Pilih Kantin</a>
</div>


<!-- CONTENT -->
<div class="content">
    <div class="cart">
        <a href="{{ route('keranjang.index') }}">🛒</a>
    </div>

    <h1>Daftar Menu<br>Kantin {{ $id }}</h1>
    @if(session('success'))
        <div class="notif">
            {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
    <script>
        if(confirm("{{ session('warning')['message'] }}")) {

            let form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('keranjang.tambah') }}";

            let token = document.createElement('input');
            token.type = 'hidden';
            token.name = '_token';
            token.value = "{{ csrf_token() }}";

            let id = document.createElement('input');
            id.type = 'hidden';
            id.name = 'id';
            id.value = "{{ session('warning')['menu_id'] }}";

            let force = document.createElement('input');
            force.type = 'hidden';
            force.name = 'force';
            force.value = "1";

            form.appendChild(token);
            form.appendChild(id);
            form.appendChild(force);

            document.body.appendChild(form);
            form.submit();
        }
    </script>
    @endif

    <h2 class="judul">Makanan Utama</h2>

    <!-- GRID MENU -->
    <div class="menu-grid">
        @forelse($menu as $menu)
            <div class="card">
                <img src="{{ asset('images/'.$menu->gambar) }}" alt="">
                <h4>{{ $menu->nama_menu }}</h4>
                <p>Rp {{ number_format($menu->harga) }}</p>
                <p>Stok : {{ $menu->stok }}</p>

                <!-- FORM KERANJANG -->
                <form action="{{ route('keranjang.tambah') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $menu->id_menu }}">
                    <input type="hidden" name="force" value="0">

                    <button class="btn">Tambah Keranjang</button>
                </form>

            </div>
        @empty
            <p>Tidak ada menu</p>
        @endforelse
    </div>

</div>

</body>
</html>
