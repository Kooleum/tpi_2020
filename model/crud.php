<?php

/**
 * @author Benzonana Alexandre
 * @version 1.0
 * @date 25.05.2020
 * @class IFA-P3B
 * @title eiTicky
 * @description Support ticket app for CFPT teacher
 */

require 'model/dbIdentifiers.php';

/**
 * create the connection to the database
 * @return PDO connection to the database
 */
function getConnexion()
{
    static $db = null;

    if ($db === null) {
        try {
            $connexionString = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . '';
            $db = new PDO($connexionString, DB_USER, DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    return $db;
}

//Transaction functions
function startTransaction()
{
    getConnexion()->beginTransaction();
}

function rollBackTransaction()
{
    getConnexion()->rollback();
}

function commitTransaction()
{
    getConnexion()->commit();
}


//Requests functions

/**
 * Get all the request that the db contain
 * @return array All the requests in the db
 */
function getAllRequests()
{
    $connexion = getConnexion();
    $req = $connexion->prepare("SELECT idRequest, titleRequest, datetimeRequest, typeRequest, levelRequest, descriptionRequest, statusRequest, idUserFrom, idUserTo, idLocation FROM requests");
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get all the open requests in the db
 * @return array All the open requests
 */
function getOpenRequests()
{
    $connexion = getConnexion();
    $req = $connexion->prepare("SELECT idRequest, titleRequest, datetimeRequest, typeRequest, levelRequest, descriptionRequest, statusRequest, idUserFrom, idUserTo, idLocation FROM requests WHERE statusRequest != 'done'");
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get all the open requests in the db for a specific admin
 * @param int id of the admin
 * @return array All the open requests of specified admin
 */
function getOpenAdminRequest($adminId)
{
    $connexion = getConnexion();
    $req = $connexion->prepare("SELECT idRequest, titleRequest, datetimeRequest, typeRequest, levelRequest, descriptionRequest, statusRequest, idUserFrom, idUserTo, idLocation FROM requests WHERE statusRequest != 'done' AND idUserTo = :idAdmin");
    $req->bindParam(":idAdmin", $adminId, PDO::PARAM_INT);
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get all the open requests thath are unowned in the db 
 * @return array All the open requests thaht are unowned
 */
function getOpenUnownedRequest()
{
    $connexion = getConnexion();
    $req = $connexion->prepare("SELECT idRequest, titleRequest, datetimeRequest, typeRequest, levelRequest, descriptionRequest, statusRequest, idUserFrom, idUserTo, idLocation FROM requests WHERE statusRequest != 'done' AND idUserTo is null");
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get all the medias uploaded with the request
 * @param int id of the request
 * @return array All the medias of the given requests
 */
function getRequestMedias($idRequest)
{
    $connexion = getConnexion();
    $req = $connexion->prepare("SELECT idMedia, datetimeMedia, pathMedia, fileName, extenssion, originalFileName FROM medias WHERE idRequest = :idRequest");
    $req->bindParam(":idRequest", $idRequest, PDO::PARAM_INT);
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get all the tasks associated with the request
 * @param int id of the request
 * @return array All the tasks of the given requests
 */
function getRequestTasks($idRequest)
{
    $connexion = getConnexion();
    $req = $connexion->prepare("SELECT idTask, datetimeTask, statusTask, endDateValued, realEndDate, commentTask, managedBy FROM tasks WHERE idRequest = :idRequest");
    $req->bindParam(":idRequest", $idRequest, PDO::PARAM_INT);
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get data associated with the request
 * @param int id of the request
 * @return array All the tasks of the given requests
 */
function getRequestById($idRequest)
{
    $connexion = getConnexion();
    $req = $connexion->prepare("SELECT idRequest, titleRequest, datetimeRequest, typeRequest, levelRequest, descriptionRequest, statusRequest, idUserFrom, idUserTo, idLocation FROM requests WHERE idRequest = :idRequest");
    $req->bindParam(":idRequest", $idRequest, PDO::PARAM_INT);
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC)[0];
}

/**
 * Add a request with the given params
 * @param string the title of the request
 * @param string the request type from given choices (software, hardware, other)
 * @param string the level of emergency from given choices (low, medium, high)
 * @param string detailed description of the request
 * @param int id of the user who created the request
 * @param int id of the user who the request is for (can be "null")
 * @param int id of the location for the request (can be "null")
 * @return bool query status 
 */
function addRequest(string $titleRequest, string $typeRequest, string $levelRequest, string $descriptionRequest, int $idUserFrom, $idUserTo, $idLocation)
{
    try {
        $dateRequest = date("Y-m-d H-i-s");
        $connexion = getConnexion();
        $req = $connexion->prepare("INSERT INTO requests (`titleRequest`, `datetimeRequest`, `typeRequest`, `levelRequest`, `descriptionRequest`, `statusRequest`, `idUserFrom`, `idUserTo`, `idLocation`) VALUES (:titleRequest, :timeRequest, :typeRequest, :levelRequest, :descriptionRequest, 'waiting', :idUserFrom, :idUserTo, :idLocation)");
        $req->bindParam(":titleRequest", $titleRequest, PDO::PARAM_STR);
        $req->bindParam(":timeRequest", $dateRequest, PDO::PARAM_STR);
        $req->bindParam(":typeRequest", $typeRequest, PDO::PARAM_STR);
        $req->bindParam(":levelRequest", $levelRequest, PDO::PARAM_STR);
        $req->bindParam(":descriptionRequest", $descriptionRequest, PDO::PARAM_STR);
        $req->bindParam(":idUserFrom", $idUserFrom, PDO::PARAM_INT);
        if ($idUserTo == "null") {
            $req->bindParam(":idUserTo", $idUserTo, PDO::PARAM_NULL);
        } else {
            $req->bindParam(":idUserTo", $idUserTo, PDO::PARAM_INT);
        }
        if ($idLocation == "null") {
            $req->bindParam(":idLocation", $idLocation, PDO::PARAM_NULL);
        } else {
            $req->bindParam(":idLocation", $idLocation, PDO::PARAM_INT);
        }
        $req->execute();
        return true;
    } catch (Exception $e) {
        return false;
    }
    return false;
}

/**
 * Edit a request
 * @param int request id
 * @param string the title of the request
 * @param string the request type from given choices (software, hardware, other)
 * @param string the level of emergency from given choices (low, medium, high)
 * @param string detailed description of the request
 * @param string status of the reuqest from given choices (waiting, handling, done)
 * @param int id of the user who the request is for (can be "null")
 * @param int id of the location for the request (can be "null")
 * @return bool query status 
 */
function updateRequest(int $idRequest, string $titleRequest, string $typeRequest, string $levelRequest, string $descriptionRequest, string $statusRequest, $idUserTo, $idLocation)
{
    try {
        $connexion = getConnexion();
        $req = $connexion->prepare("UPDATE requests SET `titleRequest`=:titleRequest, `typeRequest`=:typeRequest, `levelRequest`=:levelRequest, `descriptionRequest`=:descriptionRequest, `statusRequest`=:statusRequest, `idUserTo`=:idUserTo, `idLocation`=:idLocation, `statusRequest`=:statusRequest WHERE idRequest = :idRequest");
        $req->bindParam(":titleRequest", $titleRequest, PDO::PARAM_STR);
        $req->bindParam(":typeRequest", $typeRequest, PDO::PARAM_STR);
        $req->bindParam(":levelRequest", $levelRequest, PDO::PARAM_STR);
        $req->bindParam(":descriptionRequest", $descriptionRequest, PDO::PARAM_STR);
        $req->bindParam(":idUserTo", $idUserTo, PDO::PARAM_INT);
        $req->bindParam(":idLocation", $idLocation, PDO::PARAM_INT);
        $req->bindParam(":statusRequest", $statusRequest, PDO::PARAM_INT);
        $req->bindParam(":idRequest", $idRequest, PDO::PARAM_INT);
        $req->execute();
        return true;
    } catch (Exception $e) {
        return false;
    }
    return false;
}

/**
 * Change the request status
 * @param int request id 
 * @param string status of the reuqest from given choices (waiting, handling, done)
 * @return bool query status 
 */
function changeRequestStatus(int $idRequest, string $status)
{
    try {
        $connexion = getConnexion();
        $req = $connexion->prepare("UPDATE `requests` SET statusRequest=:statusRequest WHERE idRequest = :idRequest");
        $req->bindParam(":statusRequest", $status, PDO::PARAM_STR);
        $req->bindParam(":idRequest", $idRequest, PDO::PARAM_INT);
        $req->execute();
        return true;
    } catch (Exception $e) {
        return false;
    }
    return false;
}

/**
 * Change admin in charge of the request
 * @param int request id 
 * @param int id of the new admin  in charge
 * @return bool query status 
 */
function changeRequestAdmin($idRequest, $idNewAdmin)
{
    try {
        $connexion = getConnexion();
        $req = $connexion->prepare("UPDATE `requests` SET idUserTo=:idNewAdmin WHERE idRequest = :idRequest");
        $req->bindParam(":idNewAdmin", $idNewAdmin, PDO::PARAM_STR);
        $req->bindParam(":idRequest", $idRequest, PDO::PARAM_INT);
        $req->execute();
        return true;
    } catch (Exception $e) {
        return false;
    }
    return false;
}

//users

/**
 * Get all users
 * @return array All users
 */
function getUsers()
{
    $connexion = getConnexion();
    $req = $connexion->prepare("SELECT idUser, lastName, firstName, email, `password`, idAdmin FROM users");
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get all admins
 * @return array All admins
 */
function getAdmins()
{
    $connexion = getConnexion();
    $req = $connexion->prepare("SELECT idUser, lastName, firstName, email, `password`, isAdmin FROM users WHERE isAdmin = '1'");
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get all non-admins
 * @return array All non-admins
 */
function getNonAdmins()
{
    $connexion = getConnexion();
    $req = $connexion->prepare("SELECT idUser, lastName, firstName, email, `password`, isAdmin FROM users WHERE isAdmin = 0");
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get all password from user email
 * @return string password
 */
function getPassword(string $email)
{
    $connexion = getConnexion();
    $req = $connexion->prepare("SELECT `password` FROM users WHERE isAdmin = 1 AND email = :email");
    $req->bindParam(":email", $email, PDO::PARAM_INT);
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC)[0]['password'];
}

/**
 * Get all user infos from email
 * @return array users info
 */
function getUserInfoFromEmail(string $email)
{
    $connexion = getConnexion();
    $req = $connexion->prepare("SELECT `idUser`, `lastName`, `firstName`, `isAdmin` FROM users WHERE email = :email");
    $req->bindParam(":email", $email, PDO::PARAM_INT);
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC)[0];
}

/**
 * Get all user infos from email
 * @return array users info
 */
function getUserInfoFromId(int $idUser)
{
    $connexion = getConnexion();
    $req = $connexion->prepare("SELECT `lastName`, `firstName`, `email`, `isAdmin` FROM users WHERE idUser = :idUser");
    $req->bindParam(":idUser", $idUser, PDO::PARAM_INT);
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC)[0];
}

//Locations

/**
 * Get all locations
 * @return array All locations
 */
function getLocations()
{
    $connexion = getConnexion();
    $req = $connexion->prepare("SELECT idLocation, building, room FROM locations");
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

//Tasks

/**
 * Get all tasks
 * @return array All tasks
 */
function getTasks()
{
    $connexion = getConnexion();
    $req = $connexion->prepare("SELECT idTask, datetimeTask, statusTask, endDateValued, realEndDate, commentTask, managedBy, idRequest FROM tasks");
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get all tasks
 * @return array All tasks
 */
function getTaskById($idTask)
{
    $connexion = getConnexion();
    $req = $connexion->prepare("SELECT datetimeTask, statusTask, endDateValued, realEndDate, commentTask, managedBy, idRequest FROM tasks WHERE idTask = :idTask");
    $req->bindParam(":idTask", $idTask, PDO::PARAM_INT);
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC)[0];
}

/**
 * Get all Admin tasks
 * @param int admin id
 * @return array All admin tasks
 */
function getAdminTasks($idAdmin)
{
    $connexion = getConnexion();
    $req = $connexion->prepare("SELECT idTask, datetimeTask, statusTask, endDateValued, realEndDate, commentTask, managedBy, idRequest FROM tasks WHERE managedBy = :idAdmin");
    $req->bindParam(":idAdmin", $idAdmin, PDO::PARAM_INT);
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get all request tasks
 * @param int admin id
 * @param int request id
 * @return array All request tasks
 */
function getAdminRequestTasks($idAdmin, $idRequest)
{
    $connexion = getConnexion();
    $req = $connexion->prepare("SELECT idTask, datetimeTask, statusTask, endDateValued, realEndDate, commentTask, managedBy, idRequest FROM tasks WHERE idRequest = :idRequest AND managedBy = :idAdmin");
    $req->bindParam(":idAdmin", $idAdmin, PDO::PARAM_INT);
    $req->bindParam(":idRequest", $idRequest, PDO::PARAM_INT);
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get all request tasks
 * @param string task status (waiting, progress, completed, canceled)
 * @return array All request tasks
 */
function getTasksByStatus($status)
{
    $connexion = getConnexion();
    $req = $connexion->prepare("SELECT idTask, datetimeTask, statusTask, endDateValued, realEndDate, commentTask, managedBy, idRequest FROM tasks WHERE statusTask = :statusTask");
    $req->bindParam(":statusTask", $status, PDO::PARAM_INT);
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Add a task to a request with the given params
 * @param string the title of the task
 * @param string detailed description of the task
 * @param string when the task will be finished
 * @param int admin who handle  the task
 * @param string status of the task (waiting, progress, completed, canceled)
 * @param int request to add the task to
 * @return bool query status 
 */
function addTask(/*string $titleRequest,*/string $descriptionTask, string $endDateValued, int $managedBy, string $statusTask, int $idRequest)
{
    try {
        $dateTask = date("Y-m-d H-i-s");
        $connexion = getConnexion();
        $req = $connexion->prepare("INSERT INTO tasks (datetimeTask, statusTask, endDateValued, commentTask, managedBy, idRequest) VALUES (:datetimeTask, :statusTask, :endDateValued, :commentTask, :managedBy, :idRequest)");
        // $req->bindParam(":titleTask", $titleTask, PDO::PARAM_STR);
        $req->bindParam(":datetimeTask", $dateTask, PDO::PARAM_STR);
        $req->bindParam(":statusTask", $statusTask, PDO::PARAM_STR);
        $req->bindParam(":endDateValued", $endDateValued, PDO::PARAM_STR);
        $req->bindParam(":commentTask", $descriptionTask, PDO::PARAM_STR);
        $req->bindParam(":managedBy", $managedBy, PDO::PARAM_INT);
        $req->bindParam(":idRequest", $idRequest, PDO::PARAM_INT);
        $req->execute();
        return true;
    } catch (Exception $e) {
        return $e;
        return false;
    }
    return false;
}

/**
 * Edit a task
 * @param int task id
 * @param string the title of the task
 * @param string detailed description of the task
 * @param string when the task will be finished
 * @param int admin who handle  the task
 * @param string status of the task (waiting, progress, completed, canceled)
 * @param int request to add the task to
 * @return bool query status 
 */
function updateTask(int $taskId, /*string $titleRequest,*/ string $descriptionTask, string $endDateValued, int $managedBy, string $statusTask, int $idRequest)
{
    try {
        $connexion = getConnexion();
        $req = $connexion->prepare("UPDATE tasks SET `statusTask`=:statusTask, `endDateValued`=:endDateValued, `commentTask`=:commentTask, `managedBy`=:managedBy, `idRequest`=:idRequest, `statusRequest`=:statusReques WHERE idTask = :idTask");
        // $req->bindParam(":titleTask", $titleTask, PDO::PARAM_STR);
        $req->bindParam(":statusTask", $statusTask, PDO::PARAM_STR);
        $req->bindParam(":endDateValued", $endDateValued, PDO::PARAM_STR);
        $req->bindParam(":commentTask", $descriptionTask, PDO::PARAM_STR);
        $req->bindParam(":managedBy", $managedBy, PDO::PARAM_INT);
        $req->bindParam(":idRequest", $idRequest, PDO::PARAM_INT);
        $req->bindParam(":idTask", $taskId, PDO::PARAM_INT);
        $req->execute();
        return true;
    } catch (Exception $e) {
        return false;
    }
    return false;
}

/**
 * Edit task status
 * @param int task id
 * @param string task status
 * @param string task real end date
 * @return bool query status
 */
function updateTaskStatus(int $idTask, string $status, $endDate = null)
{
    try {
        $connexion = getConnexion();
        $req = $connexion->prepare("UPDATE tasks SET `statusTask`=:statusTask, `realEndDate`=:endDateValued WHERE idTask = :idTask");
        $req->bindParam(":statusTask", $status, PDO::PARAM_STR);
        $req->bindParam(":idTask", $idTask, PDO::PARAM_INT);
        if ($endDate == "null") {
            $req->bindParam(":realEndDate", $endDate, PDO::PARAM_NULL);
        } else {
            $req->bindParam(":realEndDate", $endDate, PDO::PARAM_STR);
        }
        $req->execute();
        return true;
    } catch (Exception $e) {
        return false;
    }
    return false;
}

/**
 * Edit task admin
 * @param int task id
 * @param int new owner
 * @return bool query status
 */
function changeTaskAdmin(int $idTask, int $managedBy)
{
    try {
        $connexion = getConnexion();
        $req = $connexion->prepare("UPDATE tasks SET managedBy = :managedBy WHERE idTask = :idTask");
        $req->bindParam(":managedBy", $managedBy, PDO::PARAM_INT);
        $req->bindParam(":idTask", $idTask, PDO::PARAM_INT);
        $req->execute();
        return true;
    } catch (Exception $e) {
        return false;
    }
    return false;
}
