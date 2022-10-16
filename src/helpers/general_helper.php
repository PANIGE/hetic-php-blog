<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/sql_connector.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/html/html_helper.php'); 
$pdo=getPDO();

function get_user_id() {
    global $pdo;
    //Get Authorization cookie
    if(!isset($_COOKIE['Authorization'])) {
        return -1;
    }
    $auth = $_COOKIE['Authorization'];
    //if cookie is not set, return false
   
    //Checks if auth is in the database
    $stmt = $pdo->prepare("SELECT id FROM tokens WHERE token = :auth");
    $stmt->bindParam(':auth', $auth);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    //If auth is not in the database
    if ($result == null) {
        return -1;
    }
    else 
    {
        return $result['id'];
    }

}

function is_log() {
    return get_user_id() != -1;
}


function require_login() {
    if(!is_log()) {
        http_response_code(302);
        header('Location: /login.php?redir='.urlencode($_SERVER["REQUEST_URI"]));
        exit();
    }
}

function require_admin() {
    require_login();
    if (!is_admin()) {
        http_response_code(403);
        die();
    }
}


function random_string($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function is_admin() {
    $id = get_user_id();
    if($id == -1) {
        return false;
    }
    global $pdo;
    $stmt = $pdo->prepare("SELECT rank FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['rank'] == 3;
}

function get_user_data($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function id_from_username($username) {
    //get the safe username, lowercase and replace spaces by underscores
    $safe_username = safe_username($username);
    global $pdo;
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username_safe = :username_safe");
    $stmt->bindParam(':username_safe', $safe_username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //check if user exists, if not return -1
    if($result == null) {
        return -1;
    }
    return $result['id'];
}

function safe_username($username) {
    return str_replace(' ', '_', strtolower($username));
}

function context() {
    $id = get_user_id();
    $data = [
        'is_log' => is_log(),
        'is_admin' => is_admin(),
        'user_id' => $id,
        'user' => get_user_data($id)
    ];
    return $data;
}