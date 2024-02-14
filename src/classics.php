<?php

declare(strict_types = 1);

namespace App;

define('RACE_ID', 227);

require_once('vendor/autoload.php');
require_once('src/ProCyclingStatsFetcher.php');
require_once('src/ScoritoFormatter.php');

$scorito = new ScoritoClassicsGame(
    RACE_ID,
    [
        'Omloop Het Nieuwsblad Elite',
        'Kuurne - Bruxelles - Kuurne',
        'Strade Bianche',
        // 'Milano - Torino',
        'Milano-Sanremo',
        'Classic Brugge-De Panne',
        'E3 Saxo Classic',
        'Gent-Wevelgem in Flanders Fields',
        'Dwars door Vlaanderen - A travers la Flandre',
        'Ronde van Vlaanderen - Tour des Flandres',
        'Scheldeprijs',
        'Amstel Gold Race',
        'Paris-Roubaix',
        'De Brabantse Pijl - La Flèche Brabançonne',
        'La Flèche Wallonne',
        'Liège-Bastogne-Liège',
        'Eschborn-Frankfurt',
    ]
);

$scoritoData = $scorito->fetch();

$out = fopen('classics.csv', 'w');
fputcsv($out, array_keys($scoritoData[0]));

foreach ($scoritoData as $row) {
    fputcsv($out, array_map(function ($col) {
        if (is_array($col)) {
            return print_r($col, true);
        }
        return $col;
    }, $row));
}
fclose($out);
