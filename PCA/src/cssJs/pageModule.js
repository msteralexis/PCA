// requete pour obtenir la liste des Modules
function listModules(){
    $.ajax({
        url: './src/fichierphp/controllerModule.php', type: 'POST', data: 'listModules=' + 10, dataType: 'json'
    })
        .done(function (response) {
            var listModuleshtml = ' <ul> '
            for (i = 0; i < response.length; ++i) {
                listModuleshtml = listModuleshtml +  '<li class="clickListModule list-group-item list-group-item-action" value="' +response[i].identifiant +'" > '+ response[i].nom +'  </li>';  
            }
            listModuleshtml =listModuleshtml +  '<ul> ';
            $('#listModules').html( listModuleshtml );
        })
}

// Sauvegarder les informations sur un modules
function sauvegardeModule() {
    $.ajax({
        url: './src/fichierphp/controllerModule.php',  type: 'POST',  
        data: 'nom=' +  $("#nomModule").val() + ' &idModule=' + $("#idModule").val() + '&niveau=' + $("#niveauModule").val() +  '&domaineModule=' + $("#domaineModule").val()   +  '&datefinModule=' + $("#datefinModule").val()  +  '&miseneligneModule=' + $("#miseneligneModule").val()  +  '&statutModule=' + $("#statutModule").val()  +  '&datedebutModule=' + $("#datedebutModule").val()+ '&niveauannne=' + $("#niveauannne").val() , 
        dataType: 'json'
    })
        .done(function (response) { alert( response);   if( response == 'Succès') {  listModules(); miseaZero();  }   })
}

// Réinitialiser le questionaire            
function miseaZero(){
    $("#idModule").val(0); $("#nomModule").val('');  $("#niveauModule").val(0);  $("#domaineModule").val(0);
    $("#datefinModule").val(0); $("#miseneligneModule").val(0);  $("#statutModule").val(0);  $("#datedebutModule").val(0);
    $("#niveauanne").val(0); $('#listGestionEnseignantnon').html( '' );  $('#listGestionEnseignant').html( '' );

}

// Modifier le questionaire avec les informations d'un module.
function modificationFormulaire( module ){
    $("#idModule").val(module.identifiant); $("#nomModule").val(module.nom);  $("#niveauModule").val(module.niveau);  $("#domaineModule").val(module.domaine);
    $("#datefinModule").val(module.datefin); $("#miseneligneModule").val(module.miseenligne);  $("#statutModule").val(module.statut);  $("#datedebutModule").val(module.datedebut);
}


// Obtenir les details d'un modules.
function detailsModule(identifiant) {
    $.ajax({
        url: './src/fichierphp/controllerModule.php', type: 'POST', data: 'identifiant=' + identifiant,  dataType: 'json'
    })
        .done(function (response) { modificationFormulaire(response); listModuleAvecGestionnaire(identifiant); listModuleSansGestionnaire(identifiant); })
}


function listModuleAvecGestionnaire(identifiant) {
    $.ajax({
        url: './src/fichierphp/controllerModule.php', type: 'POST', data: 'identifiant=' + identifiant +'&listGestionEnseignants=' + 10,  dataType: 'json'
    })
        .done(function (response) {  
            var listenseignantshtml = ' <ul> '
            for (i = 0; i < response.length; ++i) {
                listenseignantshtml =listenseignantshtml +  '<li class="ListEnseignantsGestionnaires list-group-item list-group-item-action" value="' +response[i].identifiant +'" >   <img class="fit-picture"  src="./src/image/moins.png" > '+ response[i].nom + ' ' + response[i].prenom + ' </li>';  
            }
            listenseignantshtml =listenseignantshtml +  '<ul> ';
            $('#listGestionEnseignant').html( listenseignantshtml );
    })
}


function listModuleSansGestionnaire(identifiant) {
    $.ajax({
        url: './src/fichierphp/controllerModule.php', type: 'POST', data: 'listEnseignantSansModule=' + 10 +'&identifiant=' + identifiant, dataType: 'json'
    })
        .done(function (response) {
            var listenseignantshtml = ' <ul> '
            for (i = 0; i < response.length; ++i) {
                listenseignantshtml =listenseignantshtml +  '<li  class="ListEnseignantsNonGestionnaires list-group-item list-group-item-action" value="' +response[i].identifiant +'" >  <img class="fit-picture"  src="./src/image/plus.png" >  '+ response[i].nom + ' ' + response[i].prenom + ' </li>';  
            }
            listenseignantshtml =listenseignantshtml +  '<ul> ';
            $('#listGestionEnseignantnon').html( listenseignantshtml );
        })
}



function ajoutsGestionnaireModule(identifiant) {
    $.ajax({
        url: './src/fichierphp/controllerModule.php', type: 'POST', data: 'identifiant=' + identifiant + '&ajoutsGestionnaireModule=' + 10 + ' &idModule=' + $("#idModule").val(),  dataType: 'json'
    })
        .done(function (response) {  listModuleAvecGestionnaire( $("#idModule").val()  ) ; listModuleSansGestionnaire( $("#idModule").val() ); })
}



function supressionGestionnaireModule(identifiant) {
    $.ajax({
        url: './src/fichierphp/controllerModule.php', type: 'POST', data: 'identifiant=' + identifiant + '&supressionGestionnaireModule=' + 10,  dataType: 'json'
    })
        .done(function (response) {  listModuleAvecGestionnaire( $("#idModule").val()  ) ; listModuleSansGestionnaire( $("#idModule").val() ); })
}


$(document).ready(function () {
    listModules();


    if( $("#zozo").val() > 0 ) { 
        detailsModule( $("#zozo").val());

    }

 
    $('#nouveauModule').live('click', function() {  $('.clickListModule').css('color', '#575d64');  miseaZero(); })
    $('#sauvegardeModule').live('click', function() {  sauvegardeModule(); })
    $('.clickListModule').live('click', function() {  $('.clickListModule').css('color', '#575d64');  $(this).css('color', 'red'); detailsModule( $(this).val() ); })

    $('.ListEnseignantsNonGestionnaires').live('click', function() {  ajoutsGestionnaireModule( $(this).val() ); })

    $('.ListEnseignantsGestionnaires').live('click', function() {  supressionGestionnaireModule( $(this).val() ); })


    
    // Supression nd'un module 
    $('#supressionModule').live('click', function() { if (confirm( "Êtes vous sur de vouloirs supprimer ?")) { SupressionModule( $("#idModule").val() );    }  })

    

    
});



// requete de supression d'un module 
function SupressionModule( identifiantModule ) {
    $.ajax({
        url: './src/fichierphp/controllerModule.php', type: 'POST', data: 'suppressionModule=' + 10 +'&identifiantModule=' + identifiantModule , dataType: 'json'
    })
        .done(function (response) {
            if(response == "Succès"){  miseaZero();  listModules(); }
        })
}





