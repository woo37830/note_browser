<?php
$NOTE_DIR="/Users/woo/Dropbox/Personal/Documents/Notes/";
echo "<html>";
echo "<head>";
echo "</head>";
echo "<body>";
   echo "<center><h1>Journal Entries</h1></center>";    

echo "<ul>";
if ($handle = opendir($NOTE_DIR) ) {
    $files = glob($NOTE_DIR . "Journal_*.txt");
    foreach( $files as $file) {
    $filename = basename($file, ".txt");
    $year = substr($filename, -4);
    // extract filename and show with link to page with full filepath
    echo "<li><a href='./page.php?year=$year'>$filename</a></li>";
    }
closedir($handle);
}
echo "</ul>";
echo "<p />";
echo "<hr />";
echo "<center><h2>Recent Notes</h2></center><br/>";
$YYYY=date('Y');
$source = "$NOTE_DIR"."Journal_$YYYY.txt";
$raw = file_get_contents($source);
$lines = preg_split("/\n/",$raw);
$num = count($lines);
$start = $num -20;
$raw = "";
for( $i = $start; $i <= $num; $i++ ) {
    $raw .= $lines[$i] . "\n";
}
$html = nl2br($raw);
$output = "<div>$html</div>";
echo "$output";
echo "<p />";
echo "<center><h2>ToDo List</h2></center><br/>";
$source = "$NOTE_DIR".".todo";
$raw = file_get_contents($source);
$lines = preg_split("/\n/",$raw);
$num = count($lines);
$start = 0;
$raw = "";
for( $i = $start; $i <= $num; $i++ ) {
    $raw .= $lines[$i] . "\n";
    }
$html = nl2br($raw);
$output = "<div>$html</div>";
echo "$output";
echo "</body>";
echo "</html>";
?>
