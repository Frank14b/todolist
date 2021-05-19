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
   $email = $_POST['email'];
  
   $sql = "INSERT INTO users (login, email, password) VALUES (?,?,?)";
   $req= $pdo->prepare($sql);
   $ans = $req->execute([$login, $email, $password]);

   if($ans){
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
      }
   }
}

?>

<html>
<head>
<title>TodoList - Register</title>
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

            <label for="email">Email
            <input type="email" name="email" required>
            </label>

            <label for="login">Password
            <input type="password" name="password" required>
            </label>

            <label>
              <input type="submit" value="Register">
            </label>
         </form>
      </div>
   </div>

   <a href="?p=login">Login</a>
    
</body>

</html>
