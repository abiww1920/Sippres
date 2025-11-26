<?php

namespace App\Mail;

use App\Models\Sanksi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SanksiNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sanksi;

    public function __construct(Sanksi $sanksi)
    {
        $this->sanksi = $sanksi;
    }

    public function build()
    {
        return $this->subject('Notifikasi Sanksi - ' . $this->sanksi->pelanggaran->siswa->nama_siswa)
                    ->view('emails.sanksi-notification');
    }
}
