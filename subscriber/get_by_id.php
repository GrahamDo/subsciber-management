<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/subscriber.php';

$database = new Database();
$db = $database->getConnection();

$subscriber = new Subscriber($db);
$results = $subscriber->getById($_GET["id"]);
if ($results == null) {
    echo '{"message:":"Nothing found!"}';
    return;
}

$row = $results->fetch(PDO::FETCH_ASSOC);
extract($row);
if ($id == null) {
    echo '{"message:":"Nothing found!"}';
    return;
}

$item = array(
        "id" => $id,
        "email_address" => $email_address,
        "name" => $name,
        "state" => $state,
        "state_text" => $subscriber->getStateText($state)
    );
echo json_encode($item);
