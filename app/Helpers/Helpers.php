<?php

namespace App\Helpers;

// app/Helpers.php

function isRentalOverdue($tanggalSelesai)
{
    $today = now(); // Ganti ini dengan cara mendapatkan tanggal hari ini
    $tanggalSelesai = strtotime($tanggalSelesai);

    return $tanggalSelesai < $today;
}
