<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/general_helper.php');
if (!is_log()){
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blog = filter_input(INPUT_POST, "blog");
    $files = $_FILES["file"];
    $content = filter_input(INPUT_POST, "content");
    $user = context()["user"];
    $id = $user["id"];
    $query = $pdo->prepare('INSERT INTO posts (`content`, `blog`, `author`, `unix`) VALUES (:content, :blog, :author, :unix);');
    $query->execute([
        ":content" => $content,
        ":blog" => $blog,
        ":author" => $id,
        ":unix" => time(),
    ]);
    $post_id = $pdo->lastInsertId();

    //Get all file md5 then store them into attachements folder
    $countfiles = count($_FILES['file']['name']);
    if ($_FILES['file']['name'][0] != "") {
        for($i=0;$i<$countfiles;$i++){
            $filename = $_FILES['file']['name'][$i];
            $file = $_FILES['file']['tmp_name'][$i];
            $md5 = md5_file($file);
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $filename = $md5.".".$ext;
            move_uploaded_file($file, $_SERVER['DOCUMENT_ROOT']."/attachements/".$md5.".".$ext);
            //store attachement into the Attachements table
            $query = $pdo->prepare('INSERT INTO attachements (`post_id`, `url`) VALUES (:post, :url);');
            $query->execute([
                ":post" => $post_id,
                ":url" => "/attachements/".$md5.".".$ext,
            ]);
        }
    }
    
    http_response_code(302);
    header("location:/blog/?id=".$blog);
}
else {
    http_response_code(302);
    header("location:/blog/?id=".$blog."&er=You%20are%20logged%20in");
}