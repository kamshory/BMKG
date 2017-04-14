## BMKG API

BMKG API is an API to get realtime weather forecast and earthquake history from [BMKG | Badan Meteorologi, Klimatologi, dan Geofisika](http://www.bmkg.go.id).

### Features

- earthquake
- weather forecast

### Output

Each APIs return output as JSON format

#### Earthquake

<?php
require('lib/bmkg.php');

$bmkg = new BMKG();

$data = $bmkg->earthquake();

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
echo json_encode($data, JSON_PRETTY_PRINT);
?>

#### Weather

<?php
$province_id = $_GET['province_id'];
require('lib/bmkg.php');

$bmkg = new BMKG();

$data = $bmkg->weather($province_id);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
echo json_encode($data, JSON_PRETTY_PRINT);
?>

Province ID is a string contain ID of the province and listed bellow:

- 01 = Aceh
- 02 = Bali
- 03 = Bangka Belitung
- 04 = Banten
- 05 = Bengkulu
- 06 = DI Yogyakarta
- 07 = DKI Jakarta
- 08 = Gorontalo
- 09 = Jambi
- 10 = Jawa Barat
- 11 = Jawa Tengah
- 12 = Jawa Timur
- 13 = Kalimantan Barat
- 14 = Kalimantan Selatan
- 15 = Kalimantan Tengah
- 16 = Kalimantan Timur
- 17 = Kalimantan Utara
- 18 = Kepulauan Riau
- 19 = Lampung
- 20 = Maluku
- 21 = Maluku Utara
- 22 = Nusa Tenggara Barat
- 23 = Nusa Tenggara Timur
- 24 = Papua
- 25 = Papua Barat
- 26 = Riau
- 27 = Sulawesi Barat
- 28 = Sulawesi Selatan
- 29 = Sulawesi Tengah
- 30 = Sulawesi Tenggara
- 31 = Sulawesi Utara
- 32 = Sumatera Barat
- 33 = Sumatera Selatan
- 34 = Sumatera Utara
- 35 = Indonesia

If province ID is provided, API will show data of big cities in selected province.

If province ID is not provided, API will show data of big cities in Indonesia.

