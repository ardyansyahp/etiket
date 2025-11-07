<?php

namespace App\Http\Controllers;

use App\Mail\UndanganAbsen;
use App\Models\Absen;
use App\Models\Departemen;
use App\Models\Karyawan;
use App\Models\Pengguna;
use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('pengguna')->check()) {
            return redirect()->route('admin.dashboard');
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
                    'redirect' => route('admin.dashboard')
                ]);
            }

            return redirect()->route('admin.dashboard');
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

    public function dashboard()
    {
        $stats = [
            'departemen' => Departemen::count(),
            'plant' => Plant::count(),
            'karyawan' => Karyawan::count(),
            'absen_hari_ini' => Absen::whereDate('tanggal_masuk', today())->count(),
        ];

        $today = today();

        // Absen hari ini per departemen
        $byDepartemen = Absen::whereDate('tanggal_masuk', $today)
            ->join('karyawan', 'absen.id_karyawan', '=', 'karyawan.id')
            ->join('departemen', 'karyawan.id_departemen', '=', 'departemen.id')
            ->selectRaw('departemen.nama as label, COUNT(*) as total')
            ->groupBy('departemen.nama')
            ->orderBy('label')
            ->get();

        // Absen hari ini per plant
        $byPlant = Absen::whereDate('tanggal_masuk', $today)
            ->join('karyawan', 'absen.id_karyawan', '=', 'karyawan.id')
            ->join('plant', 'karyawan.id_plant', '=', 'plant.id')
            ->selectRaw('plant.nama as label, COUNT(*) as total')
            ->groupBy('plant.nama')
            ->orderBy('label')
            ->get();

        $departemenLabels = $byDepartemen->pluck('label')->toArray();
        $departemenValues = $byDepartemen->pluck('total')->toArray();
        $plantLabels = $byPlant->pluck('label')->toArray();
        $plantValues = $byPlant->pluck('total')->toArray();

        // Generate JSON string untuk JavaScript (menghindari linter error)
        $chartDataJson = json_encode([
            'departemenLabels' => $departemenLabels,
            'departemenValues' => $departemenValues,
            'plantLabels' => $plantLabels,
            'plantValues' => $plantValues,
        ]);

        return view('admin.dashboard', compact(
            'stats',
            'departemenLabels',
            'departemenValues',
            'plantLabels',
            'plantValues',
            'chartDataJson'
        ));
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

    // CRUD Karyawan
    public function karyawan(Request $request)
    {
        $query = Karyawan::with('departemen', 'plant');

        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q
                    ->where('nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('nik', 'like', '%' . $search . '%')
                    ->orWhere('jabatan', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('no_telp', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%')
                    ->orWhereHas('departemen', function ($q) use ($search) {
                        $q->where('nama', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('plant', function ($q) use ($search) {
                        $q->where('nama', 'like', '%' . $search . '%');
                    });
            });
        }

        $karyawan = $query->paginate(10)->withQueryString();
        return view('admin.karyawan.index', compact('karyawan'));
    }

    public function karyawanCreate()
    {
        $departemen = Departemen::all();
        $plant = Plant::all();
        return view('admin.karyawan.create', compact('departemen', 'plant'));
    }

    public function karyawanStore(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:255|unique:karyawan,nik',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'umur' => 'nullable|integer',
            'alamat' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'no_telp' => 'nullable|string|max:255',
            'tanggal_masuk_kerja' => 'nullable|date',
            'status_karyawan' => 'nullable|string|max:255',
            'id_departemen' => 'nullable|exists:departemen,id',
            'id_plant' => 'nullable|exists:plant,id',
        ]);

        Karyawan::create($request->all());
        return redirect()->route('admin.karyawan')->with('success', 'Karyawan berhasil ditambahkan!');
    }

    public function karyawanDetail($id)
    {
        $karyawan = Karyawan::with('departemen', 'plant')->findOrFail($id);
        return view('admin.karyawan.detail', compact('karyawan'));
    }

    public function karyawanEdit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $departemen = Departemen::all();
        $plant = Plant::all();
        return view('admin.karyawan.edit', compact('karyawan', 'departemen', 'plant'));
    }

    public function karyawanUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:255|unique:karyawan,nik,' . $id,
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'umur' => 'nullable|integer',
            'alamat' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'no_telp' => 'nullable|string|max:255',
            'tanggal_masuk_kerja' => 'nullable|date',
            'status_karyawan' => 'nullable|string|max:255',
            'id_departemen' => 'nullable|exists:departemen,id',
            'id_plant' => 'nullable|exists:plant,id',
        ]);

        $karyawan = Karyawan::findOrFail($id);
        $karyawan->update($request->all());
        return redirect()->route('admin.karyawan')->with('success', 'Karyawan berhasil diupdate!');
    }

    public function karyawanDelete($id)
    {
        Karyawan::findOrFail($id)->delete();
        return redirect()->route('admin.karyawan')->with('success', 'Karyawan berhasil dihapus!');
    }

    public function karyawanImport(Request $request)
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
                return redirect()->route('admin.karyawan')->with('error', 'File tidak ditemukan! Pastikan file sudah dipilih.');
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
                return redirect()->route('admin.karyawan')->with('error', $errorMsg);
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
                    return redirect()->route('admin.karyawan')->with('error', 'File CSV kosong atau tidak dapat dibaca!');
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
                            return redirect()->route('admin.karyawan')->with('error', 'File Excel kosong atau tidak dapat dibaca!');
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
                        return redirect()->route('admin.karyawan')->with('error', 'Error membaca file Excel: ' . $e->getMessage() . '. Pastikan file Excel tidak corrupt dan format benar.');
                    }
                } else {
                    return redirect()->route('admin.karyawan')->with('error', 'Untuk file Excel (.xlsx/.xls), library PhpSpreadsheet diperlukan. Install dengan: composer require phpoffice/phpspreadsheet. Atau gunakan format CSV.');
                }
            }

            // Mapping kolom Excel ke field database
            $headerMap = [
                'nama_lengkap' => ['nama lengkap', 'nama', 'name'],
                'nik' => ['nik', 'nomor induk karyawan'],
                'tanggal_lahir' => ['tanggal lahir', 'tgl lahir', 'birth date'],
                'tempat_lahir' => ['tempat lahir', 'birth place'],
                'jabatan' => ['jabatan', 'position'],
                'umur' => ['umur', 'age'],
                'alamat' => ['alamat', 'address'],
                'email' => ['email', 'e-mail', 'mail'],
                'no_telp' => ['no telp', 'no telpon', 'no telephone', 'telepon', 'telp', 'phone', 'hp', 'handphone'],
                'tanggal_masuk_kerja' => ['tanggal masuk kerja', 'tanggal masuk', 'tgl masuk kerja', 'tgl masuk', 'join date'],
                'status_karyawan' => ['status karyawan', 'status', 'employee status'],
                'departemen' => ['departemen', 'department'],
                'plant' => ['plant'],
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
                return redirect()->route('admin.karyawan')->with('error', 'Tidak ada kolom yang dikenali! Header yang dibaca: ' . implode(', ', array_filter($header)) . '. Pastikan format CSV sesuai template.');
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
                    $karyawanData = [];

                    foreach ($normalizedHeader as $excelIdx => $dbField) {
                        if (isset($row[$excelIdx])) {
                            $karyawanData[$dbField] = trim($row[$excelIdx]);
                        }
                    }

                    // Handle departemen dan plant (by name)
                    if (isset($karyawanData['departemen']) && !empty($karyawanData['departemen'])) {
                        $departemen = Departemen::where('nama', 'like', '%' . $karyawanData['departemen'] . '%')->first();
                        if ($departemen) {
                            $karyawanData['id_departemen'] = $departemen->id;
                        }
                        unset($karyawanData['departemen']);
                    }

                    if (isset($karyawanData['plant']) && !empty($karyawanData['plant'])) {
                        $plant = Plant::where('nama', 'like', '%' . $karyawanData['plant'] . '%')->first();
                        if ($plant) {
                            $karyawanData['id_plant'] = $plant->id;
                        }
                        unset($karyawanData['plant']);
                    }

                    // Validasi required fields
                    if (empty($karyawanData['nama_lengkap']) || empty($karyawanData['nik'])) {
                        $errors[] = 'Baris ' . ($rowIndex + 2) . ': Nama Lengkap dan NIK wajib diisi';
                        continue;
                    }

                    // Check if NIK already exists - skip jika sudah ada (tidak perlu error, hanya skip)
                    $existing = Karyawan::where('nik', $karyawanData['nik'])->first();
                    if ($existing) {
                        // Skip jika NIK sudah ada, tidak perlu error (untuk re-import yang aman)
                        continue;
                    }

                    // Format tanggal
                    if (isset($karyawanData['tanggal_lahir']) && !empty($karyawanData['tanggal_lahir'])) {
                        try {
                            $karyawanData['tanggal_lahir'] = \Carbon\Carbon::parse($karyawanData['tanggal_lahir'])->format('Y-m-d');
                        } catch (\Exception $e) {
                            // Skip if invalid date
                        }
                    }
                    if (isset($karyawanData['tanggal_masuk_kerja']) && !empty($karyawanData['tanggal_masuk_kerja'])) {
                        try {
                            $karyawanData['tanggal_masuk_kerja'] = \Carbon\Carbon::parse($karyawanData['tanggal_masuk_kerja'])->format('Y-m-d');
                        } catch (\Exception $e) {
                            // Skip if invalid date
                        }
                    }

                    Karyawan::create($karyawanData);
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = 'Baris ' . ($rowIndex + 2) . ': ' . $e->getMessage();
                }
            }

            // Jika ada yang berhasil diimport, tampilkan success message
            if ($imported > 0) {
                $message = "✅ Berhasil mengimpor {$imported} karyawan!";
                if (!empty($errors)) {
                    $message .= ' Terdapat ' . count($errors) . ' error/warning: ' . implode(', ', array_slice($errors, 0, 3));
                }

                // Log success
                Log::info('Import Karyawan Success', [
                    'imported' => $imported,
                    'errors_count' => count($errors)
                ]);

                return redirect()->route('admin.karyawan')->with('success', $message);
            }

            // Jika tidak ada yang diimport dan tidak ada error, berarti tidak ada data valid
            if (empty($errors)) {
                $headerInfo = !empty($header) ? implode(', ', array_filter($header)) : 'Tidak ada header';
                $dataInfo = !empty($data) ? count($data) . ' baris data' : 'Tidak ada data';
                $errorMsg = 'Tidak ada data yang diimpor! Header yang dibaca: ' . $headerInfo . '. Data yang ditemukan: ' . $dataInfo . '. Pastikan file berisi data valid setelah header.';

                // Log untuk debugging
                Log::warning('Import Karyawan: No data imported', [
                    'headers' => $header,
                    'data_count' => count($data),
                    'normalized_headers' => isset($normalizedHeader) ? $normalizedHeader : [],
                    'data_preview' => !empty($data) ? array_slice($data, 0, 2) : []
                ]);

                return redirect()->route('admin.karyawan')->with('error', $errorMsg);
            }

            // Jika ada error dan tidak ada yang diimport
            $errorMsg = 'Gagal mengimpor data! ';
            $errorMsg .= count($errors) . ' error: ' . implode(', ', array_slice($errors, 0, 5));

            return redirect()->route('admin.karyawan')->with('error', $errorMsg);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            $errors = $e->errors();
            $errorMessage = 'Validasi gagal: ';
            foreach ($errors as $field => $messages) {
                $errorMessage .= implode(', ', $messages);
            }
            return redirect()->route('admin.karyawan')->with('error', $errorMessage);
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Import Karyawan Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('admin.karyawan')->with('error', 'Error mengimpor file: ' . $e->getMessage() . '. Pastikan format file sesuai template. File harus berisi header dan data.');
        }
    }

    public function karyawanTemplate()
    {
        // Buat template Excel sederhana
        $headers = [
            'Nama Lengkap',
            'NIK',
            'Tanggal Lahir',
            'Tempat Lahir',
            'Jabatan',
            'Umur',
            'Alamat',
            'Email',
            'No Telp',
            'Tanggal Masuk Kerja',
            'Status Karyawan',
            'Departemen',
            'Plant'
        ];

        $filename = 'template_karyawan_' . date('YmdHis') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');

        // Add BOM for UTF-8
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($output, $headers);

        // Contoh data
        fputcsv($output, [
            'John Doe',
            '1234567890',
            '1990-01-15',
            'Jakarta',
            'Manager',
            '33',
            'Jl. Contoh No. 123',
            'john.doe@example.com',
            '081234567890',
            '2020-01-01',
            'Tetap',
            'Information Technology',
            'Plant Jakarta'
        ]);

        fclose($output);
        exit;
    }

    public function karyawanKirimUndangan()
    {
        // Ambil semua karyawan yang punya email
        $karyawanWithEmail = Karyawan::whereNotNull('email')
            ->where('email', '!=', '')
            ->get();

        if ($karyawanWithEmail->isEmpty()) {
            return redirect()->route('admin.karyawan')->with('error', 'Tidak ada karyawan yang memiliki email!');
        }

        $sent = 0;
        $failed = 0;
        $errors = [];

        foreach ($karyawanWithEmail as $karyawan) {
            try {
                // Kirim email menggunakan queue untuk background processing
                Mail::to($karyawan->email)->queue(new UndanganAbsen($karyawan));
                $sent++;
            } catch (\Exception $e) {
                $failed++;
                $errors[] = $karyawan->nama_lengkap . ': ' . $e->getMessage();
            }
        }

        $message = "Berhasil menambahkan {$sent} email ke antrian pengiriman.";
        if ($failed > 0) {
            $message .= " Gagal mengirim ke {$failed} karyawan.";
            if (!empty($errors)) {
                $message .= ' Error: ' . implode(', ', array_slice($errors, 0, 3));
            }
        }

        return redirect()->route('admin.karyawan')->with('success', $message);
    }

    public function karyawanKirimUndanganSatu($id)
    {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return redirect()->route('admin.karyawan')->with('error', 'Karyawan tidak ditemukan!');
        }

        if (empty($karyawan->email)) {
            return redirect()->route('admin.karyawan')->with('error', 'Karyawan tidak memiliki email!');
        }

        try {
            // Kirim email menggunakan queue untuk background processing
            Mail::to($karyawan->email)->queue(new UndanganAbsen($karyawan));
            return redirect()->route('admin.karyawan')->with('success', "Email undangan untuk {$karyawan->nama_lengkap} telah ditambahkan ke antrian pengiriman!");
        } catch (\Exception $e) {
            return redirect()->route('admin.karyawan')->with('error', "Gagal mengirim email ke {$karyawan->nama_lengkap}: " . $e->getMessage());
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
        $absen = Absen::with('karyawan.departemen', 'karyawan.plant')->orderBy('tanggal_masuk', 'desc')->paginate(10);
        return view('admin.absen.index', compact('absen'));
    }

    public function absenCreate()
    {
        $karyawan = Karyawan::all();
        return view('admin.absen.create', compact('karyawan'));
    }

    public function absenStore(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id',
            'tanggal_masuk' => 'required|date',
            'nomor_tiket' => 'required|string|max:255',
        ]);

        Absen::create($request->all());
        return redirect()->route('admin.absen')->with('success', 'Absen berhasil ditambahkan!');
    }

    public function absenEdit($id)
    {
        $absen = Absen::findOrFail($id);
        $karyawan = Karyawan::all();
        return view('admin.absen.edit', compact('absen', 'karyawan'));
    }

    public function absenUpdate(Request $request, $id)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id',
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
