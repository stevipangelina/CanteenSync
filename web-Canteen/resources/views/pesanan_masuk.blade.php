<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Masuk</title>
    <link rel="stylesheet" href="{{ asset('css/pesanan_masuk.css') }}">
</head>

<body>
<div class="page-wrapper">
    <div class="sidebar">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>

        <a href="/kelola-menu/1" class="menu-btn">
            Kelola Menu
        </a>
        <a href="{{ route('kantin.pesanan') }}" class="menu-btn active">
            Pesanan Masuk
        </a>
        <a href="{{ route('kantin.riwayat') }}" class="menu-btn">
            Riwayat Penjualan
        </a>
    </div>

    <div class="content">
        <div class="header">
            <h1>
                Pesanan Masuk <br> Kantin A
            </h1>
            <a href="{{ route('dashboard') }}" class="home-icon"> 🏠 </a>
        </div>

        <div class="status-menu">
            <a href="?status=menunggu" class="status-btn menunggu">
                Pesanan Baru
            </a>
            <a href="?status=diproses" class="status-btn diproses">
                Diproses
            </a>
            <a href="?status=siap_diambil" class="status-btn siap">
                Siap Ambil
            </a>
            <a href="?status=selesai" class="status-btn selesai">
                Selesai
            </a>
            <a href="?status=dibatalkan" class="status-btn batal">
                Dibatalkan
            </a>
        </div>

        @foreach($pesanan as $p)
        <div class="order-card">
            <div class="order-info">
                <div class="row-top">
                    <div class="order-id">
                        <strong>
                            ID Pesanan :
                            {{ $p->nomor_kantin }}
                        </strong>
                    </div>

                    <div class="order-name">
                        <strong>
                            Nama :
                            {{ $p->nama_pemesan ?? 'Tanist' }}
                        </strong>
                    </div>
                </div>

                <div class="row-middle">
                    <div class="menu-col">
                        @foreach($p->detail as $d)
                        <div class="menu-row">
                            <span>
                                {{ $d->menu->nama_menu }}
                            </span>
                            <span>
                                {{ $d->jumlah }}x
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="row-bottom">
                    <div>
                        Metode Pembayaran :
                        {{ $p->metode_pembayaran }}
                    </div>
                    <div>
                        <strong>
                            Total Harga :
                            Rp {{ number_format($p->total_harga,0,',','.') }}
                        </strong>
                    </div>
                </div>
            </div>

            <div class="action-section">
                @if($p->status == 'menunggu')
                <form action="{{ route('kantin.update.status',$p->id_pesanan) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="diproses">
                    <button type="submit" class="action-btn btn-proses">
                        Diproses
                    </button>
                </form>

                <form action="{{ route('kantin.update.status',$p->id_pesanan) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="dibatalkan">
                    <button type="submit" class="action-btn btn-batal">
                        Dibatalkan
                    </button>
                </form>

                @endif
                @if($p->status == 'diproses')

                <form action="{{ route('kantin.update.status',$p->id_pesanan) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="siap_diambil">
                    <button type="submit" class="action-btn btn-siap">
                        Siap Diambil
                    </button>
                </form>

                @endif
                @if($p->status == 'siap_diambil')

                <form action="{{ route('kantin.update.status',$p->id_pesanan) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="selesai">
                    <button type="submit" class="action-btn btn-selesai">
                        Selesai
                    </button>
                </form>

                @endif
                @if($p->status == 'dibatalkan')

                <span class="label-status batal-text">
                    Pesanan Dibatalkan
                </span>

                @endif
                @if($p->status == 'selesai')

                <span class="label-status selesai-text">
                    Pesanan Selesai
                </span>

                @endif
            </div>
        </div>
        @endforeach
    </div>

</div>

</body>
</html>