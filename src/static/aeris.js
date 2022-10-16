function handleFirstTab(e) {
  if (e.keyCode === 9) { // the "I am a keyboard user" key
      document.body.classList.add('user-is-tabbing');
      window.removeEventListener('keydown', handleFirstTab);
  }
}
window.addEventListener('keydown', handleFirstTab);

function hamburger() {
  var x = document.getElementById("navbarItems");
  menu = document.getElementById("hamburger-menu");
  if (getComputedStyle(x, null).display == "block") {
    x.setAttribute("style", "max-height:0em;display:flex!important");
    menu.setAttribute("class", "big bars icon")
  } else {
    x.setAttribute("style", "max-height: 60em;display:block");
    menu.setAttribute("class", "big x icon")
  }
}
var navbar = document.getElementById('navbar')
var navImg = document.getElementById('navimg')
var avatar = document.getElementById('avatar')
var logo = document.getElementById('logo')
function init() {

    navbar = document.getElementById('navbar')
    navImg = document.getElementById('navimg')
    avatar = document.getElementById('avatar')
    logo = document.getElementById('logo')


    if ($(window).width() < $(window).height()) {
    
    navbar.classList.add('dropped')
    navImg.classList.add('hidden')
    logo.classList.remove('reactiveImages')
    try {
    avatar.classList.remove('reactiveImages')} catch (error) {
}

    navbaritems = document.getElementById("navbarItems");
    }
}



window.onscroll = function() {
  // pageYOffset or scrollY
  if (window.pageYOffset > 0 || $(window).width() < $(window).height()) {
    navbar.classList.add("navbar-background")
    
    navbar.classList.add('dropped')
    navImg.classList.add('hidden')
    logo.classList.remove('reactiveImages')
    try {
    avatar.classList.remove('reactiveImages')
} catch {}
    
    
  } else {
    navbar.classList.remove("navbar-background")
    navbar.classList.remove('dropped')
    navImg.classList.remove('hidden')
    logo.classList.add('reactiveImages')
    try {
    avatar.classList.add('reactiveImages')} catch {}
    
  }
}
function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

window.addEventListener('beforeunload', async function(e) {
    
    await sleep(2000)
    var loading = document.getElementById("loading-screen")
    loading.setAttribute("class", "loading-bg")
});





function checkClick(event) {
var ignoreClickOnMeElement = document.getElementById('search-box');
var isClickInsideElement = ignoreClickOnMeElement.contains(event.target);
if (!isClickInsideElement) {
    hideSearch()
}
}
async function search_click() {
document.getElementById("search").setAttribute("class", "search-bg")

await sleep(20)
document.addEventListener('click', checkClick)
}

function hideSearch() {
document.getElementById("search").setAttribute("class", "search-bg sbghidden")
document.removeEventListener('click', checkClick)
}

