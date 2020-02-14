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
  <link rel="stylesheet" href="_css/layout.css" id="styleid" type="text/css" />

<style>
.slug {font-size: 15pt; font-weight: bold}
.byline { font-style: italic }
</style>
</head>
<body>
<script type="text/javascript">
if( readCookie("logged_in") ) {
                  $("#data").attr('class', 'show');
                  $("#no-access").attr('class','hide');
                  alert("logged in");
} else {
              $("#data").attr('class', 'hide');
              $("#no-access").attr('class','show');
              alert("not logged in");
}
function readCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}

</script>
<div class="wrapper" >

<div id="content">


<?php

// add page content
$output .= "<center><div class='slug'>$slug</div>";
$output .= "<div class='byline'>$byline</div></center><p />";
$output .= "<hr />";
$output .= "<p /><center>$prev_link <a href='./index.php'>Back</a> $next_link </center><p />";

$output .= "<div>$html</div>";
// add return button
$output .= "<p /><center>$prev_link <a href='./index.php'>Back</a> $next_link </center><p />";
?>
  <div id="footer" >
    <hr />
    <em><?php
    include 'git-info.php';
    ?></em>
  </div>
  <div id="no-access">
    <center><h3>You must be logged in to Browse the Journal</h3></center>
  </div>

<div id="data">
<?php
// add page footer
echo "$output";
?>
</div>
</div>
</body>
</html>
