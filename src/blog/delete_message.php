<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/general_helper.php');
if (!is_log()){
    die();
}

$post = $_GET["id"];
//Get the post author
$query = $pdo->prepare('SELECT author, blog FROM posts WHERE id = :id;');
$query->execute([
    ":id" => $post,
]);
if ($query->rowCount() == 0) {
    http_response_code(302);
    header("location:/blog/?id=".$blog."&er=Post%20not%20found");
    die();
}
$result = $query->fetch();
$author = $result["author"];
if ($author != get_user_id() || !is_admin()) {
    http_response_code(403);
    die();
}

$blog = $result["blog"];

$query = $pdo->prepare('DELETE FROM posts WHERE id = :id ');
$query->execute([
    ":id" => $post,
]);
http_response_code(302);
header("location:/blog/?id=".$blog);

