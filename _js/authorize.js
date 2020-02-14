// Authorize
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
