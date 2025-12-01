<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class WaliKelasAlertNotification extends Notification
{
    use Queueable;

    protected $alertType;
    protected $siswa;
    protected $data;

    public function __construct($alertType, $siswa, $data = [])
    {
        $this->alertType = $alertType;
        $this->siswa = $siswa;
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $messages = [
            'poin_kritis' => [
                'title' => '🚨 Alert: Siswa Poin Kritis',
                'message' => 'Siswa ' . $this->siswa->nama_siswa . ' (' . $this->siswa->kelas->nama_kelas . ') mencapai poin kritis: ' . ($this->data['total_poin'] ?? 0) . ' poin',
                'icon' => 'ti-alert-circle',
                'color' => 'danger'
            ],
            'sanksi_baru' => [
                'title' => '⚠️ Alert: Sanksi Baru',
                'message' => 'Siswa ' . $this->siswa->nama_siswa . ' (' . $this->siswa->kelas->nama_kelas . ') mendapat sanksi baru: ' . ($this->data['jenis_sanksi'] ?? 'Sanksi'),
                'icon' => 'ti-alert-triangle',
                'color' => 'warning'
            ],
            'panggilan_ortu' => [
                'title' => '📞 Alert: Panggilan Orang Tua',
                'message' => 'Siswa ' . $this->siswa->nama_siswa . ' (' . $this->siswa->kelas->nama_kelas . ') perlu panggilan orang tua. Total poin: ' . ($this->data['total_poin'] ?? 0),
                'icon' => 'ti-phone',
                'color' => 'info'
            ],
            'pelanggaran_berulang' => [
                'title' => '🔄 Alert: Pelanggaran Berulang',
                'message' => 'Siswa ' . $this->siswa->nama_siswa . ' (' . $this->siswa->kelas->nama_kelas . ') melakukan ' . ($this->data['jumlah_pelanggaran'] ?? 0) . ' pelanggaran dalam 30 hari terakhir',
                'icon' => 'ti-repeat',
                'color' => 'warning'
            ]
        ];

        $alert = $messages[$this->alertType] ?? $messages['poin_kritis'];

        return [
            'title' => $alert['title'],
            'message' => $alert['message'],
            'siswa_id' => $this->siswa->id,
            'siswa_nama' => $this->siswa->nama_siswa,
            'kelas' => $this->siswa->kelas->nama_kelas,
            'alert_type' => $this->alertType,
            'icon' => $alert['icon'],
            'color' => $alert['color'],
            'data' => $this->data,
            'action_url' => route('walikelas.monitoring.detail', $this->siswa->id)
        ];
    }
}