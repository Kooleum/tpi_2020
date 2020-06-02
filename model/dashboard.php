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

$emergencyOpen = count(getRequestByAdminLevelStatus(1, "high", "open"));
$emergencyClosed = count(getRequestByAdminLevelStatus(1, "high", "closed"));
$meduimOpen = count(getRequestByAdminLevelStatus(1, "medium", "open"));
$meduimClosed = count(getRequestByAdminLevelStatus(1, "medium", "closed"));
$lowOpen = count(getRequestByAdminLevelStatus(1, "low", "open"));
$lowClosed = count(getRequestByAdminLevelStatus(1, "low", "closed"));
$unownedRequests = count(getOpenUnownedRequest());
$openTasks = 0;
$closedTasks = 0;
