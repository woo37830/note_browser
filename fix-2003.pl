#!/usr/bin/perl
#
# Read in a perl file from Notes_YYYY.txt and parse it
# to separate out the 'days' denoted by YYYY-MM-dd OR MM/dd/YY HH:MM:SS or ?
# and ouput the following lines each preceded by the date in format
# YYYY-MM-DD (time?)
# line 1 with cr replaced by $CR$, i.e. one line per entry. up to next date.
# output to temp.txt appending.
#
# problems with 3 - has nn) mm-dd-yyyy
#               6 - has 1-6-2006
#               7,8,9 - has 2007-01-02
#               14 - short no dates
#
#  month regx: (0?[1-9]|10|11|12), n or 0n, 10, 11, 12 where n 1-9
#  day regx: ((0?[1-9])|([12])([0-9])|(3[01])), n or 0n - n=1-9 or 1n or 2n - n=0,9 , or 30, or 31
#  year regx: ((19)([2-9])(\d{1})|(20)([012])(\d{1})|([89012])(\d{1}))
#
$NOTE_DIR="/Users/woo/Dropbox/Personal/Documents/Notes/";
$file = "Notes_2003.txt";

open( INPUT, "<", $NOTE_DIR . $file) or die $!;
  print $file . "\n---------------------------------------\n";
  $file =~ m!Notes_(\d\d\d\d).txt!;
  $file_year = $1;
  print "File year: $file_year\n";
	while( my $data = <INPUT> ) {
# compare against mm-dd-yy, m-d-yy, mm-dd-yyyy, or use / instead of -
# then compare agains yy-mm-dd or yyyy-mm-dd

  $DATESTR = "";
  $TIMESTR = "";
  $date_len = length($data);
  if( $data =~ m!^(\d*\)\s*)!) {
    #print "\tstarts with $1, data=$data";
    $num_len = length($1);
    $remove = $date_len-$num_len;
    $data = substr($data,$num_len,$date_len-$num_len);
    #print "\tlen=$num_len, date_len=$date_len, data is now: '" . $data . "'";
  }
  if( $data =~ m!(.*[AP]M )!) {
    $TIMESTR = $1;
    #print "\tstarts with time: $TIMESTR\n";
    $data =~ s/.*M //;
    #print "\tdate is now: $data";
  }
  if( $data =~ m!(\s.*[AP]M)$!) {
    $TIMESTR = $1;
    #print "\tends with time: $TIMESTR\n";
    $data =~ s/\s.*[AP]M$//;
    #print "\tdate is now: '" . chomp($data) . "'\n";
  }
  if( $data =~ m!^(0?[1-9]|10|11|12)(-|\/)((0?[1-9])|([12])([0-9])|(3[01]))(-|\/)((19)([2-9])(\d{1})|(20)([01])(\d{1})|([8901])(\d{1}))|(0?[2469]|11)(-|\/)(([1-9])|(0[1-9])|([12])([0-9]?)|(3[0]?))(-|\/)((19)([2-9])(\d{1})|(20)([01])(\d{1})|([8901])(\d{1}))$! ) {
       $MM = $1;
       if( length($MM) == 1 ) {
         $MM = "0" . $MM;
       }
       $DD = $3;
       if( length($DD) == 1 ) {
         $DD = "0" . $DD;
       }
       $YY = $9;
       if( $YY < 190 ) {
         $YY = 1900 + $YY;
       }
       if( $9 >= 20 ) {
       #print "\tmon first-mm: $MM, dd: $DD, yy: $YY\n";
       $DATESTR = $YY . $MM . $DD;
     }
   }
  if( $DATESTR == "" ) {
    if( $data =~ m!^(\d?\d?\d\d)(-|\/)(\d?\d)(-|\/)(\d?\d)! ) {
      if( $file_year == "2012" || $file_year == "2010") {
        $MM = $1;
        $DD = $3;
        $YY = $5;
      } else {
      $MM = $3;

      $DD = $5;
      $YY = $1;
    }
      if( $YY < 75 ) {
        $YY = "20" . $YY;
      }
      if( length($MM) == 1 ) {
        $MM = "0" . $MM;
      }
      if( length($DD) == 1 ) {
        $DD = "0" . $DD;
      }

      #print "\tmm/dd/yy mm: $MM, dd: $DD, yy: $YY\n";
      $DATESTR = $YY . $MM . $DD;
    }
  }
  if ( $DATESTR == "" ) {
  if( $data =~ m!^((19)([2-9])(\d{1})|(20)([01])(\d{1})|([8901])(\d{1}))(-|\/)(0?[1-9]|10|11|12)(-|\/)(1[0-9]|2[0-9]|30|31|0?[1-9])$! ) {
    $MM = $11;
    $DD = $13;
    $YY = $1;
    #print "\tyear first-mm: $MM, dd: $DD, yy: $YY\n"  unless $YY < 9;
    if( $1 >= 0 ) {
      if( length($MM) == 1 ) {
        $MM = "0" . $MM;
      }
      if( length($DD) == 1 ) {
        $DD = "0" . $DD;
      }
      if( $YY < 190 ) {
        $YY = 1900 + $YY;
      }
      $DATESTR = $YY . $MM . $DD;
    }
  }
}
print "\t\tDATESTR = $DATESTR $TIMESTR\n" unless $DATESTR == "";

  }

print "All Done!\n";
