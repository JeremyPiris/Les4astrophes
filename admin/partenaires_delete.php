<?php

  require 'database.php';

  if(!empty($_GET['id']))
  {
    $id = checkInput($_GET['id']);
  }

  if(!empty($_POST))
  {
    $id = checkInput($_POST['id']);
    $db = Database::connect();
    $statement = $db->prepare("DELETE FROM partenaires WHERE id = ?");
    $statement->execute(array($id));
    Database::disconnect();
    header("Location: partenaires_admin.php");
  }

  function checkInput($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

 ?>



<!DOCTYPE html>
<html lang="fr" dir="ltr">

  <head>

    <meta charset="utf-8">
    <title>Lesquatreastrophes | Accueil</title>
    <meta name="viewport" content="width=device-weight, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Holtwood+One+SC&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/styles_admin.css">

  </head>

  <body>

    <img src="../images/logo_4_strophes.png" alt="logo Lesquatreastrophes" id="logo_admin">

    <div class="container admin">

           <h1>Supprimer un partenaire</h1>
           <br>
           <form class="form" role="form" action="partenaires_delete.php" method="post">
             <input type="hidden" name="id" value="<?php echo $id ?>">
             <p class="alert alert-warning">Etes-vous sûr de vouloir supprimer ?</p>
             <div class="form-actions">
               <button type="submit" class="btn btn-warning">Oui</button>
               <a class="btn btn-default" href="partenaires_admin.php">Non</a>
             </div>
           </form>


    </div>

  </body>

</html>
