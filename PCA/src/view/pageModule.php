<?php

if (isset($_SESSION['login']) && isset($_SESSION['password'])) {
    require("./src/fichierphp/bdd.php");
    $bdd = new Bdd; ?>

    <script src="./src/cssJs/pageModule.js"> </script>

    <div class="row">
        

        <div class="col-lg-9 col-md-9 col-xs-9 col-sm-9 cadre">
        <h3> Création / Modification d'un Module  </h3>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4">
                    <input id="idModule" name="idModule" type="hidden" 
                    
                    <?php if ( isset($_GET['idModule'])  ) { ?>
                        value="<?php echo $donnees['identifiant']; ?>" 
                    <?php  } else { ?>  value="0"  <?php  } ?>  >
                    
                  


                    <label>Nom</label>
                    <span> <input class="form-control" type="text" id='nomModule'> </span>
                </div>

                <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4">
                    <label>Date Debut</label>
                    <span> <input class="form-control" type="date" id="datedebutModule"> </span>
                </div>

                <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4">
                    <label> Date Fin</label>
                    <span> <input class="form-control" type="date" id='datefinModule'> </span>
                </div>
            </div>

            <div  class="row">

                <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4">
                    <label> Domaine </label>
                    <span> <input class="form-control" type="text" id="domaineModule"> </span>
                </div>

                <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4">
                    <label> En Ligne </label>
                    <span> <select name="miseenligne" id="miseneligneModule">
                            <option value="0"> Non</option>
                            <option value="1"> Oui </option>
                        </select> </span>
                </div>

                <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4">
                    <label> Statut </label>
                    <span> <select name="statut" id="statutModule">
                            <option value="0"> Non Commencé </option>
                            <option value="1"> En cours de Rédaction </option>
                            <option value="2"> Achevé </option>
                        </select> </span>
                </div>
            </div>

            <div  class="row">
                <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4">
                    <label>Niveau Module</label>
                    <span> <select name="statut" id="niveauModule">
                            <option value="0" selected> Licence </option>
                            <option value="1"> Master </option>
                        </select> </span>
                </div>

                <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4">
                    <label>Niveau Annee</label>
                    <span> <select name="niveauanne" id="niveauannne">
                            <?php

                            $res = $bdd->list('niveauanne');
                            while ($donnees = $res->fetch()) { ?> <option value='<?php echo $donnees['identifiant']; ?>'> <?php echo $donnees['nom']; ?> </option> <?php  } ?>
                        </select> </span>
                </div>

                <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4">
                </div>
            </div>

            <div class="row" >
                <div class="col-lg-6 col-md-6 col-xs-6 col-sm-6 pageModuleListEnseignant" >
                    <h2>Enseignant Gestionnaire </h2>
                    <div id="listGestionEnseignant"  class="list"> </div>
                </div>

                <div  class="col-lg-6 col-md-6 col-xs-6 col-sm-6 pageModuleListEnseignant">
                    <h2> Enseignant Non Gestionnaire </h2>
                    <div id="listGestionEnseignantnon"  class="list"> </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-8 col-md-8 col-xs-8 col-sm-8 " >
                </div>

                <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4">
                <button type="button" class="btn btn-primary" id="sauvegardeModule"> Sauvegarder </button>

                <button type="button" class="btn btn-danger" id="supressionModule"> Suprimer </button>


                </div>
            </div>

        </div>

        <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3 cadre">
            
            <h3> Liste des Modules  </h3>
            <button style="margin-bottom:3vh;" type="button" class="btn btn-primary" id="nouveauModule"> Nouveau Module </button>
            <div id="listModules" class="list"> </div>
        </div>

    </div>

<?php $bdd->closeConnection();
} else {
    header('Location: /PCA/');
}    ?>



