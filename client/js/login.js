//variable
var urlServer='http://localhost/door2door/server/';
var urlMedia='http://localhost/door2door/server/img/';

var x = new XMLHttpRequest();

function login()
{
  var user = document.getElementById('user').value;
  var pass = document.getElementById('pass').value;
	
 /*----------------------------------------------------------------------*/
 
  x.open('POST', urlServer + 'login.php', true);
	var form = new FormData();
	
	form.append('user', user);
	form.append('pass', pass);
	
  x.send(form);
	
  x.onreadystatechange = function() {
    //check status
		if (x.readyState == 4 & x.status == 200)
		{
			//read response
			var data = x.responseText;
			console.log(data);
			//parse to json
			var JSONdata = JSON.parse(data);
			//check status
			if (JSONdata.status == 0)
			{
				//save info
        sessionStorage.perID = JSONdata.person.id;
        sessionStorage.username = JSONdata.username;
				sessionStorage.name = JSONdata.person.fullName;
				sessionStorage.token = JSONdata.token;
				sessionStorage.role = JSONdata.person.role;
				
				switch(sessionStorage.role)
				{
					case 0:
					case 1:
						window.location.href = 'profile.html';
						break;
					case 2:
						window.location.href = 'guard.html';
						break;
					default:
						alert('error');
						break;
				}
			}
			else
			{
				alert('Incorrect user or password');
			}
		}
  }
}