<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/general_helper.php'); 
html_header("welcome.jpg", "Home");
?>


<div class="vid-container">
        <video class="main-menu-vid" autoplay="" loop="" muted="" playsinline="" src="/static/assets/bg.mp4"></video>
        <img class="main-vid-img" id="san" src="/static/icon.png"> 
        <div class="main-menu-message">
        <h1>Welcome to Foobyland</h1>
        <h3>Foobyland is the place where we praise Shirakami Fubuki</h3>
                
        </div>
    </div>


<?php html_footer(); ?>

