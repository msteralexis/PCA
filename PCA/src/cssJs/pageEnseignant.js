
// requete pour sauvegarder un Enseignant
function sauvegardeEnseignant() {
    $.ajax({
        url: './src/fichierphp/controllerEnseignant.php',  type: 'POST',  
        data: 'nom=' + $("#nomEnseignant").val() + ' &prenom=' + $("#prenomEnseignant").val() + '&mail=' + $("#mailEnseignant").val() + '&telephone=' + $("#telephoneEnseignant").val() +  '&universite=' + $("#universite").val() +  '&idEnseignant=' + $("#idEnseignant").val() , 
        dataType: 'json'
    })
        .done(function (response) {
            alert( response);
            if( response == 'Succès') { listenseignants(); miseaZero(); }  
        })
}



// requete pour obtenir la liste des Enseignants
function listenseignants(){
    $.ajax({
        url: './src/fichierphp/controllerEnseignant.php', type: 'POST', data: 'listenseignants=' + 10, dataType: 'json'
    })
        .done(function (response) {
            var listenseignantshtml = ' <ul> '
            for (i = 0; i < response.length; ++i) {
                listenseignantshtml =listenseignantshtml +  '<li class="clickListenseignants list-group-item list-group-item-action" value="' +response[i].identifiant +'" > '+ response[i].nom + ' ' + response[i].prenom + '  </li>';  
            }
            listenseignantshtml =listenseignantshtml +  '<ul> ';
            $('#listenseignants').html( listenseignantshtml );
        })
}

// requete pour obtenir tous ledétails d'un Enseignant.
function detailsenseignants(identifiant) {
    $.ajax({
        url: './src/fichierphp/controllerEnseignant.php', type: 'POST', data: 'identifiant=' + identifiant,  dataType: 'json'
    })
        .done(function (response) {
            modificationformulaire(response)
        })
}

function modificationformulaire(enseignant){
    $("#nomEnseignant").val(enseignant.nom); $("#prenomEnseignant").val(enseignant.prenom);  $("#mailEnseignant").val(enseignant.mail); 
    $("#telephoneEnseignant").val(enseignant.telephone);  $("#universite").val(enseignant.universite); 
    $("#idEnseignant").val(enseignant.identifiant);
}

function miseaZero(){
    $("#nomEnseignant").val(''); $("#prenomEnseignant").val('');  $("#mailEnseignant").val(''); 
    $("#telephoneEnseignant").val('');  $("#universite").val(1);  $("#idEnseignant").val( 0 );
}



$(document).ready(function () {

    // Liste Enseignants charger au démarrage
    listenseignants();

    // Obtenir le details d'un utilsiateurs lros du click sur son nom ou prenom
    $('.clickListenseignants').live('click', function() {  $('.clickListenseignants').css('color', '#575d64');  $(this).css('color', 'red');   detailsenseignants( $(this).val() );  })

    // Remete a zero les donner du formulaire 
    $('#MiseZeroFormulaire').on('click', function () {    $('.clickListenseignants').css('color', '#575d64'); miseaZero();})


    // requete pour sauvegarder un Enseignant
    $('#sauvegardeEnseignant').on('click', function () {    sauvegardeEnseignant();})

    // On click sur le bouton de supression d'un enseingant
    $('#supressionEnseignant').live('click', function() {  if (confirm( "Êtes vous sur de vouloirs supprimer ?")) { supressionEnseignant( $("#idEnseignant").val() );   }  })

});







// Reque de supression d'un enseignant
function supressionEnseignant( identifiantEnseignant ) {
    $.ajax({
        url: './src/fichierphp/controllerEnseignant.php', type: 'POST', data: 'suppressionEnseignant=' + 10 +'&identifiantEnseignant=' + identifiantEnseignant , dataType: 'json'
    })
        .done(function (response) {
            if(response == "Succès"){  miseaZero();  listenseignants();
            }
        })
}
