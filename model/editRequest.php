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

$requestId = filter_input(INPUT_GET, "idRequest", FILTER_SANITIZE_NUMBER_INT);

//form data treatement
$titleRequest = filter_input(INPUT_POST, "titleRequest", FILTER_SANITIZE_STRING);
$descriptionRequest = filter_input(INPUT_POST, "descriptionRequest", FILTER_SANITIZE_STRING);
$type = filter_input(INPUT_POST, "type", FILTER_SANITIZE_STRING);
$emergencyLevel = filter_input(INPUT_POST, "emergencyLevel", FILTER_SANITIZE_STRING);
$userTo = filter_input(INPUT_POST, "userTo", FILTER_SANITIZE_STRING);
$location = filter_input(INPUT_POST, "location", FILTER_SANITIZE_STRING);
$submit = filter_input(INPUT_POST, "submit", FILTER_SANITIZE_STRING);



if ($submit == "submited" || is_numeric($requestId)) {

    $request = getRequestById($requestId);

    //if the from as been submited inserting given datas in database with erro handing and 
    if ($submit == "submited") {
        if ($titleRequest && $descriptionRequest && $type && $emergencyLevel && $userTo) {
            try {
                startTransaction();
                if (!updateRequest($requestId, $titleRequest, $type, $emergencyLevel, $descriptionRequest, $userTo, $location)) {
                    //if an error append during inserting 
                    throw new Exception("Errer while executing sql query");
                }
                commitTransaction();
                header("Location: ?action=viewMyRequests");
                exit();
            } catch (Exception $e) {
                $error = "<div class='alert alert-danger'>Une erreure est survenue</div>";
            }
        } else {
            rollBackTransaction();
            $error = "<div class='alert alert-danger'>Un ou plusieurs champs obligatoires n'ont pas été renseignés</div>";
        }
    } else {
        // fill form with existing datas
        $titleRequest = $request['titleRequest'];
        $descriptionRequest = $request['descriptionRequest'];
        $type =  $request['typeRequest'];
        $emergencyLevel =  $request['levelRequest'];
        $userTo =  $request['idUserTo'];
        $location =  $request['idLocation'];
    }
} else {
    header("Location: ?action=viewMyRequests");
    exit();
}

/**
 * Create options for select form with all admins (select options)
 * @return string all the options 
 */
function getAdminsOption()
{
    global $userTo;

    $admins = getAdmins();

    $options = "";

    foreach ($admins as $admin) {
        $name = $admin['lastName'] . " " . $admin['firstName'] . " - " . $admin['email'];
        $value = $admin['idUser'];
        if ($userTo == $value) {
            $options .= "<option value='$value' selected>$name</option>";
        } else {
            $options .= "<option value='$value'>$name</option>";
        }
    }
    return $options;
}

/**
 * Create options for select form with all locations
 * @return string all the options 
 */
function getLocationsOption()
{
    global $location;

    $locations = getLocations();

    $options = "";

    foreach ($locations as $location) {
        $name = $location['building'] . " - " . $location['room'];
        $value = $location['idLocation'];
        if ($location == $value) {
            $options .= "<option value='$value' selected>$name</option>";
        } else {
            $options .= "<option value='$value'>$name</option>";
        }
    }
    return $options;
}
