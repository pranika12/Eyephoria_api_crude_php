<?php
include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php'

$tokenCheck=checkIfAdmin($_GET['token']??null);
if($isAdmin){
    if(isset($_GET['token']) && $tokenCheck != null){
            $userId=$tokenCheck;
    }
}