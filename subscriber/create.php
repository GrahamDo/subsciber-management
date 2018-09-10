<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/subscriber.php';

$database = new Database();
$db = $database->getConnection();

$subscriber = new Subscriber($db);

$passed_email_address = $_GET["email_address"];
$passed_name = $_GET["name"];
$passed_state = $_GET["state"];

if (!$subscriber->doesEmailDomainExist($passed_email_address)) {
    echo '{"message":"E-mail address not valid"}';
    return;
}
if ($passed_name === "") {
    $passed_name = null;
}
if (!is_numeric($passed_state) || $passed_state < 0 || $passed_state > 4) {
    echo '{"message":"Invalid state"}';
    return;
}

$subscriber->email_address = $passed_email_address;
$subscriber->name = $passed_name;
$subscriber->state = $passed_state;
if ($subscriber->create()) {
    echo '{"message":"Subscriber created successfully"}';
    return;
} else {
    echo '{"message":"Subscriber failed to create"}';
    return;
}
