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

    <div class="container admin_global">

      <div class="row justify-content-center">
        <h1>Administration du site</h1>

      </div>



      <div class="row justify-content-center" >
        <?php
          require 'database.php';
          $db = Database::connect();
          $statement = $db->query('SELECT * FROM homepage');
          $item = $statement->fetch();
          echo '<a href="homepage_update.php?id='.$item['id'].'"" class="btn btn-secondary gestion" role="button">MODIFIER<br> LA HOMEPAGE</a>';
          Database::disconnect();
        ?>
        <a href="videos_admin.php" class="btn btn-secondary gestion" role="button">GERER<br> LES FILMS</a>
        <a href="theatre_admin.php" class="btn btn-secondary gestion" role="button">GERER<br> LES PIECES</a>
        <a href="asso_admin.php" class="btn btn-secondary gestion" role="button">GERER<br> LES MEMBRES</a>
        <a href="partenaires_admin.php" class="btn btn-secondary gestion" role="button">GERER<br> LES PARTENAIRES</a>
      </div>

      <a href="../index.php" class="btn btn-dark btn-lg">   Retourner sur le site</a>

    </div>

  </body>

</html>
