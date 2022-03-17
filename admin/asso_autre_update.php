<?php

  require 'database.php';

  if(!empty($_GET['id']))
  {
    $id = checkInput($_GET['id']);
  }

  $imgMembre = $prenomMembre = $roleMembre = $groupeMembre = $imgErrorMembre = "";


  if(!empty($_POST))
  {
    $imgMembre = checkInput($_FILES['imgMembre']['name']);
    $imagePath = '../images/membres/' . basename($imgMembre);
    $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
    $isSuccess = true;

    if(empty($imgMembre))
    {
      $imgErrorMembre = false;
    }
    else {
      $isImageUpdated = true;
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

    if(($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated))
    {
      $db = Database::connect();
      if($isImageUpdated)
      {
        $statement = $db->prepare("UPDATE membres_asso set photo_membre = ?
                                    WHERE id = ?");
        $statement->execute(array($imgMembre));
      }
      Database::disconnect();
      header("Location: asso_admin.php");
    }
    else if($isImageUpdated && !$isUploadSuccess)
    {
      $db = Database::connect();
      $statement = $db->prepare("SELECT photo_membre FROM membres_asso WHERE id = ?");
      $statement->execute(array($id));
      $item = $statement->fetch();
      $imgMembre = $item['photo_membre'];
      Database::disconnect();
    }
  }


  else {
    $db = Database::connect();
    $statement = $db->prepare("SELECT * FROM membres_asso WHERE id = ?");
    $statement->execute(array($id));
    $item = $statement->fetch();
    $imgMembre = $item['photo_membre'];
    $prenomMembre = "";
    $roleMembre = "";
    $groupeMembre = "autres";

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


      <h1>MODIFIER LA PHOTO DES MEMBRES</h1>
      </br>

      <form class="form" role="form" action="<?php echo 'asso_autre_update.php?id=' . $id; ?>" method="post" enctype="multipart/form-data">

        <div style="margin:auto;">

            <div class="form-group">
              <label>Image : </label>
              </br>
              <img src="<?php echo '../images/membres/' . $imgMembre ; ?>" alt="" class="img-thumbnail">
              <p style="background: rgb(230,230,230); margin:10px 75px;"><?php echo $imgMembre; ?></p>
              <label for="imgMembre">Sélectionner une nouvelle image : </label>
              <br>
              <input type="file" id="imgMembre" name="imgMembre">
              <span class="help-inline"><?php echo $imgErrorMembre; ?></span>
            </div>

        </div>



        <div class="form-actions">
          </br>
          <button type="submit" class="btn btn-success">Modifier</button>
          <a class="btn btn-danger" href="asso_admin.php">Retour</a>
        </div>


      </form>


    </div>

  </body>

</html>
