<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/subscriber.php';

$database = new Database();
$db = $database->getConnection();

$subscriber = new Subscriber($db);
$subscriber->deleteById($_GET["id"]);

echo '{"message:":"Done"}';
