<?php
// Beginning of tab5 code
 $source = "$NOTE_DIR"."time_track.txt";
 $datestr = date('m/d/Y H:i');
 $tab5 =   "<div id='Billing' class='tabcontent'>";
 $data5 = "<div class='data'>";
 if (isset($_REQUEST["btnOn"])){
   if( $_REQUEST['task'] != '' && $_REQUEST['client'] != '' ) {
      $data5 .= turn_on($source, $_REQUEST['task'], $_REQUEST['client'], $datestr);
    }
  } else if (isset($_REQUEST["btnOff"])){
  turn_off($source, $datestr);
}
 $parsed = parse_last_line($source);
 $start = $parsed[0];
 $end = $parsed[1];
 $task = $parsed[2];
 $client = $parsed[3];
 $num = $parsed[4];
 $lines = $parsed[5];
 $billing = "<h3>Billing</h3>";
 if( trim($end) != "" ) {
   $billing .= "No one.";
 } else {
   $billing .= $client . " for  '" . $task . "' since " . $start ;
 }

 $raw = $billing;
 $raw .= "\n" . get_todays_billed($lines);
 $raw .= "\n" . get_recent_items($lines, $num);
 $form =<<<EOS
 <form method='post' action='./index.php' id='myform' >
 <table><tr><th>Task</th><th>Client</th><th></th><th></th><th></th><th></th></tr>
 <tr><td><input type='text' id='taskField' name='task' value='' width='50' /></td>
 <td><input type='text' id='clientField' name='client' value='' width='30' /></td>
 <td><input type='submit' id='btnOn' name='btnOn' value='On'/></td>
 <td><input type='submit' id='btnOff' name='btnOff' value='Off'/></td>
 <td><input type='submit' id='btnCancel' name='btnCancel' value='Cancel'/></td></tr>
 </table></form>
 EOS;
 $raw .= $form;
 $html = nl2br($raw);
 $data5 .= $html;
 $data5 .= "</div>"; // end data
 $tab5 .= $data5 . "</div>";
 // End of tab2 code
 echo $tab5;
 function get_recent_items($lines, $num) {
   //die("<br />$total<br />All Done");
   $begin = $num -10;
   $raw = "<h3>Recent Actions</h3><br />";
   for( $i = $begin; $i < $num; $i++ ) {
       $raw .= $lines[$i] . "\n";
   }
   return $raw;
 }
 function turn_on($source, $task, $client, $datestr) {
   turn_off($source, $datestr);
   $file = fopen($source, 'a');
   $task = trim($task);
   $client = str_replace(' ', '', $client);
   $client = str_replace('@','', $client);
   $newline = "\n(" . $datestr . " - ) " . $task . ' @' . $client;
   fwrite($file, $newline);
   fclose($file);
 }
 function turn_off($source, $datestr) {
   $parsed = parse_last_line($source);
   if( empty($parsed[1]) ) {
     $lines = $parsed[5];
     $num = $parsed[4];
     echo "<br />num: $num";
     $newline = "(" . $parsed[0] . " - " . $datestr . ") " . $parsed[2] . " @" . $parsed[3];
     $file = fopen($source, 'w');
     $k = 0;
     for( $i = 0; $i < $num-1; $i++ ) {
       $k++;
       fwrite($file, $lines[$i]."\n");
     }
     echo "<br />wrote: $k lines";
     fwrite($file, $newline."\n");
     echo "<br />wrote: $newline";
     fclose($file);
   }
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
   $times = explode('-', $time_str);
   $start = trim($times[0]);
   $end = trim($times[1]);

   $start_ymdhm = get_yearMonDayHourMin( $start );
   $end_ymdhm = get_yearMonDayHourMin( $end );
   //echo "<br />pieces[1] = '".$pieces[1]."'<br />";
   $pos = strpos($pieces[1],"@");
   $task = substr($pieces[1],0,$pos);
   $client = substr($pieces[1],$pos+1);
   //echo "<br />pos = $pos, task = '".$task."', client = '".$client."'<br />";
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
      $ret = "<h3>Today</h3>";
      $ret .= "<br/><table><tr><th>Client</th><th>Billed</th></tr>";
      $billing = array();
      for( $i = $num-2; $i >= 0; $i-- ) {
        $dates = get_dates( $lines[$i] ); // return Y, m, d in array followed by start, end
        $start_ymdhm = $dates[2];
        $start_month = $start_ymdhm[1];
        $start_day = $start_ymdhm[2];
        $start_year = $start_ymdhm[0];
        $end_ymdhm = $dates[3];
        $end_month = $end_ymdhm[1];
        $end_day = $end_ymdhm[2];
        $end_year = $end_ymdhm[0];
        if( ($start_year == $year && $start_month == $mon && $start_day == $day)
            || ($end_year == $year && $end_month == $mon && $end_day == $day) ) {
          $client = $dates[5];
          if( empty($billing[$client]) ) {
            $billing[$client] = 0;
          }
          $billing[$client] += get_billed($dates[0], $dates[1]);
          }
          else {
            break;
          }
      }
      $total = 0;
      foreach( $billing as $aclient=>$value ) {
        $total += $value;
        $ret .= "<tr><td>" . $aclient . "</th><td align='right'>" . format_time($value) . "</td></tr>";
      }
      $ret .= "<tr><td>Total</td><td align='right'>" . format_time($total) . "</td></tr></table>";
      if( $total == 0 ) {
        return "<br />";
      }
      return $ret;
 }
 function format_time($amount) {
   if( $amount < 3 ) {
     return "Not Much";
   }
   $min_hr = 60;
   $min_day = 24 * 60;
   $days = "  ";
   if( $amount > $min_day ) {
      $days = ($amount - $amount % $min_day) / $min_day;
      $amount = $amount % ($days * $min_day);
      $days = $days . ":";
   }
   $mins = $amount % $min_hr;
   $hrs = round(($amount - $mins)/$min_hr);
   return $days . $hrs . ":" . $mins;
 }
 function parse_last_line($source) {
   $raw = file_get_contents($source);
   $lines = preg_split("/\n/",$raw);
   $num = count($lines);
   // Check if last line has no end time
   echo "<br />Last Line - num: $num, last line: ".$lines[$num-2]."<br />";
   $dates = get_dates( $lines[$num-2]);
   $start_ymdhm = $dates[2];
//   echo "<br />get_dates: $dates[0], $dates[1], $start_ymdhm[0], $start_ymdhm[1], $start_ymdhm[2], $start_ymdhm[3] ";
   $start = $dates[0];
   $end = $dates[1];
   $task = $dates[4];
   $client = $dates[5];
   return array($start, $end, $task, $client, $num, $lines);
 }
 ?>
 <script type='text/javascript'>
 $(document).ready(function() {
  var target = null;


 $('input:text').bind('focus blur', function() {
   this.setAttribute('style', 'background-color: white');
});
$("#myform input[type=submit]").click(function () {
    $("input[type=submit]", $(this).parents("form")).removeAttr("clicked");
    $(this).attr("clicked", "true");
});
 $('form').submit(function(event)  {
       var allIsOk = true;
       var clickedSubmitValue = $("input[type=submit][clicked=true]").val();

       if (clickedSubmitValue == "On") {
                // Check if empty of not
       $(this).find( 'input[type!="hidden"]' ).each(function () {
           if ( ! $(this).val() ) {
               this.setAttribute('style', 'background-color: red !important');
               allIsOk = false;
           }
       });
    }
       return allIsOk
});
});
  </script>
