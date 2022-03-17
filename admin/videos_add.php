<?php

  require 'database.php';

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
    $isUploadSuccess = false;


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
      $imgVideoError = "Ce champ ne peut pas être vide";
      $isSuccess = false;
    }
    else {
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
        if(!move_uploaded_file($_FILES['imgVideo']['tmp_name'], $imagePath))
        {
          $imgVideoError = "Il y a eu une erreur lors de l'upload";
          $isUploadSuccess = false;
        }
      }
    }
    if($isSuccess && $isUploadSuccess)
    {
      $db = Database::connect();
      $statement = $db->prepare("INSERT INTO videos (img_video, titre_video, lien_youtube, resume_video) values(?,?,?,?)");
      $statement->execute(array($imgVideo, $titreVideo, $lienYoutube, $resumeVideo));
      Database::disconnect();
      header("Location: videos_admin.php");

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

           <h1>AJOUTER UN FILM</h1>
           <br>
           <form class="form" role="form" action="videos_add.php" method="post" enctype="multipart/form-data">
             <div class="form-group">
               <label for="titreVideo">Titre :</label>
               <input type="text" class="form-control" id="titreVideo" name="titreVideo" placeholder="Titre" value="<?php echo $titreVideo; ?>">
               <span class="help-inline"><?php echo $titreVideoError; ?></span>
             </div>
             <div class="form-group">
               <label for="lienYoutube">URL :</label>
               <input type="text" class="form-control" id="lienYoutube" name="lienYoutube" placeholder="URL" value="<?php echo $lienYoutube; ?>">
               <span class="help-inline"><?php echo $lienYoutubeError; ?></span>
             </div>
             <div class="form-group">
               <label for="resumeVideo">Résumé :</label>
               <textarea class="form-control" id="resumeVideo" name="resumeVideo" placeholder="Résumé"><?php echo $resumeVideo; ?>
               </textarea>
               <span class="help-inline"><?php echo $resumeVideoError; ?></span>
             </div>

             <div class="form-group">
               <label for="imgVideo">Sélectionner une image :</label>
               <br>
               <input type="file" id="imgVideo" name="imgVideo">
               <span class="help-inline"><?php echo $imgVideoError; ?></span>
             </div>

             <div class="form-actions">
               <button type="submit" class="btn btn-success">Ajouter</button>
               <a class="btn btn-primary" href="videos_admin.php">Retour</a>
             </div>
           </form>


    </div>

  </body>

</html>
