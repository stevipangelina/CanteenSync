<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>
        {{ $menu ? 'Edit Menu' : 'Add New Menu' }}
    </title>
    <link rel="stylesheet" href="{{ asset('css/edit_add_menu.css') }}">

</head>

<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <a
            href="{{ route('kantin.menu.index', $id) }}"
            class="back-btn"
        >
            ←
        </a>

        <!-- TITLE -->
        <h1>
            {{ $menu ? 'Edit Menu' : 'Add New Menu' }}
        </h1>
    </div>

    <div class="logo">
        <img src="{{ asset('images/logo.png') }}">
    </div>

    <form
        action="{{ $menu
            ? route('kantin.menu.update', [$id, $menu->id_menu])
            : route('kantin.menu.store', $id)
        }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        @if($menu)
            @method('PUT')
        @endif

        <label>Nama Menu</label>
        <input
            type="text"
            name="nama_menu"
            value="{{ $menu ? $menu->nama_menu : '' }}"
            placeholder="Nama Menu"
        >

        <label>Kategori</label>
        <select name="kategori">
            <option value="makanan"
                {{ ($menu && $menu->kategori == 'makanan') ? 'selected' : '' }}>
                Makanan
            </option>

            <option value="minuman"
                {{ ($menu && $menu->kategori == 'minuman') ? 'selected' : '' }}>
                Minuman
            </option>

            <option value="snack"
                {{ ($menu && $menu->kategori == 'snack') ? 'selected' : '' }}>
                Snack
            </option>
        </select>

        <div class="row">
            <div class="group">
                <label>Harga</label>
                <input
                    type="number"
                    name="harga"
                    value="{{ $menu ? $menu->harga : '' }}"
                    placeholder="Rp. 8000"
                >

            </div>

            <div class="group">
                <label>Stok</label>
                <input
                    type="number"
                    name="stok"
                    value="{{ $menu ? $menu->stok : '' }}"
                    placeholder="30"
                >
            </div>

        </div>

        <label>Foto Menu</label>
        <div class="upload-box">
            <div class="upload-left">
                📷
                <p>Unggah Foto Menu</p>
            </div>
            <div class="upload-right">
                <input
                    type="file"
                    name="gambar"
                >
            </div>

        </div>

        @if($menu && $menu->gambar)
            <div class="preview">
                <img
                    src="{{ asset('gambar_menu/'.$menu->gambar) }}"
                >
            </div>
        @endif

        <!-- BUTTON -->
        <div class="btn-area">
            <button type="submit">
                {{ $menu ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>

</body>
</html>