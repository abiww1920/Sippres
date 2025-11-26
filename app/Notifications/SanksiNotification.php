<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SanksiNotification extends Notification
{
    use Queueable;

    protected $sanksi;

    public function __construct($sanksi)
    {
        $this->sanksi = $sanksi;
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
            'title' => 'Sanksi Baru',
            'message' => 'Siswa ' . $this->sanksi->siswa->nama_siswa . ' mendapat sanksi: ' . $this->sanksi->jenis_sanksi,
            'sanksi_id' => $this->sanksi->id,
            'siswa_id' => $this->sanksi->siswa_id,
            'type' => 'sanksi'
        ];
    }
    
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('⚠️ Notifikasi Sanksi')
            ->greeting('Yth. ' . $notifiable->nama_lengkap)
            ->line('Sanksi telah diberikan kepada siswa **' . $this->sanksi->siswa->nama_siswa . '**')
            ->line('**Jenis Sanksi:** ' . $this->sanksi->jenis_sanksi)
            ->line('**Tanggal Mulai:** ' . $this->sanksi->tanggal_mulai)
            ->line('**Tanggal Selesai:** ' . $this->sanksi->tanggal_selesai)
            ->action('Lihat Detail', url('/admin/sanksi/' . $this->sanksi->id))
            ->line('Mohon untuk memastikan pelaksanaan sanksi.');
    }
}
