<?php

  require 'database.php';

  if(!empty($_GET['id']))
  {
    $id = checkInput($_GET['id']);
  }

  $titreError = $adaptationError = $auteurError = $miseensceneError = $resumeError = $imageError = $anneeError = $titre = $adaptation = $auteur = $miseenscene = $resume = $image = $annee = "";

  if(!empty($_POST))
  {
    $titre = checkInput($_POST['titre']);
    $adaptation = checkInput($_POST['adaptation']);
    $auteur = checkInput($_POST['auteur']);
    $miseenscene = checkInput($_POST['miseenscene']);
    $resume = checkInput($_POST['resume']);
    $annee = checkInput($_POST['annee']);
    $image = checkInput($_FILES['image']['name']);
    $imagePath = '../images/theatre/' . basename($image);
    $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
    $isSuccess = true;

    if(empty($titre))
    {
      $titreError = "Ce champ ne peut pas être vide";
      $isSuccess = false;
    }
    if(empty($adaptation))
    {
      $adaptationError = "Ce champ ne peut pas être vide";
      $isSuccess = false;
    }
    if(empty($auteur))
    {
      $auteurError = "Ce champ ne peut pas être vide";
      $isSuccess = false;
    }
    if(empty($miseenscene))
    {
      $miseensceneError = "Ce champ ne peut pas être vide";
      $isSuccess = false;
    }
    if(empty($resume))
    {
      $resumeError = "Ce champ ne peut pas être vide";
      $isSuccess = false;
    }
    if(empty($annee))
    {
      $anneeError = "Ce champ ne peut pas être vide";
      $isSuccess = false;
    }
    if(empty($image))
    {
      $isImageUpdated = false;

    }
    else {
      $isImageUpdated = true;
      $isUploadSuccess = true;
      if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif")
      {
        $imageError = "Les fichiers autorisés sont : .jpg, .jpeg, .png, .gif";
        $isUploadSuccess = false;
      }
      if(file_exists($imagePath))
      {
        $imageError = "Le fichier existe déjà";
        $isUploadSuccess = false;
      }
      if($_FILES["image"]["size"] > 500000)
      {
        $imageError = "Le fichier ne doit pas dépasser 500KB";
        $isUploadSuccess = false;
      }
      if($isUploadSuccess)
      {
        if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath))
        {
          $imageError = "Il y a eu une erreur lors de l'upload";
          $isUploadSuccess = false;
        }
      }
    }

    if(($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated))
    {
      $db = Database::connect();
      if($isImageUpdated)
      {
        $statement = $db->prepare("UPDATE theatre set img_theatre = ?, titre_theatre = ?, annee_theatre = ?, auteur_theatre = ?, mise_scene_theatre = ?, adaptation_theatre = ?, resume_theatre = ?
                                    WHERE id = ?");
        $statement->execute(array($image, $titre, $annee, $auteur, $miseenscene, $adaptation, $resume, $id));
      }
      else {
        $statement = $db->prepare("UPDATE theatre set titre_theatre = ?, annee_theatre = ?, auteur_theatre = ?, mise_scene_theatre = ?, adaptation_theatre = ?, resume_theatre = ?
                                    WHERE id = ?");
        $statement->execute(array($titre, $annee, $auteur, $miseenscene, $adaptation, $resume, $id));
      }
      Database::disconnect();
      header("Location: theatre_admin.php");
    }
    else if($isImageUpdated && !$isUploadSuccess)
    {
      $db = Database::connect();
      $statement = $db->prepare("SELECT img_theatre FROM theatre WHERE id = ?");
      $statement->execute(array($id));
      $item = $statement->fetch();
      $image = $item['img_theatre'];
      Database::disconnect();
    }

  }

  else {
    $db = Database::connect();
    $statement = $db->prepare("SELECT * FROM theatre WHERE id = ?");
    $statement->execute(array($id));
    $item = $statement->fetch();
    $titre        = $item['titre_theatre'];
    $adaptation   = $item['adaptation_theatre'];
    $auteur       = $item['auteur_theatre'];
    $miseenscene  = $item['mise_scene_theatre'];
    $resume       = $item['resume_theatre'];
    $image        = $item['img_theatre'];
    $annee        = $item['annee_theatre'];

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

      <h1>MODIFIER UNE PIECE DE THEATRE</h1>
      </br>
      <form class="form" role="form" action="<?php echo 'theatre_update.php?id=' . $id; ?>" method="post" enctype="multipart/form-data">

        <div class="row">

          <div class="col-sm-6">
              <div class="form-group">
                <label for="titre">Titre :</label>
                <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre" value="<?php echo $titre; ?>">
                <span class="help-inline"><?php echo $titreError; ?></span>
              </div>
              <div class="form-group">
                <label for="annee">Année :</label>
                <input type="text" class="form-control" id="annee" name="annee" placeholder="Année" value="<?php echo $annee; ?>">
                <span class="help-inline"><?php echo $anneeError; ?></span>
              </div>
              <div class="form-group">
                <label for="auteur">Auteur :</label>
                <input type="text" class="form-control" id="auteur" name="auteur" placeholder="Auteur" value="<?php echo $auteur; ?>">
                <span class="help-inline"><?php echo $auteurError; ?></span>
              </div>
              <div class="form-group">
                <label for="adaptation">Adaptation :</label>
                <input type="text" class="form-control" id="adaptation" name="adaptation" placeholder="Adaptation" value="<?php echo $adaptation; ?>">
                <span class="help-inline"><?php echo $adaptationError; ?></span>
              </div>
              <div class="form-group">
                <label for="miseenscene">Mise en scène :</label>
                <input type="text" class="form-control" id="miseenscene" name="miseenscene" placeholder="Mise en scène" value="<?php echo $miseenscene; ?>">
                <span class="help-inline"><?php echo $miseensceneError; ?></span>
              </div>



              <div class="form-group">
                <label for="resume">Résumé :</label>
                <textarea class="form-control" id="resume" name="resume" placeholder="Résumé" rows="10">
                  <?php echo $resume; ?>
                </textarea>
                <span class="help-inline"><?php echo $resumeError; ?></span>
              </div>
          </div>

          <div class="col-sm-6">
              <div class="form-group">
                <label>Image: </label>
                </br>
                <img src="<?php echo '../images/theatre/' . $image ; ?>" alt="" class="img-thumbnail">
                <p style="background: rgb(230,230,230); margin:10px 75px;"><?php echo $image; ?></p>
                <label for="imgage">Sélectionner une nouvelle image: </label>
                <br>
                <input type="file" id="image" name="image">
                <span class="help-inline"><?php echo $imageError; ?></span>
              </div>
          </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">Modifier</button>
            <a class="btn btn-danger" href="theatre_admin.php">Retour</a>
        </div>

      </form>




    </div>

  </body>

</html>
