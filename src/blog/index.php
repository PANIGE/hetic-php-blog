<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/general_helper.php'); 

//check if we have an id provided in params
if (!isset($_GET["id"])) {
    http_response_code(302);
    header('location:/blog/list.php');
}

//check if ID exists in table blogs
$id = $_GET["id"];
$query = $pdo->prepare('SELECT * FROM blogs WHERE id = :id');
$query->execute([
    ":id"   => $id,
]);
if ($query->rowCount() == 0) {
    http_response_code(302);
    header('location:/blog/list.php?er=Blog%20not%20found');
}
$data = $query->fetch(PDO::FETCH_ASSOC);

html_header("blogs.jpg", "Blogs > ".$data["name"], -50, "Blogs");

?>
<div class="ui segment"> 
    <a  class="ui pink inverted button" href="/blog/list.php">Back</a> 
    <?php
    if (is_log()) {
        if (is_admin() || $data["owner"] == get_user_id()) {
            ?>
            <a style="float:right" class="ui red inverted button" href="/blog/delete_blog.php?id=<?= $data["id"] ?>">Delete</a> 
            <?php
        }
    }
    ?>
</div>

<div class="ui segment">
    <h1><?= $data["name"] ?></h1>
    <p><?= $data["description"] ?></p>
</div>

<?php
//Get all post liked to this blog
$query = $pdo->prepare('SELECT p.id, p.author, p.content, p.unix, u.username author_name FROM posts p LEFT JOIN users u ON p.author = u.id WHERE p.blog = :id ORDER BY p.unix ASC');
$query->execute([
    ":id"   => $id,
]);
$data = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($data as $t) { 

    $q = $pdo->prepare('SELECT url FROM attachements WHERE post_id = :id;');
    $q->execute([
        ":id"   => $t["id"],
    ]);
    $attachements = $q->fetchAll(PDO::FETCH_ASSOC);

    ?>
<div class="channel-message-tab" style="position:relative;" id="post_<?= $t["id"] ?>">
            <a href="/users.php?id=<?= $id?>"><img class="channel-message-avatar" src="/avatars.php?id=<?= $t["author"]?>"></a>
            
            <div class="channel-message-box"> <a href="/users/<?= $id?>"><h4>               
                <?= $t["author_name"] ?>
                <?php 
                    $user = get_user_data($t["author"]);
                    switch ($user["rank"]) {
                        case 2:
                            echo "<span class=\"ui small blue horizontal label\" style=\"color: white!important;\">Moderator</span>";
                        break;
                        case 3:
                            echo "<span class=\"ui small red horizontal label\" style=\"color: white!important;\">Admin</span>";
                        break;  
                    }
                ?>    
                </h4></a><?= htmlspecialchars_decode($t['content']);?><?php 
                foreach ($attachements as $im) {
                    echo "<img style=\"height: 32em;width: fit-content;\" src=\"".$im["url"]."\" />";
                }
                ?>
                <?php if (get_user_id() == $user["id"] || is_admin()) {?>
                
                    <a id="delete" class="ui mini red inverted button" style="position:absolute;right: 4.7em;top: 1em;" href="/blog/delete_message.php?id=<?= $t['id'] ?>">delete</a>
                    
                <?php } ?>
            </div>

            
        </div>
<?php }

if (is_log()) {
    ?>
    <div class="ui segment">
    <h3 class="ui horizontal header divider"> Contribute to this blog </h3>
        <form  class="ui form"  action="/blog/new_message.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="blog" value="<?= $id ?>">
            <textarea name="content" placeholder="Write a message"></textarea>
            <div class="ui divider"></div>
            <input class="ui green inverted button" type="file" name="file[]" id="filesToUpload" multiple>
            <div class="ui divider"></div>
            <input class="ui blue inverted button" type="submit" value="Send" name="submit">
        </form>
    </div>
    <?php
}
  

html_footer();