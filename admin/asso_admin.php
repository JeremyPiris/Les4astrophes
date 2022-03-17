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
        <h1>GESTION DES MEMBRES
        </br>
        <a href="asso_add.php" class="btn btn-success btn-lg">Ajouter un membre du bureau</a>
        <a href="index.php" class="btn btn-secondary btn-lg">Retour</a>
        </h1>
      </div>

      <div class="row">
        <?php
        require 'database.php';
        $db = Database::connect();
        $statement = $db->query('SELECT membres_asso.id, membres_asso.photo_membre, membres_asso.prenom_membre, membres_asso.poste_membre
                                FROM membres_asso
                                WHERE membres_asso.groupe_membre = "bureau"
                                ORDER BY membres_asso.id');

        while($item = $statement->fetch())
        {
          echo '
            <div class="col vignette_film">
              <img src="../images/membres/' . $item['photo_membre'].'" alt="" class="img-thumbnail">
              </br>
              <p>' . $item['prenom_membre'] . '</br>
              ' . $item['poste_membre'] . '</p>
              <a href="asso_update.php?id=' . $item['id'] . '" class="btn btn-primary" style="width:100px; margin-bottom:5px;">Modifier</a></br>
              <a href="asso_delete.php?id=' . $item['id'] . '" class="btn btn-danger" style="width:100px;">Supprimer</a>
              </br>
              </br>
              </br>
            </div>
          ';
        }

        $statement = $db->query('SELECT membres_asso.id, membres_asso.photo_membre, membres_asso.prenom_membre, membres_asso.poste_membre
                                FROM membres_asso
                                WHERE membres_asso.groupe_membre = "autres"
                                ORDER BY membres_asso.id');

        while($item = $statement->fetch())
        {
          echo '
            <div style="margin:auto;">
              <img src="../images/membres/' . $item['photo_membre'].'" alt="" class="img-fluid" style="margin-bottom:5px;">
              </br>
              <a href="asso_update.php?id=' . $item['id'] . '" class="btn btn-primary" style="width:300px;">Modifier</a>
            </div>
          ';
        }

        Database::disconnect();
        ?>
      </div>



    </div>

  </body>

</html>
