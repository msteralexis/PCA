<?php 

if (isset($_SESSION['login']) && isset($_SESSION['password'])) { 
  require("./src/fichierphp/bdd.php"); $bdd = new Bdd; ?>

<script src="./src/cssJs/pageUniversite.js"> </script>

<div class="row">
  <div class="col-lg-6 col-md-6 col-xs-6 col-sm-6 cadre">

    <h3> Création / Modification d'une Universite  </h3>
    
    <input id="idUniversite" name="idUniversite" type="hidden" value="0">
    <label> Nom :</label>
    <span> <input class="form-control" type="text" id='nomUniversite'>  </span> <br />

    <label> Adresse :</label>
    <span> <input class="form-control" type="text" id="villeAdresse"> </span> <br />

    <label> Ville :</label>
    <span> <input class="form-control" type="text" id="VilleUniversite"> </span> <br />

    <button type="button" class="btn btn-primary" id="sauvegardeUniversite"> Sauvegarder </button>
    <button type="button" class="btn btn-primary" id="MiseZeroFormulaire"> Remise à Zero </button> 

  </div>


  <div class="col-lg-6 col-md-6 col-xs-6 col-sm-6 cadre">
    <h3> Liste des Universites </h3>
    <div id="listUniversite" class="list" > </div>
  </div>

</div>

<?php $bdd->closeConnection(); }else { header('Location: /PCA/');  }   ?>