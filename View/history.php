<?php
if (!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION['userTodolist'])){
    // header("Location: login.php");
    require("login.php");
    die();
 }

require("ConnexionBD.php");

   $req = $pdo->prepare("SELECT * FROM history");
   $req->execute(); 
   $historiqs = $req->fetchAll();

?>

<html>
<head>
<title>TodoList - History</title>
</head>
<body>

<style>
      table, th, td {
      padding: 10px;
      border: 1px solid black;
      border-collapse: collapse;
      }

      table{
         width: 100%;
      }
    </style>

   <div class="header">

   </div>

   <div class="section-body">

   <a href="/todolist/index.php">Taches</a>

      <div class="form-contain">
      <table>
         <tr>
            <th>#</th>
            <th>details</th>
            <th>Created</th>
         </tr>

         <?php foreach($historiqs as $index => $hist): ?>
        <tr>
           <td>#</td>
           <td><?=$hist['details']?></td>
           <td><?=$hist['created']?></td>
        </tr>
         <?php endforeach; ?>
      </table>
      </div>
   </div>
    
</body>

</html>
