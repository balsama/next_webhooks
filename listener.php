<?php
$secret = 'webhooksecret'; // Change this to match the config on the dispatcher.
$event = file_get_contents("php://input");

$theirHash = $_SERVER['HTTP_X_HUB_SIGNATURE_256'];
$myHash = 'sha256=' . hash_hmac('sha256', $event, $secret, FALSE);

if ($myHash !== $theirHash) {
    http_response_code(403);
    echo 'Unable to validate webhook origin.';
    exit;
}

http_response_code(202);

$event = json_decode($event);
$updated_content = [
    'content_type' => $event->entity->type[0]->target_id,
    'uuid' =>  $event->entity->uuid[0]->value,
    'path_alias' => $event->entity->path[0]->alias,
];

file_put_contents('received.txt', print_r($updated_content, true), FILE_APPEND);
exit;