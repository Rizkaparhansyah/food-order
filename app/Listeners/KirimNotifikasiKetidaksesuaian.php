<?php

// app/Listeners/KirimNotifikasiKetidaksesuaian.php

namespace App\Listeners;

use App\Events\KetidaksesuaianBarangDiterima;
use App\Notifications\NotifikasiKetidaksesuaianBarang;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;

class KirimNotifikasiKetidaksesuaian
{
    public function handle(KetidaksesuaianBarangDiterima $event)
    {
        // Cari manajer pembelian atau staf terkait yang akan menerima notifikasi
        $manajer = User::where('role', 'manajer_pembelian')->first();

        if ($manajer) {
            // Kirim notifikasi ke manajer pembelian
            $manajer->notify(new NotifikasiKetidaksesuaianBarang($event->pesanan, $event->penerimaan));
        }
    }
}
