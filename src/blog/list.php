<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/general_helper.php'); 
html_header("blogs.jpg", "Blogs", -50, "Blogs");

if (is_log()) {
    ?>
    
        <a style="width:100%" class="ui blue inverted button" href="/blog/new.php">Create</a> 
    
    <?php
}

    $blogs=$pdo->prepare('SELECT b.id, b.owner, b.name, b.description, u.username owner_name FROM blogs b LEFT JOIN users u ON b.owner = u.id;');
    $blogs->execute();
    $data= $blogs->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $t) { 
        ?>
        <div class="ui segment">
            
            <a style="float:right"class="ui blue inverted button" href="/blog/?id=<?= $t['id'] ?>">See</a> 
            <div style="font-size:20px">
                <img style="height:1em;margin-bottom:-.16em;border-radius: 500rem;" src="/avatars.php?id=<?= $t["owner"] ?>"> 
                <span><?= $t['owner_name'] ?></span>
            </div>
            <div style="margin-top: 2em"class="ui divider"></div>
            <h1><?= $t["name"] ?></h1>
            <p><?= $t["description"] ?></p>
        </div>
    <?php } 

  

html_footer()
?>

