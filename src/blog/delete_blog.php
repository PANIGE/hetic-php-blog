<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/general_helper.php');
if (!is_log()){
    die();
}

$blog = $_GET["id"];
//Get the blog owner
$query = $pdo->prepare('SELECT owner FROM blogs WHERE id = :id;');
$query->execute([
    ":id" => $blog,
]);
if ($query->rowCount() == 0) {
    http_response_code(302);
    header("location:/blog/list.php?er=Blog%20not%20found");
    die();
}
$result = $query->fetch();
$owner = $result["owner"];
if ($owner != get_user_id() || !is_admin()) {
    http_response_code(403);
    die();
}


$query = $pdo->prepare('DELETE FROM blogs WHERE id = :id ');
$query->execute([
    ":id" => $blog,
]);
http_response_code(302);
header("location:/blog/list.php");

