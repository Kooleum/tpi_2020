<?php

/**
 * @author Benzonana Alexandre
 * @version 1.0
 * @date 25.05.2020
 * @class IFA-P3B
 * @title eiTicky
 * @description Support ticket app for CFPT teacher
 */

 
session_start();
require_once 'model/crud.php';

$action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);

if (isset($_SESSION['role']))
    $role = $_SESSION['role'];
else
    $role = "Anonymous";

$permission = [
    "Anonymous" => [
        "default" => "viewOpenRequests",
        "index" => "viewOpenRequests",
        "login" => "login",
        "createRequest" => "createRequest",
        "viewOpenRequests" => "viewOpenRequests",
        "faq" => "faq",
    ],
    "Admin" => [
        "default" => "viewTasks",
        "viewOpenRequests" => "viewOpenAdminRequests",
        "viewOpenAdminRequests" => "viewOpenAdminRequests",
        "viewMyRequests" => "viewMyRequests",
        "viewUnownedRequests" => "viewUnownedRequests",
        "changeRequestManager" => "changeRequestManager",
        "changeTaskManager" => "changeTaskManager",
        "requestDetails" => "requestDetails",
        "logout" => "logout",
        "createTask" => "createTask",
        "editTask" => "editTask",
        "faq" => "faq",
    ],
];

if (!array_key_exists($action, $permission[$role])) {
    $action = "default";
}

try {
    require './controller/' . $permission[$role][$action] . '.php';
} catch (Exception $e) {
}
