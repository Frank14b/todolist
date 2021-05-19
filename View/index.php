<?php
if(!isset($_SESSION)){
   session_start();
}

if(!isset($_SESSION['userTodolist'])){
   // header("Location: login.php");
   require("login.php");
   die();
}

require("ConnexionBD.php");


if(isset($_POST['title'])) {
   $title = $_POST['title'];
   $description = $_POST['description'];
   $statut_id = $_POST['statut_id'];
   $finish_date = $_POST['finish_date'];
   $user_id = 5;
  
   ///// create todolist /////////
   $sql = "INSERT INTO taches (title, description, statut_id, finish_date, created) VALUES (?,?,?,?,?)";
   $req= $pdo->prepare($sql);
   $ans = $req->execute([$title, $description, $statut_id, $finish_date, date("Y-m-d H:i:s")]);

   ////////////// add create history ////////

   $details = "Nouvelle tache créer : ".$title;
   $sql = "INSERT INTO history (details) VALUES (?)";
   $req= $pdo->prepare($sql);
   $hist = $req->execute([$details]);
}

if(isset($_POST['editstatut'])){
   ///// create todolist /////////
   $sql = "UPDATE taches set statut_id=? WHERE id =?";
   $req= $pdo->prepare($sql);
   $ans = $req->execute([$_POST['statut_id'], $_POST['id']]);

   ////////////// add create history ////////

   $details = "Mise a jour de la tache en statut : ".$_POST['statut_id'];
   $sql = "INSERT INTO history (details) VALUES (?)";
   $req= $pdo->prepare($sql);
   $hist = $req->execute([$details]);
}

   $req = $pdo->prepare("SELECT * FROM statut");
   $req->execute(); 
   $lists = $req->fetchAll();

   $req = $pdo->prepare("SELECT * FROM taches WHERE etat=1");
   $req->execute(); 
   $taches = $req->fetchAll();
?>

<html>
<head>
<title>TodoList</title>
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
      
      .card{
         background: #eee;
         padding: 12px;
         border-radius: 5pt;
         margin-top:5px;
      }
    </style>

   <div class="header">

   </div>

   <div class="section-body">

   <div class="form-contain">
         <form class="form" method="POST">
            <label for="title">Title
            <input type="text" name="title" required>
            </label>

            <label for="desc">Description
            <textarea name="description" required></textarea>
            </label>

            <label for="finish">Finish
            <input type="datetime-local" name="finish_date" required>
            </label>

            <label for="finish">Statut
              <select name="statut_id">
               <?php foreach($lists as $index => $list): ?>
                  <option value="<?=$lists[$index]['id']?>"><?=$lists[$index]['name']?></option>
                <?php endforeach; ?>
              </select>
            </label>

            <label>
              <input type="submit" value="save">
            </label>
         </form>
      </div>

      <a href="?p=history">Historique</a> || <a href="?p=logout">Deconexion</a>

      <table>
         <tr>
         <?php foreach($lists as $index => $list): ?>
            <th><?=$lists[$index]['id']?> - <?=$lists[$index]['name']?></th>
         <?php endforeach; ?>
         </tr>

         <tr>
         <?php foreach($lists as $index => $list): ?>
            <td>
               <?php foreach($taches as $index2 => $tach): ?>
                  <?php if($tach['statut_id'] == $lists[$index]['id']): ?>
                      <div class='card'>
            
            <form method="post" id="formEdit-<?=$tach['id']?>">

            <label for="finish">Changer Statut
              <select name="statut_id" class="changeStatut" onchange="myFunction(<?=$tach['id']?>)">
              <option selected disabled></option>
               <?php foreach($lists as $index3 => $list3): if($tach['statut_id'] != $list3['id']): ?>
                  <option value="<?=$list3['id']?>"><?=$list3['name']?></option>
                <?php endif; endforeach; ?>
              </select>
            </label>
            <input type="hidden" name="id" value="<?=$tach['id']?>"/>
            <input type="hidden" name="editstatut"/>

            </form>
                         <h4><?=$tach['title']?></h4>
                         <p><?=$tach['description']?></p>
                         <p><b>Finish</b> <?=$tach['finish_date']?></p>
                         <p><b>Created</b> <?=$tach['created']?></p>
                      </div>
                  <?php endif; ?>
               <?php endforeach; ?>
            </td>
         <?php endforeach; ?>
         </tr>
      </table>

   </div>

   <script>
   function myFunction(id) {
      document.getElementById('formEdit-'+id).submit()
   }
   </script>

</body>

</html>
