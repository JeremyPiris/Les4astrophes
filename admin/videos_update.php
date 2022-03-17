<?php

  require 'database.php';

  if(!empty($_GET['id']))
  {
    $id = checkInput($_GET['id']);
  }

  $imgVideo = $titreVideo = $lienYoutube = $resumeVideo = $imgVideoError = $titreVideoError = $lienYoutubeError = $resumeVideoError = "";

  if(!empty($_POST))
  {
    $titreVideo = checkInput($_POST['titreVideo']);
    $lienYoutube = checkInput($_POST['lienYoutube']);
    $resumeVideo = checkInput($_POST['resumeVideo']);
    $imgVideo = checkInput($_FILES['imgVideo']['name']);
    $imagePath = '../images/films/' . basename($imgVideo);
    $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
    $isSuccess = true;



    if(empty($titreVideo))
    {
      $titreVideoError = "Ce champ ne peut pas être vide";
      $isSuccess = false;
    }
    if(empty($lienYoutube))
    {
      $lienYoutubeError = "Ce champ ne peut pas être vide";
      $isSuccess = false;
    }
    if(empty($resumeVideo))
    {
      $resumeVideoError = "Ce champ ne peut pas être vide";
      $isSuccess = false;
    }
    if(empty($imgVideo))
    {
      $isImageUpdated = false;
    }
    else {
      $isImageUpdated = true;
      $isUploadSuccess = true;
      if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif")
      {
        $imgVideoError = "Les fichiers autorisés sont : .jpg, .jpeg, .png, .gif";
        $isUploadSuccess = false;
      }
      if(file_exists($imagePath))
      {
        $imgVideoError = "Le fichier existe déjà";
        $isUploadSuccess = false;
      }
      if($_FILES["imgVideo"]["size"] > 500000)
      {
        $imgVideoError = "Le fichier ne doit pas dépasser 500KB";
        $isUploadSuccess = false;
      }
      if($isUploadSuccess)
      {
        if(!move_uploaded_file($_FILES["imgVideo"]["tmp_name"], $imagePath))
        {
          $imgVideoError = "Il y a eu une erreur lors de l'upload";
          $isUploadSuccess = false;
        }
      }
    }

    if(($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated))
    {
      $db = Database::connect();
      if($isImageUpdated)
      {
        $statement = $db->prepare("UPDATE videos set img_video = ?, titre_video = ?, lien_youtube = ?, resume_video = ?
                                    WHERE id_videos = ?");
        $statement->execute(array($imgVideo, $titreVideo, $lienYoutube, $resumeVideo, $id));
      }
      else {
        $statement = $db->prepare("UPDATE videos set titre_video = ?, lien_youtube = ?, resume_video = ?
                                    WHERE id_videos = ?");
        $statement->execute(array($titreVideo, $lienYoutube, $resumeVideo, $id));
      }
      Database::disconnect();
      header("Location: videos_admin.php");
    }
    else if($isImageUpdated && !$isUploadSuccess)
    {
      $db = Database::connect();
      $statement = $db->prepare("SELECT img_video FROM videos WHERE id_videos = ?");
      $statement->execute(array($id));
      $item = $statement->fetch();
      $imgVideo = $item['img_video'];
      Database::disconnect();
    }
  }


  else {
    $db = Database::connect();
    $statement = $db->prepare("SELECT * FROM videos WHERE id_videos = ?");
    $statement->execute(array($id));
    $item = $statement->fetch();
    $titreVideo = $item['titre_video'];
    $lienYoutube = $item['lien_youtube'];
    $resumeVideo = $item['resume_video'];
    $imgVideo = $item['img_video'];
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


      <h1>MODIFIER UN FILM</h1>
      </br>

      <form class="form" role="form" action="<?php echo 'videos_update.php?id=' . $id; ?>" method="post" enctype="multipart/form-data">

        <div class="row">

          <div class="col-sm-6">
              <div class="form-group">
                <label for="titreVideo">Titre:</label>
                <input type="text" class="form-control" id="titreVideo" name="titreVideo" placeholder="Titre" value="<?php echo $titreVideo; ?>">
                <span class="help-inline"><?php echo $titreVideoError; ?></span>
              </div>
              <div class="form-group">
                <label for="lienYoutube">URL:</label>
                <input type="text" class="form-control" id="lienYoutube" name="lienYoutube" placeholder="URL" value="<?php echo $lienYoutube; ?>">
                <span class="help-inline"><?php echo $lienYoutubeError; ?></span>
              </div>
              <div class="form-group">
                <label for="resumeVideo">Résumé:</label>
                <textarea class="form-control" id="resumeVideo" name="resumeVideo" placeholder="Résumé" rows="5">
                  <?php echo $resumeVideo; ?>
                </textarea>
                <span class="help-inline"><?php echo $resumeVideoError; ?></span>
              </div>
          </div>

          <div class="col-sm-6">
              <div class="form-group">
                <label>Image: </label>
                </br>
                <img src="<?php echo '../images/films/' . $imgVideo ; ?>" alt="" class="img-thumbnail">
                <p style="background: rgb(230,230,230); margin:10px 75px;"><?php echo $imgVideo; ?></p>
                <label for="imgVideo">Sélectionner une nouvelle image: </label>
                <br>
                <input type="file" id="imgVideo" name="imgVideo">
                <span class="help-inline"><?php echo $imgVideoError; ?></span>
              </div>
          </div>

        </div>

        <div class="form-actions">
          </br>
          <button type="submit" class="btn btn-success">Modifier</button>
          <a class="btn btn-danger" href="videos_admin.php">Retour</a>
        </div>

      </form>


    </div>

  </body>

</html>
