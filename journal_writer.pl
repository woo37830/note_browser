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
my $filename = "sorted.txt";
my $journal = "";
open(SORTED, '<', $filename) or die "Could not open file '$filename' $!";
$PREV_YEAR = "";
$PREV_DATA = "";
  while( my $data = <SORTED> ) {

  if( $data =~ m!^---(\d\d\d\d).*\|! ) {
       $YEAR = $1;
  }

  if( $YEAR != $PREV_YEAR ) {
    if( $journal != "" ) {
      close(JOURNAL);
    }
    if( $YEAR != "" ) {
       $journal = "Journal_" . $YEAR . ".txt";
       open ( JOURNAL, ">", $journal ) or die "Count not create file $journal in directory $NOTE_DIR\n";
   }
   $PREV_YEAR = $YEAR;
}

$data =~ s/\|/\n/g;

print JOURNAL $data;

} # end of reading sorted file
  close(JOURNAL);
print "All Done!\n";
