<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Peserta - Admin</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ time() }}">
    <style>
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .alert-success {
            animation: slideIn 0.3s ease-out;
        }
    </style>
</head>
<body class="admin-body admin-purple-theme">
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('admin.peserta') }}" class="navbar-brand">Kelola Peserta</a>
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
                <h2>Daftar Peserta</h2>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success" style="margin-bottom: 8px; background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 16px 20px; border-radius: 8px; font-weight: 600; font-size: 15px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); border-left: 4px solid #047857; animation: slideIn 0.3s ease-out;">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger" style="margin-bottom: 8px; background: #ef4444; color: white; padding: 12px 16px; border-radius: 8px; font-weight: 600; border-left: 4px solid #dc2626;">
                        ❌ {{ session('error') }}
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger" style="margin-bottom: 8px; background: #ef4444; color: white; padding: 12px 16px; border-radius: 8px; font-weight: 600; border-left: 4px solid #dc2626;">
                        <strong>❌ Error:</strong>
                        <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(request('search'))
                    <div class="alert alert-info" style="margin-bottom: 8px; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; padding: 12px 16px; border-radius: 8px;">
                        🔍 Hasil pencarian untuk "<strong>{{ request('search') }}</strong>": Ditemukan <strong>{{ $peserta->total() }}</strong> peserta
                    </div>
                @endif

                <div style="margin-bottom: 20px; display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                    <form action="{{ route('admin.peserta') }}" method="GET" style="flex: 1; min-width: 250px; display: flex; gap: 8px;">
                        <input 
                            type="text" 
                            name="search" 
                            class="form-control" 
                            placeholder="Cari peserta (nama, No. Peserta, email, no hp)..." 
                            value="{{ request('search') }}"
                            style="flex: 1; padding: 10px 14px; border: 1px solid var(--gray-200); border-radius: 8px; font-size: 14px;">
                        <button type="submit" class="btn-purple" style="padding: 10px 20px; white-space: nowrap;">
                            🔍 
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.peserta') }}" class="btn-purple" style="padding: 10px 20px; white-space: nowrap; background: linear-gradient(135deg, #6b7280, #4b5563); text-decoration: none;">
                                ✕ Reset
                            </a>
                        @endif
                    </form>
                    <a href="{{ route('admin.peserta.create') }}" class="btn-purple">
                        +
                    </a>
                    <form action="{{ route('admin.peserta.import') }}" method="POST" enctype="multipart/form-data" style="display: inline;">
                        @csrf
                        <label for="excel_file" class="btn-purple" style="cursor: pointer; margin: 0;">
                            📥
                            <input type="file" id="excel_file" name="excel_file" accept=".xlsx,.xls,.csv" style="display: none;" onchange="this.form.submit()">
                        </label>
                    </form>
                    <a href="{{ route('admin.peserta.template') }}" class="btn-purple" style="background: linear-gradient(135deg, #10b981, #059669);">
                        📄 Download Template
                    </a>
                    <form action="{{ route('admin.peserta.kirimUndangan') }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin mengirim undangan email ke semua peserta yang memiliki email?')">
                        @csrf
                        <button type="submit" class="btn-purple" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
                            📧 Kirim Email ke Semua
                        </button>
                    </form>
                    <form action="{{ route('admin.peserta.kirimWhatsApp') }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin mengirim undangan WhatsApp ke semua peserta yang memiliki nomor HP?')">
                        @csrf
                        <button type="submit" class="btn-purple" style="background: linear-gradient(135deg, #10b981, #059669);">
                            💬 Kirim WhatsApp ke Semua
                        </button>
                    </form>
                </div>

                <div class="table-wrapper" style="max-height: 600px; overflow-y: auto; border: 1px solid var(--gray-200); border-radius: 8px;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Lengkap</th>
                                <th>No. Peserta</th>
                                <th>Email</th>
                                <th>No. HP</th>
                                <th>Status Email</th>
                                <th>Status WA</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peserta as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->nama_lengkap }}</td>
                                    <td>{{ $item->no_peserta }}</td>
                                    <td>{{ $item->email ?? '-' }}</td>
                                    <td>{{ $item->no_hp ?? '-' }}</td>
                                    <td>
                                        @if($item->status_kirim_email)
                                            <span style="color: #10b981; font-weight: 600;">✓ Terkirim</span>
                                        @else
                                            <span style="color: #6b7280;">Belum</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->status_kirim_whatsapp)
                                            <span style="color: #10b981; font-weight: 600;">✓ Terkirim</span>
                                        @else
                                            <span style="color: #6b7280;">Belum</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 4px; flex-wrap: wrap;">
                                            <a href="{{ route('admin.peserta.detail', $item->id) }}" class="btn-purple" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); text-decoration: none; padding: 4px 8px; border-radius: 4px; font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; justify-content: center; min-width: 32px; height: 32px;" title="Detail">
                                                📋
                                            </a>
                                            <a href="{{ route('admin.peserta.edit', $item->id) }}" class="btn-warning" style="padding: 4px 8px; border-radius: 4px; font-size: 14px; display: inline-flex; align-items: center; justify-content: center; min-width: 32px; height: 32px; text-decoration: none;" title="Edit">
                                                ✏️
                                            </a>
                                            @if($item->email)
                                                <form action="{{ route('admin.peserta.kirimUndanganSatu', $item->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin mengirim undangan email ke {{ $item->nama_lengkap }}?')">
                                                    @csrf
                                                    <button type="submit" class="btn-purple" style="background: linear-gradient(135deg, #3b82f6, #2563eb); padding: 4px 8px; border-radius: 4px; font-size: 14px; display: inline-flex; align-items: center; justify-content: center; min-width: 32px; height: 32px; cursor: pointer;" title="Kirim Email">
                                                        📧
                                                    </button>
                                                </form>
                                            @endif
                                            @if($item->no_hp)
                                                <form action="{{ route('admin.peserta.kirimWhatsAppSatu', $item->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin mengirim undangan WhatsApp ke {{ $item->nama_lengkap }}?')">
                                                    @csrf
                                                    <button type="submit" class="btn-purple" style="background: linear-gradient(135deg, #10b981, #059669); padding: 4px 8px; border-radius: 4px; font-size: 14px; display: inline-flex; align-items: center; justify-content: center; min-width: 32px; height: 32px; cursor: pointer;" title="Kirim WhatsApp">
                                                        💬
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.peserta.delete', $item->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn-danger" onclick="return confirm('Yakin ingin menghapus?')" style="padding: 4px 8px; border-radius: 4px; font-size: 14px; display: inline-flex; align-items: center; justify-content: center; min-width: 32px; height: 32px;" title="Hapus">
                                                    🗑️
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
                    {{ $peserta->links('pagination::simple-bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>

