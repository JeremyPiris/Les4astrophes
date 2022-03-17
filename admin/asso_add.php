<?php

  require 'database.php';

  $imgMembre = $prenomMembre = $roleMembre = $groupeMembre = $imgErrorMembre = $prenomErrorMembre = $roleErrorMembre = $groupeErrorMembre = "";

  if(!empty($_POST))
  {

    $prenomMembre = checkInput($_POST['prenomMembre']);
    $roleMembre = checkInput($_POST['roleMembre']);
    $groupeMembre = checkInput($_POST['groupeMembre']);
    $imgMembre = checkInput($_FILES['imgMembre']['name']);
    $imagePath = '../images/membres/' . basename($imgMembre);
    $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
    $isSuccess = true;
    $isUploadSuccess = false;


    if(empty($prenomMembre))
    {
      $prenomErrorMembre = "Ce champ ne peut pas être vide";
      $isSuccess = false;
    }
    if(empty($roleMembre))
    {
      $roleErrorMembre = "Ce champ ne peut pas être vide";
      $isSuccess = false;
    }
    if(empty($groupeMembre))
    {
      $groupeErrorMembre = "Ce champ ne peut pas être vide";
      $isSuccess = false;
    }
    if(empty($imgMembre))
    {
      $imgErrorMembre = "Ce champ ne peut pas être vide";
      $isSuccess = false;
    }
    else {
      $isUploadSuccess = true;
      if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif")
      {
        $imgErrorMembre = "Les fichiers autorisés sont : .jpg, .jpeg, .png, .gif";
        $isUploadSuccess = false;
      }
      if(file_exists($imagePath))
      {
        $imgErrorMembre = "Le fichier existe déjà";
        $isUploadSuccess = false;
      }
      if($_FILES["imgMembre"]["size"] > 500000)
      {
        $imgErrorMembre = "Le fichier ne doit pas dépasser 500KB";
        $isUploadSuccess = false;
      }
      if($isUploadSuccess)
      {
        if(!move_uploaded_file($_FILES["imgMembre"]["tmp_name"], $imagePath))
        {
          $imgErrorMembre = "Il y a eu une erreur lors de l'upload";
          $isUploadSuccess = false;
        }
      }
    }

    if($isSuccess && $isUploadSuccess)
    {
      $db = Database::connect();
      $statement = $db->prepare("INSERT INTO membres_asso (photo_membre, prenom_membre, poste_membre, groupe_membre) values(?,?,?,?)");
      $statement->execute(array($imgMembre, $prenomMembre, $roleMembre, $groupeMembre));
      Database::disconnect();
      header("Location: asso_admin.php");

    }

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

           <h1>AJOUTER UN MEMBRE DU BUREAU</h1>
           <br>
           <form class="form" role="form" action="asso_add.php" method="post" enctype="multipart/form-data">
             <div class="form-group">
               <label for="prenomMembre">Prénom :</label>
               <input type="text" class="form-control" id="prenomMembre" name="prenomMembre" placeholder="Prénom" value="<?php echo $prenomMembre; ?>">
               <span class="help-inline"><?php echo $prenomErrorMembre; ?></span>
             </div>
             <div class="form-group">
               <label for="roleMembre">Poste :</label>
               <input type="text" class="form-control" id="roleMembre" name="roleMembre" placeholder="Poste" value="<?php echo $roleMembre; ?>">
               <span class="help-inline"><?php echo $roleErrorMembre; ?></span>
             </div>
             <div class="form-group">
               <label for="groupeMembre">Groupe :</label>
               <input type="text" class="form-control" id="groupeMembre" name="groupeMembre" value="bureau">
               <span class="help-inline"><?php echo $groupeErrorMembre; ?></span>
             </div>
             <div class="form-group">
               <label for="imgMembre">Sélectionner une image :</label>
               <br>
               <input type="file" id="imgMembre" name="imgMembre">
               <span class="help-inline"><?php echo $imgErrorMembre; ?></span>
             </div>

             <div class="form-actions">
               <button type="submit" class="btn btn-success">Ajouter</button>
               <a class="btn btn-primary" href="asso_admin.php">Retour</a>
             </div>
           </form>


    </div>

  </body>

</html>
