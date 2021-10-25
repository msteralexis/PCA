

// requete pour sauvegarder une universite
function sauvegardeUniversite() {
    $.ajax({
        url: './src/fichierphp/controllerUniversite.php',  type: 'POST',  
        data: 'idUniversite=' + $("#idUniversite").val() + ' &nom=' + $("#nomUniversite").val() + '&adresse=' + $("#villeAdresse").val() + '&ville=' + $("#VilleUniversite").val() , 
        dataType: 'json'
    })
        .done(function (response) {
            alert( response);
            if( response == 'Succès' ) { listUniversites(); miseaZero(); }  
        })
}


// requete pour obtenir la liste des universites
function listUniversites(){
    $.ajax({
        url: './src/fichierphp/controllerUniversite.php', type: 'POST', data: 'listUniversite=' + 10, dataType: 'json'
    })
        .done(function (response) {
            var listenseignantshtml = ' <ul> '
            for (i = 0; i < response.length; ++i) {
                listenseignantshtml =listenseignantshtml +  '<li class="clickListUniversite list-group-item list-group-item-action" value="' +response[i].identifiant +'" > '+ response[i].nom + ' ' + response[i].ville + ' </li>';  
            }
            listenseignantshtml =listenseignantshtml +  '<ul> ';
            $('#listUniversite').html( listenseignantshtml );
        })
}


// requete pour obtenir tous ledétails d'une universite.
function detailsenseignants(identifiant) {
    $.ajax({
        url: './src/fichierphp/controllerUniversite.php', type: 'POST', data: 'identifiant=' + identifiant,  dataType: 'json'
    })
        .done(function (response) {
            modificationformulaire(response)
        })
}

function modificationformulaire(universite){
    $("#idUniversite").val(universite.identifiant); $("#nomUniversite").val(universite.nom);   $("#villeAdresse").val(universite.adresse);   $("#VilleUniversite").val( universite.ville);  
}

function miseaZero(){
    $("#idUniversite").val( 0 ); $("#nomUniversite").val('');   $("#villeAdresse").val('');    $("#VilleUniversite").val( '');  
}


$(document).ready(function () {
    listUniversites();


    // Obtenir le details d'une universite lors du click sur son nom ou prenom
    $('.clickListUniversite').live('click', function() { $('.clickListUniversite').css('color', '#575d64');  $(this).css('color', 'red');
        detailsenseignants( $(this).val() );
    })

    // Remete a zero les donner du formulaire 
    $('#MiseZeroFormulaire').on('click', function () {
        $('.clickListUniversite').css('color', '#575d64');  miseaZero();
    })

    // requete pour sauvegarder un universite
    $('#sauvegardeUniversite').on('click', function () {
        sauvegardeUniversite()
    })

   


});

