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
