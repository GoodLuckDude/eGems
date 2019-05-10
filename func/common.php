<?php
//it's func for for general use
function checkAuthorization() {
  if ($_SESSION['authorized']<>true) {
    return false;
  }
  return true;
}

//save url's this page in'$_SESSION['neededPage']' for redirect after login
function rememberThisPage() {
  $_SESSION['neededPage'] = $_SERVER['SCRIPT_NAME']; //NOTE почему не работает php_self???
};

//redirect to login page
function goToLoginPage() {
	header("Location: http://localhost");
	die();
};

function redirIfGuest() {
  if(checkAuthorization() == false) {
    rememberThisPage();
    goToLoginPage();
  }
}

?>