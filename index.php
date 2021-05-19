<?php 
if(!isset($_SESSION)){
  session_start();
}

  if(isset($_GET['p'])){
    if($_GET['p'] == 'register'){
      require("View/register.php");
      die();
    }

    if($_GET['p'] == 'login'){
      require("View/login.php");
      die();
    }

    if($_GET['p'] == 'history'){
      require("View/history.php");
      die();
    }

    if($_GET['p'] == 'logout'){
      session_destroy();
      header("Location: index.php");
      die();
    }
  }
  require("View/index.php");
?>