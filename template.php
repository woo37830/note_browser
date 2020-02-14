<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="./_js/jquery.easyui.min.js"></script>
<script type="text/javascript" src="./_js/cookies.js"></script>
<script type="text/javascript" src="./_js/authorize.js"></script>
<link rel="stylesheet" href="_css/layout.css" id="styleid" type="text/css" />
<link rel="stylesheet" href="_css/dlg-form.css" id="formid" type="text/css" />
<link rel="stylesheet" type="text/css" href="./themes/default/easyui.css">

</head>
<body>
  <!-- Tab links -->

  <div class="wrapper" >

  <header>
    Header
  </header>
  <div id="content">

    <div id="log_in">Login</div>
    <div class="title">
      Template for login to display data
    </div>
    <div id="no-access">
      You must be logged in to Browse the Journal
    </div>

<?php
  $slug="Slug";
  $byline="byline";
  $raw="Hello, World!";
  // Creating raw reading from file, etc.
?>
<?php
  // Process teh raw data into a form for the page
  $html = nl2br($raw);
  // add page content
  $output .= "<center><div class='slug'>$slug</div>";
  $output .= "<div class='byline'>$byline</div></center><p />";
  $output .= "<hr />";
  $output .= "<p /><center>$prev_link <a href='./index.php'>Back</a> $next_link </center><p />";
  $output .= "<div id='page'>";
  $output .= "<div class='data'>";
  $output .= "<div>$html</div>";
  $output .= "</div>"; // end data
  $output .= "</div>"; // end page
  // add return button
  $output .= "<p /><center>$prev_link <a href='./index.php'>Back</a> $next_link </center><p />";

  echo "$output";
  require 'login.php';
  echo "$scripts";
  echo "</div><br />"; // end content
?>


<div id="footer" >
  <hr />
  <em><?php
  include 'git-info.php';
  ?></em>
</div>
</div>
</div>


</body>
</html>