async function search_maps(query) {
var searchElement = document.getElementById("maps-result");
if (query == '') {
  
  searchElement.innerHTML = "No input";
} else {
  searchElement.innerHTML = "Loading...";
  const response = await fetch( "https://kitsu.moe/api/search?amount=10"+"&query=" + query);
  const responseText = await response.text();
  const Data = JSON.parse(responseText)

if (Data) {
  searchElement.innerHTML = "";
  Data.forEach(element => {
    var mode = ["osu", "taiko", "fruits", "mania"];
    
    var anchor = searchElement.appendChild(document.createElement('a'));
    anchor.setAttribute("href", "/b/"+element["ChildrenBeatmaps"][0]["BeatmapID"])
    var container = anchor.appendChild(document.createElement('div'));
    container.setAttribute("class", "beatmap-container bm-search");
    container.setAttribute("id", element["SetID"]);
        var tab = container.appendChild(document.createElement('div'));
        tab.setAttribute("class", "tab");
            var head3 = tab.appendChild(document.createElement('h3'));
            head3.innerHTML = element["Title"]
            var head4 = tab.appendChild(document.createElement('h4'));
            head4.innerHTML = element["Artist"] + " // " + element["Creator"];
            var miniIcons = tab.appendChild(document.createElement('div'));
            miniIcons.setAttribute("class", "mini-icons");
            index = 0
            element["ChildrenBeatmaps"].forEach(maps => {
                index = ++index;
                    if (index <=15) {
                    var icondiv = miniIcons.appendChild(document.createElement('div'))
                    icondiv.setAttribute("data-title", maps["DiffName"] + " \n " + maps["DifficultyRating"] + "⭐") 
                    img = icondiv.appendChild(document.createElement('img'))
                    img.setAttribute("src", "/static/icons/mode-"+mode[maps["Mode"]]+".png")
                    
                
                    } else {
                        miniIcons.append(".")
                    }
            })

            var buttons = container.appendChild(document.createElement('div'));
            buttons.setAttribute("class", "buttons")
            var ap = buttons.appendChild(document.createElement('a'));
            ap.setAttribute("onclick", "interract("+element["SetID"]+")")
                var playDiv = ap.appendChild(document.createElement('div'));
                playDiv.setAttribute("class", "play-div");
                var iP =  playDiv.appendChild(document.createElement('i'));
                iP.setAttribute("class", "play icon")
                iP.setAttribute("id", "play-"+ element["SetID"])
                var audioFile = iP.appendChild(document.createElement('audio'));
                audioFile.setAttribute("src", "https://b.ppy.sh/preview/"+element["SetID"]+".mp3");
                audioFile.setAttribute("id", "audio-"+element["SetID"]);
            var ad = buttons.appendChild(document.createElement('a'));
            ad.setAttribute("href", "https://bm6.aeris-dev.pw/d/"+element["SetID"])
                var downDiv = ad.appendChild(document.createElement('div'));
                downDiv.setAttribute("class", "download-div")
                var iD =  downDiv.appendChild(document.createElement('i'));
                iD.setAttribute("class", "download icon")
        var img = container.appendChild(document.createElement('img'));
        img.setAttribute("src", "https://assets.ppy.sh/beatmaps/"+element["SetID"]+"/covers/card@2x.jpg")
        img.setAttribute("onerror", "this.onerror=null; this.src='https://aeris-dev.pw/static/default-bg.png'")
        });
} else {
  searchElement.innerHTML = "No maps found";
}
}
}


async function search_users(query) {
var searchitems = document.getElementById("players-result");
if (query == '') {
  searchitems.innerHTML = "No input";
} else {
  searchitems.innerHTML = "Loading...";
  const response = await fetch( "/api/search.php?q=" + query);
  const Data = await response.json();
  if (Data.length > 0) {
    searchitems.innerHTML = "";
    Data.forEach(element => {
      var anchor = searchitems.appendChild(document.createElement('a'));
      anchor.setAttribute("href", "/users.php?id="+element.id);
      var maindiv = anchor.appendChild(document.createElement('div'));
      maindiv.setAttribute("class","players-search-tab")
      var imgdiv = maindiv.appendChild(document.createElement('div'));
      imgdiv.setAttribute("class", "avatar")
      var img = imgdiv.appendChild(document.createElement('img'));
      img.setAttribute("src", "/avatars.php?id="+element.id)
      var h3 = maindiv.appendChild(document.createElement('h3'));
      h3.innerHTML = element.username
    })
    
  }
  else {
    searchitems.innerHTML = "No user was found";
    
  }
  
}
}


async function search() {
var search = document.getElementById('search-input').value;
search_users(search)
}

function interract(id) {
soundPlayer = document.getElementById("audio-"+id);
if (soundPlayer.duration > 0 && !soundPlayer.paused) {
    soundPlayer.pause();
    soundPlayer.currentTime = 0;
    icon = document.getElementById("play-"+id);
    icon.setAttribute("class", "play icon")
} else {
    soundPlayer.play();
    icon = document.getElementById("play-"+id);
    icon.setAttribute("class", "pause icon")
    soundPlayer.addEventListener("ended", function(){
        soundPlayer.currentTime = 0;
        icon.setAttribute("class", "play icon")
        });
}
}

function endAudio(id) {
soundPlayer = document.getElementById("audio-"+id);
soundPlayer.currentTime = 0;
icon = document.getElementById("play-"+id);
icon.setAttribute("class", "play icon")
}



