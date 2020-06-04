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
        "viewClosedRequests" => "viewClosedRequests",
        "requestDetails" => "requestDetails",
        "viewMedia" => "viewMedia",
        "faq" => "faq",
    ],
    "Admin" => [
        "index" => "dashboard",
        "default" => "dashboard",
        "dashboard" => "dashboard",
        "openTasks" => "openTasks",
        "viewOpenRequests" => "viewOpenAdminRequests",
        "viewClosedRequests" => "viewClosedRequests",
        "viewOpenAdminRequests" => "viewOpenAdminRequests",
        "viewMyRequests" => "viewMyRequests",
        "viewUnownedRequests" => "viewUnownedRequests",
        "changeRequestManager" => "changeRequestManager",
        "changeTaskManager" => "changeTaskManager",
        "requestDetails" => "requestDetails",
        "viewMedia" => "viewMedia",
        "changeRequestStatus" => "changeRequestStatus",
        "logout" => "logout",
        "createTask" => "createTask",
        "editRequest" => "editRequest",
        "sendMail" => "sendMail",
        "editTask" => "editTask",
        "createRequest" => "createRequest",
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
