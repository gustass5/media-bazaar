<?php

if(!isset($_SESSION)) { 
    session_start(); 
} 

require_once 'core/config.php';


function checkLoggedIn($redirect = true){
    if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in'])){
        if($redirect){
            header('Location: login.php');
            exit;
        }else{
            return false;
        }
    }

    return true;
}

function fetchUserData($userId, $sql){
    Global $pdo;
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':user_id', $userId);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    return $user;
}


?>