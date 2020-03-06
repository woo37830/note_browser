<?php
// Beginning of tab4 code
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
// End of tab5 code
echo $tab4;
?>
