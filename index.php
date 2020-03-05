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
    <button class="tablinks" onclick="openCity(event, 'Years')">Years</button>
    <?php
    if( empty( $_REQUEST['for']) ) { ?>
      <button class="tablinks" id="defaultOpen" onclick="openCity(event, 'Latest')">Latest</button>
    <?php } else { ?>
      <button class="tablinks" onclick="openCity(event, 'Latest')">Latest</button>
    <?php } ?>
    <button class="tablinks" onclick="openCity(event, 'To Do')">To Do</button>
    <?php
    if( !empty( $_REQUEST['for']) ){ ?>
      <button class="tablinks" id="defaultOpen" onclick="openCity(event, 'Search')">Search</button>
    <?php } else { ?>
      <button class="tablinks" onclick="openCity(event, 'Search')">Search</button>
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
 $page = "<div id='page'>";

 $tab1 =   "<div id='Years' class='tabcontent'>";
 $data1 = "<div class='data'>";
 $data1 .= "<center><h3>Journal Entries</h3></center>";

 $data1 .= "<ul>";

  $NOTE_DIR="/Users/woo/Dropbox/Personal/Documents/Notes/";
if ($handle = opendir($NOTE_DIR) ) {
    $files = glob($NOTE_DIR . "Journal_*.txt");
    foreach( $files as $file) {
    $filename = basename($file, ".txt");
    $year = substr($filename, -4);
    // extract filename and show with link to page with full filepath
    $data1 .= "<li><a href='./page.php?year=$year'>$filename</a></li>";
    }
closedir($handle);
}
$data1 .= "</ul>";
$data1 .= "</div>";
$tab1 .= $data1 . "</div>";// end data

$tab2 = "<div id='Latest' class='tabcontent' >";

$data2 = "<div class='data'>";

$data2 .= "<center><h2>Recent Notes</h2></center><br/>";
$YYYY=date('Y');
$source = "$NOTE_DIR"."Journal_$YYYY.txt";
if( !empty($_REQUEST['diary']) ) {
  $raw = file_get_contents($source);
  $lines = preg_split("/\n/",$raw);
  $num = count($lines);
  $file = fopen($source, 'w');
  for( $i = 0; $i <= $num; $i++ ) {
      fwrite($file, "\n" . $lines[$i] );
  }
  $datestr = date('Ymd h:m:s');
  fwrite($file, "\n---$datestr");
  fwrite($file, "\n" . $_REQUEST['diary']);
  fclose($file);
}
$raw = file_get_contents($source);
$lines = preg_split("/\n/",$raw);
$num = count($lines);
$start = $num -20;
$raw = "";
for( $i = $start; $i <= $num; $i++ ) {
    $raw .= $lines[$i] . "\n";
}
$raw .= "<br /><hr /><br /><form action='./index.php' ><input type='textarea' name='diary' value='' cols='50' rows='10' /><input type='submit' value='Add' /><input type='submit' value='Cancel' /></form>";

$html = nl2br($raw);
$data2 .= $html;
$data2 .= "</div>"; // end data
$tab2 .= $data2 . "</div>";
$tab3 = "<div id='To Do' class='tabcontent'>";
$data3 = "<div class='data'>";
$data3 .= "<center><h2>ToDo List</h2></center><br/>";
$source = "$NOTE_DIR".".todo";
if( !empty($_REQUEST['delete']) ) {
  $raw = file_get_contents($source);
  $lines = preg_split("/\n/",$raw);
  $num = count($lines);
  $file = fopen($source, 'w');
  for( $i = 0; $i <= $num; $i++ ) {
    if( $i != (int)$_REQUEST['delete'] ) {
      fwrite($file, $lines[$i] . "\n" );
    }
  }
  fclose($file);
}
if( !empty($_REQUEST['add']) ) {
  $raw = file_get_contents($source);
  $lines = preg_split("/\n/",$raw);
  $num = count($lines);
  $file = fopen($source, 'w');
  for( $i = 0; $i <= $num; $i++ ) {
      if( !empty($lines[$i]) ) {
      fwrite($file, $lines[$i] . "\n" );
    }
  }
  fwrite($file, $_REQUEST['add'] . "\n");
  fclose($file);
}
$raw = file_get_contents($source);
$lines = preg_split("/\n/",$raw);
$num = count($lines);
$start = 0;
$raw = "";
for( $i = $start; $i <= $num; $i++ ) {
    if( !empty($lines[$i]) ) {
      $raw .= "<a href='index.php?delete=".$i."' >$i ) </a>" . $lines[$i] . "\n";
    }
}
$raw .= "<br /><hr /><br /><form action='./index.php' ><input type='textarea' name='add' value='' cols='50' rows='10' /><input type='submit' value='Add' /><input type='submit' value='Cancel' /></form>";
$html = nl2br($raw);
$data3 .= $html;
$data3 .= "</div>";
$tab3 .= $data3 . "</div>";
$tab4 = "<div id='Search' class='tabcontent'>";

$data4 = "<div class='data'>";
$data4 .= "<center><h2>Search</h2></center><br/>";
if( empty( $_REQUEST['for'] ) ){
$raw = "<form action='./index.php' ><input type='text' name='for' value='' width='30'/><br/><input type='submit' value='Search' /><input type='submit' value='Cancel'/></form>";
} else {
  $raw = "Search for " . $_REQUEST['for'];
  $raw .= "<br />";
  $sources = array(".todo", "Port_Starboard.txt", "Language.txt", "Restaurants.txt");
  foreach( $sources as $source ) {
  $raw .= "Searching: " . $source . "\n";
  // | sed 's:~/Dropbox/Personal/Documents/Notes/::'
  $cmd = "/usr/bin/grep -n -i " . $_REQUEST['for'] . " /Users/woo/Dropbox/Personal/Documents/Notes/$source ";
  //$raw .= "cmd: " . $cmd . "<br />";
  $output = "\n" . shell_exec($cmd);
  $raw .= nl2br($output);
}
$search_file = "search.txt";
if( file_exists($search_file)) {
  unlink($search_file);
}
$handle = fopen($search_file,'a');
fwrite($handle, "Searching Journal\n");
$files = glob("/Users/woo/Dropbox/Personal/Documents/Notes/Journal_*.txt");
foreach( $files as $file ) {
  $matches = match($file, $_REQUEST['for']);
  if( sizeof( $matches ) > 0 ) {
    fwrite( $handle, "----------$file--------\n");
    foreach( $matches as $match ) {
      fwrite($handle, $match);
    }
  }
}


if( file_exists($search_file)) {
  $output = file_get_contents($search_file);
  $raw .= nl2br($output);
  unlink($search_file);
}

  $raw .= "<form action='./index.php' ><input type='text' name='for' value='' width='30'/><br/><input type='submit' value='Search' /><input type='submit' value='Cancel'/></form>";
}
$html = nl2br($raw);
$data4 .= $html;
$data4 .= "</div>";
$tab4 .= $data4 . "</div>";
echo "$page";
echo "$tab1";
echo "$tab2";
echo "$tab3";
echo "$tab4";
echo "</div>"; // end of page
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

?>
<script type="text/javascript">

document.getElementById("defaultOpen").click();

function openCity(evt, cityName) {
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
