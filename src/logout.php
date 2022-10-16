<?php 
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/general_helper.php');
    if (is_log()) {
        $token = $_COOKIE['Authorization'];
        setcookie('Authorization', '', time() - 3600, '/');
        $r = $pdo->prepare("DELETE FROM tokens WHERE token = :tok");
        $r->execute([
            ":tok" => $token
        ]);
        http_response_code(302);
        header("location:/?es=You've%20been%20disconnected%20successfully");
    }
    else {
        http_response_code(302);
        header("location: /");
    }
    
