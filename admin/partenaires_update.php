<?php

  require 'database.php';

  if(!empty($_GET['id']))
  {
    $id = checkInput($_GET['id']);
  }

$logoError = $urlError = $nomError = $logo = $url = $nom = "";

  if(!empty($_POST))
  {
    $url = checkInput($_POST['url']);
    $nom = checkInput($_POST['nom']);
    $logo = checkInput($_FILES['logo']['name']);
    $imagePath = '../images/partenaires/' . basename($logo);
    $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
    $isSuccess = true;


    if(empty($url))
    {
      $urlError = "Ce champ ne peut pas être vide";
      $isSuccess = false;
    }
    if(empty($nom))
    {
      $nomError = "Ce champ ne peut pas être vide";
      $isSuccess = false;
    }
    if(empty($logo))
    {
      $isImageUpdated = false;
    }
    else {
      $isImageUpdated = true;
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

    if(($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated))
    {
      $db = Database::connect();
      if($isImageUpdated)
      {
        $statement = $db->prepare("UPDATE partenaires set url_part = ?, nom_part = ?, logo_part = ?
                                    WHERE id = ?");
        $statement->execute(array($url, $nom, $logo, $id));
      }
      else {
        $statement = $db->prepare("UPDATE partenaires set url_part = ?, nom_part = ?
                                    WHERE id = ?");
        $statement->execute(array($url, $nom, $id));
      }
      Database::disconnect();
      header("Location: partenaires_admin.php");
    }
    else if($isImageUpdated && !$isUploadSuccess)
    {
      $db = Database::connect();
      $statement = $db->prepare("SELECT logo_part FROM partenaires WHERE id = ?");
      $statement->execute(array($id));
      $item = $statement->fetch();
      $imgHome = $item['logo_part'];
      Database::disconnect();
    }

  }


  else {
    $db = Database::connect();
    $statement = $db->prepare("SELECT * FROM partenaires WHERE id = ?");
    $statement->execute(array($id));
    $item = $statement->fetch();
    $url          = $item['url_part'];
    $nom          = $item['nom_part'];
    $logo         = $item['logo_part'];
    Database::disconnect();
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

      <h1>MODIFIER LES PARTENAIRES</h1>
      <br>

      <form class="form" role="form" action="<?php echo 'partenaires_update.php?id=' . $id; ?>" method="post" enctype="multipart/form-data">

      <div class="row">

        <div class="col-sm-6">
          <div class="form-group">
            <label>Image : </label>
            </br>
            <img src="<?php echo '../images/partenaires/' . $logo ; ?>" alt="" class="img-thumbnail" style="background:rgb(254,187,72);">
            <p style="background: rgb(230,230,230); margin:10px 75px;"><?php echo $logo; ?></p>
            <br>
            <label for="imgHome">Sélectionner une nouvelle image : </label>
            <br>
            <input type="file" id="logo" name="logo">
            <span class="help-inline"><?php echo $logoError; ?></span>
          </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
              <label for="url">URL :</label>
              <input type="text" class="form-control" id="url" name="url" placeholder="URL" value="<?php echo $url; ?>">
              <span class="help-inline"><?php echo $urlError; ?></span>
            </div>
            <div class="form-group">
              <label for="nom">Nom :</label>
              <input type="text" class="form-control" id="nom" name="nom" placeholder="URL" value="<?php echo $nom; ?>">
              <span class="help-inline"><?php echo $nomError; ?></span>
            </div>
        </div>



      </div>

        <div class="form-actions">
          </br>
          <button type="submit" class="btn btn-success">Modifier</button>
          <a class="btn btn-danger" href="partenaires_admin.php">Retour</a>
        </div>

    </form>


    </div>

  </body>

</html>
