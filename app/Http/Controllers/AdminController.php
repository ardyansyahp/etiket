<?php

namespace App\Http\Controllers;

use App\Jobs\KirimWhatsappPeserta;
use App\Mail\UndanganAbsen;
use App\Models\Absen;
use App\Models\Departemen;
use App\Models\Pengguna;
use App\Models\Peserta;
use App\Models\Plant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('pengguna')->check()) {
            return redirect()->route('admin.absen');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $pengguna = Pengguna::where('username', $request->username)->first();

        if ($pengguna && Hash::check($request->password, $pengguna->password)) {
            Auth::guard('pengguna')->login($pengguna);

            // Handle remember me
            if ($request->remember) {
                Auth::guard('pengguna')->login($pengguna, true);
            }

            // Check if AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('admin.absen')
                ]);
            }

            return redirect()->route('admin.absen');
        }

        // Check if AJAX request
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password salah!'
            ], 422);
        }

        return redirect()->back()->with('error', 'Username atau password salah!');
    }

    public function logout()
    {
        Auth::guard('pengguna')->logout();
        return redirect()->route('admin.login');
    }

    // CRUD Departemen
    public function departemen()
    {
        $departemen = Departemen::paginate(10);
        return view('admin.departemen.index', compact('departemen'));
    }

    public function departemenCreate()
    {
        return view('admin.departemen.create');
    }

    public function departemenStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:255',
            'nomor' => 'required|string|max:255',
        ]);

        Departemen::create($request->all());
        return redirect()->route('admin.departemen')->with('success', 'Departemen berhasil ditambahkan!');
    }

    public function departemenEdit($id)
    {
        $departemen = Departemen::findOrFail($id);
        return view('admin.departemen.edit', compact('departemen'));
    }

    public function departemenUpdate(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:255',
            'nomor' => 'required|string|max:255',
        ]);

        $departemen = Departemen::findOrFail($id);
        $departemen->update($request->only(['nama', 'kode', 'nomor']));
        return redirect()->route('admin.departemen')->with('success', 'Departemen berhasil diupdate!');
    }

    public function departemenDelete($id)
    {
        Departemen::findOrFail($id)->delete();
        return redirect()->route('admin.departemen')->with('success', 'Departemen berhasil dihapus!');
    }

    // CRUD Plant
    public function plant()
    {
        $plant = Plant::paginate(10);
        return view('admin.plant.index', compact('plant'));
    }

    public function plantCreate()
    {
        return view('admin.plant.create');
    }

    public function plantStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kota' => 'nullable|string|max:255',
            'area' => 'required|string|max:255',
            'kode_area' => 'nullable|string|max:255',
            'nomor' => 'required|string|max:255',
            'kode' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        Plant::create($request->all());
        return redirect()->route('admin.plant')->with('success', 'Plant berhasil ditambahkan!');
    }

    public function plantEdit($id)
    {
        $plant = Plant::findOrFail($id);
        return view('admin.plant.edit', compact('plant'));
    }

    public function plantUpdate(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kota' => 'nullable|string|max:255',
            'area' => 'required|string|max:255',
            'kode_area' => 'nullable|string|max:255',
            'nomor' => 'required|string|max:255',
            'kode' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        $plant = Plant::findOrFail($id);
        $plant->update($request->all());
        return redirect()->route('admin.plant')->with('success', 'Plant berhasil diupdate!');
    }

    public function plantDelete($id)
    {
        Plant::findOrFail($id)->delete();
        return redirect()->route('admin.plant')->with('success', 'Plant berhasil dihapus!');
    }

    // CRUD Peserta
    public function peserta(Request $request)
    {
        $query = Peserta::query();

        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q
                    ->where('nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('no_peserta', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('no_hp', 'like', '%' . $search . '%');
            });
        }

        $peserta = $query->paginate(10)->withQueryString();
        return view('admin.peserta.index', compact('peserta'));
    }

    public function pesertaCreate()
    {
        return view('admin.peserta.create');
    }

    public function pesertaStore(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_peserta' => 'required|string|max:255|unique:peserta,no_peserta',
            'email' => 'nullable|email|max:255',
            'no_hp' => 'nullable|string|max:255',
            'status_kirim_email' => 'nullable|boolean',
            'status_kirim_whatsapp' => 'nullable|boolean',
        ]);

        Peserta::create($request->all());
        return redirect()->route('admin.peserta')->with('success', 'Peserta berhasil ditambahkan!');
    }

    public function pesertaDetail($id)
    {
        $peserta = Peserta::findOrFail($id);
        return view('admin.peserta.detail', compact('peserta'));
    }

    public function pesertaEdit($id)
    {
        $peserta = Peserta::findOrFail($id);
        return view('admin.peserta.edit', compact('peserta'));
    }

    public function pesertaUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_peserta' => 'required|string|max:255|unique:peserta,no_peserta,' . $id,
            'email' => 'nullable|email|max:255',
            'no_hp' => 'nullable|string|max:255',
            'status_kirim_email' => 'nullable|boolean',
            'status_kirim_whatsapp' => 'nullable|boolean',
        ]);

        $peserta = Peserta::findOrFail($id);
        $peserta->update($request->all());
        return redirect()->route('admin.peserta')->with('success', 'Peserta berhasil diupdate!');
    }

    public function pesertaDelete($id)
    {
        Peserta::findOrFail($id)->delete();
        return redirect()->route('admin.peserta')->with('success', 'Peserta berhasil dihapus!');
    }

    public function pesertaImport(Request $request)
    {
        try {
            // Validasi file berdasarkan extension, bukan MIME type (lebih fleksibel untuk CSV)
            $request->validate([
                'excel_file' => 'required|max:10240',
            ], [
                'excel_file.required' => 'File harus diisi!',
                'excel_file.max' => 'Ukuran file maksimal 10MB!',
            ]);

            $file = $request->file('excel_file');

            if (!$file) {
                return redirect()->route('admin.peserta')->with('error', 'File tidak ditemukan! Pastikan file sudah dipilih.');
            }

            // Deteksi extension dari nama file dan MIME type
            $extension = strtolower($file->getClientOriginalExtension());
            $mimeType = $file->getMimeType();

            // Jika extension tidak ada, coba deteksi dari MIME type
            if (empty($extension)) {
                $mimeToExtension = [
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
                    'application/vnd.ms-excel' => 'xls',
                    'text/csv' => 'csv',
                    'text/plain' => 'csv',  // CSV sering terdeteksi sebagai text/plain
                    'application/csv' => 'csv',
                ];
                if (isset($mimeToExtension[$mimeType])) {
                    $extension = $mimeToExtension[$mimeType];
                }
            }

            // Validasi extension
            if (!in_array($extension, ['xlsx', 'xls', 'csv'])) {
                $errorMsg = 'Format file tidak didukung! ';
                $errorMsg .= 'Extension yang terdeteksi: ' . ($extension ?: 'tidak ada') . '. ';
                $errorMsg .= 'MIME type: ' . $mimeType . '. ';
                $errorMsg .= 'Gunakan format .xlsx, .xls, atau .csv';
                return redirect()->route('admin.peserta')->with('error', $errorMsg);
            }

            if ($extension == 'csv') {
                // Baca file CSV dengan handling encoding dan BOM
                $filePath = $file->getRealPath();
                $content = file_get_contents($filePath);

                // Remove BOM UTF-8 jika ada
                if (substr($content, 0, 3) == chr(0xEF) . chr(0xBB) . chr(0xBF)) {
                    $content = substr($content, 3);
                }

                // Coba detect encoding
                $encoding = mb_detect_encoding($content, ['UTF-8', 'Windows-1252', 'ISO-8859-1'], true);
                if ($encoding && $encoding != 'UTF-8') {
                    $content = mb_convert_encoding($content, 'UTF-8', $encoding);
                }

                // Simpan ke temporary file
                $tempFile = tempnam(sys_get_temp_dir(), 'csv_import_');
                file_put_contents($tempFile, $content);

                // Baca CSV dengan berbagai delimiter
                $data = [];
                $delimiters = [',', ';', "\t"];
                $delimiter = ',';

                foreach ($delimiters as $del) {
                    $handle = fopen($tempFile, 'r');
                    if ($handle !== false) {
                        $testRow = fgetcsv($handle, 0, $del);
                        fclose($handle);
                        if (is_array($testRow) && count($testRow) > 1) {
                            $delimiter = $del;
                            break;
                        }
                    }
                }

                // Baca semua baris dengan delimiter yang tepat
                $handle = fopen($tempFile, 'r');
                if ($handle !== false) {
                    while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
                        // Clean up setiap cell (remove BOM dan whitespace)
                        $row = array_map(function ($cell) {
                            $cell = trim($cell);
                            // Remove BOM dari cell jika ada
                            if (substr($cell, 0, 3) == chr(0xEF) . chr(0xBB) . chr(0xBF)) {
                                $cell = substr($cell, 3);
                            }
                            return $cell;
                        }, $row);
                        $data[] = $row;
                    }
                    fclose($handle);
                }
                unlink($tempFile);

                // Ambil header
                if (empty($data)) {
                    return redirect()->route('admin.peserta')->with('error', 'File CSV kosong atau tidak dapat dibaca!');
                }

                $header = array_shift($data);
                // Clean header dari BOM
                $header = array_map(function ($h) {
                    $h = trim($h);
                    if (substr($h, 0, 3) == chr(0xEF) . chr(0xBB) . chr(0xBF)) {
                        $h = substr($h, 3);
                    }
                    return $h;
                }, $header);
            } else {
                // Untuk Excel, gunakan library PhpSpreadsheet jika ada
                if (class_exists('PhpOffice\PhpSpreadsheet\IOFactory')) {
                    try {
                        /** @var \PhpOffice\PhpSpreadsheet\Reader\IReader $reader */
                        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file->getRealPath());
                        $spreadsheet = $reader->load($file->getRealPath());
                        $worksheet = $spreadsheet->getActiveSheet();
                        $rows = $worksheet->toArray();

                        // Filter baris kosong dan ambil header
                        if (empty($rows)) {
                            return redirect()->route('admin.peserta')->with('error', 'File Excel kosong atau tidak dapat dibaca!');
                        }

                        $header = array_shift($rows);

                        // Clean header - hapus null/empty dan trim
                        $header = array_map(function ($h) {
                            if ($h === null)
                                return '';
                            $h = trim((string) $h);
                            // Remove BOM jika ada
                            if (substr($h, 0, 3) == chr(0xEF) . chr(0xBB) . chr(0xBF)) {
                                $h = substr($h, 3);
                            }
                            return $h;
                        }, $header);

                        // Filter data - hanya ambil baris yang tidak kosong
                        $data = [];
                        foreach ($rows as $row) {
                            // Clean row - hapus null dan trim
                            $cleanRow = array_map(function ($cell) {
                                if ($cell === null)
                                    return '';
                                return trim((string) $cell);
                            }, $row);

                            // Skip jika semua cell kosong
                            if (!empty(array_filter($cleanRow))) {
                                $data[] = $cleanRow;
                            }
                        }
                    } catch (\Exception $e) {
                        return redirect()->route('admin.peserta')->with('error', 'Error membaca file Excel: ' . $e->getMessage() . '. Pastikan file Excel tidak corrupt dan format benar.');
                    }
                } else {
                    return redirect()->route('admin.peserta')->with('error', 'Untuk file Excel (.xlsx/.xls), library PhpSpreadsheet diperlukan. Install dengan: composer require phpoffice/phpspreadsheet. Atau gunakan format CSV.');
                }
            }

            // Mapping kolom Excel ke field database
            $headerMap = [
                'nama_lengkap' => ['nama lengkap', 'nama', 'name'],
                'no_peserta' => ['no peserta', 'no. peserta', 'nomor peserta', 'nik', 'nomor induk karyawan'],
                'email' => ['email', 'e-mail', 'mail'],
                'no_hp' => ['no hp', 'no. hp', 'no telp', 'no telpon', 'no telephone', 'telepon', 'telp', 'phone', 'handphone'],
            ];

            // Normalize header
            $normalizedHeader = [];
            $unmappedHeaders = [];
            foreach ($header as $idx => $h) {
                $h = strtolower(trim($h));
                $found = false;
                foreach ($headerMap as $dbField => $excelFields) {
                    if (in_array($h, $excelFields)) {
                        $normalizedHeader[$idx] = $dbField;
                        $found = true;
                        break;
                    }
                }
                if (!$found && !empty($h)) {
                    $unmappedHeaders[] = $h;
                }
            }

            // Validasi header yang dibaca
            if (empty($normalizedHeader)) {
                return redirect()->route('admin.peserta')->with('error', 'Tidak ada kolom yang dikenali! Header yang dibaca: ' . implode(', ', array_filter($header)) . '. Pastikan format CSV sesuai template.');
            }

            $imported = 0;
            $errors = [];

            // Tambahkan warning jika ada header yang tidak dikenali
            if (!empty($unmappedHeaders)) {
                $errors[] = 'Warning: Kolom tidak dikenali: ' . implode(', ', $unmappedHeaders);
            }

            foreach ($data as $rowIndex => $row) {
                if (empty(array_filter($row)))
                    continue;  // Skip empty rows

                try {
                    $pesertaData = [];

                    foreach ($normalizedHeader as $excelIdx => $dbField) {
                        if (isset($row[$excelIdx])) {
                            $pesertaData[$dbField] = trim($row[$excelIdx]);
                        }
                    }

                    // Validasi required fields
                    if (empty($pesertaData['nama_lengkap']) || empty($pesertaData['no_peserta'])) {
                        $errors[] = 'Baris ' . ($rowIndex + 2) . ': Nama Lengkap dan No. Peserta wajib diisi';
                        continue;
                    }

                    // Check if no_peserta already exists - skip jika sudah ada (tidak perlu error, hanya skip)
                    $existing = Peserta::where('no_peserta', $pesertaData['no_peserta'])->first();
                    if ($existing) {
                        // Skip jika no_peserta sudah ada, tidak perlu error (untuk re-import yang aman)
                        continue;
                    }

                    // Set default untuk status_kirim_email dan status_kirim_whatsapp
                    if (!isset($pesertaData['status_kirim_email'])) {
                        $pesertaData['status_kirim_email'] = false;
                    }
                    if (!isset($pesertaData['status_kirim_whatsapp'])) {
                        $pesertaData['status_kirim_whatsapp'] = false;
                    }

                    Peserta::create($pesertaData);
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = 'Baris ' . ($rowIndex + 2) . ': ' . $e->getMessage();
                }
            }

            // Jika ada yang berhasil diimport, tampilkan success message
            if ($imported > 0) {
                $message = "✅ Berhasil mengimpor {$imported} peserta!";
                if (!empty($errors)) {
                    $message .= ' Terdapat ' . count($errors) . ' error/warning: ' . implode(', ', array_slice($errors, 0, 3));
                }

                // Log success
                Log::info('Import Peserta Success', [
                    'imported' => $imported,
                    'errors_count' => count($errors)
                ]);

                return redirect()->route('admin.peserta')->with('success', $message);
            }

            // Jika tidak ada yang diimport dan tidak ada error, berarti tidak ada data valid
            if (empty($errors)) {
                $headerInfo = !empty($header) ? implode(', ', array_filter($header)) : 'Tidak ada header';
                $dataInfo = !empty($data) ? count($data) . ' baris data' : 'Tidak ada data';
                $errorMsg = 'Tidak ada data yang diimpor! Header yang dibaca: ' . $headerInfo . '. Data yang ditemukan: ' . $dataInfo . '. Pastikan file berisi data valid setelah header.';

                // Log untuk debugging
                Log::warning('Import Peserta: No data imported', [
                    'headers' => $header,
                    'data_count' => count($data),
                    'normalized_headers' => isset($normalizedHeader) ? $normalizedHeader : [],
                    'data_preview' => !empty($data) ? array_slice($data, 0, 2) : []
                ]);

                return redirect()->route('admin.peserta')->with('error', $errorMsg);
            }

            // Jika ada error dan tidak ada yang diimport
            $errorMsg = 'Gagal mengimpor data! ';
            $errorMsg .= count($errors) . ' error: ' . implode(', ', array_slice($errors, 0, 5));

            return redirect()->route('admin.peserta')->with('error', $errorMsg);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            $errors = $e->errors();
            $errorMessage = 'Validasi gagal: ';
            foreach ($errors as $field => $messages) {
                $errorMessage .= implode(', ', $messages);
            }
            return redirect()->route('admin.peserta')->with('error', $errorMessage);
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Import Peserta Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('admin.peserta')->with('error', 'Error mengimpor file: ' . $e->getMessage() . '. Pastikan format file sesuai template. File harus berisi header dan data.');
        }
    }

    public function pesertaTemplate()
    {
        // Cek apakah PhpSpreadsheet tersedia
        if (!class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet')) {
            return redirect()->route('admin.peserta')->with('error', 'Library PhpSpreadsheet tidak tersedia. Install dengan: composer require phpoffice/phpspreadsheet');
        }

        try {
            // Buat template Excel
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set headers
            $headers = [
                'Nama Lengkap',
                'No. Peserta',
                'Email',
                'No. HP'
            ];

            // Set header row dengan styling
            $sheet->setCellValue('A1', $headers[0]);
            $sheet->setCellValue('B1', $headers[1]);
            $sheet->setCellValue('C1', $headers[2]);
            $sheet->setCellValue('D1', $headers[3]);

            // Style header
            $headerStyle = [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '8B5CF6'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ];
            $sheet->getStyle('A1:D1')->applyFromArray($headerStyle);

            // Set contoh data
            $sheet->setCellValue('A2', 'John Doe');
            $sheet->setCellValue('B2', '1234567890');
            $sheet->setCellValue('C2', 'john.doe@example.com');
            $sheet->setCellValue('D2', '081234567890');

            // Auto size columns
            foreach (range('A', 'D') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Set filename
            $filename = 'template_peserta_' . date('YmdHis') . '.xlsx';

            // Set headers untuk download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            // Write file
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;
        } catch (\Exception $e) {
            return redirect()->route('admin.peserta')->with('error', 'Error membuat template Excel: ' . $e->getMessage());
        }
    }

    public function pesertaKirimUndangan()
    {
        // Ambil semua peserta yang punya email
        $pesertaWithEmail = Peserta::whereNotNull('email')
            ->where('email', '!=', '')
            ->get();

        if ($pesertaWithEmail->isEmpty()) {
            return redirect()->route('admin.peserta')->with('error', 'Tidak ada peserta yang memiliki email!');
        }

        $sent = 0;
        $failed = 0;
        $errors = [];

        foreach ($pesertaWithEmail as $peserta) {
            try {
                // Kirim email menggunakan queue untuk background processing
                Mail::to($peserta->email)->queue(new UndanganAbsen($peserta));

                // Update status_kirim_email setelah email berhasil masuk ke queue
                $peserta->update(['status_kirim_email' => true]);

                $sent++;
            } catch (\Exception $e) {
                $failed++;
                $errors[] = $peserta->nama_lengkap . ': ' . $e->getMessage();
            }
        }

        $message = "Berhasil menambahkan {$sent} email ke antrian pengiriman.";
        if ($failed > 0) {
            $message .= " Gagal mengirim ke {$failed} peserta.";
            if (!empty($errors)) {
                $message .= ' Error: ' . implode(', ', array_slice($errors, 0, 3));
            }
        }

        return redirect()->route('admin.peserta')->with('success', $message);
    }

    public function pesertaKirimUndanganSatu($id)
    {
        $peserta = Peserta::find($id);

        if (!$peserta) {
            return redirect()->route('admin.peserta')->with('error', 'Peserta tidak ditemukan!');
        }

        if (empty($peserta->email)) {
            return redirect()->route('admin.peserta')->with('error', 'Peserta tidak memiliki email!');
        }

        try {
            // Kirim email menggunakan queue untuk background processing
            Mail::to($peserta->email)->queue(new UndanganAbsen($peserta));

            // Update status_kirim_email setelah email berhasil masuk ke queue
            $peserta->update(['status_kirim_email' => true]);

            return redirect()->route('admin.peserta')->with('success', "Email undangan untuk {$peserta->nama_lengkap} telah ditambahkan ke antrian pengiriman!");
        } catch (\Exception $e) {
            return redirect()->route('admin.peserta')->with('error', "Gagal mengirim email ke {$peserta->nama_lengkap}: " . $e->getMessage());
        }
    }

    public function pesertaKirimWhatsApp()
    {
        // Ambil semua peserta yang punya nomor HP
        $pesertaWithHp = Peserta::whereNotNull('no_hp')
            ->where('no_hp', '!=', '')
            ->get();

        if ($pesertaWithHp->isEmpty()) {
            return redirect()->route('admin.peserta')->with('error', 'Tidak ada peserta yang memiliki nomor HP!');
        }

        $sent = 0;
        $failed = 0;
        $errors = [];

        // Ambil waktu eksekusi terakhir dari cache
        $waktuEksekusiTerakhir = Cache::get('eksekusi_whatsapp_peserta_terakhir', now());

        foreach ($pesertaWithHp as $peserta) {
            try {
                // Buat pesan WhatsApp dengan format yang lebih bagus
                $pesan = "🎉 *UNDANGAN SEMINAR*\n";
                $pesan .= "PT. Mada Wikri Tunggal\n\n";
                $pesan .= "Halo *{$peserta->nama_lengkap}*,\n\n";
                $pesan .= "Dengan hormat, kami mengundang Bapak/Ibu untuk menghadiri seminar:\n";
                $pesan .= "*Level Up Session with James Gwee*\n\n";
                $pesan .= "📅 *Hari/Tanggal:* 5 November 2025\n";
                $pesan .= "⏰ *Waktu:* 09:00 - 17:00 WIB\n";
                $pesan .= "📍 *Tempat:* Hotel Primebiz, Cikarang\n\n";
                $pesan .= "🆔 *No. Peserta Anda:*\n";
                $pesan .= "*{$peserta->no_peserta}*\n\n";
                $pesan .= "📱 QR Code absensi akan dikirim setelah pesan ini melalui email, harap cek email anda.\n\n";
                $pesan .= "✅ *Mohon balas pesan ini dengan kata \"HADIR\" untuk konfirmasi kehadiran Anda.*\n\n";
                $pesan .= "Terima kasih.\n\n";
                $pesan .= 'PT. Mada Wikri Tunggal';

                // Hitung waktu eksekusi berikutnya (random 60-90 detik)
                $waktuEksekusiBerikutnya = Carbon::parse($waktuEksekusiTerakhir)
                    ->addSeconds(rand(60, 90));

                // Dispatch Job dengan delay
                KirimWhatsappPeserta::dispatch($peserta, $pesan)
                    ->delay($waktuEksekusiBerikutnya);

                // Update waktu eksekusi terakhir untuk peserta berikutnya
                $waktuEksekusiTerakhir = $waktuEksekusiBerikutnya;

                $sent++;
            } catch (\Throwable $th) {
                $failed++;
                $errors[] = $peserta->nama_lengkap . ': ' . $th->getMessage();

                // Log error ke file .txt
                Log::error("Gagal menambahkan WhatsApp ke antrian untuk {$peserta->nama_lengkap} ({$peserta->no_hp}): " . $th->getMessage());
            }
        }

        // Simpan waktu eksekusi terakhir ke cache
        Cache::put('eksekusi_whatsapp_peserta_terakhir', $waktuEksekusiTerakhir, now()->addMinutes(10));

        $message = "Berhasil menambahkan {$sent} WhatsApp ke antrian pengiriman.";
        if ($failed > 0) {
            $message .= " Gagal menambahkan ke antrian untuk {$failed} peserta.";
            if (!empty($errors)) {
                $message .= ' Error: ' . implode(', ', array_slice($errors, 0, 3));
            }
        }

        return redirect()->route('admin.peserta')->with('success', $message);
    }

    public function pesertaKirimWhatsAppSatu($id)
    {
        $peserta = Peserta::find($id);

        if (!$peserta) {
            return redirect()->route('admin.peserta')->with('error', 'Peserta tidak ditemukan!');
        }

        if (empty($peserta->no_hp)) {
            return redirect()->route('admin.peserta')->with('error', 'Peserta tidak memiliki nomor HP!');
        }

        try {
            // Buat pesan WhatsApp dengan format yang lebih bagus
            $pesan = "🎉 *UNDANGAN SEMINAR*\n";
            $pesan .= "PT. Mada Wikri Tunggal\n\n";
            $pesan .= "Halo *{$peserta->nama_lengkap}*,\n\n";
            $pesan .= "Dengan hormat, kami mengundang Bapak/Ibu untuk menghadiri seminar:\n";
            $pesan .= "*Level Up Session with James Gwee*\n\n";
            $pesan .= "📅 *Hari/Tanggal:* 5 November 2025\n";
            $pesan .= "⏰ *Waktu:* 09:00 - 17:00 WIB\n";
            $pesan .= "📍 *Tempat:* Hotel Primebiz, Cikarang\n\n";
            $pesan .= "🆔 *No. Peserta Anda:*\n";
            $pesan .= "*{$peserta->no_peserta}*\n\n";
            $pesan .= "📱 QR Code absensi akan dikirim setelah pesan ini melalui email, harap cek email anda.\n\n";
            $pesan .= "✅ *Mohon balas pesan ini dengan kata \"HADIR\" untuk konfirmasi kehadiran Anda.*\n\n";
            $pesan .= "Terima kasih.\n\n";
            $pesan .= 'PT. Mada Wikri Tunggal';

            // Ambil waktu eksekusi terakhir dari cache
            $waktuEksekusiTerakhir = Cache::get('eksekusi_whatsapp_peserta_terakhir', now());

            // Hitung waktu eksekusi berikutnya (random 60-90 detik)
            $waktuEksekusiBerikutnya = Carbon::parse($waktuEksekusiTerakhir)
                ->addSeconds(rand(60, 90));

            // Dispatch Job dengan delay
            KirimWhatsappPeserta::dispatch($peserta, $pesan)
                ->delay($waktuEksekusiBerikutnya);

            // Simpan waktu eksekusi terakhir ke cache
            Cache::put('eksekusi_whatsapp_peserta_terakhir', $waktuEksekusiBerikutnya, now()->addMinutes(10));

            return redirect()->route('admin.peserta')->with('success', "WhatsApp undangan untuk {$peserta->nama_lengkap} telah ditambahkan ke antrian pengiriman!");
        } catch (\Throwable $th) {
            // Log error ke file .txt
            Log::error("Gagal menambahkan WhatsApp ke antrian untuk {$peserta->nama_lengkap} ({$peserta->no_hp}): " . $th->getMessage());

            return redirect()->route('admin.peserta')->with('error', "Gagal menambahkan WhatsApp ke antrian untuk {$peserta->nama_lengkap}: " . $th->getMessage());
        }
    }

    // CRUD Pengguna
    public function pengguna()
    {
        $pengguna = Pengguna::with('departemen')->paginate(10);
        return view('admin.pengguna.index', compact('pengguna'));
    }

    public function penggunaCreate()
    {
        $departemen = Departemen::all();
        return view('admin.pengguna.create', compact('departemen'));
    }

    public function penggunaStore(Request $request)
    {
        $request->validate([
            'id_departemen' => 'required|exists:departemen,id',
            'username' => 'required|string|max:255|unique:pengguna,username',
            'password' => 'required|string|min:6',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'plant' => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        Pengguna::create($data);

        return redirect()->route('admin.pengguna')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    public function penggunaEdit($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $departemen = Departemen::all();
        return view('admin.pengguna.edit', compact('pengguna', 'departemen'));
    }

    public function penggunaUpdate(Request $request, $id)
    {
        $request->validate([
            'id_departemen' => 'required|exists:departemen,id',
            'username' => 'required|string|max:255|unique:pengguna,username,' . $id,
            'password' => 'nullable|string|min:6',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'plant' => 'nullable|integer',
        ]);

        $pengguna = Pengguna::findOrFail($id);
        $data = $request->all();

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $pengguna->update($data);
        return redirect()->route('admin.pengguna')->with('success', 'Pengguna berhasil diupdate!');
    }

    public function penggunaDelete($id)
    {
        Pengguna::findOrFail($id)->delete();
        return redirect()->route('admin.pengguna')->with('success', 'Pengguna berhasil dihapus!');
    }

    // CRUD Absen
    public function absen()
    {
        $absen = Absen::with('peserta')->orderBy('tanggal_masuk', 'desc')->paginate(10);
        return view('admin.absen.index', compact('absen'));
    }

    public function absenCreate()
    {
        $peserta = Peserta::all();
        return view('admin.absen.create', compact('peserta'));
    }

    public function absenStore(Request $request)
    {
        $request->validate([
            'id_peserta' => 'required|exists:peserta,id',
            'tanggal_masuk' => 'required|date',
            'nomor_tiket' => 'required|string|max:255',
        ]);

        Absen::create($request->all());
        return redirect()->route('admin.absen')->with('success', 'Absen berhasil ditambahkan!');
    }

    public function absenEdit($id)
    {
        $absen = Absen::findOrFail($id);
        $peserta = Peserta::all();
        return view('admin.absen.edit', compact('absen', 'peserta'));
    }

    public function absenUpdate(Request $request, $id)
    {
        $request->validate([
            'id_peserta' => 'required|exists:peserta,id',
            'tanggal_masuk' => 'required|date',
            'nomor_tiket' => 'required|string|max:255',
        ]);

        $absen = Absen::findOrFail($id);
        $absen->update($request->all());
        return redirect()->route('admin.absen')->with('success', 'Absen berhasil diupdate!');
    }

    public function absenDelete($id)
    {
        Absen::findOrFail($id)->delete();
        return redirect()->route('admin.absen')->with('success', 'Absen berhasil dihapus!');
    }

    public function absenDeleteAll()
    {
        $count = Absen::count();
        Absen::truncate();
        return redirect()->route('admin.absen')->with('success', "Berhasil menghapus semua data absen ({$count} record)!");
    }
}
