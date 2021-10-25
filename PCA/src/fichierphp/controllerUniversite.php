<?php

session_start();
if (isset($_SESSION['login']) && isset($_SESSION['password'])) { 

require("bdd.php"); $bdd = new Bdd;

function jsonRetour( $valeurRetour) {
    header('Content-Type: application/json');
    echo json_encode( $valeurRetour, JSON_PRETTY_PRINT);
}

// Vérification des données passer en paramètre dans la requête
function verificationDonnerUniversite( $nom, $ville, $adresse){
    if( strlen($nom) < 3 || strlen($nom) > 30  ){ return "Erreur sur le nom" ;}
    if( strlen($ville) < 3 || strlen($ville) > 30  ){ return "Erreur sur la ville" ;}
    if( strlen($adresse) < 3 || strlen($adresse) > 30  ){ return "Erreur sur l'adresse" ;}
    return  "Succès";
}

// reception requete pour enregistrer un Enseignant
if( isset( $_POST['nom']) && isset( $_POST['adresse']) && isset( $_POST['ville'])    ) {
    $reponse = "default";
    
    $reponse = verificationDonnerUniversite($_POST['nom'], $_POST['ville'], $_POST['adresse']  );
    if(  $reponse  == "Succès"  ){
        // si l'Enseignant nexiste pas on l'ajoute
        if(! $bdd->details('universite', $_POST['idUniversite']) && $_POST['idUniversite']  == 0 ) {
            if(  $bdd->insertUniversite($_POST['nom'],$_POST['ville'],  $_POST['adresse'] )) {  $reponse = "Succès";  }
        } else {
            if($bdd->modificationUniversite($_POST['nom'],$_POST['ville'], $_POST['adresse'], $_POST['idUniversite'] )){ $reponse = "Succès"; }
        }      
    }


    $bdd->closeConnection(); jsonRetour( $reponse );    
}




// Obtenir la liste des Universites
if( isset( $_POST['listUniversite'])  ) {
    $listUniversiteTab = array();
    $listUniversite = $bdd->list('universite');
    while($enseignant = $listUniversite ->fetch() ){
        $listUniversiteTab [] = $enseignant ;
    }

    $bdd->closeConnection(); jsonRetour( $listUniversiteTab );  
}

// Obtenir les informations pour un Enseigant
if( isset( $_POST['identifiant'])  ) {
    $detailsenseignant = $bdd->details('universite',$_POST['identifiant']);
    $bdd->closeConnection(); jsonRetour(  $detailsenseignant );    
}


$bdd->closeConnection();

}else { header('Location: /PCA/');  }

