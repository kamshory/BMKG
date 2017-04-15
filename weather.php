<?php
$province_id = substr(trim(strip_tags(@$_GET['province_id'])), 0, 2);
require('lib/bmkg.php');

$bmkg = new BMKG();

$data = $bmkg->weather($province_id);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
echo json_encode($data, JSON_PRETTY_PRINT);
?>
