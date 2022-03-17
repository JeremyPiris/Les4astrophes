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
        <h1>GESTION DES PARTENAIRES
        </br>
        <a href="partenaires_add.php" class="btn btn-success btn-lg">Ajouter un partenaire</a>
        <a href="index.php" class="btn btn-secondary btn-lg">Retour</a>
        </h1>
      </div>

        <?php
        require 'database.php';
        $db = Database::connect();
        $statement = $db->query('SELECT partenaires.id, partenaires.logo_part, partenaires.url_part, partenaires.nom_part
                                FROM partenaires
                                ORDER BY partenaires.id');

        while($item = $statement->fetch())
        {
          echo '
            <div class="col vignette_film">
              <img src="../images/partenaires/' . $item['logo_part'].'" alt="" class="img-thumbnail" style="background:rgb(254,187,72);">
              </br>
              <p>URL : ' . $item['url_part'] . '</br>
              Nom : ' . $item['nom_part'] . '</p>
              <a href="partenaires_update.php?id=' . $item['id'] . '" class="btn btn-primary" style="width:100px;">Modifier</a>
              <a href="partenaires_delete.php?id=' . $item['id'] . '" class="btn btn-danger" style="width:100px;">Supprimer</a>
              </br>
              </br>
              </br>
            </div>
          ';
        }
        Database::disconnect();
        ?>



    </div>

  </body>

</html>
