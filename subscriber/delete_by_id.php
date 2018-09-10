<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/subscriber.php';

$database = new Database();
$db = $database->getConnection();

$subscriber = new Subscriber($db);
$passed_id = $_GET["id"];
$results = $subscriber->getById($passed_id);

$row = $results->fetch(PDO::FETCH_ASSOC);
extract($row);
if ($id == null) {
    echo '{"message:":"Nothing to delete!"}';
    return;
}

$subscriber->deleteById($_GET["id"]);

echo '{"message:":"Done"}';
