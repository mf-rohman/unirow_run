<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background: #ffffff; border: 1px solid #ddd; }
        .header { background: #1e3a8a; color: white; padding: 20px; text-align: center; }
        .header img { max-height: 60px; }
        .content { padding: 30px; color: #333; }
        .title { text-align: center; font-size: 24px; font-weight: bold; color: #444; margin-bottom: 10px; text-transform: uppercase; }
        .subtitle { text-align: center; font-size: 18px; color: #666; margin-bottom: 30px; }
        .qr-code { text-align: center; margin: 30px 0; }
        .qr-code img { border: 1px solid #ddd; padding: 5px; }
        
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 14px; }
        .info-table th { text-align: left; width: 40%; color: #666; padding: 5px 0; font-weight: normal; }
        .info-table td { text-align: left; width: 60%; font-weight: bold; color: #000; padding: 5px 0; }
        .section-title { font-weight: bold; border-bottom: 2px solid #eee; padding-bottom: 5px; margin-top: 20px; margin-bottom: 10px; color: #1e3a8a; }

        .items-table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 14px; }
        .items-table th { background: #f8f9fa; padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        .items-table td { padding: 10px; border-bottom: 1px solid #eee; }
        .total-row td { font-weight: bold; border-top: 2px solid #1e3a8a; color: #1e3a8a; font-size: 16px; }

        .footer { background: #f9fafb; padding: 20px; font-size: 12px; color: #666; line-height: 1.6; border-top: 1px solid #eee; }
        .footer strong { color: #333; }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>UNIROW RUN 2025</h1>
            <p>Dies Natalis Ke-19</p>
        </div>

        <div class="content">
            <div class="title">E-TICKET & INVOICE</div>
            <div class="subtitle">KATEGORI: 5K FUN RUN</div>

            <div class="qr-code">
                @php
                    // Kita gabungkan data jadi format teks rapi
                    // Gunakan "urlencode" agar spasi dan simbol terbaca oleh generator QR
                    $qrContent = "BIB: " . $participant->bib_number . "\n" .
                                 "NAMA: " . $participant->name . "\n" .
                                 "NIK: " . $participant->nik . "\n" .
                                 "JERSEY: " . $participant->jersey_size . "\n" .
                                 "STATUS: LUNAS";
                @endphp

                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($qrContent) }}" 
                     alt="QR Code" width="150">
                
                <p style="font-size: 12px; color: #888; margin-top: 5px;">
                    BIB: {{ $participant->bib_number }}
                </p>
            </div>

            <p style="text-align: center; color: green; font-weight: bold;">✅ Registration Confirmed for {{ $participant->name }}!</p>

            <br>

            <div class="section-title">Registration Detail</div>
            <table class="info-table">
                <tr>
                    <th>Invoice ID</th>
                    <td>: INV-{{ str_pad($participant->id, 6, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>: {{ $participant->created_at->format('d M Y') }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td style="color: green;">: PAID (LUNAS)</td>
                </tr>
            </table>

            <div class="section-title">Personal Details</div>
            <table class="info-table">
                <tr>
                    <th>Name</th>
                    <td>: {{ $participant->name }}</td>
                </tr>
                <tr>
                    <th>Identity ID (NIK)</th>
                    <td>: {{ $participant->nik }}</td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td>: {{ $participant->jenis_kl }}</td>
                </tr>
                <tr>
                    <th>Phone (WA)</th>
                    <td>: {{ $participant->phone }}</td>
                </tr>
            </table>

            <div class="section-title">Items Detail</div>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th style="text-align: right;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Registration Fee (5K Fun Run)</td>
                        <td style="text-align: right;">IDR 150,000</td>
                    </tr>
                    <tr>
                        <td>
                            Race Pack Bundle<br>
                            <small style="color: #666;">Jersey Size: <strong>{{ $participant->jersey_size }}</strong></small>
                        </td>
                        <td style="text-align: right;">Included</td>
                    </tr>
                    <tr>
                        <td>Service Charge</td>
                        <td style="text-align: right;">IDR 0</td>
                    </tr>
                    <tr class="total-row">
                        <td>TOTAL PAID</td>
                        <td style="text-align: right;">IDR 150,000</td>
                    </tr>
                </tbody>
            </table>

            <div style="text-align: center; margin-top: 30px; margin-bottom: 10px; padding: 20px; background: #f0fdf4; border: 1px dashed #22c55e; border-radius: 8px;">
                <p style="margin: 0 0 15px 0; color: #15803d; font-size: 14px;">
                    <strong>🏃‍♂️ PENTING:</strong> Silakan bergabung ke Grup Resmi Peserta untuk info pengambilan Race Pack & Rundown Acara.
                </p>
                
                <a href="https://bit.ly/waGroupUnirowRun-2025" 
                   style="background-color: #25D366; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 50px; font-weight: bold; font-size: 14px; display: inline-block; border: 1px solid #1da851;">
                   <span style="font-size: 16px; vertical-align: middle;">💬</span> GABUNG GRUP WHATSAPP
                </a>
            </div>

        </div>

        <div class="footer">
            <p><strong>Yang Terhormat Peserta,</strong></p>
            <p>Terima kasih telah bergabung di acara <strong>UNIROW RUN DIES NATALIS KE-19</strong>.</p>
            
            <p><strong>Harap membawa dokumen berikut saat pengambilan Race Pack:</strong></p>
            <ol>
                <li>Tunjukkan Email Konfirmasi ini (Softcopy/Print) atau Scan QR Code di atas.</li>
                <li>Kartu Identitas Asli KTP sesuai data pendaftaran.</li>
            </ol>

            <p style="margin-top: 20px; border-top: 1px dashed #ccc; padding-top: 10px;">
                <em>Jika Anda mewakilkan pengambilan, harap membawa <strong>Surat Kuasa</strong> bermeterai dan fotokopi KTP pemberi kuasa.</em>
            </p>

            <p style="text-align: center; margin-top: 30px;">
                &copy; 2025 SIPD Unirow. All rights reserved.
            </p>
        </div>
    </div>

</body>
</html>