<?php

// @TODO implement
// implemented
// Define a function called usd_to_rupiah_format that accepts one parameter, $usd
function usd_to_rupiah_format($usd)
{
    // Calculate the equivalent amount in Rupiah by multiplying the USD amount by 14,000 (exchange rate)
    $rupiah = $usd * 14000;

    // Format the calculated Rupiah amount with thousand separators and append "Rp" at the start 
    // as well as ",00" at the end to represent cents.
    // number_format is used to format the number with commas for thousands and periods for decimal points
    return 'Rp ' . number_format($rupiah, 0, ',', '.') . ',00';
}
