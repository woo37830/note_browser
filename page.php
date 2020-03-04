<?php
   $DIR = "/Users/woo/Dropbox/Personal/Documents/Notes/";
   if( ! isset( $_REQUEST['year'] ) ) {
      $YYYY = date('Y');
   } else {
      $YYYY=$_REQUEST['year'];
   }
   $THIS_YEAR = date('Y');
   $prev = $YYYY - 1;
   $next = $YYYY + 1;
   $prev_link = "";
   if( $prev > 1990 ) {
      $prev_link = "<a href='./page.php?year=$prev'>Prev</a> | ";
   }
   $next_link = "";
   if( $next <= $THIS_YEAR ) {
       $next_link = " | <a href='./page.php?year=$next'>Next</a>";
   }
   $slug =  "$YYYY";
   $byline = "J. W. Wooten, Ph.D.";
   $source = "$DIR/Journal_$YYYY.txt";

// read raw text as array
$raw = file($source) or die("Cannot read file");


// join remaining data into string
$data = join('', $raw);

// replace special characters with HTML entities
// replace line breaks with <br />
$html = nl2br($data);
//$html = nl2br(htmlspecialchars($data));

// replace multiple spaces with single spaces
//$html = preg_replace('/\s\s+/', ' ', $html);

// replace URLs with <a href...> elements
//$html = preg_replace('/\s(\w+:\/\/)(\S+)/', ' <a href="\\1\\2" target="_blank">\\1\\2</a>', $html);

// start building output page
// add page header
?>
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
  <div class="wrapper" >

  <div id="content">

    <div id="log_in">Login</div>
    <div id="no-access">
      You must be logged in to Browse the Pages
    </div>


<?php

// add page content
$output .= "<center><div class='slug'>$slug</div>";
$output .= "<div class='byline'>$byline</div></center><p />";
$output .= "<hr />";
$output .= "<p /><center>$prev_link <a href='./index.php'>Back</a> $next_link </center><p />";
$output .= "<div id='page'>";
$output .= "<div class='data'>";
$output .= "<div>$html</div>";
$output .= "</div>"; // end data
$output .= "</div>"; // end page
// add return button
$output .= "<p /><center>$prev_link <a href='./index.php'>Back</a> $next_link </center><p />";

echo "$output";
require 'login.php';
echo "$scripts";
echo "</div><br />"; // end content
?>

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
