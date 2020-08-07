<html>
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="./_js/jquery.easyui.min.js"></script>
  <script type="text/javascript" src="/frameworks/_js/cookies.js"></script>
  <script type="text/javascript" src="/frameworks/_js/authorize.js"></script>
  <link rel="stylesheet" href="/frameworks/_css/layout.css" id="styleid" type="text/css" />
  <link rel="stylesheet" href="/frameworks/_css/dlg-form.css" id="formid" type="text/css" />
  <link rel="stylesheet" type="text/css" href="./themes/default/easyui.css">
  <script type="text/javascript">

function start() {
  var tabDiv = document.getElementsByClassName('tab');


  function openTab(evt, cityName) {
    // Declare all variables
    var i, tabcontent, tablinks;
    //alert('Clicked Tab ' + cityName);
    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
      if( tabcontent[i].id == cityName ) {
        tabcontent[i].style.display = "block";
        createCookie('tab', cityName);
      }
    }

    event.currentTarget.className += " active";
}


  function addTab(text) {
    var btn = document.createElement( 'button' );
    tabDiv[0].appendChild(btn);
    btn.class = "tablinks";
    btn.id = text;
    btn.onclick=openTab(event,text);
    btn.innerHTML = text;
}
addTab('Years');
addTab('Latest');
addTab('To Do');
addTab('Billing');
addTab('Search');
if( readCookie("tab") ) {
  document.getElementById( readCookie("tab")).click();
} else {
  document.getElementById('Latest').click();
}
// Get all elements with class="tablinks" and remove the class "active"
tablinks = document.getElementsByClassName("tablinks");
for (i = 0; i < tablinks.length; i++) {
  tablinks[i].className = tablinks[i].className.replace(" active", "");
}

const state = { 'page_id': 1, 'add': '', 'delete': '', 'diary': ''}
const title = 'Browse'
const url = 'index.php'

history.pushState(state, title, url);
// Show the current tab, and add an "active" class to the button that opened the tab
//document.getElementById(cityName).style.display = "block";



if( readCookie("logged_in") && readCookie('userid') ) {
                $("#log_in").text("Logout: "+readCookie('userid'));
                $("#log_in").attr('id', 'log_out');
                  $(".data").attr('class', 'show');
                  $("#no-access").attr('class','hide');
                  $("#lin").attr('class','hide');
                  $("#lin-buttons").attr('class','hide');



  } else {
            $("#log_out").text("Login");
            $("#log_out").attr('id', 'log_in');
              $(".data").attr('class', 'hide');
              $("#no-access").attr('class','show');
  }
}
  //alert('Hello, World!')
  </script>
</head>
<body onload="start();">


  <!-- Tab links -->
  <div class="tab">
  </div>


  <div class="wrapper" >

    <header>

    </header>
  <div id="content">
  <div id="log_in">Login</div>
<div class="title">
    Journal Explorer
  </div>
  <div id="no-access">
    <center><h3>You must be logged in to Browse the Journal</h3></center>
  </div>


<div id="footer" >
  <hr />
  <em><?php
  include 'git-info.php';
  ?></em>
</div>
</div>
</div>
</body>
</html>
