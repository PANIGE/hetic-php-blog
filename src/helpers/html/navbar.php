<?php

function html_navbar_item($name, $href, $activate=true) {
    $a = ((($_SERVER['REQUEST_URI']) == $href && $activate) ? "active" : "");
    echo '<a class="'.$a.' item" href="'.$href.'">'.$name.'</a>';
}

function html_navbar_logo() {
    echo '<div class="item"><b><a href="/" title="Home page"><img class="ripple logo reactiveImages" id="logo" src="/static/logos/logo.png" alt="osu!Aeris"></a></b></div>';
}

