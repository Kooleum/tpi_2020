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


