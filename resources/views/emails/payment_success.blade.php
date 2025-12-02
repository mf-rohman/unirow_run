<div style="text-align: center; border: 1px solid #ddd; padding: 20px;">
    <h1 style="color: green;">PEMBAYARAN VALID</h1>
    <p>Halo <strong>{{ $participant->name }}</strong>,</p>
    <p>Selamat! Pembayaran Anda telah kami terima.</p>
    
    <div style="background: #f3f4f6; padding: 20px; margin: 20px 0; border-radius: 10px;">
        <h3>NOMOR DADA (BIB) ANDA:</h3>
        <h1 style="font-size: 3em; margin: 0; color: #1e3a8a;">{{ $participant->bib_number }}</h1>
        <p>Kategori: {{ $participant->category_dummy ?? '5K' }}</p>
    </div>

    <p>Simpan email ini untuk pengambilan Race Pack.</p>
    <p>Sampai jumpa di garis start!</p>
</div>