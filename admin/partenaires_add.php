<?php

  require 'database.php';

  $logoError = $urlError = $nomError = $logo = $url = $nom = "";

  if(!empty($_POST))
  {

    $url = checkInput($_POST['url']);
    $nom = checkInput($_POST['nom']);
    $logo = checkInput($_FILES['logo']['name']);
    $imagePath = '../images/partenaires/' . basename($logo);
    $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
    $isSuccess = true;
    $isUploadSuccess = false;


    if(empty($url))
    {
      $url = "Ce champ ne peut pas être vide";
      $isSuccess = false;
    }
    if(empty($nom))
    {
      $nomError = "Ce champ ne peut pas être vide";
      $isSuccess = false;
    }
    if(empty($logo))
    {
      $logoError = "Ce champ ne peut pas être vide";
      $isSuccess = false;
    }
    else {
      $isUploadSuccess = true;
      if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif")
      {
        $logoError = "Les fichiers autorisés sont : .jpg, .jpeg, .png, .gif";
        $isUploadSuccess = false;
      }
      if(file_exists($imagePath))
      {
        $logoError = "Le fichier existe déjà";
        $isUploadSuccess = false;
      }
      if($_FILES["logo"]["size"] > 500000)
      {
        $logoError = "Le fichier ne doit pas dépasser 500KB";
        $isUploadSuccess = false;
      }
      if($isUploadSuccess)
      {
        if(!move_uploaded_file($_FILES["logo"]["tmp_name"], $imagePath))
        {
          $logoError = "Il y a eu une erreur lors de l'upload";
          $isUploadSuccess = false;
        }
      }
    }

    if($isSuccess && $isUploadSuccess)
    {
      $db = Database::connect();
      $statement = $db->prepare("INSERT INTO partenaires (logo_part, url_part, nom_part) values(?,?,?)");
      $statement->execute(array($logo, $url, $nom));
      Database::disconnect();
      header("Location: partenaires_admin.php");

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

           <h1>AJOUTER UN PARTENAIRE</h1>
           <br>
           <form class="form" role="form" action="partenaires_add.php" method="post" enctype="multipart/form-data">
             <div class="form-group">
               <label for="url">URL :</label>
               <input type="text" class="form-control" id="url" name="url" placeholder="URL" value="<?php echo $url; ?>">
               <span class="help-inline"><?php echo $urlError; ?></span>
             </div>
             <div class="form-group">
               <label for="nom">Nom :</label>
               <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" value="<?php echo $nom; ?>">
               <span class="help-inline"><?php echo $nomError; ?></span>
             </div>
             <div class="form-group">
               <label for="logo">Sélectionner une image :</label>
               <br>
               <input type="file" id="logo" name="logo">
               <span class="help-inline"><?php echo $logoError; ?></span>
             </div>
             <div class="form-actions">
               <button type="submit" class="btn btn-success">Ajouter</button>
               <a class="btn btn-primary" href="partenaires_admin.php">Retour</a>
             </div>
           </form>


    </div>

  </body>

</html>
