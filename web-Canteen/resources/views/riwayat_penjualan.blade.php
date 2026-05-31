<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Penjualan</title>
    <link rel="stylesheet" href="{{ asset('css/riwayat_penjualan.css') }}">
</head>

<body>
<div class="page-wrapper">
    <div class="sidebar">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>
        <a href="{{ route('kantin.menu.index',$id_kantin ?? 1) }}" class="menu-btn">
            Kelola Menu
        </a>
        <a href="{{ route('kantin.pesanan',$id_kantin ?? 1) }}" class="menu-btn">
            Pesanan Masuk
        </a>
        <a href="{{ route('kantin.riwayat',$id_kantin ?? 1) }}" class="menu-btn active">
            Riwayat Penjualan
        </a>
    </div>

    <div class="content">
        <div class="header">
            <h1>
                Riwayat Penjualan <br>
                Kantin A
            </h1>
            <a href="{{ route('dashboard') }}" class="home-icon">
                🏠
            </a>
        </div>

        <div class="summary-container">
            <div class="summary-card">
                <h3>Total Pendapatan</h3>
                <p>Rp. {{ number_format($totalPendapatan,0,',','.') }}</p>
            </div>
            <div class="summary-card">
                <h3>Dine In</h3>
                <p>Rp. {{ number_format($totalDineIn,0,',','.') }}</p>
            </div>
            <div class="summary-card">
                <h3>E-Wallet</h3>
                <p>Rp. {{ number_format($totalEwallet,0,',','.') }}</p>
            </div>
        </div>

        <div class="history-container">
            <div class="table-header">
                <div>ID Pesanan</div>
                <div>Nama</div>
                <div>Menu</div>
                <div>Total</div>
                <div>Metode Pembayaran</div>
            </div>
            @foreach($penjualan as $p)
            <div class="history-row">
                <div>
                    K{{ $p->id_pesanan }}
                </div>
                <div>
                    {{ $p->nama_pemesan ?? 'Tanist' }}
                </div>
                <div>
                    @foreach($p->detail as $d)
                        {{ $d->menu->nama_menu }}
                        {{ $d->jumlah }}x
                        <br>
                    @endforeach
                </div>
                <div>
                    Rp. {{ number_format($p->total_harga,0,',','.') }}
                </div>
                <div>
                    @if(strtolower($p->metode_pembayaran) == 'ewallet')
                        E-Wallet
                    @else
                        Dine-In
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
</div>

</body>
</html>