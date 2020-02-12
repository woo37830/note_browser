<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="./_js/jquery.easyui.min.js"></script>
<link rel="stylesheet" href="_css/layout.css" id="styleid" type="text/css" />
<link rel="stylesheet" href="_css/dlg-form.css" id="formid" type="text/css" />
<link rel="stylesheet" type="text/css" href="./themes/default/easyui.css">

</head>
<body>
  <!-- Tab links -->
  <div class="tab">
    <button class="tablinks" onclick="openCity(event, 'Years')">Years</button>
    <button class="tablinks" id="defaultOpen" onclick="openCity(event, 'Latest')">Latest</button>
    <button class="tablinks" onclick="openCity(event, 'To Do')">To Do</button>
  </div>


  <div class="wrapper" >

  <header>

  </header>
  <div id="content">

  <div id="log_in">Login</div>
<div class="title">
    Journal Explorer
  </div>
  <div id="no-access">
    <center><h3>You must be logged in to Browse the Journal</h3></center>
  </div>
 <div id="data">
   <!-- Tab content -->
   <div id="Years" class="tabcontent">
     <center><h3>Journal Entries</h3></center>
<ul>
<?php
  $NOTE_DIR="/Users/woo/Dropbox/Personal/Documents/Notes/";

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

echo "</div>"; // end of journal entries

echo "<p />";
?>
<div id="Latest" class="tabcontent" >
<?php
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
echo "</div>"; //end of recent notes
?>
<div id="To Do" class="tabcontent">
<?php
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
echo "</div>";
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

document.getElementById("defaultOpen").click();

function openCity(evt, cityName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

        if( readCookie("logged_in") ) {
                        $("#log_in").text("Logout: "+readCookie('userid'));
                        $("#log_in").attr('id', 'log_out');
                          $("#data").attr('class', 'show');
                          $("#no-access").attr('class','hide');
                          $("#lin").attr('class','hide');
                          $("#lin-buttons").attr('class','hide');
        } else {
                    $("#log_out").text("Login");
                    $("#log_out").attr('id', 'log_in');
                      $("#data").attr('class', 'hide');
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
            function authorize() {
                // Compare the form data to the json data and if match, createCookie, else logout;
                // alert("json data: " + json.user[1] + ", " + json.passwd);
                //alert("form data: " + document.getElementById("userid").value);
                uName = document.getElementById("userid").value;
                var pName = document.getElementById("password").value;
               $('#lin').dialog('close');
               var done = false;
             for( var i=0;i<users.length&&!done;i++) {
                 // alert("Testing '"+users[i].user+"' and '"+users[i].passwd+"'");
                    if( uName == users[i].user && pName == users[i].passwd ) {
                        createCookie('logged_in', 'yes', days);
                        createCookie('userid', uName);
                        user = uName;
                        done = true;
                    }
                }
                if( !done ) {
                        alert('username or password not found');
                        logout();
                } else {
                   // alert("Cookie: 'logged_in': "+readCookie('logged_in'));
                    }
                    window.location.reload();
                }
                // Cookie functions
              function createCookie(name,value,days) {
                if (days) {
                  var date = new Date();
                  date.setTime(date.getTime()+(days*24*60*60*1000));
                  var expires = "; expires="+date.toGMTString();
                }
                else var expires = "";
                document.cookie = name+"="+value+expires+"; path=/";
              }

              function readCookie(name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for(var i=0;i < ca.length;i++) {
                  var c = ca[i];
                  while (c.charAt(0)==' ') c = c.substring(1,c.length);
                  if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
                }
                return null;
              }

              function eraseCookie(name) {
                createCookie(name,"",-1);
                //alert("Cookie: "+name+": "+readCookie(name));
                  }
                var logged_in = document.getElementById('logged_in');
                if (readCookie('logged_in') ) {
                    createCookie('logged_in', 'yes', days);
                } else {
                    toolbar.className = 'hide';
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
      <input name="user" class="easyui-textbox" id="userid" required="true">
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
