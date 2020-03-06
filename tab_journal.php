<?php
// Beginning of tab1 code
 $tab1 =   "<div id='Years' class='tabcontent'>";
 $data1 = "<div class='data'>";
 $data1 .= "<center><h3>Journal Entries</h3></center>";

 $data1 .= "<ul>";

if ($handle = opendir($NOTE_DIR) ) {
    $files = glob($NOTE_DIR . "Journal_*.txt");
    foreach( $files as $file) {
    $filename = basename($file, ".txt");
    $year = substr($filename, -4);
    // extract filename and show with link to page with full filepath
    $data1 .= "<li><a href='./page.php?year=$year'>$filename</a></li>";
    }
closedir($handle);
}
$data1 .= "</ul>";
$data1 .= "</div>";
$tab1 .= $data1 . "</div>";// end data
//  End of tab1 code
echo $tab1;
?>
