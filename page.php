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
$html = nl2br(htmlspecialchars($data));

// replace multiple spaces with single spaces
$html = preg_replace('/\s\s+/', ' ', $html);

// replace URLs with <a href...> elements
$html = preg_replace('/\s(\w+:\/\/)(\S+)/', ' <a href="\\1\\2" target="_blank">\\1\\2</a>', $html);

// start building output page
// add page header
$output =<<< HEADER
<html>
<head>
<style>
.slug {font-size: 15pt; font-weight: bold}
.byline { font-style: italic }
</style>
</head>
<body>
HEADER;

// add page content
$output .= "<center><div class='slug'>$slug</div>";
$output .= "<div class='byline'>$byline</div></center><p />";
$output .= "<hr />";
$output .= "<p /><center>$prev_link <a href='./index.php'>Back</a> $next_link </center><p />";

$output .= "<div>$html</div>";
// add return button
$output .= "<p /><center><a href='./index.php'>Back</a></center><p />";

// add page footer
$output .=<<< FOOTER
</body>
</html>
FOOTER;

// display in browser
echo $output;
?>
