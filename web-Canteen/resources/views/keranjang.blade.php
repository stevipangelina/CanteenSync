<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang</title>
    <link rel="stylesheet" href="{{ asset('css/keranjang.css') }}">
</head>

<body>

<div class="container">
    <a href="{{ url('/kantin/'.$id_kantin) }}" class="back-btn">←</a>
    <div class="header">
        <h2>Keranjang Makanan<br>Kantin {{ $id_kantin }}</h2>
        <img src="{{ asset('images/logo.png') }}" alt="">
    </div>

    @php $total = 0; @endphp

    @forelse($keranjang as $id => $item)

        @php
            $subtotal = $item['harga'] * $item['qty'];
            $total += $subtotal;
        @endphp

        <div class="item">
            <img src="{{ asset('images/'.$item['gambar']) }}" alt="">
            <div class="item-info">
                <b>{{ $item['nama'] }}</b>
                <span class="harga">
                    Rp {{ number_format($item['harga']) }}
                </span>

                <form action="{{ route('keranjang.update') }}"
                      method="POST"
                      class="qty-form">

                    @csrf

                    <input type="hidden"
                           name="id"
                           value="{{ $id }}">

                    <div class="qty">

                        <button type="button"
                                class="minus-btn"
                                data-id="{{ $id }}"
                                data-qty="{{ $item['qty'] }}">
                            −
                        </button>

                        <span>{{ $item['qty'] }}</span>

                        <button type="submit"
                                name="qty"
                                value="{{ $item['qty'] + 1 }}">
                            +
                        </button>
                    </div>
                </form>
            </div>

            <div class="pilih-wrapper">
                <input type="checkbox"
                       class="pilih-item"
                       data-harga="{{ $subtotal }}"
                       checked>
            </div>
        </div>

    @empty

        <p class="kosong">Keranjang kosong</p>

    @endforelse

    <div class="total-box">
        <b id="totalHarga">
            Total: Rp {{ number_format($total) }}
        </b>
        <a href="{{ route('checkout') }}">
            <button class="checkout">
                Checkout
            </button>
        </a>
    </div>
</div>


<div class="popup-overlay" id="popupHapus">
    <div class="popup-card">
        <h3>Hapus Menu?</h3>
        <p>
            yakin menghapus menu ini dari keranjang?
        </p>
        <div class="popup-btn">

            <button id="batalBtn">
                Batal
            </button>
            <button id="hapusBtn">
                Hapus
            </button>

        </div>
    </div>
</div>

<script>

const checkboxes = document.querySelectorAll('.pilih-item');
const totalText = document.getElementById('totalHarga');

function hitungTotal(){
    let total = 0;
    checkboxes.forEach(cb => {
        if(cb.checked){
            total += parseInt(cb.dataset.harga);
        }
    });
    totalText.innerText =
        'Total: Rp ' + total.toLocaleString('id-ID');
}

checkboxes.forEach(cb => {
    cb.addEventListener('change', hitungTotal);
});


const minusBtns = document.querySelectorAll('.minus-btn');
const popup = document.getElementById('popupHapus');
const hapusBtn = document.getElementById('hapusBtn');
const batalBtn = document.getElementById('batalBtn');

let hapusId = null;

minusBtns.forEach(btn => {
    btn.addEventListener('click', function(){
        let qty = parseInt(this.dataset.qty);
        hapusId = this.dataset.id;

        if(qty <= 1){
            popup.style.display = 'flex';
        }else{
            let form = this.closest('form');
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'qty';
            input.value = qty - 1;
            form.appendChild(input);
            form.submit();
        }

    });

});

hapusBtn.addEventListener('click', function(){
    window.location.href =
        '/keranjang/hapus/' + hapusId;
});

batalBtn.addEventListener('click', function(){
    popup.style.display = 'none';

});

</script>

</body>
</html>