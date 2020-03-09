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
</head>
<body>
  <!-- Tab links -->
  <div class="tab">
    <button class="tablinks" onclick="openTab(event, 'Years')">Years</button>
    <?php
    if( empty( $_REQUEST['for']) ) { ?>
      <button class="tablinks" id="defaultOpen" onclick="openTab(event, 'Latest')">Latest</button>
    <?php } else { ?>
      <button class="tablinks" onclick="openTab(event, 'Latest')">Latest</button>
    <?php } ?>
    <button class="tablinks" onclick="openTab(event, 'To Do')">To Do</button>
    <button class="tablinks" onclick="openTab(event, 'Billing')">Billing</button>
    <?php
    if( !empty( $_REQUEST['for']) ){ ?>
      <button class="tablinks" id="defaultOpen" onclick="openTab(event, 'Search')">Search</button>
    <?php } else { ?>
      <button class="tablinks" onclick="openTab(event, 'Search')">Search</button>
    <?php } ?>
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

echo "</div>"; // end of page

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
<script type="text/javascript">


document.getElementById("defaultOpen").click();

function openTab(evt, cityName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  if( readCookie("logged_in") ) {
                  $("#log_in").text("Logout: "+readCookie('userid'));
                  $("#log_in").attr('id', 'log_out');
                    $(".data").attr('class', 'show');
                    $("#no-access").attr('class','hide');
                    $("#lin").attr('class','hide');
                    $("#lin-buttons").attr('class','hide');


  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";


} else {
            $("#log_out").text("Login");
            $("#log_out").attr('id', 'log_in');
              $(".data").attr('class', 'hide');
              $("#no-access").attr('class','show');
}
}

const state = { 'page_id': 1, 'add': '', 'delete': '', 'diary': ''}
const title = 'Browse'
const url = 'index.php'

history.pushState(state, title, url)
//alert('Hello, World!')
</script>

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
