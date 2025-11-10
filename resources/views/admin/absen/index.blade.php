<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Absen - Admin</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ time() }}">
</head>
<body class="admin-body admin-purple-theme">
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('admin.absen') }}" class="navbar-brand">Kelola Absen</a>
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
        <div class="card">
            <div class="card-header">
                <h2>Daftar Absen</h2>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success" style="margin-bottom: 8px;">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger" style="margin-bottom: 8px; background: #ef4444; color: white; padding: 12px 16px; border-radius: 8px;">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('admin.absen.deleteAll') }}" method="POST" id="deleteAllForm" style="margin-bottom: 20px;">
                    @csrf
                    <button type="button" onclick="if(confirm('Yakin ingin menghapus semua data absen?')) { document.getElementById('deleteAllForm').submit(); }" class="btn-purple" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                        🗑️ Hapus Semua
                    </button>
                </form>

                <div class="table-wrapper" style="max-height: 600px; overflow-y: auto; border: 1px solid var(--gray-200); border-radius: 8px;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Peserta</th>
                                <th>No. Peserta</th>
                                <th>Email</th>
                                <th>No. HP</th>
                                <th>Tanggal Masuk</th>
                                <th>Nomor Tiket</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($absen as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->peserta->nama_lengkap ?? '-' }}</td>
                                    <td>{{ $item->peserta->no_peserta ?? '-' }}</td>
                                    <td>{{ $item->peserta->email ?? '-' }}</td>
                                    <td>{{ $item->peserta->no_hp ?? '-' }}</td>
                                    <td>{{ $item->tanggal_masuk ? $item->tanggal_masuk->format('d/m/Y H:i:s') : '-' }}</td>
                                    <td>{{ $item->nomor_tiket ?? '-' }}</td>
                                    <td>
                                        <div style="display: flex; gap: 8px;">
                                            <form action="{{ route('admin.absen.delete', $item->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 20px; color: #6b7280;">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    {{ $absen->links('pagination::simple-bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
