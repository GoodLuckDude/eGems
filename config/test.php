<?php

require_once './database.php';
require_once '../func/common.php';

// $array = DB::run("SELECT ARRAY['Корунд', 'Топаз', 'Алмаз']")->fetch(PDO::FETCH_NUM);

$array = array('Корунд', "Топаз", "Алмаз", "Кварц");
var_export($array);

$array = json_encode($array);
echo "\n";
var_export($array);
echo "\n";
$array = json_decode($array);
var_export($array);
?>