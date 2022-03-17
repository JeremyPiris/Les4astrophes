<?php
  require 'admin/database.php';

  if(!empty($_GET['Id']))
  {
    $id = checkInput($_GET['Id']);
  }

  $db = Database::connect();
  $statement = $db->prepare('SELECT * FROM videos WHERE videos.id_videos = ?');
  $statement->execute(array($id));
  $item = $statement->fetch();

  Database::disconnect();

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
    <title>Lesquatreastrophes | Vidéos | Détail</title>
    <meta name="viewport" content="width=device-weight, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Holtwood+One+SC&display=swap" rel="stylesheet">

    <link rel="stylesheet" media="screen" href="css/styles.css">

  </head>

  <div class="container-fluid site_details">


    <div class="row justify-content-center video_details_header">
      <div class="col-6">
        <a href="videos.php">
          <span class="material-icons">keyboard_arrow_left</span>
          <span>Retour</span>
        </a>
      </div>

      <div class="col-6">
        <h5><?php echo ' ' . $item['titre_video']; ?></h5>
      </div>
    </div>


    <div class="row justify-content-center video_details_body">


      <?php
        echo '
        <div class="embed-responsive embed-responsive-16by9">
          <iframe class="embed-responsive-item" src="'.$item['lien_youtube'].'" allowfullscreen></iframe>
        </div>
        <p>'.nl2br($item['resume_video']).'</p>
        ';
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
