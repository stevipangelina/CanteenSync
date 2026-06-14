<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Riwayat Pesanan </title>
    <link rel="stylesheet" href="{{ asset('css/riwayat.css') }}">
</head>

<body>

<!-- TOGGLE -->
<div
    class="toggle-btn"
    onclick="toggleSidebar()"> ☰ </div>

<!-- SIDEBAR -->
<div
    id="sidebar"
    class="sidebar">
    <!-- LOGO -->
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}">
    </div>

    <!-- MENU -->
    <div class="menu">
        <a href="{{ url('/dashboard') }}">
            <button> Pilihan Kantin </button>
        </a>
        <a href="{{ route('riwayat') }}"> <button> Riwayat Pesanan </button> </a>
        <a href="{{ route('profil') }}"> <button> Profil </button> </a>
    </div>
</div>

<!-- MAIN -->
<div class="main-content">
    <!-- TITLE -->
    <h1>
        Riwayat Pemesanan<br>Makanan Kantin
    </h1>

    <!-- FILTER -->
    <form method="GET">
        <div class="filter">
            <!-- FILTER KANTIN -->
            <div>
                <label>
                    Pilih Kantin :
                </label>

                <select
                    name="kantin"
                    class="filter-select"
                    onchange="this.form.submit()">
                    <option value=""> All </option>
                    <option
                        value="1"
                        {{ request('kantin') == 1 ? 'selected' : '' }}>
                        Kantin Nusantara
                    </option>

                    <option
                        value="2"
                        {{ request('kantin') == 2 ? 'selected' : '' }}>
                        Kantin Sehat
                    </option>

                    <option
                        value="3"
                        {{ request('kantin') == 3 ? 'selected' : '' }}>
                        Kantin Gaul
                    </option>
                </select>
            </div>

            <!-- FILTER STATUS -->
            <div>
                <label> Status : </label>

                <select
                    name="status"
                    class="filter-select"
                    onchange="this.form.submit()">

                    <option value=""> All </option>

                    <option
                        value="menunggu"
                        {{ request('status') == 'menunggu' ? 'selected' : '' }}>
                        Menunggu
                    </option>

                    <option
                        value="diproses"
                        {{ request('status') == 'diproses' ? 'selected' : '' }}>
                        Diproses
                    </option>

                    <option
                        value="dibatalkan"
                        {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>
                        Dibatalkan
                    </option>

                    <option
                        value="selesai"
                        {{ request('status') == 'selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>
                </select>
            </div>
        </div>
    </form>

    <!-- ALERT SUCCESS -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- ALERT ERROR -->
    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <!-- CARD CONTAINER -->
    <div class="riwayat-container">
        @forelse($pesanan as $item)
            @php
                $status = $item->status;
            @endphp

            <!-- CARD -->
            <div class="riwayat-card">
                <!-- STATUS -->
                <div class="status {{ $status }}">
                    @if($status == 'menunggu')
                        ⏳ Menunggu
                    @elseif($status == 'diproses')
                        🔄 Diproses
                    @elseif($status == 'dibatalkan')
                        ❌ Dibatalkan
                    @elseif($status == 'selesai')
                        ✔ Selesai
                    @endif
                </div>

                <!-- KANTIN -->
                <h3>
                    Kantin
                    {{ chr(64 + $item->id_kantin) }}
                </h3>

                <!-- ID -->
                <p>
                    ID Pesanan :
                    K{{ $item->id_pesanan }}
                </p>

                <!-- MENU -->
                <p>
                    Menu :
                    @foreach($item->detailPesanan as $detail)
                        {{ $detail->menu->nama_menu ?? 'Menu Tidak Ada' }}
                        @if(!$loop->last)
                            ,
                        @endif
                    @endforeach
                </p>

                <!-- TOTAL -->
                <p>
                    Total : Rp {{ number_format($item->total_harga) }}
                </p>

                <!-- METODE -->
                <p>
                    Metode Pembayaran : {{ $item->metode_pembayaran }}
                </p>

                <!-- RESERVASI -->
                <p> Reservasi Waktu Ambil : {{ $item->jam_pengambilan }} Menit</p>

                <!-- BUTTON BATAL -->
                @if($status == 'menunggu')
                    <form
                        action="{{ route('pesanan.batal', $item->id_pesanan) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <button
                            type="submit"
                            class="btn-batal">
                            Batalkan Pesanan
                        </button>
                    </form>
                @endif
            </div>
        @empty
            <div class="alert alert-error">
                Belum ada riwayat pemesanan.
            </div>
        @endforelse
    </div>
</div>

<!-- SCRIPT -->
<script>
function toggleSidebar()
{
    document
        .getElementById("sidebar")
        .classList
        .toggle("hide");

}

</script>

</body>
</html>