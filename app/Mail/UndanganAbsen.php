<?php

namespace App\Mail;

use App\Models\Karyawan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;

class UndanganAbsen extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $karyawan;
    public $qrcodePath;

    /**
     * Create a new message instance.
     */
    public function __construct(Karyawan $karyawan)
    {
        $this->karyawan = $karyawan;
        
        // Generate QR Code dan simpan ke temporary file
        $this->generateQRCode();
    }

    /**
     * Generate QR Code dan simpan ke file
     */
    private function generateQRCode()
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($this->karyawan->nik)
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
        
        $filename = 'qrcode_' . $this->karyawan->nik . '_' . time() . '.png';
        $this->qrcodePath = $tempPath . '/' . $filename;
        $result->saveToFile($this->qrcodePath);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address('ardyansyahputra174@gmail.com', 'PT. Mada Wikri Tunggal'),
            subject: 'Undangan Seminar - PT Mada Wikri Tunggal',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.undangan_absen',
            with: [
                'karyawan' => $this->karyawan,
                'qrcodePath' => $this->qrcodePath,
                'tanggalSeminar' => '5 November 2025',
                'waktuSeminar' => '09:00 - 17:00 WIB',
                'tempatSeminar' => 'Hotel Primebiz, Cikarang',
                'linkAbsen' => route('absen.index'),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // Tetap attach QR code sebagai file untuk backup
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($this->karyawan->nik)
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
        
        $filename = 'qrcode_' . $this->karyawan->nik . '.png';
        $filepath = $tempPath . '/' . $filename;
        $result->saveToFile($filepath);
        
        return [
            \Illuminate\Mail\Mailables\Attachment::fromPath($filepath)
                ->as('QRCode_' . $this->karyawan->nik . '.png')
                ->withMime('image/png'),
        ];
    }
}
