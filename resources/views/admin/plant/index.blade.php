<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Plant - Admin</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ time() }}">
</head>
<body class="admin-body admin-purple-theme compact-page">
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('admin.plant') }}" class="navbar-brand">Kelola Plant</a>
            <ul class="navbar-nav">
                <li><a href="{{ route('admin.absen') }}">Absen</a></li>
                <li><a href="{{ route('admin.departemen') }}">Departemen</a></li>
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
                                <th>Nama</th>
                                <th>Kota</th>
                                <th>Area</th>
                                <th>Kode Area</th>
                                <th>Nomor</th>
                                <th>Kode</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($plant as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->kota ?? '-' }}</td>
                                    <td>{{ $item->area ?? '-' }}</td>
                                    <td>{{ $item->kode_area ?? '-' }}</td>
                                    <td>{{ $item->nomor ?? '-' }}</td>
                                    <td>{{ $item->kode ?? '-' }}</td>
                                    <td>
                                        <div style="display: flex; gap: 8px;">
                                            <a href="{{ route('admin.plant.edit', $item->id) }}" class="btn-warning">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.plant.delete', $item->id) }}" method="POST" style="display: inline;">
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
                    {{ $plant->links('pagination::simple-bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
