<?php
session_start();
require_once 'model/crud.php';

$action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);

if (isset($_SESSION['role']))
    $role = $_SESSION['role'];
else
    $role = "Anonymous";

$permission = [
    "Anonymous" => [
        "default" => "index",
        "login" => "login",
        "createRequest" => "createRequest",
        "ViewOpenRequests" => "ViewOpenRequests",
    ],
    "Admin" => [
        "default" => "index",
        "logout" => "logout",
        "createTask" => "createTask",
        "editTask" => "editTask",
    ],
];

if (!array_key_exists($action, $permission[$role])) {
    $action = "default";
}

try {
    require './controller/' . $permission[$role][$action] . '.php';
} catch (Exception $e) {
}
