<?php
// Beginning of tab5 code
 $source = "$NOTE_DIR"."time_track.txt";
 $datestr = date('m/d/Y h:m');
 $tab5 =   "<div id='Billing' class='tabcontent'>";
 $data5 = "<div class='data'>";
 if (isset($_REQUEST["btnOn"])){
  if( empty($_REQUEST['on']) )
  {
    $data5 .= "<h3>You must provide a task followed by @client-name</h3>";
  } else {
    if( !strpos($_REQUEST['on'], '@') )
    {
      $data5 .= "<h3>You must provide a client after the task as @client-name</h3>";
    } else {
      $data5 .= turn_on($source, $_REQUEST['on'], $datestr);
    }
  }
} else if (isset($_REQUEST["btnOff"])){
  $data5 .= turn_off($source, $datestr);
}
 $parsed = parse_last_line($source);
 $start = $parsed[0];
 $end = $parsed[1];
 $task = $parsed[2];
 $client = $parsed[3];
 $num = $parsed[4];
 $last_line = "<h3>Billing</h3>";
 if( $end ) {
   $last_line .= "No one.";
 } else {
   $last_line = $client . " for  '" . $task . "' since " . $start ;
 }
 $html = nl2br($last_line);
 $data5 .= $html;
 $raw = $parsed[5];
 $raw .= "<br /><hr /><br /><form action='./index.php' ><input type='text' name='on' value='' width='30' /><input type='submit' id='btnOn' name='btnOn' value='On'/><input type='submit' id='btnOff' name='btnOff' value='Off'/><input type='submit' id='btnCancel' name='btnCancel' value='Cancel'/></form>";

 $html = nl2br($raw);
 $data5 .= $html;
 $data5 .= "</div>"; // end data
 $tab5 .= $data5 . "</div>";
 // End of tab2 code
 echo $tab5;
 function turn_on($source, $data, $date_str) {
    return "Turned on with $data at $date_str";
 }
 function turn_off($source, $date_str) {
    return "Turned off at: $date_str";
 }
 function parse_last_line($source) {
   $raw = file_get_contents($source);
   $lines = preg_split("/\n/",$raw);
   $num = count($lines);
   // Check if last line has no end time
   $pieces = explode(') ', $lines[$num-1]); // gives times, rest of string
   $time_str = $pieces[0]; // start : end
   $time_str = substr($time_str, 1); // strip off the leading ()
   $times = explode(' - ', $time_str);
   $start = $times[0];
   $end = $times[1];
   $pieces = explode('@', $pieces[1]); // task @ client
   $task = $pieces[0];
   $client = $pieces[1];
   $begin = $num -10;
   $raw = "<h3>Recent Actions</h3><br />";
   for( $i = $begin; $i <= $num; $i++ ) {
       $raw .= $lines[$i] . "\n";
   }
   return array($start, $end, $task, $client, $num, $raw);
 }
 ?>
