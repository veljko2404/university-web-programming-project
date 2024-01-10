function login() {
    var login = document.getElementById('login');
    var status = document.getElementById('login_status');
    login.innerHTML = "Please wait";
    var http = new XMLHttpRequest();
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var data = 'username=' + username + '&password=' + password;
    var url = "login/login.php";
    http.open('POST', url, true);
  
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function() {
      if(http.readyState == 4 && http.status == 200) {
          if(http.responseText=="ok"){
            status.innerHTML = "Login successful!";
            status.style.color = "#00b74a";
            login.innerHTML = "Login successful!";
            login.style.pointerEvents = "none";
            login.style.backgroundColor = "#00b74a";
            location.reload();
          } else {
            status.innerHTML = http.responseText;
            status.style.color = "#f93154";
            login.innerHTML = "Login";
          }
      }
    }
    http.send(data);
  }
  