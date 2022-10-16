<?php 
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/general_helper.php'); 
    

    $ID = $_GET["id"];
    $User = get_user_data($ID);
    if (!$User ) {
        http_response_code(404);
        require('404.php');
        die();
    }
    html_header("profile.jpg", "User Profile", 200);

    $req = $pdo->prepare("SELECT * FROM blogs where owner = :id order by name ASC LIMIT 50;");
    $req->execute([
        ":id" => $ID
    ]);
    $data = $req->fetchAll();
    $self = is_log() && get_user_id() == $ID;

?>

<div class="ui container">
    <div class="profile-bg" style="background-image: url('/static/headers/profile.jpg');">
        <div class="overlay"></div>
        <div class="profile">
            <div class="profile-data">
                <div class="cat">
                <div class="rank">
            
                    
                    
                </div>
                <div class="stats">
                    <h1 class="username"><?= $User["username"] ?></h1>
                    
                    <?php switch($User["rank"]): 

                        case 1: ?>
                            <h1 style="margin: 0;color: #5f5;text-shadow: 0 0 6px black;">Foobyland Member</h1>
                        <?php break; ?>

                        <?php case 2: ?>
                            <h1 style="margin: 0;color: #99f;text-shadow: 0 0 6px black;">Foobyland Moderator</h1>
                        <?php break; ?>

                        <?php case 3: ?>
                            <h1 style="margin: 0;color: #f55;text-shadow: 0 0 6px black;">Foobyland Administrator</h1>
                        <?php break; ?>

                    <?php endswitch; ?>
                </div>
                </div>
            </div>
            
            <?php if ($self) echo "<a href=\"/settings/avatar.php\""?>
            <div class="p-avatar">
                <img height="256" alt="avatar" src="/avatars.php?id=<?= $ID ?>">
            </div>
            <?php if ($self) echo "</a>"?>
        </div>
    </div>
    

<?php

foreach ($data as $t) { 
    ?>
    <div class="ui segment">
        
        <a style="position:absolute;right:10px;"class="ui blue inverted button" href="/blog/?id=<?= $t['id'] ?>">See</a> 
        <h1 style="margin-top:.1em"><?= $t["name"] ?></h1>
        <p><?= $t["description"] ?></p>
    </div>
<?php } 

html_footer(); ?>