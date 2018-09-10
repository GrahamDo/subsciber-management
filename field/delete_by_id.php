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
    echo '{"message:":"Nothing to delete!"}';
    return;
}

$field->deleteById($_GET["id"]);

echo '{"message:":"Done"}';
