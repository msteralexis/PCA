<?php
session_start();
if (isset($_SESSION['login']) && isset($_SESSION['password'])) { 

    require("bdd.php"); $bdd = new Bdd;


    /*
    Reception requete ajax.
    */
    function jsonRetour( $valeurRetour) {
        header('Content-Type: application/json');
        echo json_encode( $valeurRetour, JSON_PRETTY_PRINT);
    }




    // Obtenir la listes des enseignant ne s'occupant pas du module
    if( isset( $_POST['listEnseignantSansModule']) && isset($_POST['identifiant'] ) ) {
        $listenseignantsTab = array();
        $listenseignants = $bdd->listEnseignantSansModule( $_POST['identifiant'] );
        while($enseignant = $listenseignants ->fetch() ){
            $listenseignantsTab [] = $enseignant ;
        }
        jsonRetour( $listenseignantsTab );      $bdd->closeConnection(); exit();
    }


    // Obtenir la liste des enseignant s'occupant d'un module.
    if( isset( $_POST['listGestionEnseignants'])  ) {
        $c = $bdd->detailsModule(  $_POST['identifiant'] );
        $listModulesTab = array();
        while($Module = $c->fetch() ){
            $listModulesTab[] = $Module ;
        }
        jsonRetour( $listModulesTab );   $bdd->closeConnection(); exit();
    }


    // Obtenir la liste des Module
    if( isset( $_POST['listModules'])  ) {
        $listModulesTab = array();
        $listModules = $bdd->list('module');
        while($Module = $listModules ->fetch() ){
            $listModulesTab [] = $Module ;
        }
        jsonRetour( $listModulesTab );   $bdd->closeConnection(); exit();
    }




    // Vérification des données passer en paramètre
    function verificationDonnerModule($nom, $niveau, $domaine, $miseneligne, $statut ){
        if( strlen($nom) < 3 || strlen($nom) > 50  ){ return "Erreur sur le nom" ;}
        if( strlen($domaine) < 3 || strlen($domaine) > 30  ){ return "Erreur sur le domaine" ;}
        return  "Succès";
    }

    // Sauvegarde / Modification donner pour un module
    if( isset( $_POST['nom']) && isset( $_POST['niveau']) && isset( $_POST['domaineModule'])  && isset( $_POST['datefinModule']) && isset( $_POST['miseneligneModule'])   && isset( $_POST['statutModule']) && isset( $_POST['datedebutModule'])   ) {
        $reponse = "defaults";
        $reponse = verificationDonnerModule($_POST['nom'], $_POST['niveau'], $_POST['domaineModule'], $_POST['miseneligneModule'], $_POST['statutModule']  );
        if( $reponse  == "Succès"  ){   
            if(! $bdd->details( 'module',$_POST['idModule']) && $_POST['idModule']  == 0 ) {
                if(  $bdd->insertModule($_POST['nom'],$_POST['niveau'], $_POST['domaineModule'], $_POST['datefinModule'], $_POST['miseneligneModule']  , $_POST['statutModule'], $_POST['datedebutModule'] , $_POST['niveauannne']    )) { $reponse = "Succès"; }          
            }else {// si l'Module existe alors on le modifie avec les element passers 
                if(  $bdd->modificationModule($_POST['nom'],$_POST['niveau'], $_POST['domaineModule'], $_POST['datefinModule'], $_POST['miseneligneModule']  , $_POST['statutModule'], $_POST['datedebutModule'],  $_POST['idModule'] ,  $_POST['niveauannne']     )) { $reponse = "Succès"; }     
            }
        }

        $bdd->closeConnection(); jsonRetour( $reponse );    
     
    }

    
    // Ajouts d'un enseignant comme gestionaire d'un module
    if( isset( $_POST['ajoutsGestionnaireModule'])  ) {
        $response = 'defaults';
        if( $bdd->details('enseignant',  $_POST['identifiant']) && $_POST['identifiant'] != 0 && $_POST['idModule'] != 0 &&  $bdd->details('module',  $_POST['idModule']) ){
            if( $bdd->insertGestionaireModule( $_POST['identifiant'] ,$_POST['idModule'] ) ) { $response = "Succès"; };
        }
        jsonRetour( $response );    exit;
    }

    // supression d'un enseignantcomme gestionaire d'un module
    if( isset( $_POST['supressionGestionnaireModule']) && isset($_POST['identifiant'] )  ) {
        $response = 'defaults';
        if( $bdd->deleteGestionaireModule( $_POST['identifiant'] ) ) { $response = "Succès"; };
        jsonRetour( $response );    exit;
    }


    
    // Obtenir les informations pour un Module
    if( isset( $_POST['identifiant'])  ) {
        $detailsModule = $bdd->details( 'module',$_POST['identifiant']);
        $bdd->closeConnection(); jsonRetour(  $detailsModule );    
       
    }









    if( isset( $_POST['suppressionModule']) && isset($_POST['identifiantModule'] ) ) {
 
        $response = "erreur";
        if(  $bdd->deleteEnseignantGestionaire( $_POST['identifiantModule']) && $bdd->deleteElement( 'module', $_POST['identifiantModule'])   ) { 
            $response =  "Succès" ;

        }
   
        jsonRetour( $response );      $bdd->closeConnection(); exit();
    }








}else { header('Location: /PCA/'); }



























