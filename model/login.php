<?php

/**
 * @author Benzonana Alexandre
 * @version 1.0
 * @date 25.05.2020
 * @class IFA-P3B
 * @title eiTicky
 * @description Support ticket app for CFPT teacher
 */

$submited = filter_input(INPUT_POST, "submit", FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

$error = "";

if ($submited == "submited") {
    if (!empty($email) && !empty($password)) {
        $realPassword = getPassword($email);
        //verify user password and if he is admin
        if (password_verify($password, $realPassword)){
            $userInfo = getUserInfoFromEmail($email);
            $_SESSION['log']=true;
            $_SESSION['role']="Admin";
            $_SESSION['email']=$email;
            $_SESSION['id']=$userInfo['idUser'];
            $_SESSION['lasName']=$userInfo['lasName'];
            $_SESSION['firstName']=$userInfo['firstName'];
            header("Location: ?action=index");
            exit();
        }else{
            echo "false";
            $error = "<div class='alert alert-danger'>L'email ou le mot de passe est invalide ou l'email n'est pas associé à un compte admin</div>";
        }
    }else{
        $error = "<div class='alert alert-danger'>Tout les champs doivent être reiseignés</div>";
    }
}
