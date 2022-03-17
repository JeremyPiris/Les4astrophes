<?php

  require 'database.php';

  if(!empty($_GET['id']))
  {
    $id = checkInput($_GET['id']);
  }

  $textHomeError = $imgHomeError = $textHome = $imgHome = "";

  if(!empty($_POST))
  {
    $textHome = checkInput($_POST['textHome']);
    $imgHome = checkInput($_FILES['imgHome']['name']);
    $imagePath = '../images/' . basename($imgHome);
    $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
    $isSuccess = true;


    if(empty($textHome))
    {
      $textHomeError = "Ce champ ne peut pas être vide";
      $isSuccess = false;
    }
    if(empty($imgHome))
    {
      $isImageUpdated = false;
    }
    else {
      $isImageUpdated = true;
      $isUploadSuccess = true;
      if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif")
      {
        $imgHomeError = "Les fichiers autorisés sont : .jpg, .jpeg, .png, .gif";
        $isUploadSuccess = false;
      }
      if(file_exists($imagePath))
      {
        $imgHomeError = "Le fichier existe déjà";
        $isUploadSuccess = false;
      }
      if($_FILES["imgHome"]["size"] > 500000)
      {
        $imgHomeError = "Le fichier ne doit pas dépasser 500KB";
        $isUploadSuccess = false;
      }
      if($isUploadSuccess)
      {
        if(!move_uploaded_file($_FILES["imgHome"]["tmp_name"], $imagePath))
        {
          $imgHomeError = "Il y a eu une erreur lors de l'upload";
          $isUploadSuccess = false;
        }
      }
    }

    if(($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated))
    {
      $db = Database::connect();
      if($isImageUpdated)
      {
        $statement = $db->prepare("UPDATE homepage set text_home = ?, img_home = ?
                                    WHERE id = ?");
        $statement->execute(array($textHome, $imgHome, $id));
      }
      else {
        $statement = $db->prepare("UPDATE homepage set text_home = ?
                                    WHERE id = ?");
        $statement->execute(array($textHome, $id));
      }
      Database::disconnect();
      header("Location: index.php");
    }
    else if($isImageUpdated && !$isUploadSuccess)
    {
      $db = Database::connect();
      $statement = $db->prepare("SELECT img_home FROM homepage WHERE id = ?");
      $statement->execute(array($id));
      $item = $statement->fetch();
      $imgHome = $item['img_home'];
      Database::disconnect();
    }

  }


  else {
    $db = Database::connect();
    $statement = $db->prepare("SELECT * FROM homepage WHERE id = ?");
    $statement->execute(array($id));
    $item = $statement->fetch();
    $textHome     = $item['text_home'];
    $imgHome      = $item['img_home'];
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

      <h1>MODIFIER LA HOMEPAGE</h1>
      <br>

      <form class="form" role="form" action="<?php echo 'homepage_update.php?id=' . $id; ?>" method="post" enctype="multipart/form-data">

      <div class="row">

        <div class="col-sm-6">
            <div class="form-group">
              <label for="textHome">Texte :</label>
              <textarea class="form-control" id="textHome" name="textHome" placeholder="Texte de présentation" rows="15"><?php echo $textHome; ?></textarea>
              <span class="help-inline"><?php echo $textHomeError; ?></span>
            </div>


        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <label>Image : </label>
            </br>
            <img src="<?php echo '../images/' . $imgHome ; ?>" alt="" class="img-thumbnail">
            <p style="background: rgb(230,230,230); margin:10px 75px;"><?php echo $imgHome; ?></p>
            <br>
            <label for="imgHome">Sélectionner une nouvelle image: </label>
            <br>
            <input type="file" id="imgHome" name="imgHome">
            <span class="help-inline"><?php echo $imgHomeError; ?></span>
          </div>
        </div>
      </div>

        <div class="form-actions">
          </br>
          <button type="submit" class="btn btn-success">Modifier</button>
          <a class="btn btn-danger" href="index.php">Retour</a>
        </div>

    </form>


    </div>

  </body>

</html>
