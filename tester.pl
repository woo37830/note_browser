#!/usr/bin/perl
#
# problems with 3 - has nn) mm-dd-yyyy
#               6 - has 1-6-2006
#               7,8,9 - has 2007-01-02
#               14 - short no dates
#
#  month regx: (0?[1-9]|10|11|12), n or 0n, 10, 11, 12 where n 1-9
#  day regx: ((0?[1-9])|([12])([0-9])|(3[01])), n or 0n - n=1-9 or 1n or 2n - n=0,9 , or 30, or 31
#  year regx: ((19)([2-9])(\d{1})|(20)([012])(\d{1})|([89012])(\d{1}))
#  leading nn) : (\d\d\) )? - Possible leading nn) . In Notes_2003.txt
#  Leading time (.*[AP]M )?  : (.*[AP]M )? - Possible leading time in Notes_2005.txt
@dates = ("30) 01-20-2003\n","301) 01-20-2003\n","30)  01-20-2003\n","3)  01-31-2003\n","53)  01-31-2003\n","2000-10-30\n","2000-09-15\n","1/14/12 10:15:04 PM\n","02-01-05\n","7:02 PM 2/22/2005\n","2006-04-02\n","2006-04-09\n","2006-04-10\n","2006-04-23\n","2006-04-31\n","4-23-2006\n","01-02-2002\n","01/02/2002\n","1-2-2002\n","1-6-2006\n","2007-01-02\n","11/30/11 9:53:41 AM\n","11/30/98 9:53:41 AM\n");
foreach $date (@dates)  {
  print $date ;
  $DATESTR = "";
  $TIMESTR = "";
  if( $date =~ m!^(\d*\) )!) {
    print "\tstarts with $1\n";
    $date =~ s/.*\)\s*//;
    print "\tdate is now: $date";
  }
  if( $date =~ m!(.*[AP]M )!) {
    $TIMESTR = $1;
    print "\tstarts with time: $TIMESTR\n";
    $date =~ s/.*M //;
    print "\tdate is now: $date";
  }
  if( $date =~ m!(\s.*[AP]M)$!) {
    $TIMESTR = $1;
    print "\tends with time: $TIMESTR\n";
    $date =~ s/\s.*[AP]M$//;
    print "\tdate is now: $date";
  }
  if( $date =~ m!(0?[1-9]|10|11|12)(-|\/)((0?[1-9])|([12])([0-9])|(3[01]))(-|\/)((19)([2-9])(\d{1})|(20)([01])(\d{1})|([8901])(\d{1}))|(0?[2469]|11)(-|\/)(([1-9])|(0[1-9])|([12])([0-9]?)|(3[0]?))(-|\/)((19)([2-9])(\d{1})|(20)([01])(\d{1})|([8901])(\d{1}))! ) {
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
       print "\tmon first-mm: $MM, dd: $DD, yy: $YY\n";
       $DATESTR = $YY . $MM . $DD;
   }
   }
   if( $DATESTR == "" ) {
     if( $date =~ m!^(\d?\d?\d?\d)(-|\/)(\d?\d)(-|\/)(\d?\d)! ) {
       if( $file_year == "2012" || $file_year == "2010" || $file_year == "2013" ) {
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
     }   }
  if ( $DATESTR == "" ) {
  if( $date =~ m!((19)([2-9])(\d{1})|(20)([01])(\d{1})|([8901])(\d{1}))(-|\/)(0?[1-9]|10|11|12)(-|\/)(1[0-9]|2[0-9]|30|31|0?[1-9])! ) {
    $MM = $11;
    $DD = $13;
    $YY = $1;
    print "\tyear first-mm: $MM, dd: $DD, yy: $YY\n"  unless $YY < 9;
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
print "\t\tDATESTR = $DATESTR $TIMESTR\n";

}

print "All Done!\n";
