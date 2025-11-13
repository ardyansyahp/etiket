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

                <!-- Search Peserta untuk Absen -->
                <div style="margin-bottom: 24px; padding: 20px; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <h3 style="color: white; margin-bottom: 16px; font-size: 18px; font-weight: 600;">🔍 Cari Peserta untuk Absen</h3>
                    <div style="position: relative;">
                        <input 
                            type="text" 
                            id="searchPeserta" 
                            placeholder="Cari berdasarkan nama, no. peserta, email, atau no. HP..." 
                            autocomplete="off"
                            style="width: 100%; padding: 12px 16px; border: 2px solid rgba(255,255,255,0.3); border-radius: 8px; font-size: 14px; background: white; color: #1f2937; outline: none; transition: all 0.3s;"
                            onfocus="this.style.borderColor='rgba(255,255,255,0.6)'"
                            onblur="this.style.borderColor='rgba(255,255,255,0.3)'"
                        >
                        <div id="searchResults" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #e5e7eb; border-radius: 8px; margin-top: 4px; max-height: 300px; overflow-y: auto; z-index: 1000; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                        </div>
                    </div>
                    <div id="searchMessage" style="margin-top: 8px; color: rgba(255,255,255,0.9); font-size: 13px;"></div>
                </div>

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

    <script>
        let searchTimeout;
        const searchInput = document.getElementById('searchPeserta');
        const searchResults = document.getElementById('searchResults');
        const searchMessage = document.getElementById('searchMessage');

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            clearTimeout(searchTimeout);
            
            if (query.length < 2) {
                searchResults.style.display = 'none';
                searchMessage.textContent = '';
                return;
            }

            searchTimeout = setTimeout(() => {
                searchPeserta(query);
            }, 300);
        });

        function searchPeserta(query) {
            searchMessage.textContent = 'Mencari...';
            searchResults.style.display = 'none';

            fetch(`{{ route('admin.absen.searchPeserta') }}?q=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                searchMessage.textContent = '';
                
                if (data.length === 0) {
                    searchResults.innerHTML = '<div style="padding: 12px; text-align: center; color: #6b7280;">Tidak ada peserta ditemukan</div>';
                    searchResults.style.display = 'block';
                    return;
                }

                let html = '';
                data.forEach(peserta => {
                    html += `
                        <div 
                            class="search-result-item" 
                            style="padding: 12px 16px; cursor: pointer; border-bottom: 1px solid #e5e7eb; transition: background 0.2s;"
                            onmouseover="this.style.background='#f3f4f6'"
                            onmouseout="this.style.background='white'"
                            onclick="selectPeserta(${peserta.id}, '${peserta.nama_lengkap.replace(/'/g, "\\'")}', '${peserta.no_peserta.replace(/'/g, "\\'")}')"
                        >
                            <div style="font-weight: 600; color: #1f2937; margin-bottom: 4px;">${peserta.nama_lengkap}</div>
                            <div style="font-size: 12px; color: #6b7280;">
                                No. Peserta: ${peserta.no_peserta} | Email: ${peserta.email} | HP: ${peserta.no_hp}
                            </div>
                        </div>
                    `;
                });
                
                searchResults.innerHTML = html;
                searchResults.style.display = 'block';
            })
            .catch(error => {
                console.error('Error:', error);
                searchMessage.textContent = 'Terjadi kesalahan saat mencari peserta';
                searchResults.style.display = 'none';
            });
        }

        function selectPeserta(id, nama, noPeserta) {
            // Tampilkan konfirmasi
            if (!confirm(`Apakah Anda yakin ingin menambahkan absen untuk:\n\nNama: ${nama}\nNo. Peserta: ${noPeserta}`)) {
                return;
            }

            // Kirim request untuk menyimpan absen
            searchMessage.textContent = 'Menyimpan absen...';
            searchResults.style.display = 'none';

            fetch('{{ route("admin.absen.storeFromSearch") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id_peserta: id
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    searchMessage.textContent = '✅ ' + data.message;
                    searchInput.value = '';
                    searchResults.style.display = 'none';
                    
                    // Reload halaman setelah 1 detik untuk menampilkan data baru
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    searchMessage.textContent = '❌ ' + (data.message || 'Gagal menyimpan absen');
                    searchMessage.style.color = 'rgba(255,255,255,0.9)';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                searchMessage.textContent = '❌ Terjadi kesalahan saat menyimpan absen';
                searchMessage.style.color = 'rgba(255,255,255,0.9)';
            });
        }

        // Tutup dropdown saat klik di luar
        document.addEventListener('click', function(event) {
            const searchContainer = searchInput.parentElement;
            if (!searchContainer.contains(event.target)) {
                searchResults.style.display = 'none';
            }
        });
    </script>
</body>
</html>
