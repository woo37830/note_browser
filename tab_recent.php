<?php
// Beginning of tab2 code
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
  fwrite($file, "\n---$datestr\n");
  fwrite($file, $_REQUEST['diary']);
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
$raw .= "<br /><hr /><br /><form method='post' action='./index.php' ><input type='textarea' name='diary' value='' cols='50' rows='10' /><input type='submit' value='Add' /><input type='submit' value='Cancel' /></form>";

$html = nl2br($raw);
$data2 .= $html;
$data2 .= "</div>"; // end data
$tab2 .= $data2 . "</div>";
// End of tab2 code
echo $tab2;
?>
