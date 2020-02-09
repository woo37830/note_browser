#!/usr/bin/perl
#
# Read in a perl file from .diary and parse it
# to separate out the 'days' denoted by ---Thurs Feb  6 10:53:58 EST 2020, for instance
#                                       ----Wed Dec 12 11:02:26 EST 1990---
# and ouput the following lines each preceded by the date in format
# YYYY-MM-DD (time?)
#
#
my %months = (
  Jan => '01',
  Feb => '02',
  Mar => '03',
  Apr => '04',
  May => '05',
  Jun => '06',
  Jul => '07',
  Aug => '08',
  Sep => '09',
  Oct => '10',
  Nov => '11',
  Dec => '12',
);
$NOTE_DIR="/Users/woo/Dropbox/Personal/Documents/Notes/";
my $filename = "tmp.txt";
open(TMP, '>>', $filename) or die "Could not open file '$filename' $!";
$PREV_DATE = "";
$PREV_DATA = "";
my $file = ".diary";
open( INPUT, "<", $NOTE_DIR . $file) or die $!;
  print $file . "\n---------------------------------------\n";
  while( my $data = <INPUT> ) {
# compare against mm-dd-yy, m-d-yy, mm-dd-yyyy, or use / instead of -
# then compare agains yy-mm-dd or yyyy-mm-dd
  $DATESTR = "";


  if( $data =~ m!^-?---(Sun|Mon|Tue|Wed|Thu|Fri|Sat)\s*(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s*(\d?\d)\s*(\d?\d:\d?\d:\d?\d)\s*.*\s*(\d\d\d\d).*$! ) {
       $DOW = $1;
       $MON = $2;
       $MM = $months{$MON};

       $DD = $3;
       if( length($DD) == 1 ) {
         $DD = "0" . $DD;
       }
       $TIME = $4;
       $YY = $5;
       $DATESTR = $YY . $MM . $DD . " " . $TIME;

       #print "\tvalues: dow: $DOW, mon: $MON, mm: $MM, dd: $DD, yy: $YY, time: $TIME, datestr: $DATESTR\n";

   }


   if( $DATESTR == "" ) {
     $data =~ s/\n/|/g;
     $data =~ s/\r//g;
     $PREV_DATA = $PREV_DATA . $data;
     #print "prev data: " . $PREV_DATA;
   } else {
     print TMP "---" . $PREV_DATE . "|" . $PREV_DATA . "\n";
     $PREV_DATA = "";
     $DATESTR =~ s/\n/\|/g;
     $DATESTR =~ s/\r//g;
     $PREV_DATE = $DATESTR;
   }
  }
  close(TMP);
print "All Done!\n";
