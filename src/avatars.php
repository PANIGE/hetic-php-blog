<?php
$id = "-1.png";
if (isset($_GET["id"]) && file_exists($_SERVER['DOCUMENT_ROOT']."/avatars/".$_GET["id"].".png")) {
    $id = $_GET["id"].".png";
}
$content = file_get_contents('./avatars/'.$id);
header('Content-Type: Image/PNG');
echo $content;