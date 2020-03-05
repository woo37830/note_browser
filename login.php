<?php
$scripts =<<<EOS
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
//     Note:  # is used for ids, while . is used for classes

      if( !readCookie('userid') )
      {
        eraseCookie('logged_in');
      }
      if( readCookie("logged_in") ) {
                      $("#log_in").text("Logout: "+readCookie('userid'));
                      $("#log_in").attr('id', 'log_out');
                        $(".data").attr('class', 'show');
                        $("#page").attr('class', 'show');
                        $("#no-access").attr('class','hide');
                        $("#lin").attr('class','hide');
                        $("#lin-buttons").attr('class','hide');
      } else {
                  $("#log_out").text("Login");
                  $("#log_out").attr('id', 'log_in');
                    $(".data").attr('class', 'hide');
                    $("#page").attr('class', 'hide');
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
EOS

?>
