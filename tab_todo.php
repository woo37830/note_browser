<?php
// Beginning of tab3 code
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
      $raw .= "<a href='index.php?delete=".$i."' onclick=\"return confirm('Are you sure you want to delete this item?')\">$i ) </a>" . $lines[$i] . "\n";
    }
}
$raw .= "<br /><hr /><br /><form method='post' action='./index.php'  ><input type='textarea' name='add' value='' cols='50' rows='10' /><input type='submit' value='Add' /><input type='submit' value='Cancel' /></form>";
$html = nl2br($raw);
$data3 .= $html;
$data3 .= "</div>";
$tab3 .= $data3 . "</div>";
// End of tab3 code
echo $tab3;
?>
