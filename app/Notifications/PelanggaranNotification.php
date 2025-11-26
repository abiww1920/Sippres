<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PelanggaranNotification extends Notification
{
    use Queueable;

    protected $pelanggaran;

    public function __construct($pelanggaran)
    {
        $this->pelanggaran = $pelanggaran;
    }

    public function via($notifiable)
    {
        $channels = ['database'];
        
        if ($notifiable->email) {
            $channels[] = 'mail';
        }
        
        return $channels;
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Pelanggaran Baru',
            'message' => 'Siswa ' . $this->pelanggaran->siswa->nama_siswa . ' melakukan pelanggaran: ' . $this->pelanggaran->jenisPelanggaran->nama_pelanggaran,
            'pelanggaran_id' => $this->pelanggaran->id,
            'siswa_id' => $this->pelanggaran->siswa_id,
            'type' => 'pelanggaran'
        ];
    }
    
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('🚨 Notifikasi Pelanggaran Siswa')
            ->greeting('Yth. ' . $notifiable->nama_lengkap)
            ->line('Siswa **' . $this->pelanggaran->siswa->nama_siswa . '** telah melakukan pelanggaran.')
            ->line('**Jenis Pelanggaran:** ' . $this->pelanggaran->jenisPelanggaran->nama_pelanggaran)
            ->line('**Kategori:** ' . $this->pelanggaran->jenisPelanggaran->kategori)
            ->line('**Poin:** ' . $this->pelanggaran->jenisPelanggaran->poin)
            ->line('**Tanggal:** ' . $this->pelanggaran->tanggal_pelanggaran)
            ->action('Lihat Detail', url('/admin/pelanggaran/' . $this->pelanggaran->id))
            ->line('Mohon segera ditindaklanjuti.');
    }
}
