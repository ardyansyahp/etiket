<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Seminar</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #ff6b35;
        }
        .header h1 {
            color: #ff6b35;
            margin: 0;
            font-size: 24px;
            font-weight: 800;
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 30px;
        }
        .info-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #ff6b35;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #555;
        }
        .info-value {
            color: #333;
        }
        .qrcode-section {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background: #fff5f0;
            border-radius: 8px;
        }
        .qrcode-section h3 {
            color: #ff6b35;
            margin-bottom: 15px;
        }
        .qrcode-image {
            margin: 20px 0;
        }
        .instruction {
            background: #e8f5e9;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            border-left: 4px solid #28a745;
        }
        .instruction h4 {
            color: #155724;
            margin-top: 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #eee;
            color: #666;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 20px;
            text-align: center;
        }
        
        /* Mobile Responsive Styles */
        @media only screen and (max-width: 600px) {
            body {
                padding: 10px !important;
                background-color: #f5f5f5 !important;
            }
            .container {
                padding: 15px !important;
                border-radius: 8px !important;
            }
            .header {
                margin-bottom: 20px !important;
                padding-bottom: 15px !important;
            }
            .header h1 {
                font-size: 20px !important;
            }
            .greeting {
                font-size: 14px !important;
                margin-bottom: 15px !important;
            }
            .content {
                margin-bottom: 20px !important;
                font-size: 14px !important;
            }
            .info-box {
                padding: 15px !important;
                margin-bottom: 15px !important;
            }
            .info-row {
                flex-direction: column !important;
                padding: 6px 0 !important;
            }
            .info-label {
                font-size: 13px !important;
                margin-bottom: 4px !important;
            }
            .info-value {
                font-size: 13px !important;
            }
            .qrcode-section {
                margin: 20px 0 !important;
                padding: 15px !important;
            }
            .qrcode-section h3 {
                font-size: 18px !important;
                margin-bottom: 12px !important;
            }
            .qrcode-image {
                margin: 15px 0 !important;
                padding: 15px !important;
            }
            .instruction {
                padding: 12px !important;
                margin-top: 15px !important;
            }
            .instruction h4 {
                font-size: 16px !important;
            }
            .instruction ol {
                font-size: 13px !important;
                padding-left: 20px !important;
            }
            .footer {
                margin-top: 20px !important;
                padding-top: 15px !important;
                font-size: 12px !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>UNDANGAN SEMINAR</h1>
            <p style="color: #666; margin: 5px 0;">PT. Mada Wikri Tunggal</p>
        </div>

        <div class="greeting">
            <p>Yth. <strong>{{ $peserta->nama_lengkap }}</strong>,</p>
        </div>

        <div class="content">
            <p>Dengan hormat, kami mengundang Bapak/Ibu untuk menghadiri <strong>Seminar PT. Mada Wikri Tunggal</strong> yang akan diselenggarakan pada:</p>
        </div>

        <div class="info-box">
            <div class="info-row">
                <span class="info-label">Hari/Tanggal:</span>
                <span class="info-value">{{ \Carbon\Carbon::now()->format('l, d F Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Waktu:</span>
                <span class="info-value">08:00 - 17:00 WIB</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tempat:</span>
                <span class="info-value">Hotel Primebiz, Cikarang</span>
            </div>
            <div class="info-row">
                <span class="info-label">No. Peserta Anda:</span>
                <span class="info-value" style="font-weight: 700; color: #ff6b35; font-size: 16px; word-break: break-all;">{{ $peserta->no_peserta }}</span>
            </div>
        </div>

        <div class="qrcode-section">
            <h3>QR CODE ABSENSI ANDA</h3>
            <p style="color: #666; margin-bottom: 20px; font-size: 14px; margin-bottom: 15px;">Screenshot atau simpan QR Code di bawah ini:</p>
            <div class="qrcode-image" style="background: white; padding: 12px; border-radius: 8px; display: inline-block; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: calc(100% - 20px);">
                <!-- QR Code embedded menggunakan CID (Content-ID) -->
                <img src="{{ $message->embed($qrcodePath) }}" 
                     alt="QR Code Absensi {{ $peserta->no_peserta }}" 
                     style="max-width: 100%; width: 220px; height: auto; display: block; margin: 0 auto; border: 2px solid #ff6b35; border-radius: 6px;" />
            </div>
            <p style="color: #ff6b35; font-size: 18px; font-weight: 700; margin-top: 15px; margin-bottom: 15px;">No. Peserta: {{ $peserta->no_peserta }}</p>
            <div style="background: #fff3cd; border: 2px solid #ffc107; border-radius: 8px; padding: 12px; margin: 15px auto; max-width: 100%;">
                <p style="margin: 0; color: #856404; font-size: 13px; line-height: 1.5;">
                    💡 <strong>Tips:</strong> Screenshot QR Code di atas dan simpan di HP Anda untuk digunakan saat absensi. 
                    QR Code juga dilampirkan sebagai file attachment untuk backup.
                </p>
            </div>
        </div>

        <div class="instruction">
            <h4>Cara Menggunakan QR Code:</h4>
            <ol style="margin: 10px 0; padding-left: 20px;">
                <li><strong>Screenshot</strong> QR Code di atas dan simpan ke HP Anda</li>
                <li>Tunjukkan QR Code saat tiba di lokasi seminar</li>
                <li>Petugas akan scan QR Code Anda untuk absensi</li>
                <li>Jika QR Code tidak bisa di-scan, input No. Peserta <strong>{{ $peserta->no_peserta }}</strong> di mesin absen</li>
                <li>File QR Code juga dilampirkan sebagai attachment untuk backup</li>
            </ol>
        </div>

        <div class="footer">
            <p><strong>PT. Mada Wikri Tunggal</strong></p>
            <p>Metal and Plastic Industries</p>
            <p style="margin-top: 10px; color: #999; font-size: 12px;">
                Email ini dikirim secara otomatis. Mohon untuk tidak membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>

