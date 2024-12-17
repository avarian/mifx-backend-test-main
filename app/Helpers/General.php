<?php

// @TODO implement
// implemented
function usd_to_rupiah_format($usd)
{
    $rupiah = $usd * 14000;
    return 'Rp ' . number_format($rupiah, 0, ',', '.'). ',00';
}
