<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Berhasil</title>

    <link rel="stylesheet" href="{{ asset('css/sukses.css') }}">
</head>

<body>
<img src="{{ asset('images/logo.png') }}" class="logo" alt="">
<div class="container">
    <h2>Pesanan Berhasil!</h2>
    <div class="check-icon"> ✔ </div>
    <div class="id-box">
        ID Pemesanan : K{{ $data['id_pesanan'] }}
    </div>

    <div class="box">
        <table width="100%">
            <tr>
                <th>Nama Menu</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
            @foreach($data['keranjang'] as $item)
            <tr>
                <td>{{ $item['nama'] }}</td>
                <td>{{ $item['qty'] }}</td>
                <td>
                    Rp. {{ number_format($item['harga']) }}
                </td>

                <td>
                    Rp. {{ number_format($item['harga'] * $item['qty']) }}
                </td>
            </tr>
            @endforeach
        </table>
        <hr>
        <div class="total">
            <b>
                Total Harga: Rp. {{ number_format($data['total']) }}
            </b>
        </div>
    </div>

    <div class="box info-box">
        <div class="info-row">
            <span>Waktu Pemesanan</span>
            <span>
                {{ date('d/m/Y, H.i') }} WIB
            </span>
        </div>

        <div class="info-row">
            <span>Reservasi Pengambilan</span>
            <span>
                {{ $data['jam'] }} Menit
            </span>
        </div>

        <div class="info-row">
            <span>Metode Pembayaran</span>
                <span>
                    {{ $data['metode'] }}
                </span>
        </div>
    </div>

    <a href="/dashboard">
        <button class="btn">
            Kembali Ke Beranda
        </button>
    </a>
</div>
</body>
</html>