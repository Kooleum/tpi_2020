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
function getAllRequests(){
    $connexion = getConnexion();
    $req = $connexion->prepare("SELECT idRequest, titleRequest, datetimeRequest, typeRequest, levelRequest, descriptionRequest, statusRequest, idUserFrom, idUserTo, idLocation FROM requests");
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get all the open requests in the db
 * @return array All the open requests
 */
function getOpenRequests(){
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
function getOpenAdminRequest($adminId){    
    $connexion = getConnexion();
    $req = $connexion->prepare("SELECT idRequest, titleRequest, datetimeRequest, typeRequest, levelRequest, descriptionRequest, statusRequest, idUserFrom, idUserTo, idLocation FROM requests WHERE statusRequest != 'done' AND idUserTo = :idAdmin");
    $req->bindParam(":idAdmin", $adminId, PDO::PARAM_INT);
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get all the medias uploaded with the request
 * @param int id of the request
 * @return array All the medias of the given requests
 */
function getRequestMedias($idRequest){    
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
function getRequestTasks($idRequest){    
    $connexion = getConnexion();
    $req = $connexion->prepare("SELECT idTask, datetimeTask, statusTask, endDateValued, realEndDate, commentsTask, managedBy FROM tasks WHERE idRequest = :idRequest");
    $req->bindParam(":idRequest", $idRequest, PDO::PARAM_INT);
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
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
function addRequest($titleRequest, $typeRequest, $levelRequest, $descriptionRequest, $idUserFrom, $idUserTo, $idLocation){
    try{
        $dateRequest = date("Y-m-d");
        $connexion = getConnexion();
        $req = $connexion->prepare("INSERT INTO requests (`titleRequest`, `datetimeRequest`, `typeRequest`, `levelRequest`, `descriptionRequest`, `statusRequest`, `idUserFrom`, `idUserTo`, `idLocation`) VALUES (:titleRequest, :timeRequest, :typeRequest, :levelRequest, :descriptionRequest, 'waiting', :idUserFrom, :idUserTo, :idLocation)");
        $req->bindParam(":titleRequest", $titleRequest, PDO::PARAM_STR);
        $req->bindParam(":timeRequest", $dateRequest, PDO::PARAM_STR);
        $req->bindParam(":typeRequest", $typeRequest, PDO::PARAM_STR);
        $req->bindParam(":levelRequest", $levelRequest, PDO::PARAM_STR);
        $req->bindParam(":descriptionRequest", $descriptionRequest, PDO::PARAM_STR);
        $req->bindParam(":idUserFrom", $idUserFrom, PDO::PARAM_INT);
        $req->bindParam(":idUserTo", $idUserTo, PDO::PARAM_INT);
        $req->bindParam(":idLocation", $idLocation, PDO::PARAM_INT);
        $req->execute();
        return true;
    }catch(Exception $e){
        return false;
    }
    return false;
}

/**
 * Edit a request
 * @param string the title of the request
 * @param string the request type from given choices (software, hardware, other)
 * @param string the level of emergency from given choices (low, medium, high)
 * @param string detailed description of the request
 * @param string status of the reuqest from given choices (waiting, handling, done)
 * @param int id of the user who the request is for (can be "null")
 * @param int id of the location for the request (can be "null")
 * @return bool query status 
 */
function updateRequest($titleRequest, $typeRequest, $levelRequest, $descriptionRequest, $statusRequest, $idUserTo, $idLocation){
    try{
        $connexion = getConnexion();
        $req = $connexion->prepare("UPDATE requests SET `titleRequest`=:titleRequest, `typeRequest`=:typeRequest, `levelRequest`=:levelRequest, `descriptionRequest`=:descriptionRequest, `statusRequest`=:statusRequest, `idUserTo`=:idUserTo, `idLocation`=:idLocation, `statusRequest`=:statusRequest");
        $req->bindParam(":titleRequest", $titleRequest, PDO::PARAM_STR);
        $req->bindParam(":typeRequest", $typeRequest, PDO::PARAM_STR);
        $req->bindParam(":levelRequest", $levelRequest, PDO::PARAM_STR);
        $req->bindParam(":descriptionRequest", $descriptionRequest, PDO::PARAM_STR);
        $req->bindParam(":idUserTo", $idUserTo, PDO::PARAM_INT);
        $req->bindParam(":idLocation", $idLocation, PDO::PARAM_INT);
        $req->bindParam(":statusRequest", $statusRequest, PDO::PARAM_INT);
        $req->execute();
        return true;
    }catch(Exception $e){
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
function changeRequestStatus($idRequest, $status){
    try{
        $connexion = getConnexion();
        $req = $connexion->prepare("UPDATE `requests` SET statusRequest=:statusRequest WHERE idRequest = :idRequest");
        $req->bindParam(":statusRequest", $status, PDO::PARAM_STR);
        $req->bindParam(":idRequest", $idRequest, PDO::PARAM_INT);
        $req->execute();
        return true;
    }catch(Exception $e){
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
function changeRequestAdmin($idRequest, $idNewAdmin){
    try{
        $connexion = getConnexion();
        $req = $connexion->prepare("UPDATE `requests` SET idUserTo=:idNewAdmin WHERE idRequest = :idRequest");
        $req->bindParam(":idNewAdmin", $idNewAdmin, PDO::PARAM_STR);
        $req->bindParam(":idRequest", $idRequest, PDO::PARAM_INT);
        $req->execute();
        return true;
    }catch(Exception $e){
        return false;
    }
    return false;
}
