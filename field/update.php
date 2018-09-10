<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/field.php';

$database = new Database();
$db = $database->getConnection();

$field = new Field($db);
$passed_id = $_GET["id"];
$results = $field->getById($passed_id);

$row = $results->fetch(PDO::FETCH_ASSOC);
extract($row);
if ($id == null) {
    echo '{"message:":"Nothing to update!"}';
    return;
}

$passed_subscriber_id = $_GET["subscriber_id"];
$passed_title = $_GET["title"];
$passed_type = $_GET["type"];

if (!is_numeric($passed_type) || $passed_type < 0 || $passed_type > 3) {
    echo '{"message":"Invalid type"}';
    return;
}

$field->id = $passed_id;
$field->subscriber_id = $passed_subscriber_id;
$field->title = $passed_title;
$field->type = $passed_type;
if ($field->update()) {
    echo '{"message":"Field updated successfully"}';
    return;
} else {
    echo '{"message":"field failed to update"}';
    return;
}
