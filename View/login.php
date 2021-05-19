<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userTodolist'])) {
    // header("Location: login.php");
    require "index.php";
    die();
}

require("ConnexionBD.php");

if(isset($_POST['login'])) {
   $password = sha1($_POST['password']);

   $login = $_POST['login'];
  
   $req = $pdo->prepare("SELECT * FROM users WHERE login=? AND password=?");
   $req->execute([$login, $password]); 
   $user = $req->fetch();

   if(!empty($user)){
      $_SESSION['userTodolist'] = [
         'id' => $user['id'],
         'login' => $user['login'],
         'email' => $user['email']
      ];

      header("Location: index.php");
      die();
   }else{
      echo "Echec de connexion";
   }
}

?>

<html>
<head>
<title>TodoList - Login</title>
</head>
<body>

   <div class="header">

   </div>

   <div class="section-body">
      <div class="form-contain">
         <form class="form" method="POST">
            <label for="login">Login
            <input type="text" name="login" required>
            </label>

            <label for="login">Password
            <input type="password" name="password" required>
            </label>

            <label>
              <input type="submit" value="Login">
            </label>
         </form>
      </div>
   </div>

   <a href="?p=register">Inscription</a>
    
</body>

</html>
