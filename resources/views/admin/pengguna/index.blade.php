<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - Admin</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ time() }}">
</head>
<body class="admin-body admin-purple-theme compact-page">
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('admin.pengguna') }}" class="navbar-brand">Kelola Pengguna</a>
            <ul class="navbar-nav">
                <li><a href="{{ route('admin.absen') }}">Absen</a></li>
                <li><a href="{{ route('admin.departemen') }}">Departemen</a></li>
                <li><a href="{{ route('admin.plant') }}">Plant</a></li>
                <li><a href="{{ route('admin.peserta') }}">Peserta</a></li>
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

    <div class="container-admin compact">
        <div class="card compact-card">
            <div class="card-body compact-body">
                @if(session('success'))
                    <div class="alert alert-success" style="margin-bottom: 8px;">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Departemen</th>
                                <th>Plant</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengguna as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->username }}</td>
                                    <td>{{ $item->nama_lengkap }}</td>
                                    <td>{{ $item->email ?? '-' }}</td>
                                    <td>{{ $item->departemen->nama ?? '-' }}</td>
                                    <td>{{ $item->plant ?? '-' }}</td>
                                    <td>
                                        <div style="display: flex; gap: 8px;">
                                            <a href="{{ route('admin.pengguna.edit', $item->id) }}" class="btn-warning">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.pengguna.delete', $item->id) }}" method="POST" style="display: inline;">
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
                                    <td colspan="7" style="text-align: center; padding: 20px; color: #6b7280;">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    {{ $pengguna->links('pagination::simple-bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
