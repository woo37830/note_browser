<?php
$scripts =<<<EOS
<script type="text/javascript">
if( readCookie("tab") ) {
  document.getElementById( readCookie("tab")).click();
} else {
  document.getElementById('Latest').click();
}

function openTab(evt, cityName) {
  // Declare all variables
  var i, tabcontent, tablinks;
  //alert('Clicked Tab ' + cityName);
  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
    if( tabcontent[i].id == cityName ) {
      tabcontent[i].style.display = "block";
      createCookie('tab', cityName);
    }
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  if( readCookie("logged_in") ) {
                  $("#log_in").text("Logout: "+readCookie('userid'));
                  $("#log_in").attr('id', 'log_out');
                    $(".data").attr('class', 'show');
                    $("#no-access").attr('class','hide');
                    $("#lin").attr('class','hide');
                    $("#lin-buttons").attr('class','hide');


  // Show the current tab, and add an "active" class to the button that opened the tab
  //document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";

} else {
            $("#log_out").text("Login");
            $("#log_out").attr('id', 'log_in');
              $(".data").attr('class', 'hide');
              $("#no-access").attr('class','show');
}
}

const state = { 'page_id': 1, 'add': '', 'delete': '', 'diary': ''}
const title = 'Browse'
const url = 'index.php'

history.pushState(state, title, url)
EOS

?>
