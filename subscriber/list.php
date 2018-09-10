<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/subscriber.php';

$database = new Database();
$db = $database->getConnection();

$subscriber = new Subscriber($db);
$results = $subscriber->list();
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
        "email_address" => $email_address,
        "name" => $name,
        "state" => $state,
        "state_text" => $subscriber->getStateText($state)
    );
    array_push($arr["records"], $item);
}

echo json_encode($arr);
