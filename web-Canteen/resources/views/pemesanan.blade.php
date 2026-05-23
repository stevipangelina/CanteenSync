<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pemesanan</title>

    <link rel="stylesheet" href="{{ asset('css/pemesanan.css') }}">
</head>

<body>

<div class="container">
    <a href="{{ route('keranjang.index') }}" class="back-btn">←</a>
    <div class="header">
        <h2>
            Reservasi Pengambilan dan
            <br>
            Pembayaran Pesanan
        </h2>
        <img src="{{ asset('images/logo.png') }}" alt="">
    </div>

    <form action="{{ route('checkout.simpan') }}" method="POST">
    @csrf
    <div class="box">
        <b class="judul-box">Detail Pemesanan Menu:</b>
        <div class="detail-list">
            @foreach($keranjang as $item)
            <div class="detail-item">
                <span>{{ $item['nama'] }}</span>
                <span>{{ $item['qty'] }}x</span>
                <span>
                    Rp. {{ number_format($item['harga']) }}
                </span>
                <span>
                    Rp. {{ number_format($item['harga'] * $item['qty']) }}
                </span>
            </div>
            @endforeach
        </div>

        <hr>
        <div class="total">
            <b>
                Total Harga Pemesanan:
                &nbsp;&nbsp;
                Rp. {{ number_format($total) }}
            </b>
        </div>
    </div>

    <div class="box">
        <b class="judul-box">
            Reservasi Waktu Pengambilan
        </b>
        <div class="radio-group">
            <label>
                <input type="radio"
                       name="jam_pengambilan"
                       value="10"
                       required>

                10 Menit
            </label>

            <label>
                <input type="radio"
                       name="jam_pengambilan"
                       value="15"
                       checked>
                15 Menit
            </label>

            <label>
                <input type="radio"
                       name="jam_pengambilan"
                       value="20">
                20 Menit
            </label>

            <label>
                <input type="radio"
                       name="jam_pengambilan"
                       value="30">
                30 Menit
            </label>
        </div>
    </div>

    <div class="box">
        <b class="judul-box">
            Metode Pembayaran
        </b>
        <div class="radio-group pembayaran">
            <label>
                <input type="radio"
                       name="metode"
                       value="dinein">

                Dine In (Kasir)
            </label>

            <label>
                <input type="radio"
                       name="metode"
                       value="ewallet"
                       checked>
                E-Wallet
            </label>
        </div>
    </div>

    <div class="btn-area">
        <button class="checkout">
            Konfirmasi Pemesanan
        </button>
    </div>
    </form>
</div>

</body>
</html>