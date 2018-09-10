<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/field.php';

$database = new Database();
$db = $database->getConnection();

$field = new Field($db);

$passed_subscriber_id = $_GET["subscriber_id"];
$passed_title = $_GET["title"];
$passed_type = $_GET["type"];

if (!is_numeric($passed_type) || $passed_type < 0 || $passed_type > 3) {
    echo '{"message":"Invalid type"}';
    return;
}


$field->subscriber_id = $passed_subscriber_id;
$field->title = $passed_title;
$field->type = $passed_type;

if ($field->create()) {
    echo '{"message":"Field created successfully"}';
    return;
} else {
    echo '{"message":"Field failed to create (does the subscriber exist?)"}';
    return;
}