/*



    // Obtenir la liste des enseignant s'occupant d'un module.
    if( isset( $_POST['listGestionEnseignants'])  ) {
        $c = $bdd->detailsModule(  $_POST['identifiant'] );
        $listModulesTab = array();
        while($Module = $c->fetch() ){
            $listModulesTab[] = $Module ;
        }
        $bdd->closeConnection(); jsonRetour( $listModulesTab );   
    }

    // Obtenir la liste des enseignant ne s'occupant pas d'un module.
    if( isset( $_POST['listEnseignantSansModule']) && isset($_POST['identifiant'] ) ) {
        $listenseignantsTab = array();
        $listenseignants = $bdd->listEnseignantSansModule( $_POST['identifiant'] );
        while($enseignant = $listenseignants ->fetch() ){
            $listenseignantsTab [] = $enseignant ;
        }
        $bdd->closeConnection(); jsonRetour( $listenseignantsTab );    
    }


    // Obtenir la liste des Module
    if( isset( $_POST['listModules'])  ) {
        $listModulesTab = array();
        $listModules = $bdd->list('module');
        while($Module = $listModules ->fetch() ){
            $listModulesTab [] = $Module ;
        }
        $bdd->closeConnection(); jsonRetour( $listModulesTab );   
    }


    // Vérification des données passer en paramètre dans la requête
    function verificationDonnerModule($nom, $niveau, $miseneligne, $statut ){
        return true;
    }

    if( isset( $_POST['nom']) && isset( $_POST['niveau']) && isset( $_POST['domaineModule'])  && isset( $_POST['datefinModule']) && isset( $_POST['miseneligneModule'])   && isset( $_POST['statutModule']) && isset( $_POST['datedebutModule'])   ) {
        $reponse = "defaults";
        $testReponse = verificationDonnerModule($_POST['nom'], $_POST['niveau'], $_POST['domaineModule'], $_POST['miseneligneModule'], $_POST['statutModule']  );
        if( $testReponse  == true  ){   
            if(! $bdd->details( 'module',$_POST['idModule']) && $_POST['idModule']  == 0 ) {
                if(  $bdd->insertModule($_POST['nom'],$_POST['niveau'], $_POST['domaineModule'], $_POST['datefinModule'], $_POST['miseneligneModule']  , $_POST['statutModule'], $_POST['datedebutModule'] , $_POST['niveauannne']    )) { $reponse = "Succès"; }          
            }else {// si l'Module existe alors on le modifie avec les element passers 
                if(  $bdd->modificationModule($_POST['nom'],$_POST['niveau'], $_POST['domaineModule'], $_POST['datefinModule'], $_POST['miseneligneModule']  , $_POST['statutModule'], $_POST['datedebutModule'],  $_POST['idModule'] ,  $_POST['niveauannne']     )) { $reponse = "Succès"; }     
            }
        }else {  $reponse = "Erreur dans vos saisie";  }  

        $bdd->closeConnection(); jsonRetour( $reponse );    
     
    }


    






    

    if( isset( $_POST['ajoutsGestionnaireModule'])  ) {
        $response = 'defaults';
        if( $bdd->details('enseignant',  $_POST['identifiant']) && $_POST['identifiant'] != 0 && $_POST['idModule'] != 0 &&  $bdd->details('module',  $_POST['idModule']) ){
            if( $bdd->insertGestionaireModule( $_POST['identifiant'] ,$_POST['idModule'] ) ) { $response = "Succès"; };
        }
        $bdd->closeConnection(); jsonRetour( $response );    
    }


    if( isset( $_POST['supressionGestionnaireModule']) && isset($_POST['identifiant'] )  ) {
        $response = 'defaults';
        if( $bdd->deleteGestionaireModule( $_POST['identifiant'] ) ) { $response = "Succès"; };
        $bdd->closeConnection(); jsonRetour( $response );    
    }


    
    // Obtenir les informations pour un Module
    if( isset( $_POST['identifiant'])  ) {
        $detailsModule = $bdd->details( 'module',$_POST['identifiant']);
        $bdd->closeConnection(); jsonRetour(  $detailsModule );    
       
    }


   
    

    


*/
