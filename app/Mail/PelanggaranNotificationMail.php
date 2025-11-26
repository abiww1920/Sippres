<?php

namespace App\Mail;

use App\Models\Pelanggaran;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PelanggaranNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pelanggaran;

    public function __construct(Pelanggaran $pelanggaran)
    {
        $this->pelanggaran = $pelanggaran;
    }

    public function build()
    {
        return $this->subject('Notifikasi Pelanggaran Siswa - ' . $this->pelanggaran->siswa->nama_siswa)
                    ->view('emails.pelanggaran-notification');
    }
}
