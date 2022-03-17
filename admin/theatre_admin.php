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
        <h1>GESTION DES PIECES DE THEATRE
        </br>
        <a href="theatre_add.php" class="btn btn-success btn-lg">Ajouter une pièce</a>
        <a href="index.php" class="btn btn-secondary btn-lg">Retour</a>
        </h1>
      </div>
      <div class="row">




            <?php
            require 'database.php';
            $db = Database::connect();
            $statement = $db->query('SELECT theatre.id, theatre.img_theatre, theatre.titre_theatre, theatre.annee_theatre, theatre.auteur_theatre, theatre.mise_scene_theatre, theatre.adaptation_theatre, theatre.resume_theatre
                                    FROM theatre
                                    ORDER BY theatre.id DESC');

            while($item = $statement->fetch())
            {
              echo '
                <div class="col-md-4 vignette_film">
                  <img src="../images/theatre/' . $item['img_theatre'].'" alt="" class="img-thumbnail" style="height:400px; width:270px;">
                  <br>
                  <p>' . $item['titre_theatre'] . '</p>
                  <a href="theatre_update.php?id=' . $item['id'] . '" class="btn btn-primary">Modifier</a>
                  <a href="theatre_delete.php?id=' . $item['id'] . '" class="btn btn-danger">Supprimer</a>
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
