<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Tiket</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/absen.css') }}?v={{ time() }}">
</head>

<body class="absen-body" 
      data-success-absen="{{ session('success_absen') ? 'true' : 'false' }}"
      data-already-absen="{{ session('already_absen') ? 'true' : 'false' }}"
      data-error-no-peserta="{{ session('error_no_peserta') ? 'true' : 'false' }}">
    <div class="absen-container">
        <!-- Header -->
        <div class="absen-header">
            <h1>DAFTAR HADIR SEMINAR PT. MADA WIKRI TUNGGAL</h1>
        </div>

        <!-- Main Content Grid -->
        <div class="absen-grid">
            <!-- Left: WAKTU Card -->
            <div class="absen-card waktu-card">
                <div class="card-header-orange">
                    <h2>WAKTU SAAT INI</h2>
                </div>
                <div class="clock-container">
                    <canvas id="analogClock" width="300" height="300"></canvas>
                    <div class="clock-text">Hotel Primebiz, Cikarang.</div>
                </div>
                <div class="card-footer-gradient">
                    <span id="dateDisplay"></span>
                </div>
            </div>

            <!-- Middle: ABSEN MASUK Card -->
            <div class="absen-card absen-masuk-card">
                <!-- Logo Header -->
                <div class="logo-header-section">
                    <img src="{{ asset('images/mwt.jpg') }}" alt="Logo PT. MADA WIKRI TUNGGAL" class="logo-company-image">
                </div>

                <div class="card-header-orange">
                    <h2>ABSEN MASUK</h2>
                </div>

                @if(session('error_no_peserta'))
                <div class="alert-box error-no-peserta" id="errorNoPesertaAlert" style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); border: 2px solid #dc3545; border-radius: 10px; padding: 20px; margin: 10px 15px; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                        <div style="font-size: 40px;">❌</div>
                        <div style="flex: 1;">
                            <div style="font-weight: 700; font-size: 18px; color: #721c24; margin-bottom: 5px;">No. Peserta Tidak Ditemukan!</div>
                            <div style="font-size: 14px; color: #721c24;">{{ session('error_message') ?? 'No. Peserta yang Anda masukkan tidak terdaftar dalam sistem' }}</div>
                        </div>
                    </div>
                    <div style="background: white; padding: 15px; border-radius: 8px; margin-top: 15px;">
                        <div style="text-align: center; color: #555; font-size: 14px;">
                            Silakan periksa kembali No. Peserta yang Anda masukkan atau hubungi administrator
                        </div>
                    </div>
                </div>
                @endif

                @if(session('already_absen'))
                <div class="alert-box already-absen" id="alreadyAbsenAlert" style="background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%); border: 2px solid #ffc107; border-radius: 10px; padding: 20px; margin: 10px 15px; box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                        <div style="font-size: 40px;">⚠️</div>
                        <div style="flex: 1;">
                            <div style="font-weight: 700; font-size: 18px; color: #856404; margin-bottom: 5px;">Anda Sudah Melakukan Absen Hari Ini!</div>
                            <div style="font-size: 14px; color: #856404;">No. Peserta ini sudah terdaftar untuk hari ini</div>
                        </div>
                    </div>
                    <div style="background: white; padding: 15px; border-radius: 8px; margin-top: 15px;">
                        <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee;">
                            <span style="font-weight: 600; color: #555;">Nama:</span>
                            <span style="color: #333; font-weight: 500;">{{ session('absen_data.nama') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee;">
                            <span style="font-weight: 600; color: #555;">Email:</span>
                            <span style="color: #333; font-weight: 500;">{{ session('absen_data.email') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee;">
                            <span style="font-weight: 600; color: #555;">Jam Masuk:</span>
                            <span style="color: #ff6b35; font-weight: 700; font-size: 18px;">{{ session('absen_data.jam_masuk') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 8px 0;">
                            <span style="font-weight: 600; color: #555;">Tanggal:</span>
                            <span style="color: #333; font-weight: 500;">{{ session('absen_data.tanggal') }}</span>
                        </div>
                    </div>
                </div>
                @endif

                @if(session('success_absen'))
                <div class="alert-box success-absen" id="successAbsenAlert" style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); border: 2px solid #28a745; border-radius: 10px; padding: 20px; margin: 10px 15px; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                        <div style="font-size: 40px;">✅</div>
                        <div style="flex: 1;">
                            <div style="font-weight: 700; font-size: 18px; color: #155724; margin-bottom: 5px;">Absensi Sukses!</div>
                            <div style="font-size: 14px; color: #155724;">Data absen Anda telah berhasil dicatat</div>
                        </div>
                    </div>
                    <div style="background: white; padding: 15px; border-radius: 8px; margin-top: 15px;">
                        <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee;">
                            <span style="font-weight: 600; color: #555;">Nama:</span>
                            <span style="color: #333; font-weight: 500;">{{ session('absen_data.nama') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee;">
                            <span style="font-weight: 600; color: #555;">Email:</span>
                            <span style="color: #333; font-weight: 500;">{{ session('absen_data.email') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee;">
                            <span style="font-weight: 600; color: #555;">Jam Masuk:</span>
                            <span style="color: #ff6b35; font-weight: 700; font-size: 18px;">{{ session('absen_data.jam_masuk') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 8px 0;">
                            <span style="font-weight: 600; color: #555;">Tanggal:</span>
                            <span style="color: #333; font-weight: 500;">{{ session('absen_data.tanggal') }}</span>
                        </div>
                    </div>
                </div>
                @endif

                <div class="absen-content" @if(session('already_absen') || session('success_absen') || session('error_no_peserta')) style="display: none;" @endif>
                    <!-- Barcode Image -->
                    <div class="barcode-container">
                        <div class="barcode-placeholder">
                            <svg width="300" height="80" viewBox="0 0 300 80" xmlns="http://www.w3.org/2000/svg">
                                <!-- Barcode lines -->
                                <rect x="10" y="10" width="3" height="60" fill="#000" />
                                <rect x="16" y="10" width="2" height="60" fill="#000" />
                                <rect x="21" y="10" width="1" height="60" fill="#000" />
                                <rect x="25" y="10" width="3" height="60" fill="#000" />
                                <rect x="31" y="10" width="2" height="60" fill="#000" />
                                <rect x="36" y="10" width="1" height="60" fill="#000" />
                                <rect x="40" y="10" width="4" height="60" fill="#000" />
                                <rect x="47" y="10" width="2" height="60" fill="#000" />
                                <rect x="52" y="10" width="1" height="60" fill="#000" />
                                <rect x="56" y="10" width="3" height="60" fill="#000" />
                                <rect x="62" y="10" width="2" height="60" fill="#000" />
                                <rect x="67" y="10" width="1" height="60" fill="#000" />
                                <rect x="71" y="10" width="3" height="60" fill="#000" />
                                <rect x="77" y="10" width="2" height="60" fill="#000" />
                                <rect x="82" y="10" width="1" height="60" fill="#000" />
                                <rect x="86" y="10" width="4" height="60" fill="#000" />
                                <rect x="93" y="10" width="2" height="60" fill="#000" />
                                <rect x="98" y="10" width="1" height="60" fill="#000" />
                                <rect x="102" y="10" width="3" height="60" fill="#000" />
                                <rect x="108" y="10" width="2" height="60" fill="#000" />
                                <rect x="113" y="10" width="1" height="60" fill="#000" />
                                <rect x="117" y="10" width="3" height="60" fill="#000" />
                                <rect x="123" y="10" width="2" height="60" fill="#000" />
                                <rect x="128" y="10" width="1" height="60" fill="#000" />
                                <rect x="132" y="10" width="4" height="60" fill="#000" />
                                <rect x="139" y="10" width="2" height="60" fill="#000" />
                                <rect x="144" y="10" width="1" height="60" fill="#000" />
                                <rect x="148" y="10" width="3" height="60" fill="#000" />
                                <rect x="154" y="10" width="2" height="60" fill="#000" />
                                <rect x="159" y="10" width="1" height="60" fill="#000" />
                                <rect x="163" y="10" width="3" height="60" fill="#000" />
                                <rect x="169" y="10" width="2" height="60" fill="#000" />
                                <rect x="174" y="10" width="1" height="60" fill="#000" />
                                <rect x="178" y="10" width="4" height="60" fill="#000" />
                                <rect x="185" y="10" width="2" height="60" fill="#000" />
                                <rect x="190" y="10" width="1" height="60" fill="#000" />
                                <rect x="194" y="10" width="3" height="60" fill="#000" />
                                <rect x="200" y="10" width="2" height="60" fill="#000" />
                                <rect x="205" y="10" width="1" height="60" fill="#000" />
                                <rect x="209" y="10" width="3" height="60" fill="#000" />
                                <rect x="215" y="10" width="2" height="60" fill="#000" />
                                <rect x="220" y="10" width="1" height="60" fill="#000" />
                                <rect x="224" y="10" width="4" height="60" fill="#000" />
                                <rect x="231" y="10" width="2" height="60" fill="#000" />
                                <rect x="236" y="10" width="1" height="60" fill="#000" />
                                <rect x="240" y="10" width="3" height="60" fill="#000" />
                                <rect x="246" y="10" width="2" height="60" fill="#000" />
                                <rect x="251" y="10" width="1" height="60" fill="#000" />
                                <rect x="255" y="10" width="3" height="60" fill="#000" />
                                <rect x="261" y="10" width="2" height="60" fill="#000" />
                                <rect x="266" y="10" width="1" height="60" fill="#000" />
                                <rect x="270" y="10" width="4" height="60" fill="#000" />
                            </svg>
                        </div>
                    </div>

                    <form action="{{ route('absen.check') }}" method="POST" class="absen-form" id="absenForm">
                        @csrf
                        <div class="form-group-absen">
                            <input
                                type="text"
                                id="no_peserta"
                                name="no_peserta"
                                class="absen-input-custom @if(session('already_absen') || session('success_absen')) disabled-input @endif"
                                placeholder="@if(session('already_absen')) No. Peserta sudah terdaftar hari ini @elseif(session('success_absen')) Absen berhasil dicatat @else INPUT NO. PESERTA DISINI .... @endif"
                                value="{{ session('absen_data.no_peserta') ?? '' }}"
                                required
                                @if(session('already_absen') || session('success_absen')) disabled @else autofocus @endif
                                autocomplete="off">
                        </div>

                        <div class="button-row">
                            <button type="submit" class="btn-scan @if(session('already_absen') || session('success_absen')) disabled-btn @endif" @if(session('already_absen') || session('success_absen')) disabled @endif>
                                SCAN
                            </button>
                            <a href="{{ route('admin.login') }}" class="btn-login">
                                LOGIN
                            </a>
                        </div>
                    </form>
                    
                    <div class="motivasi-text">Tetap semangat! Kehadiran Anda sangat berarti hari ini.</div>
                </div>
            <div class="card-footer-gradient">
                <span>PT Mada Wikri Tunggal</span>
            </div>
        </div>

        <!-- Right: 5 Absensi Terakhir -->
        <div class="absen-card absen-terakhir-card">
            <div class="card-header-orange">
                <h2>5 ABSENSI TERAKHIR</h2>
            </div>
            <div class="absen-list">
                @forelse($last5Absen as $absen)
                <div class="absen-item">
                    <div class="absen-item-icon">👤</div>
                    <div class="absen-item-content">
                        <div class="absen-item-name">{{ $absen->peserta->nama_lengkap }}</div>
                        <div class="absen-item-role">{{ $absen->peserta->email ?? '-' }}</div>
                        <div class="absen-item-time">masuk : {{ $absen->tanggal_masuk->format('H:i:s') }}</div>
                    </div>
                </div>
                @empty
                <div class="absen-item">
                    <div class="absen-item-content">
                        <div class="absen-item-name" style="text-align: center; color: #999;">Belum ada data absen</div>
                    </div>
                </div>
                @endforelse
            </div>
            <div class="card-footer-gradient">
                <span>Seminar James Gwee.</span>
            </div>
        </div>
    </div>
    </div>

    <!-- Audio Elements -->
    <audio id="soundSukses" preload="auto">
        <source src="{{ asset('sound/sukses.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="soundFailed" preload="auto">
        <source src="{{ asset('sound/failed.mp3') }}" type="audio/mpeg">
    </audio>

    <script src="{{ asset('js/absen.js') }}"></script>
    <script>
        // Set variabel dari Blade ke JavaScript via data attributes
        const bodyElement = document.body;
        const sessionData = {
            success_absen: bodyElement.getAttribute('data-success-absen') === 'true',
            already_absen: bodyElement.getAttribute('data-already-absen') === 'true',
            error_no_peserta: bodyElement.getAttribute('data-error-no-peserta') === 'true'
        };

        // Play sound berdasarkan kondisi
        if (sessionData.success_absen) {
            (function() {
                const soundSukses = document.getElementById('soundSukses');
                if (soundSukses) {
                    soundSukses.play().catch(function(error) {
                        console.log('Error playing success sound:', error);
                    });
                }
            })();
        }

        if (sessionData.already_absen || sessionData.error_no_peserta) {
            (function() {
                const soundFailed = document.getElementById('soundFailed');
                if (soundFailed) {
                    soundFailed.play().catch(function(error) {
                        console.log('Error playing failed sound:', error);
                    });
                }
            })();
        }

        // Auto-hide alert dan reset form setelah 5 detik
        if (sessionData.already_absen || sessionData.success_absen || sessionData.error_no_peserta) {
            (function() {
                let alertId;
                if (sessionData.already_absen) {
                    alertId = 'alreadyAbsenAlert';
                } else if (sessionData.success_absen) {
                    alertId = 'successAbsenAlert';
                } else if (sessionData.error_no_peserta) {
                    alertId = 'errorNoPesertaAlert';
                }
                
                const alertElement = document.getElementById(alertId);
                const noPesertaInput = document.getElementById('no_peserta');
                const scanButton = document.querySelector('.btn-scan');
                const absenContent = document.querySelector('.absen-content');
                let countdown = 5;
                
                if (alertElement) {
                    // Update countdown setiap detik
                    const countdownInterval = setInterval(function() {
                        countdown--;
                        if (countdown <= 0) {
                            clearInterval(countdownInterval);
                            
                            // Hide alert dengan animasi
                            alertElement.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                            alertElement.style.opacity = '0';
                            alertElement.style.transform = 'translateY(-20px)';
                            
                            setTimeout(function() {
                                alertElement.style.display = 'none';
                                
                                // Tampilkan kembali barcode container
                                if (absenContent) {
                                    absenContent.style.display = 'flex';
                                }
                                
                                // Reset form
                                noPesertaInput.value = '';
                                noPesertaInput.disabled = false;
                                noPesertaInput.classList.remove('disabled-input');
                                noPesertaInput.placeholder = 'INPUT NO. PESERTA DISINI ....';
                                noPesertaInput.focus();
                                
                                // Enable button
                                scanButton.disabled = false;
                                scanButton.classList.remove('disabled-btn');
                            }, 500);
                        }
                    }, 1000);
                }
            })();
        }
    </script>
</body>

</html>