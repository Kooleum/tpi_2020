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

//form data treatement
$titleRequest = filter_input(INPUT_POST, "titleRequest", FILTER_SANITIZE_STRING);
$descriptionRequest = filter_input(INPUT_POST, "descriptionRequest", FILTER_SANITIZE_STRING);
$type = filter_input(INPUT_POST, "type", FILTER_SANITIZE_STRING);
$emergencyLevel = filter_input(INPUT_POST, "emergencyLevel", FILTER_SANITIZE_STRING);
$userFrom = filter_input(INPUT_POST, "userFrom", FILTER_SANITIZE_STRING);
$userTo = filter_input(INPUT_POST, "userTo", FILTER_SANITIZE_STRING);
$location = filter_input(INPUT_POST, "location", FILTER_SANITIZE_STRING);
$submit = filter_input(INPUT_POST, "submit", FILTER_SANITIZE_STRING);

// $files = $_FILES["uploadedFile"];
// $totalSize = 0;
// foreach($_FILES["uploadedFile"]["size"] as $s) $totalSize += $s;

//if the from as been submited inserting given datas in database with erro handing and 
if ($submit == "submited") {
    if ($titleRequest && $descriptionRequest && $type && $emergencyLevel && $userFrom) {
        try {
            startTransaction();
            if(addRequest($titleRequest, $type, $emergencyLevel, $descriptionRequest, $userFrom, $userTo, $location)){

            }else{
                //if an error append during inserting 
                throw new Exception("Errer while executing sql query");
            }
            commitTransaction();
            $error = "<div class='alert alert-success'>La demande à été soumise</div>";
        } catch (Exception $e) {
            $error = "<div class='alert alert-danger'>Une erreure est survenue</div>";
        }
    } else {
        rollBackTransaction();
        $error = "<div class='alert alert-danger'>Un ou plusieurs champs obligatoires n'ont pas été renseignés</div>";
    }
}

/**
 * Create options for select form with all admins (select options)
 * @return string all the options 
 */
function getAdminsOption()
{
    $admins = getAdmins();

    $options = "";

    foreach ($admins as $admin) {
        $name = $admin['lastName'] . " " . $admin['firstName'] . " - " . $admin['email'];
        $value = $admin['idUser'];
        $options .= "<option value='$value'>$name</option>";
    }
    return $options;
}

/**
 * Create options for select form with all non-admins (select from)
 * @return string all the options 
 */
function getNonAdminsOption()
{
    $nonAdmins = getNonAdmins();

    $options = "";

    foreach ($nonAdmins as $nonAdmin) {
        $name = $nonAdmin['lastName'] . " " . $nonAdmin['firstName'] . " - " . $nonAdmin['email'];
        $value = $nonAdmin['idUser'];
        $options .= "<option value='$value'>$name</option>";
    }
    return $options;
}

/**
 * Create options for select form with all locations
 * @return string all the options 
 */
function getLocationsOption()
{
    $locations = getLocations();

    $options = "";

    foreach ($locations as $location) {
        $name = $location['building'] . " - " . $location['room'];
        $value = $location['idLocation'];
        $options .= "<option value='$value'>$name</option>";
    }
    return $options;
}
