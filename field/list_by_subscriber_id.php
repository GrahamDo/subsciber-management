<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/field.php';

$database = new Database();
$db = $database->getConnection();

$field = new Field($db);
$results = $field->listBySubscriberId($_GET["subscriber_id"]);

$arr = array();
$arr["records"] = array();

// fetch() is more performant than fetchAll():
// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
// GD: I'm not sure exactly what this means, or if it's actually valid in the
//     version of PHP I'm using, but I found this in a tutorial.
while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $item = array(
        "id" => $id,
        "title" => $title,
        "type" => $type,
        "type_text" => $field->getTypeText($type)
    );
    array_push($arr["records"], $item);
}

echo json_encode($arr);
