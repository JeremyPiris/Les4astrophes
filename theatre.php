<!DOCTYPE html>
<html lang="fr" dir="ltr">

  <head>

    <meta charset="utf-8">
    <title>Lesquatreastrophes | Théâtre</title>
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
            <a class="nav-link active" href="theatre.php">Théâtre</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="assoetmonde.php">L'asso et le monde</a>
          </li>
          <li class="nav-item">
            <a href="https://www.facebook.com/lesquatreastrophes/" target="blank">
              <img src="images/facebook-icon-preview-400x400.png" alt="lien vers page facebook" width="40px" height="40px" />
            </a>
          </li>
        </ul>
      </nav>

    <div class="row justify-content-center theatre_body">


      <?php
          require 'admin/database.php';
          $db = Database::connect();
          $statement = $db->query('SELECT * FROM theatre');
          $theatre = $statement->fetchAll();
          foreach ($theatre as $piece) {
            echo '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                    <a href="theatre_details.php?Id=' . $piece['id'] . '">
                    <img src="images/theatre/' . $piece['img_theatre'] . '" alt="" class="img-thumbnail" />
                    <p id="titre_theatre">' . $piece['titre_theatre'] . '<br><FONT size="2pt">' . $piece['auteur_theatre'] . '</FONT></p>
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
