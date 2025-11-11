<?php

namespace App\Jobs;

use App\Models\Peserta;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KirimWhatsappPeserta implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $peserta;
    public $pesan;

    /**
     * Create a new job instance.
     */
    public function __construct(Peserta $peserta, string $pesan)
    {
        $this->peserta = $peserta;
        $this->pesan = $pesan;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Format nomor HP (hilangkan +, 0, spasi, dll)
            $noHp = preg_replace('/[^0-9]/', '', $this->peserta->no_hp);
            if (substr($noHp, 0, 1) == '0') {
                $noHp = '62' . substr($noHp, 1);
            }

            // Ambil config
            $apiKey = config('services.whatsapp.api_key');
            $apiUrl = config('services.whatsapp.api_url');

            // Log untuk debugging
            Log::info("Mengirim WhatsApp ke {$noHp}");
            Log::info('API Key (first 10 chars): ' . substr($apiKey, 0, 10) . '...');

            // 1. Kirim pesan teks terlebih dahulu
            $endpoint = $apiUrl . '/send/message';
            $respon = Http::withOptions([
                'verify' => false,  // Untuk development di Laragon yang punya masalah certificate
            ])->withHeaders([
                'Authorization' => $apiKey,  // Tanpa "Bearer"
                'Content-Type' => 'application/json',
            ])->post($endpoint, [
                'phone' => $noHp,
                'message' => $this->pesan,
                'isGroup' => false,
                'secure' => true,
            ]);

            $responJson = $respon->json();
            Log::info('Response WhatsApp API (text): ' . json_encode($responJson));

            if (!$responJson['success']) {
                throw new \Exception($responJson['message'], 1);
            }

            // 2. Generate QR Code
            Log::info("Generating QR Code untuk {$this->peserta->no_peserta}");
            $qrcodePath = $this->generateQRCode();
            Log::info("QR Code generated: {$qrcodePath}");

            // 3. Kirim QR Code sebagai gambar
            try {
                $endpointImage = $apiUrl . '/send/image';
                Log::info("Mengirim QR Code ke endpoint: {$endpointImage}");

                // Convert image ke base64
                $imageData = file_get_contents($qrcodePath);
                $base64Image = base64_encode($imageData);

                // Coba format dengan base64
                $responImage = Http::withOptions([
                    'verify' => false,
                ])->withHeaders([
                    'Authorization' => $apiKey,
                    'Content-Type' => 'application/json',
                ])->post($endpointImage, [
                    'phone' => $noHp,
                    'image' => 'data:image/png;base64,' . $base64Image,
                    'caption' => "📱 *QR CODE ABSENSI ANDA*\n\nNo. Peserta: *{$this->peserta->no_peserta}*\n\nSilakan screenshot QR Code ini untuk digunakan saat absensi.",
                    'isGroup' => false,
                    'secure' => true,
                ]);

                $responImageJson = $responImage->json();
                Log::info('Response WhatsApp API (image): ' . json_encode($responImageJson));

                // Hapus file QR Code temporary setelah dikirim
                if (file_exists($qrcodePath)) {
                    @unlink($qrcodePath);
                }

                if ($responImageJson['success'] ?? false) {
                    // Update status_kirim_whatsapp setelah berhasil
                    $this->peserta->update(['status_kirim_whatsapp' => true]);

                    // Log success
                    Log::info("Pesan WhatsApp dan QR Code sudah terkirim ke nomor {$noHp} - {$this->peserta->nama_lengkap}");
                } else {
                    // Jika gambar gagal, coba format multipart
                    Log::warning('Format base64 gagal, mencoba format multipart');
                    $this->kirimQRCodeMultipart($apiUrl, $apiKey, $noHp, $qrcodePath);
                }
            } catch (\Throwable $e) {
                Log::error('Error saat kirim QR Code: ' . $e->getMessage());
                // Jika base64 gagal, coba format multipart
                try {
                    $this->kirimQRCodeMultipart($apiUrl, $apiKey, $noHp, $qrcodePath);
                } catch (\Throwable $e2) {
                    Log::error('Format multipart juga gagal: ' . $e2->getMessage());
                    // Tetap update status karena pesan teks sudah berhasil
                    $this->peserta->update(['status_kirim_whatsapp' => true]);
                }
            } finally {
                // Hapus file QR Code temporary setelah dikirim
                if (file_exists($qrcodePath)) {
                    @unlink($qrcodePath);
                }
            }

            // Update status_kirim_whatsapp setelah berhasil (jika belum terupdate)
            $this->peserta->refresh();
            if (!$this->peserta->status_kirim_whatsapp) {
                $this->peserta->update(['status_kirim_whatsapp' => true]);
            }
        } catch (\Throwable $th) {
            // Log error
            Log::error("Gagal mengirim WhatsApp ke {$this->peserta->nama_lengkap} ({$this->peserta->no_hp}): " . $th->getMessage());

            // Re-throw agar job bisa di-retry jika diperlukan
            throw $th;
        }
    }

    /**
     * Generate QR Code dan simpan ke temporary file
     */
    private function generateQRCode(): string
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($this->peserta->no_peserta)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->build();

        // Save ke temporary file
        $tempPath = storage_path('app/temp');
        if (!file_exists($tempPath)) {
            mkdir($tempPath, 0755, true);
        }

        $filename = 'qrcode_' . $this->peserta->no_peserta . '_' . time() . '.png';
        $filepath = $tempPath . '/' . $filename;
        $result->saveToFile($filepath);

        return $filepath;
    }

    /**
     * Kirim QR Code menggunakan format multipart
     */
    private function kirimQRCodeMultipart(string $apiUrl, string $apiKey, string $noHp, string $qrcodePath): void
    {
        $endpointImage = $apiUrl . '/send/image';

        $responImage = Http::withOptions([
            'verify' => false,
        ])
            ->withHeaders([
                'Authorization' => $apiKey,
            ])
            ->attach('image', fopen($qrcodePath, 'r'), 'qrcode.png')
            ->asMultipart()
            ->post($endpointImage, [
                'phone' => $noHp,
                'caption' => "📱 *QR CODE ABSENSI ANDA*\n\nNo. Peserta: *{$this->peserta->no_peserta}*\n\nSilakan screenshot QR Code ini untuk digunakan saat absensi.",
                'isGroup' => false,
                'secure' => true,
            ]);

        $responImageJson = $responImage->json();
        Log::info('Response WhatsApp API (image multipart): ' . json_encode($responImageJson));

        if ($responImageJson['success'] ?? false) {
            $this->peserta->update(['status_kirim_whatsapp' => true]);
            Log::info("QR Code berhasil dikirim via multipart ke nomor {$noHp} - {$this->peserta->nama_lengkap}");
        } else {
            throw new \Exception($responImageJson['message'] ?? 'Gagal mengirim QR Code via multipart');
        }
    }
}
