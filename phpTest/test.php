<?php

$menu = [
    'home' => [
        'path' => 'index.php',
        'name' => 'Domov',
    ],
    'portfolio' => [
        'path' => 'portfolio.php',
        'name' => 'Portfólio',
    ],
    'faq' => [
        'path' => 'qna.php',
        'name' => 'Q&A',
    ],
    'contact' => [
        'path' => 'kontakt.php',
        'name' => 'Kontakt',
    ],
];
$menuJson = json_encode($menu);
file_put_contents("source/menu.json", $menuJson);

$priecinok = fopen("source/menu.csv", "w"); //otovrenie súboru v režime write
$Mena = ["Nazov","Cesta", "MenoStranka"]; //prvý riadok buduceho csv, (vytvorenie hlaviciek)
fputcsv($priecinok, $Mena); //zapise pole ako riadok do csv

foreach ($menu as $key => $item) {
    $list=[$key,$item["path"],$item["name"]]; //vytvorenie pola ktore budeme vkladat po riadkoch do csv
    fputcsv($priecinok, $list); //vloz do priecinku, a čo
}


fclose($priecinok); //zatvorenie suboru
