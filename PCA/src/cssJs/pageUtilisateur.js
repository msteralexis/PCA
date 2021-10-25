
// requete pour sauvegarder un User
function sauvegardeUser() {
    $.ajax({
        url: './src/fichierphp/controllerUser.php',  type: 'POST',  
        data: 'nom=' + $("#nomutilisateur").val() + ' &prenom=' + $("#prenomUtilisateur").val() + '&mail=' + $("#mailUtilisateur").val()+  '&idUser=' + $("#idutilisateur").val() , 
        dataType: 'json'
    })
        .done(function (response) { alert( response);   if( response == 'Succès') { listUsers(); miseaZero(); }   })
}

// requete pour obtenir la liste des users
function listUsers(){
    $.ajax({
        url: './src/fichierphp/controllerUser.php', type: 'POST', data: 'listUsers=' + 10, dataType: 'json'
    })
        .done(function (response) {
            var listusershtml = ' <ul> '
            for (i = 0; i < response.length; ++i) {
                listusershtml = listusershtml +  '<li class="clickListusers list-group-item list-group-item-action" value="' +response[i].identifiant +'" > '+ response[i].nom + ' ' + response[i].prenom + ' </li>';  
            }
            listusershtml =listusershtml +  '<ul> ';
            $('#listUsers').html( listusershtml );
        })
}


// requete pour obtenir tous ledétails d'un User.
function detailsUser(identifiant) {
    $.ajax({
        url: './src/fichierphp/controllerUser.php', type: 'POST', data: 'identifiant=' + identifiant,  dataType: 'json'
    })
        .done(function (response) { modificationformulaire(response) })
}


function modificationformulaire(User){
    $("#nomutilisateur").val(User.nom); $("#prenomUtilisateur").val(User.prenom);  $("#mailUtilisateur").val(User.mail);  $("#idutilisateur").val(User.identifiant);
}

function miseaZero(){
    $("#nomutilisateur").val(''); $("#prenomUtilisateur").val('');  $("#mailUtilisateur").val('');  $("#idutilisateur").val( 0 );
}




function ChangementPasswordUser(){
    $.ajax({
        url: './src/fichierphp/controllerUser.php',  type: 'POST',  
        data: 'oldPassword=' + $("#oldPassword").val() + '&newPassword1=' + $("#newPassword1").val() + '&newPassword2=' + $("#newPassword2").val() , 
        dataType: 'json'
    })
        .done(function (response) {  alert( response);  if( response == 'Votre password est modifier.' ){ } })
}

function remiseAzeroFormualirePassword( ){
    $("#oldPassword").val('');$("#newPassword1").val('');$("#newPassword2").val('');
}

$(document).ready(function () {

    listUsers()

    // Obtenir le details d'un utilsiateurs lros du click sur son nom ou prenom
    $('.clickListusers').live('click', function() { $('.clickListusers').css('color', '#575d64');  $(this).css('color', 'red');  detailsUser( $(this).val() ); })

    // Remete a zero les donner du formulaire 
    $('#MiseZeroFormulaire').on('click', function () {  $('.clickListusers').css('color', '#575d64'); miseaZero(); })

    // requete pour sauvegarder un User
    $('#sauvegardeUser').on('click', function () {sauvegardeUser(); })

    // requete pour sauvegarder un User
    $('#changePassword').on('click', function () { ChangementPasswordUser();  })


    $('#supressionUtilisateur').live('click', function() {  if (confirm( "Êtes vous sur de vouloirs supprimer ?")) { supressionUtilisateur( $("#idutilisateur").val() );    }  })

    
    
});








function supressionUtilisateur( identifiantUtilisateur ) {
    $.ajax({
        url: './src/fichierphp/controllerUser.php', type: 'POST', data: 'suppressionUtilisateur=' + 10 +'&identifiantUtilisateur=' + identifiantUtilisateur , dataType: 'json'
    })
        .done(function (response) {
            if(response == "Succès"){  miseaZero();  
                listUsers(); }
        })
}






