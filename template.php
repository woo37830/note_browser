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
  echo "</div><br />";
?>


<script type="text/javascript">
$(document).on('click','#log_in', function() {
$.getJSON( "./users.txt", function( json ) {
     $.each(json, function( key, value) {
     //for( var i=0; i<value.length; i++ ) {
    //alert("user = "+value[i].user+" password = "+value[i].passwd);
    //}
    users = $.map(value, function(el) { return el });
  });
});
    login();
});
$(document).on('click','#log_out', function() {
    logout();
});


      if( readCookie("logged_in") ) {
                      $("#log_in").text("Logout: "+readCookie('userid'));
                      $("#log_in").attr('id', 'log_out');
                        $(".data").attr('class', 'show');
                        $("#no-access").attr('class','hide');
                        $("#lin").attr('class','hide');
                        $("#lin-buttons").attr('class','hide');
      } else {
                  $("#log_out").text("Login");
                  $("#log_out").attr('id', 'log_in');
                    $(".data").attr('class', 'hide');
                    $("#no-access").attr('class','show');
    }
             var days = 1;
          function login() {
                      $('#lin').dialog('open').dialog('set Title', 'Login');
                      $('#lfm').form('clear');
              }
          function logout() {
                  eraseCookie('logged_in');
                  eraseCookie('userid');
                  window.location.reload();
              }

</script>

<div id="footer" >
  <hr />
  <em><?php
  include 'git-info.php';
  ?></em>
</div>
</div>
</div>
<div id="lin" class="easyui-dialog" style="width:400px;height:380px;padding:10px 20px"
    closed="true" buttons="#lin-buttons">
  <div class="ftitle">Login</div>
  <form id="lfm" method="post" novalidate>
    <div class="fitem">
      <label>User:</label>
      <input name="user" class="easyui-textbox" id="userid" required="true" autofocus>
    </div>
    <div class="fitem">
      <label>Password:</label>
      <input name="passwd" type= "password" class="easyui-textbox" id="password" required="true">
    </div>
  </form>
</div>
<div id="lin-buttons">
  <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="authorize()" style="width:90px">Login</a>
  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#lin').dialog('close')" style="width:90px">Cancel</a>
</div>

</body>
</html>
