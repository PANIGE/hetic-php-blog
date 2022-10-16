<?php 
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/general_helper.php'); 
    
    $searchTerms = "%".$_GET["q"]."%"; // api/search?q=term
    $query = $pdo->prepare('SELECT username, id FROM users where username like :term');
    $query ->execute([
        ":term" => $searchTerms
    ]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($result);
    echo ($json);
?>