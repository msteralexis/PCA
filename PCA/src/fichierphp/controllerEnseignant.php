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

    function verificationDonnerEnseignant( $nom, $mail, $prenom, $universite){
        if( strlen( $nom) < 3  ||  strlen( $prenom) > 30 ) { return "Erreur sur le nom"; }
        if( strlen($prenom) < 3 || strlen($prenom) > 30  ){ return "Erreur sur le prenom" ;}
        if(! preg_match('`^[[:alnum:]]([-_.]?[[:alnum:]])*@[[:alnum:]]([-.]?[[:alnum:]])*\.([a-z]{2,4})$`', $mail )) {return "Erreur sur le mail" ;}
        return  "Succès" ;
    }

    // reception requete pour enregistrer un Enseignant
    if( isset( $_POST['nom']) && isset( $_POST['prenom']) && isset( $_POST['mail']) && isset( $_POST['telephone']) && isset( $_POST['universite'])    ) {
        $reponse = "default";
        
        $reponse = verificationDonnerEnseignant($_POST['nom'], $_POST['mail'], $_POST['prenom'], $_POST['universite']   );
        if( $reponse  == "Succès"  ){
            if(! $bdd->details( 'enseignant', $_POST['idEnseignant']) && $_POST['idEnseignant']  == 0 ) {
                if(  $bdd->insertenseignant($_POST['nom'],$_POST['prenom'], $_POST['mail'], $_POST['telephone'], $_POST['universite'] )) { $reponse = "Succès"; }
            }else{
                if(  $bdd->modificationenseignant($_POST['nom'],$_POST['prenom'], $_POST['mail'], $_POST['telephone'], $_POST['universite'],  $_POST['idEnseignant'] ) ){ $reponse = "Succès"; }
            }
        }

        $bdd->closeConnection(); jsonRetour( $reponse );    
    }

    // Obtenir la liste des Enseigant
    if( isset( $_POST['listenseignants'])  ) {
        $listenseignantsTab = array();
        $listenseignants = $bdd->list('enseignant');
        while($enseignant = $listenseignants ->fetch() ){
            $listenseignantsTab [] = $enseignant ;
        }

        $bdd->closeConnection();jsonRetour( $listenseignantsTab );      
    }

    // Obtenir les informations pour un Enseigant
    if( isset( $_POST['identifiant'])  ) {
        $detailsenseignant = $bdd->details('enseignant',$_POST['identifiant']);
        $bdd->closeConnection(); jsonRetour(  $detailsenseignant );    
      
    }






    if( isset( $_POST['suppressionEnseignant']) && isset($_POST['identifiantEnseignant'] ) ) {
 
        $response = "erreur";
        if(  $bdd->deleteElement( 'enseignant', $_POST['identifiantEnseignant']) && $bdd->deleteEnseignantGestionaireEnseignant( $_POST['identifiantEnseignant']  )  ) { 
            $response =  "Succès" ;

        }
   
        jsonRetour( $response );      $bdd->closeConnection(); exit();
    }







    
}else { header('Location: /PCA/');  }  

?>