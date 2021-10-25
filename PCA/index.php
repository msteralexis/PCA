<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title> Man’Class </title>
  <meta name="description" content="MIAGE / PCA">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Sonsie+One" rel="stylesheet" type="text/css">

  <link rel="stylesheet" href="./src/bibliotheques/bootstrap.min.css">
  <script src="./src/bibliotheques/jquery.slim.min.js"> </script>
  <script src="./src/bibliotheques/ajax.js"> </script>

  <script src="./src/cssJs/index.js"> </script>
  <link rel="stylesheet" href="./src/cssJs/style.css">
</head>

<body>
  <div class="container-fluid">
    <header>
      <div class="row">
        <div class="col-lg-10 col-md-10 col-xs-10 col-sm-10">
          <nav class="navbar navbar-expand-lg navbar-black bg-black">
            <div class="container-fluid">
              <h1> Man’Class </h1>

              <div class="collapse navbar-collapse" id="navbarNav">
                <form action="/PCA/index.php" method="POST">
                  <ul class="navbar-nav">
                    <li class="nav-item">
                      <button type="submit" name="gestionEnseignant"> Enseignant </button>
                    </li>
                    <li class="nav-item">
                      <button type="submit" name="gestionUniversite"> Universite </button>
                    </li>
                    <li class="nav-item">
                      <button type="submit" name="gestionUtilisateur"> Utilisateur </button>
                    </li>
                    <li class="nav-item">
                      <button type=" submit" name="gestionModule"> Module </button>
                    </li>
                    <li class="nav-item">
                      <button type="submit" name="gestionExport"> Requete / Export </button>
                    </li>
                  </ul>
                </form>
              </div>
            </div>
          </nav>
        </div>

        <div class="col-lg-2 col-md-2 col-xs-2 col-sm-2">
          <form style=padding-top:2vh; action="./src/fichierphp/controllerUser.php" method="POST">
            <button type="submit" name="deconnection"> <img style="width:30px;height:30px;" src="./src/image/deconnexion.png"> </button>
          </form>
        </div>


      </div>
    </header>
    <main>

      <?php
      session_start();
      if (isset($_SESSION['login']) && isset($_SESSION['password'])) { ?>

        <div class="row">
          <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
            <?php

            if (isset($_POST['gestionEnseignant'])) {
              require("./src/view/pageEnseignant.php");
            }

            if (isset($_POST['gestionUniversite'])) {
              require("./src/view/pageUniversite.php");
            }

            if (isset($_POST['gestionUtilisateur'])) {
              require("./src/view/pageUtilisateur.php");
            }


            if (isset($_GET['idModule'])) { ?> <input id="zozo" type="hidden" value="<?php echo $_GET['idModule']; ?>"> <?php require("./src/view/pageModule.php"); ?> <?php  } else { ?> <input id="zozo" type="hidden" value="0"> <?php  }

                                                                                                                                                                                                                                      if (isset($_POST['gestionModule'])) {
                                                                                                                                                                                                                                        require("./src/view/pageModule.php");
                                                                                                                                                                                                                                      }

                                                                                                                                                                                                                                      if (isset($_POST['gestionExport'])) {
                                                                                                                                                                                                                                        require("./src/view/pageExport.php");
                                                                                                                                                                                                                                      }

                                                                                                                                                                                                                                      require("./src/view/pageEnseignant.php");

                                                                                                                                                                                                                                        ?>
          </div>
        </div>



      <?php } else { ?>
        <div class="row">
          <div class="col-lg-6 col-md-6 col-xs-6 col-sm-6">
            <h2> Bienvenue </h2>
            <p> Cette application a pour objectif de gerer les modules de cours et la gestion des cours en ligne</p>
          </div>
          <div class="col-lg-6 col-md-6 col-xs-6 col-sm-6">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <h2> Connexion : </h2>
              </div>
            </div>

            <form action="./src/fichierphp/controllerUser.php" method="POST">
              <div class="row" id="formulaireInscriptions">
                <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3">
                  <label for="nomInscription"> Mail </label>
                  <input class="form-control" type="text" name='nomInsription'>
                </div>
                <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3">
                  <label for="passwordInsription">Password</label>
                  <input class="form-control" type="text" name="passwordInsription">
                </div>

                <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3">
                  <button type="button submit" class="btn btn-primary"> Connexion </button>
                </div>

                <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3"> </div>
              </div>
            </form>
          </div>
        </div>
  </div>

<?php }  ?>



</main>
</div>
</body>


</html>