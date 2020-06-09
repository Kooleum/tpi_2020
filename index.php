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

//<first install proced
if (file_exists("installation/index.php")) {
    if (!isset($_SESSION['install_step'])) {
        $_SESSION['install_step'] = 1;
    }
    if ($_SESSION['install_step'] == 2) {
        include("installation/setMailer.php");
        exit();
    } elseif ($_SESSION['install_step'] == 3) {
        include("installation/setUser.php");
        exit();
    } elseif ($_SESSION['install_step'] == 1) {
        include("installation/index.php");
        exit();
    } elseif ($_SESSION['install_step'] == "done") {
        if (is_dir(__DIR__ . "installation")) {
            rmdir(__DIR__ . "/installation");
        }
        $_SESSION = array();
        header("Refresh:0");
        exit();
    }
    exit();
}

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
