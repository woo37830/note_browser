<?php
// Beginning of tab3 code
$tab3 = "<div id='To Do' class='tabcontent'>";
$data3 = "<div class='data'>";
$data3 .= "<center><h2>ToDo List</h2></center><br/>";
$link_path = readlink('link');
$source = $link_path."/.todo";
$raw = file_get_contents($source);
$lines = preg_split("/\n/",$raw);
$num = count($lines);
for( $i = 0; $i <= $num; $i++ ) {
    echo  $lines[$i] . "\n" ;
}
?>
