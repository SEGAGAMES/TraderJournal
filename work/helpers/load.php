<?php
ini_set('display_errors', 0);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$url = 'https://www.cbr-xml-daily.ru/daily_json.js';
$json_data = file_get_contents($url);
$data = json_decode($json_data, true);

$usd = $data['Valute']['USD'];
$eur = $data['Valute']['EUR'];
$gbp = $data['Valute']['GBP'];
$cny = $data['Valute']['CNY'];
    
// Рассчитываем процент изменения.
$usd_change = round(($usd['Value'] - $usd['Previous']) / $usd['Previous'] * 100, 2);
$eur_change = round(($eur['Value'] - $eur['Previous']) / $eur['Previous'] * 100, 2);
$gbp_change = round(($gbp['Value'] - $gbp['Previous']) / $gbp['Previous'] * 100, 2);
$cny_change = round(($cny['Value'] - $cny['Previous']) / $cny['Previous'] * 100, 2);

// Добавления знака "+" если больше 0.
($usd_change > 0) ? $usd_change = '+' . $usd_change : $usd_change=$usd_change;
($eur_change > 0) ? $eur_change = '+' . $eur_change : $eur_change=$eur_change;
($gbp_change > 0) ? $gbp_change = '+' . $gbp_change : $gbp_change=$gbp_change;
($cny_change > 0) ? $cny_change = '+' . $cny_change : $cny_change=$cny_change;

// Определяем класс для цвета (положительное/отрицательное изменение).
$usd_class = $usd_change >= 0 ? 'positive' : 'negative';
$eur_class = $eur_change >= 0 ? 'positive' : 'negative';
$gbp_class = $gbp_change >= 0 ? 'positive' : 'negative';
$cny_class = $cny_change >= 0 ? 'positive' : 'negative';

$moex_url = 'https://iss.moex.com/iss/engines/stock/markets/index/boards/SNDX/securities/IMOEX.json?iss.meta=off';
$moex_data = json_decode(file_get_contents($moex_url), true);


// Обработка IMOEX
$imoex_value = $moex_data['marketdata']['data'][0][2];
$imoex_change = $moex_data['marketdata']['data'][0][12];

($imoex_change > 0) ? $imoex_change = '+' . $imoex_change : $imoex_change=$imoex_change;

$imoex_class = $imoex_change >= 0 ? 'positive' : 'negative';

$data = array(
    'USD'=>$usd['Value'],
    'USD_change'=>$usd_change,
    'USD_class'=>$usd_class,

    'EUR'=>$eur['Value'],
    'EUR_change'=>$eur_change,
    'EUR_class'=>$eur_class,

    'GBP'=>$gbp['Value'],
    'GBP_change'=>$gbp_change,
    'GBP_class'=>$gbp_class,

    'CNY'=>$cny['Value'],
    'CNY_change'=>$cny_change,
    'CNY_class'=>$cny_class,

    'MOEX'=>$imoex_value,
    'MOEX_change'=>$imoex_change,
    'MOEX_class'=>$imoex_class,
);
echo json_encode($data);
?>
    