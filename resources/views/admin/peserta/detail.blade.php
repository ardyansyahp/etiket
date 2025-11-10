<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peserta - Admin</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ time() }}">
</head>
<body class="admin-body admin-purple-theme">
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('admin.peserta') }}" class="navbar-brand">Detail Peserta</a>
            <ul class="navbar-nav">
                <li><a href="{{ route('admin.absen') }}">Absen</a></li>
                <li><a href="{{ route('admin.departemen') }}">Departemen</a></li>
                <li><a href="{{ route('admin.plant') }}">Plant</a></li>
                <li><a href="{{ route('admin.peserta') }}">Peserta</a></li>
                <li><a href="{{ route('admin.pengguna') }}">Pengguna</a></li>
                <li>
                    <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-logout">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-admin">
        <div class="card" style="max-width: 800px; margin: 0 auto;">
            <div class="card-header">
                <h2>Detail Peserta</h2>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
                    <!-- Info Peserta -->
                    <div>
                        <h3 style="color: var(--purple-700); margin-bottom: 20px; font-size: 20px;">Informasi Peserta</h3>
                        <div style="background: var(--purple-50); padding: 20px; border-radius: 12px;">
                            <div style="margin-bottom: 15px;">
                                <strong style="color: var(--purple-700); display: block; margin-bottom: 5px;">Nama Lengkap:</strong>
                                <span style="color: #333;">{{ $peserta->nama_lengkap }}</span>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <strong style="color: var(--purple-700); display: block; margin-bottom: 5px;">No. Peserta:</strong>
                                <span style="color: #333; font-weight: 600; font-size: 18px;">{{ $peserta->no_peserta }}</span>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <strong style="color: var(--purple-700); display: block; margin-bottom: 5px;">Email:</strong>
                                <span style="color: #333;">{{ $peserta->email ?? '-' }}</span>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <strong style="color: var(--purple-700); display: block; margin-bottom: 5px;">No. HP:</strong>
                                <span style="color: #333;">{{ $peserta->no_hp ?? '-' }}</span>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <strong style="color: var(--purple-700); display: block; margin-bottom: 5px;">Status Kirim Email:</strong>
                                <span style="color: {{ $peserta->status_kirim_email ? '#10b981' : '#6b7280' }}; font-weight: 600;">
                                    {{ $peserta->status_kirim_email ? '✓ Terkirim' : 'Belum Terkirim' }}
                                </span>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <strong style="color: var(--purple-700); display: block; margin-bottom: 5px;">Status Kirim WhatsApp:</strong>
                                <span style="color: {{ $peserta->status_kirim_whatsapp ? '#10b981' : '#6b7280' }}; font-weight: 600;">
                                    {{ $peserta->status_kirim_whatsapp ? '✓ Terkirim' : 'Belum Terkirim' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- QR Code -->
                    <div>
                        <h3 style="color: var(--purple-700); margin-bottom: 20px; font-size: 20px;">QR Code</h3>
                        <div style="background: white; padding: 30px; border-radius: 12px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                            <div style="margin-bottom: 20px; display: flex; justify-content: center; align-items: center;">
                                {!! QrCode::size(250)->generate($peserta->no_peserta) !!}
                            </div>
                            <div style="background: var(--purple-50); padding: 15px; border-radius: 8px; margin-top: 20px;">
                                <p style="margin: 0; color: var(--purple-700); font-weight: 600; font-size: 14px;">
                                    Scan QR Code ini untuk absen
                                </p>
                                <p style="margin: 5px 0 0 0; color: #666; font-size: 12px;">
                                    No. Peserta: {{ $peserta->no_peserta }}
                                </p>
                            </div>
                            <div style="margin-top: 20px;">
                                <button onclick="window.print()" class="btn-purple" style="padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">
                                    🖨️ Print QR Code
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; justify-content: center; margin-top: 30px;">
                    <a href="{{ route('admin.peserta') }}" class="btn-purple" style="text-decoration: none; padding: 10px 20px; border-radius: 8px;">
                        ← Kembali ke Daftar
                    </a>
                    <a href="{{ route('admin.peserta.edit', $peserta->id) }}" class="btn-warning" style="text-decoration: none;">
                        ✏️ Edit Peserta
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

