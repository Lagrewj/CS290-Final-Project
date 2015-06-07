function login() {
//The XMLHttpRequest object is used to exchange data with a server behind the scenes. 
//This means that it is possible to update parts of a web page, without reloading the whole page.
//creating new xmlhttp request
  var xmlhttp = new XMLHttpRequest();
  if (!xmlhttp) {
    throw 'Unable to create HttpRequest.';
  }
  
  var username = document.getElementsByName('username')[0].value;
  var password = document.getElementsByName('password')[0].value;
  
  var params = [];
  params['username'] = username;
  params['password'] = password;
  
  var encodedParams = [];
  for (var prop in params) {
    var pair = encodeURIComponent(prop) +
              '=' + encodeURIComponent(params[prop]);
    encodedParams.push(pair);
  }
//if successful login will redirect page to main.php
  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
      if (xmlhttp.responseText == 'Login Successful') {
        window.location.href = "main.php";
      } else {
        document.getElementById('errorMsg1').innerHTML = xmlhttp.responseText;
      }
    }
  };
//authenticate.php will open
  xmlhttp.open('POST', 'authenticate.php');
  xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xmlhttp.send(encodedParams.join('&'));
}

function createAcct() {
  var xmlhttp = new XMLHttpRequest();
  if (!xmlhttp) {
    throw 'Unable to create HttpRequest.';
  }
  
  var newUsername = document.getElementsByName('newUsername')[0].value;
  var newPassword1 = document.getElementsByName('newPassword1')[0].value;
  var newPassword2 = document.getElementsByName('newPassword2')[0].value;
  
  var params = [];
  params['newUsername'] = newUsername;
  params['newPassword1'] = newPassword1;
  params['newPassword2'] = newPassword2;
  
  var encodedParams = [];
  for (var prop in params) {
    var pair = encodeURIComponent(prop) +
              '=' + encodeURIComponent(params[prop]);
    encodedParams.push(pair);
  }

  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
      if (xmlhttp.responseText == 'Account Creation Successful') {
        window.location.href = "main.php";
      } else {
        document.getElementById('errorMsg2').innerHTML = xmlhttp.responseText;
      }
    }
  };
//open createAcct.php
  xmlhttp.open('POST', 'createAcct.php');
  xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xmlhttp.send(encodedParams.join('&'));
}