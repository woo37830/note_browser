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
echo "</body>";
echo "</html>";
?>
