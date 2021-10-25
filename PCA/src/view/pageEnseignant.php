<?php 

if (isset($_SESSION['login']) && isset($_SESSION['password'])) { 
  require("./src/fichierphp/bdd.php"); $bdd = new Bdd; ?>

<script src="./src/cssJs/pageEnseignant.js"> </script>

<div class="row">
  <div class="col-lg-6 col-md-6 col-xs-6 col-sm-6 cadre">

    <h3> Création / Modification d'un Enseignant </h3>
 
    <input id="idEnseignant" name="idEnseignant" type="hidden" value="0">
    <label> Nom :</label>
    <span> <input class="form-control" type="text" id='nomEnseignant'>  </span> <br />

    <label>Prenom :</label>
    <span> <input class="form-control" type="text" id="prenomEnseignant"> </span> <br />

    <label> Mail :</label>
    <span> <input class="form-control" type="text" id="mailEnseignant"> </span> <br />

    <label> Telephone :</label>
    <span><input class="form-control" type="text" id="telephoneEnseignant"> </span> <br />

    <label for="universite ">Universite :</label>
    <span> <select id="universite" name="universite ">
      <?php
      $res = $bdd->list('universite');
      while ($donnees = $res->fetch()) { ?> <option selected value='<?php echo $donnees['identifiant']; ?>'> <?php echo $donnees['nom']; ?> </option> <?php  } ?>
    </select>   </span>  <br />

    <button type="button" class="btn btn-primary" id="sauvegardeEnseignant"> Sauvegarder </button>
    <button type="button" class="btn btn-primary" id="MiseZeroFormulaire"> Remise à Zero </button> 
    <button type="button" class="btn btn-danger" id="supressionEnseignant"> Suprimer </button>

  </div>


  <div class="col-lg-6 col-md-6 col-xs-6 col-sm-6 cadre">
    <h3> Liste des Enseignants </h3>
    <ul class="list-group" id="listenseignants" >  </ul>
  </div>

</div>

<?php $bdd->closeConnection(); }else { header('Location: /PCA/');  }   ?>