<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/field.php';

$database = new Database();
$db = $database->getConnection();

$field = new Field($db);
$results = $field->getById($_GET["id"]);

$row = $results->fetch(PDO::FETCH_ASSOC);
extract($row);
if ($id == null) {
    echo '{"message:":"Nothing found!"}';
    return;
}

$item = array(
        "id" => $id,
        "subscriber_id" => $subscriber_id,
        "title" => $title,
        "type" => $type,
        "type_text" => $field->getTypeText($state)
    );
echo json_encode($item);
