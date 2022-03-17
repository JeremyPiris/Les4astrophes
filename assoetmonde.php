<?php
  require 'admin/database.php';

  $db = Database::connect();
  $statement = $db->query('SELECT * FROM membres_asso WHERE membres_asso.groupe_membre = "bureau"');
  $bureau = $statement->fetchAll();
  $statement = $db->query('SELECT * FROM membres_asso WHERE membres_asso.groupe_membre = "autres"');
  $autres = $statement->fetchAll();
  $statement = $db->query('SELECT * FROM partenaires');
  $partenaires = $statement->fetchAll();


  $db = Database::disconnect();

 ?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">

  <head>

    <meta charset="utf-8">
    <title>Lesquatreastrophes | L'asso et le monde</title>
    <meta name="viewport" content="width=device-weight, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Holtwood+One+SC&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/styles.css">

  </head>

  <div class="container-fluid site">


    <div class="row justify-content-center site_header">
      <img src="images/logo_4_strophes.png" alt="logo Lesquatreastrophes">
    </div>

    <nav class="navbar navbar-expand-sm justify-content-center site_navigation">
      <button type="button" class="navbar-toggler navbar-dark" data-toggle="collapse" data-target="#navbarSupportedContent" name="button">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <ul class="collapse navbar-collapse nav-fill" id="navbarSupportedContent">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="videos.php">Vidéos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="theatre.php">Théâtre</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="assoetmonde.php">L'asso et le monde</a>
          </li>
          <li class="nav-item">
            <a href="https://www.facebook.com/lesquatreastrophes/" target="blank">
              <img src="images/facebook-icon-preview-400x400.png" alt="lien vers page facebook" width="40px" height="40px" />
            </a>
          </li>
        </ul>
      </nav>

    <div class="row justify-content-center notre_bureau">

      <?php

          foreach ($bureau as $membre_b) {
            echo '<div class="col-2">
                    <div class="card" style="min-width: 35px;">
                      <img src="images/membres/' . $membre_b['photo_membre'] . '" class="card-img-top" alt="" />
                      <div class="card-body">
                        <p class="card-title"><strong>'.$membre_b['prenom_membre'].'</strong></p>
                        <p class="card-text">'.$membre_b['poste_membre'].'</p>
                      </div>
                    </div>
                  </div>';
                }
       ?>

    </div>

    <div class="row justify-content-center nos_membres">

      <?php

          foreach ($autres as $membre_a) {
            echo '<img class="img-fluid" src="images/membres/'.$membre_a['photo_membre'].'" alt="">';
                }
       ?>

    </div>

    <div class="row nos_partenaires">

      <?php

          foreach ($partenaires as $item) {
            echo '<div class="col-3">
                    <a href="'.$item['url_part'].'">
                      <img src="images/partenaires/'.$item['logo_part'].'" alt="">
                    </a>
                  </div>';
                }
       ?>

    </div>

    <div class="row justify-content-center site_footer">
      <div class="col-md-3 footer_part_1">
        <span class="footerMotOrange">
        Aucune chèvre n'a été blessée lors du développement de ce site.
        <br>2021 | &copy Tous droits réservés |</span>
        <a class="mentions" href="http://www.meuse.gouv.fr/Politiques-publiques/Animaux/Les-animaux-d-elevage/Quelles-obligations-reglementaires-pour-detenir-des-chevres-ou-des-moutons" target="blank"
        >Mentions légales</a>
      </div>
      <div class="col-md-6 footer_part_2">
        <a class="mail" href="#">lesquatreastrophes@hotmail.fr</a>
      </div>
      <div class="col-md-3 footer_part_3">
        <span class="footerMotOrange">Design</span>
        <span class="footerMotBlanc">Jérémy Piris</span>
        <br>
        <span class="footerMotOrange">Dessin</span>
        <span class="footerMotBlanc">Damien Lecoq</span>
      </div>
    </div>


  </div>

</html>
