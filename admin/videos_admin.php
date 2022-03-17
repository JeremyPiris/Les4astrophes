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

      <div class="row justify-content-center" style="margin-bottom: 20px;">
        <h1>GESTION DES VIDEOS
        </br>
        <a href="videos_add.php" class="btn btn-success btn-lg">Ajouter une vidéo</a>
        <a href="index.php" class="btn btn-secondary btn-lg">Retour</a>
        </h1>
      </div>

      <div class="row">
        <?php
        require 'database.php';
        $db = Database::connect();
        $statement = $db->query('SELECT videos.id_videos, videos.titre_video, videos.img_video
                                FROM videos
                                ORDER BY videos.id_videos DESC');

        while($item = $statement->fetch())
        {
          echo '
            <div class="col-md-4 vignette_film">
              <img src="../images/films/' . $item['img_video'].'" alt="" class="img-thumbnail" style="height:181px; width:320px;">
              <br>
              <p>' . $item['titre_video'] . '</p>
              <a href="videos_update.php?id=' . $item['id_videos'] . '" class="btn btn-primary">Modifier</a>
              <a href="videos_delete.php?id=' . $item['id_videos'] . '" class="btn btn-danger">Supprimer</a>
              <br>
              <br>
            </div>
          ';
        }
        Database::disconnect();
        ?>
      </div>


    </div>

  </body>

</html>
