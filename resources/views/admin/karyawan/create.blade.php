<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Karyawan - Admin</title>
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
                <li><a href="{{ route('admin.karyawan') }}">Karyawan</a></li>
                <li><a href="{{ route('admin.pengguna') }}">Pengguna</a></li>
                <li><a href="{{ route('admin.absen') }}">Absen</a></li>
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
                <h2>Tambah Karyawan</h2>
            </div>

            <form action="{{ route('admin.karyawan.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="nik">NIK</label>
                    <input type="text" id="nik" name="nik" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="datetime-local" id="tanggal_lahir" name="tanggal_lahir" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <input type="text" id="jabatan" name="jabatan" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="umur">Umur</label>
                    <input type="number" id="umur" name="umur" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" class="form-control" rows="3"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="no_telp">No Telp</label>
                    <input type="text" id="no_telp" name="no_telp" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="tanggal_masuk_kerja">Tanggal Masuk Kerja</label>
                    <input type="datetime-local" id="tanggal_masuk_kerja" name="tanggal_masuk_kerja" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="status_karyawan">Status Karyawan</label>
                    <input type="text" id="status_karyawan" name="status_karyawan" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="id_departemen">Departemen</label>
                    <select id="id_departemen" name="id_departemen" class="form-control">
                        <option value="">Pilih Departemen</option>
                        @foreach($departemen as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->nama }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="id_plant">Plant</label>
                    <select id="id_plant" name="id_plant" class="form-control">
                        <option value="">Pilih Plant</option>
                        @foreach($plant as $p)
                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('admin.karyawan') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

