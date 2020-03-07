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
 $total = $parsed[6];
 $last_line = "<h3>Billing</h3>";
 if( $end ) {
   $last_line .= "No one.";
 } else {
   $last_line .= $client . " for  '" . $task . "' since " . $start ;
 }
 if( $total ) {
   $last_line .= "<br />$total";
 }
 $html = nl2br($last_line);
 $data5 .= $html;
 $raw = $parsed[5];
 $raw .= "<br /><hr /><br /><form method='post' action='./index.php' ><input type='text' name='on' value='' width='30' /><input type='submit' id='btnOn' name='btnOn' value='On'/><input type='submit' id='btnOff' name='btnOff' value='Off'/><input type='submit' id='btnCancel' name='btnCancel' value='Cancel'/></form>";

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
 function get_yearMonDayHourMin( $time_str ) {
   //echo "<br />time_str: $time_str";
   $time = explode(' ', $time_str); // gives mm/dd/yyyy
   $pieces = explode('/', $time[0]);
   $hhmm = explode(':', $time[1]);
   //echo "<br />ymdhm = $pieces[2],$pieces[0],$pieces[1],$hhmm[0],$hhmm[1]";
   return array($pieces[2],$pieces[0],$pieces[1],$hhmm[0],$hhmm[1]);
 }
 function get_dates( $line ) {
   // return start, end, (start_ymdhm, end_ymdhm), task, client
   $pieces = explode(') ', $line); // gives times, rest of string
   $time_str = $pieces[0]; // start : end

   $time_str = substr($time_str, 1); // strip off the leading ()
   $times = explode(' - ', $time_str);
   $start = $times[0];
   $end = $times[1];

   $start_ymdhm = get_yearMonDayHourMin( $start );
   $end_ymdhm = get_yearMonDayHourMin( $end );
   $task_client = explode('@', $pieces[1]); // task @ client
   $task = $task_client[0];
   $client = $task_client[1];
   return array($start, $end, $start_ymdhm, $end_ymdhm, $task, $client );
 }
 function get_billed($start, $end) {
   $date1 = new DateTime($start);
   if( empty( $end ) ) {
     $date2 = new DateTime();
   } else {
     $date2 = new DateTime( $end );
   }
   $diff = $date2->diff($date1);
   $ret =  60*((24*$diff->d)+$diff->h)+$diff->i;
   //echo "<br />$start, $end, $ret";
   return $ret;
 }
 function get_todays_billed($lines) {
      $num = count($lines);
      $year = date('Y');
      $mon = date('m');
      $day = date('d');
      //echo "<br/>year: $year, mon: $mon, day: $day";
      $ret = "<br/><table><tr><th>Client</th><th>Billed</th></tr>";
      $billing = array();
      for( $i = $num-1; $i >= $num-3; $i-- ) {
        $dates = get_dates( $lines[$i] ); // return Y, m, d in array followed by start, end
        $start_ymdhm = $dates[2];
        $start_month = $start_ymdhm[1];
        $start_day = $start_ymdhm[2];
        $start_year = $start_ymdhm[0];
        if( $start_year == $year && $start_month == $mon && $start_day == $day ) {
          $client = $dates[5];
          if( empty($billing[$client]) ) {
            $billing[$client] = 0;
          }
          $billing[$client] += get_billed($dates[0], $dates[1]);
          }
      }
      $total = 0;
      foreach( $billing as $aclient=>$value ) {
        if( $value < 3 ) {
          $value = "Not Much";
        }
        $total += $value;
        $ret .= "<tr><td>" . $aclient . "</th><td>" . $value . " minutes</td></tr>";
      }
      $ret .= "<tr><td>Total</td><td>$total</td></tr></table>";
      return $ret;
 }
 function parse_last_line($source) {
   $raw = file_get_contents($source);
   $lines = preg_split("/\n/",$raw);
   $num = count($lines);
   // Check if last line has no end time
   $dates = get_dates( $lines[$num-1]);
   $start_ymdhm = $dates[2];
   //echo "<br />get_dates: $dates[0], $dates[1], $start_ymdhm[0], $start_ymdhm[1], $start_ymdhm[2], $start_ymdhm[3] ";
   $start = $dates[0];
   $end = $dates[1];
   $task = $dates[4];
   $client = $dates[5];
   // Get totals for today
   $total = get_todays_billed($lines);
   //die("<br />$total<br />All Done");
   $begin = $num -10;
   $raw = "<h3>Recent Actions</h3><br />";
   for( $i = $begin; $i <= $num; $i++ ) {
       $raw .= $lines[$i] . "\n";
   }
   return array($start, $end, $task, $client, $num, $raw, $total);
 }
 ?>
