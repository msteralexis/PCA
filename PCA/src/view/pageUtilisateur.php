<?php 


if (isset($_SESSION['login']) && isset($_SESSION['password'])) { 
  require("./src/fichierphp/bdd.php"); $bdd = new Bdd; ?>





<script src="./src/cssJs/pageUtilisateur.js"> </script>

<div class="row">
  <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 cadre">
    
    <h3> Création / Modification d'un Utilisateur  </h3> 

    <input id="idutilisateur" name="idutilisateur" type="hidden" value="0">
    <label> Nom : </label>
    <span> <input class="form-control" type="text" id='nomutilisateur'>  </span> <br />

    <label> Prenom : </label>
    <span> <input class="form-control" type="text" id="prenomUtilisateur"> </span> <br />

    <label> Mail : </label>
    <span> <input class="form-control" type="text" id="mailUtilisateur"> </span> <br />

    <button type="button" class="btn btn-primary" id="sauvegardeUser"> Sauvegarder </button>
    <button type="button" class="btn btn-primary" id="MiseZeroFormulaire"> Remise à Zero </button> 
    <button type="button" class="btn btn-danger" id="supressionUtilisateur"> Suprimer </button>

  </div>


  <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 cadre">
    <h3> Liste des Utilisateurs </h3>
    <div id="listUsers" class="list"> </div>
  </div>

  
  <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 cadre">
    <h2> Changer votre mot de passe </h2>
        

    <label> ancien mot de passe: </label>
    <span> <input class="form-control" type="text" id='oldPassword'>  </span> <br />

    <label> nouveau mot de passe : </label>
    <span> <input class="form-control" type="text" id="newPassword1"> </span> <br />

    <label> repeter le nouveau mot de passe : </label>
    <span> <input class="form-control" type="text" id="newPassword2"> </span> <br />

    <button type="button" class="btn btn-primary" id="changePassword"> Changer </button>

  </div>



</div>

<?php $bdd->closeConnection(); }else { header('Location: /PCA/');  }   ?>