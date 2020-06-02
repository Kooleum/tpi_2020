<?php

/**
 * @author Benzonana Alexandre
 * @version 1.0
 * @date 25.05.2020
 * @class IFA-P3B
 * @title eiTicky
 * @description Support ticket app for CFPT teacher
 */

$error = "";

//get stats from db
$emergencyOpen = count(getRequestByAdminLevelStatus($_SESSION['id'], "high", "open"));
$emergencyClosed = count(getRequestByAdminLevelStatus($_SESSION['id'], "high", "closed"));
$meduimOpen = count(getRequestByAdminLevelStatus($_SESSION['id'], "medium", "open"));
$meduimClosed = count(getRequestByAdminLevelStatus($_SESSION['id'], "medium", "closed"));
$lowOpen = count(getRequestByAdminLevelStatus($_SESSION['id'], "low", "open"));
$lowClosed = count(getRequestByAdminLevelStatus($_SESSION['id'], "low", "closed"));
$unownedRequests = count(getOpenUnownedRequest());
$openTasks = count(getAdminTasks($_SESSION['id'], "open"));
$closedTasks = count(getAdminTasks($_SESSION['id'], "cloed"));
$lateTasks = count(getLateTasksByIdAdmin($_SESSION['id']));
