<?php

// app/Events/KetidaksesuaianBarangDiterima.php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KetidaksesuaianBarangDiterima
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pesanan;
    public $penerimaan;

    public function __construct($pesanan, $penerimaan)
    {
        $this->pesanan = $pesanan;
        $this->penerimaan = $penerimaan;
    }
}
