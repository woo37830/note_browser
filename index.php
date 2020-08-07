<html>
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="./_js/jquery.easyui.min.js"></script>
  <script type="text/javascript" src="/frameworks/_js/cookies.js"></script>
  <script type="text/javascript" src="/frameworks/_js/authorize.js"></script>
  <link rel="stylesheet" href="/frameworks/_css/dlg-form.css" id="formid" type="text/css" />
  <link rel="stylesheet" type="text/css" href="./themes/default/easyui.css">
   <link rel="stylesheet" href="/frameworks/_css/layout.css" id="styleid" type="text/css" />
 <script type="text/javascript">

function start() {

  var tabDiv = document.getElementsByClassName('tab');


  function openTab(evt) {
    // Declare all variables
    var i, tabcontent;
    //alert('Clicked Tab ' + evt.target.innerHTML);
    // Get all elements with class="tabcontent" and hide them

     tabcontent = document.getElementsByClassName("tabcontent");
  /*   for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].className = tabcontent[i].className.replace(" active", "");
      }*/
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
      var tab = document.getElementById(tabcontent[i].id);
      tab.style.backgroundColor = "#f1f1f1";
     if( tabcontent[i].id == evt.target.innerHTML ) {
        tab.style.backgroundColor = "white";
        tabcontent[i].style.display = "block";
        tabcontent[i].className += " active"; // Controls showing contents
        createCookie('tab', tabcontent[i].id);
      }
  }
 }

  function addTab(text) {
 //       alert('Add event listener for '+text);
    var btn = document.createElement( 'button' );
    tabDiv[0].appendChild(btn);
    btn.className = "tablinks tab";
    btn.id = text;
    btn.addEventListener('click', function (event) {
       openTab(event);
        });
    btn.innerHTML = text;
}
addTab('Years');
addTab('Latest');
addTab('To Do');
addTab('Billing');
addTab('Search');
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
//document.getElementById('Latest').style.display = "block";



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
              //eraseCookie("tab");
  }
  
   //alert('Hello, World!')
  if( readCookie("tab") ) {
  document.getElementById( readCookie("tab")).click();
} else {
  document.getElementById('Latest').click();
}
}
 

  </script>
 
</head>
<body onload="start();">
 

  <div class="wrapper" >

    <header>

    </header>
  <div id="content">
        <!-- Tab links -->
  <div class="tab">
  </div>
  <div id="log_in">Login</div>
<div class="title">
    Journal Explorer
  </div>
  <div id="no-access">
    <center><h3>You must be logged in to Browse the Journal</h3></center>
  </div>
 <?php
 require 'login.php';
 echo "$scripts";
 $NOTE_DIR="/Users/woo/Dropbox/Personal/Documents/Notes/";

echo "<div id='page' class='show'>"; // put in the page div
//echo "$tab1";
require 'tab_journal.php';
require 'tab_recent.php';
require 'tab_todo.php';
require 'tab_search.php';
require 'tab_billing.php';



// php Functions
function match( $file, $pattern ) {
  // get the file contents, assuming the file to be readable (and exist)
  $matches = array();
  $pat = strtolower($pattern);
  $handle = @fopen($file, "r");
  if ($handle)
  {
    $k = 0;
      while (!feof($handle))
      {
        $k++;
          $buffer = fgets($handle);
          if(strpos(strtolower($buffer), $pat) !== FALSE) {
              $matches[] = $k . ") " . $buffer;
            }
      }
      fclose($handle);
  }

  //show results:
  return $matches;
}
// end of php functions
?>


<div id="footer" >
  <hr />
  <em><?php
  include 'git-info.php';
  ?></em>
</div>
</div>
</body>
</html>
