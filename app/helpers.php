<?php

if (!function_exists('indonesianDate')) {

    function indonesianDate($date)
    {
        return \Carbon\Carbon::parse($date)
            ->locale('id')
            ->settings(['formatFunction' => 'translatedFormat'])
            ->format('j F Y');
    }

}

if (!function_exists('rupiahToWords')) {

    function rupiahToWords($number)
    {
        $units = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'];
        $teens = ['sepuluh', 'sebelas', 'dua belas', 'tiga belas', 'empat belas', 'lima belas', 'enam belas', 'tujuh belas', 'delapan belas', 'sembilan belas'];
        $tens = ['', '', 'dua puluh', 'tiga puluh', 'empat puluh', 'lima puluh', 'enam puluh', 'tujuh puluh', 'delapan puluh', 'sembilan puluh'];
        $thousands = ['', 'ribu', 'juta', 'miliar', 'triliun'];

        if ($number == 0) {
            return 'nol';
        }

        $numberStr = strval($number);
        $length = strlen($numberStr);
        $levels = intdiv($length, 3) + (($length % 3) > 0 ? 1 : 0);
        $words = [];

        for ($i = 0; $i < $levels; $i++) {
            $levelValue = substr($numberStr, -3 * ($i + 1), 3);
            if ($levelValue != '000') {
                $words[] = convertThreeDigits(intval($levelValue), $units, $teens, $tens) . ' ' . $thousands[$i];
            }
        }

        return trim(implode(' ', array_reverse($words)));
    }

}

if (!function_exists('convertThreeDigits')) {

    function convertThreeDigits($number, $units, $teens, $tens)
    {
        $hundreds = intdiv($number, 100);
        $remainder = $number % 100;
        $tensPart = intdiv($remainder, 10);
        $unitsPart = $remainder % 10;

        $words = [];

        if ($hundreds > 0) {
            $words[] = $units[$hundreds] . ' ratus';
        }

        if ($remainder > 0) {
            if ($remainder < 10) {
                $words[] = $units[$remainder];
            } elseif ($remainder < 20) {
                $words[] = $teens[$remainder - 10];
            } else {
                $words[] = $tens[$tensPart];
                if ($unitsPart > 0) {
                    $words[] = $units[$unitsPart];
                }
            }
        }

        return implode(' ', $words);
    }

}
