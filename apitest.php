<?php

$datas1 = ["un" => "hello",
    "deux" => "hello lolo"];


$datas2 = ["un" => "salute",
    "deux" => "saloperie"];


$datas3 = ["un" => "kkchose",
    "deux" => "kelkechoseu"];


$array = [$datas1, $datas2, $datas3];


$bodyRequest = file_get_contents('php://input');

$values = json_decode($bodyRequest, true);

if(!empty($values['truc']) && $values['truc'] == "machin") {

    header('Access-Control-Allow-Origin: *');

    echo json_encode($array);
} else {
    header('Access-Control-Allow-Origin:*');
    echo json_encode("no");
}


?>