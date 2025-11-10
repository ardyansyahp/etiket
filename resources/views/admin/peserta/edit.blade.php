<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peserta - Admin</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ route('admin.absen') }}" class="navbar-brand">Admin Absen</a>
            <ul class="navbar-nav">
                <li><a href="{{ route('admin.absen') }}">Absen</a></li>
                <li><a href="{{ route('admin.departemen') }}">Departemen</a></li>
                <li><a href="{{ route('admin.plant') }}">Plant</a></li>
                <li><a href="{{ route('admin.peserta') }}">Peserta</a></li>
                <li><a href="{{ route('admin.pengguna') }}">Pengguna</a></li>
                <li>
                    <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger" style="padding: 8px 16px;">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="card" style="max-width: 700px; margin: 50px auto;">
            <div class="card-header">
                <h2>Edit Peserta</h2>
            </div>

            <form action="{{ route('admin.peserta.update', $peserta->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap <span style="color: red;">*</span></label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" value="{{ $peserta->nama_lengkap }}" required>
                </div>
                
                <div class="form-group">
                    <label for="no_peserta">No. Peserta <span style="color: red;">*</span></label>
                    <input type="text" id="no_peserta" name="no_peserta" class="form-control" value="{{ $peserta->no_peserta }}" required>
                    <small style="color: #6b7280; font-size: 12px;">Bisa menggunakan NIK karyawan MWT atau nomor random untuk eksternal</small>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ $peserta->email }}">
                </div>
                
                <div class="form-group">
                    <label for="no_hp">No. HP</label>
                    <input type="text" id="no_hp" name="no_hp" class="form-control" value="{{ $peserta->no_hp }}">
                </div>
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" id="status_kirim_email" name="status_kirim_email" value="1" {{ $peserta->status_kirim_email ? 'checked' : '' }}>
                        Status Kirim Email (centang jika email berhasil dikirim)
                    </label>
                </div>
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" id="status_kirim_whatsapp" name="status_kirim_whatsapp" value="1" {{ $peserta->status_kirim_whatsapp ? 'checked' : '' }}>
                        Status Kirim WhatsApp (centang jika notifikasi WA berhasil dikirim)
                    </label>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('admin.peserta') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

