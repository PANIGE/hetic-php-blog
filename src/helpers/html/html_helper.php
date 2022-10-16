<?php 
    require_once($_SERVER['DOCUMENT_ROOT']."/helpers/html/navbar.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/helpers/general_helper.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/helpers/html/html_helper.php");

    function html_header($header, $name, $hue=-100, $desc="Welcome to Foobyland") {
        ?>
               <html>
               <head>
               <style>
                     :root {
                     <?= "--main-hue-theme: ".$hue."deg;" ?>
                     }
               </style>
               <meta charset="utf-8">
               <meta name="viewport" content="width=device-width, initial-scale=1">
               
               <?= "<title> ".$name." | Foobyland</title>"?>
               
               <link rel="icon" href="/static/favicon.ico">
               <meta property="og:type" content="website">
               
               <?= '<meta name="description" content="'.$desc.'">'?>
               <meta name="msapplication-TileImage" content="/static/logos/logo2.png">
               <meta name="theme-color" content="#7f03fc">
               <meta name="robots" content="index, follow">
               <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
               <meta lang="en">
               <meta name="language" content="English">
               <link rel="stylesheet" type="text/css" href="/static/semantic.css">
               <link rel="stylesheet" type="text/css" href="/static/Aeris.css">
               <link rel="stylesheet" type="text/css" href="/static/fontAwesome.css">
               <link rel="apple-touch-icon" href="/static/apple-touch-icon.png">
               <link href="https://kit-free.fontawesome.com/releases/latest/css/free-v4-shims.min.css" media="all" rel="stylesheet">
               <link href="https://kit-free.fontawesome.com/releases/latest/css/free-v4-font-face.min.css" media="all" rel="stylesheet">
               <link href="https://kit-free.fontawesome.com/releases/latest/css/free.min.css" media="all" rel="stylesheet">
               <script src="/static/aeris.js?v=1.4" type="text/javascript"></script>
               <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
               <body>
               <div class="background-image" <?= 'style="background-image: url(\'/static/headers/'.$header.'\');"'?>>
               </div>
               <div class="ui full height main wrapper">
                  <div class="ui secondary fixed-height stackable main menu no margin bottom" id="navbar">
                     <img navbar="" class="navbar-image" id="navimg" src="/static/assets/navbar.png">
                     <div class="nav2" style="display: none;"></div>
                     <div class="ui container responsive" id="navbarhtml_navbar_items">
            <?php

/* ------------------------------- LEFT ITEMS ------------------------------- */
               html_navbar_logo();
               html_navbar_item("home", "/");
               html_navbar_item("Blog","/blog/list.php", false);
               
/* -------------------------------------------------------------------------- */

             ?>
                     <div class="firetrucking-right-menu">
                        <div class="item">
                           <button class="search-button" onclick="search_click()">
                              <i class="search link icon"></i>
                           </button> 
                        </div>
               <?php

/* ------------------------------- RIGHT ITEMS ------------------------------ */
               if (!is_log()) {
                  html_navbar_item("Login", "/login.php");
                  html_navbar_item("Register", "/register.php");
               }
               else {
                  echo '<div class="ui dropdown item avatar-div"><a></a><img id="avatar" class="ui avatar image reactiveImages" src="/avatars.php?id='.get_user_id().'"><div class="menu">';
                     html_navbar_item("Profile", "/users.php?id=".get_user_id());
                     html_navbar_item("Avatar", "/settings/avatar.php");
                     html_navbar_item("Log out", "/logout.php");
                  echo '</div></div>';

                  
               }
/* -------------------------------------------------------------------------- */

            ?>

                     </div>
                        
                     </div>
                     <i class="big bars icon responsive-icon" onclick="if (!window.__cfRLUnblockHandlers) return false; hamburger()" ,="" id="hamburger-menu"></i>
                  </div>
                  <div class="huge heading  dropped" <?= 'style="background-image: url(\'/static/headers/'.$header.'\');'?>">
            
                  <div class="header-overlay"><i></i></div>
                  <div class="ui container">
                  <div class="main-bg-container"></div>
                  <h1> <?= $name ?> </h1>
                        </div>
                              </div>
                              <div class="h-container">
                                 <div class="ui margined container" id="messages-container">
                                    <noscript>Research has proven this website works 10000% better if you have JavaScript enabled.</noscript>
                                    <div class="information-message">Welcome to FoobyLand</div>
                        <?php
                        if (isset($_GET["er"])) {
                           echo "<div class=\"ui error message\"><i class=\"close icon\"></i>".$_GET["er"]."</div>";
                        }

                        else if (isset($_GET["ew"])) {
                           echo "<div class=\"ui warning message\"><i class=\"close icon\"></i>".$_GET["ew"]."</div>";
                        }

                        else if (isset($_GET["es"])) {
                           echo "<div class=\"ui success message\"><i class=\"close icon\"></i>".$_GET["es"]."</div>";
                        }
                        
                       ?>
                                 </div>
                                 <div class="ui container">
                  <?php
    }


    function html_footer() {
       ?>

       </div>
       </div>
    </div>
    <div class="footer">
       <div class="footer-texts">
          <div class="upper">
             <a href="https://www.mikapikazo.com">Artworks used</a>
             
             <div class="lower">Frontend Hanayo 1.11.0 | FoobLand 2022-2022</div>
          </div>

          <div id="loading-screen" class="loading-bg lbghidden">
             <i class="l1"></i>
             <i class="l2"></i>
             <i class="l3"></i>
             <i class="l4"></i>
          </div>
          <div id="search" class="search-bg sbghidden">
             <div id="search-box" class="search-fg">
                <div>
                   <div class="search-window">
                      <input type="text" placeholder="Looking for someone?" id="search-input" autocomplete="off" oninput="search()">
                      <i class="big search link icon"></i>
                   </div>
                </div>
                <div class="search-divider"></div>
                <div class="search-container">
                   <h1 id="players">Users</h1>
                   <div id="players-result">
                      No input
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
    <script src="/static/dist.min.js" type="text/javascript"></script>
 

</body></div></html>
<?php
    }