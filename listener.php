<?php
$event = json_decode(file_get_contents("php://input"));

file_put_contents('received.json', print_r($event, true));
