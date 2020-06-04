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


//if the from as been submited inserting given datas in database with erro handing and 
if ($submit == "submited") {
    if ($titleRequest && $descriptionRequest && $type && $emergencyLevel && $userFrom) {
        $movedFiles = ['files' => [], 'paths' => []];
        try {
            $totalSize = 0;
            foreach ($_FILES["medias"]["size"] as $s) $totalSize += $s;

            //if files size  is to high
            if ($totalSize > 70000000) {
                $error = "<div class='alert alert-success'>La taille totale des fichiers est trop importante</div>";
            } else {
                $fileError = null;
                $files = $_FILES["medias"];

                //if files are uploaded
                if (!(count($files['name']) == 1 && $files['size'][0] == 0)) {
                    foreach ($files['tmp_name'] as $key => $file) {
                        $mimeType =  mime_content_type($file);
                        $fileType = explode("/", $mimeType);
                        if ($fileType[0] == "image" || $mimeType == "application/pdf") {
                            //create uniq file name
                            $newFileName = md5($files['name'][$key] . uniqid() . date('Y-m-d H:i:s')) . "." . $fileType[1];
                            if (move_uploaded_file($file, "files/" . $fileType[0] . "/" . $newFileName)) {
                                array_push($movedFiles['files'], ['path' => "files/" . $fileType[0] . "/" . $newFileName, 'originalName' => $files['name'][$key], 'newName' => $newFileName, 'mime' => $mimeType, 'extension' => $fileType[1]]);
                                array_push($movedFiles['paths'], "files/" . $fileType[0] . "/" . $newFileName);
                            } else {
                                $fileError = "error";
                                break;
                            }
                        } else {
                            $fileError = "incorectType";
                            break;
                        }
                    }
                }
                //if no errors with files
                if ($fileError == null) {
                    startTransaction();
                    if (addRequest($titleRequest, $type, $emergencyLevel, $descriptionRequest, $userFrom, $userTo, $location)) {
                        $idRequest = lasInsertId();
                        if (is_numeric($idRequest)) {
                            foreach ($movedFiles['files'] as $key => $file) {
                                if (!addRequestMedia($idRequest, $file['originalName'], $file['newName'], $file['path'], $file['extension'], $file['mime'])) {
                                    //if an error append during inserting 
                                    throw new Exception("Errer while executing sql query");
                                }
                            }
                        } else {
                            //if an error append during inserting 
                            throw new Exception("Errer while executing sql query");
                        }
                    } else {
                        //if an error append during inserting 
                        throw new Exception("Errer while executing sql query");
                    }
                    commitTransaction();


                    include "model/mailer.php";

                    $error = "<div class='alert alert-success'>La demande à été soumise</div>";
                } else {
                    //generic error
                    $error = "<div class='alert alert-danger'>Erreur au niveau du traitement de fichier</div>";
                    //specific errror
                    if ($fileError == "incorectType") {
                        $error = "<div class='alert alert-danger'>Un ou plusieurs de vos fichier sont d'un type n'étant pas pris en charge</div>";
                    }
                    foreach ($movedFiles['paths'] as $file) {
                        unlink($file);
                    }
                }
            }
        } catch (Exception $e) {
            $error = "<div class='alert alert-danger'>Une erreure est survenue</div>";
            rollBackTransaction();
            foreach ($movedFiles['paths'] as $file) {
                unlink($file);
            }
        }
    } else {
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
 * Create options for select form with all users (select from)
 * @return string all the options 
 */
function getUsersOption()
{
    $users = getUsers();

    $options = "";

    foreach ($users as $user) {
        $name = $user['lastName'] . " " . $user['firstName'] . " - " . $user['email'];
        $name .= $user['isAdmin'] ? ' (Admin)' : '';
        $value = $user['idUser'];
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
