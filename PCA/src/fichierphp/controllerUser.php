<?php

require("bdd.php");
$bdd = new Bdd;


/*
Reception requete ajax.
*/
function jsonRetour( $valeurRetour) {
    header('Content-Type: application/json');
    echo json_encode( $valeurRetour, JSON_PRETTY_PRINT);
}

function verificationDonnerUser( $nom, $mail, $prenom){
    if( strlen($nom) < 3 || strlen($nom) > 30  ){ return "Erreur sur le nom" ;}
    if( strlen($prenom) < 3 || strlen($prenom) > 30  ){ return "Erreur sur le prenom" ;}
    if(! preg_match('`^[[:alnum:]]([-_.]?[[:alnum:]])*@[[:alnum:]]([-.]?[[:alnum:]])*\.([a-z]{2,4})$`', $mail )) {return "Erreur sur le mail" ;}
    return  "Succès";
}

// reception requete pour enregistrer un User
if( isset( $_POST['nom']) && isset( $_POST['prenom']) && isset( $_POST['mail'])    ) {
    $testReponse = "default";
    
    $testReponse = verificationDonnerUser($_POST['nom'], $_POST['mail'], $_POST['prenom'] );
    if( $testReponse  == "Succès"  ){

        if(! $bdd->details( 'user', $_POST['idUser']) && $_POST['idUser']  == 0 ) {
            if(  $bdd->insertUser($_POST['nom'],$_POST['prenom'], $_POST['mail'] )) {   $testReponse = "Succès"; }
        }else {
            if(  $bdd->modificationUser($_POST['nom'],$_POST['prenom'], $_POST['mail'],  $_POST['idUser'] ) ){   $testReponse = "Succès"; }
        }
        
    }

    jsonRetour( $testReponse );    
    $bdd->closeConnection(); exit();
}





// Obtenir la liste des User
if( isset( $_POST['listUsers'])  ) {
    $listusersTab = array();
    $listusers = $bdd->list('user');
    while($user = $listusers ->fetch() ){
        $listusersTab [] = $user ;
    }

    jsonRetour( $listusersTab );    
    $bdd->closeConnection(); exit();
}




if( isset( $_POST['suppressionUtilisateur']) && isset($_POST['identifiantUtilisateur'] ) ) {
 
    $response = "erreur";
    if(   $bdd->deleteElement( 'user', $_POST['identifiantUtilisateur'])   ) { 
        $response =  "Succès" ;

    }

    jsonRetour( $response );      $bdd->closeConnection(); exit();
}







// Obtenir les informations pour un User
if( isset( $_POST['identifiant'])  ) {
    $detailsUser = $bdd->details('user',$_POST['identifiant']);
    jsonRetour(  $detailsUser );    
    $bdd->closeConnection(); exit();
}

// Changement de mot de passe d'un utilisateur
if( isset( $_POST['oldPassword']) && isset( $_POST['newPassword1']) && isset( $_POST['newPassword2'])   ) {
    session_start(); $response = 'error';
    if( $_SESSION['password'] == md5(  $_POST['oldPassword'] )  ){
        if( $_POST['newPassword1'] == $_POST['newPassword2'] ){
            if( strlen( $_POST['newPassword1']) > 3){
                if( $bdd->modificationPasswordUser( $_POST['newPassword1'], $_SESSION['identifiant'] )){ $response = 'Votre password est modifier.'; }
            }else { $response = 'Mot de passe non conforme.'; }
        } else { $response = 'Les deux mot de passe sont différents'; }
    } else { $response = 'Erreur ancien mot de passe'; }
    jsonRetour(  $response   );    
    $bdd->closeConnection(); exit();
}

// Réceptions formulaire de connection
if( isset( $_POST['nomInsription'] )   &&  isset( $_POST['passwordInsription'] ) ) {
    // si les element passer pemetent une connection alors on créer un session.
    if( $result = $bdd->connection($_POST['nomInsription'],  $_POST['passwordInsription'])    ){
        session_start();
        $_SESSION= $result;
        $_SESSION["login"]= $result['mail'];
    }
}

// déconneciton d'un utilisateur
if( isset( $_POST["deconnection"] )  ) {
    session_start(); session_unset(); session_destroy();
}


$bdd->closeConnection();
header('Location: /PCA/');    exit();

    
