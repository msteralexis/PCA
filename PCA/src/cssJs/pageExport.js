
// Obtenir la liste des modules
function listsModules() {
    $.ajax({
        url: './src/fichierphp/controllerExport.php', type: 'POST', 
        data: 'listsModulesFiltre=' + 10 + '&statutModule=' + $("#statutModule").val()   + '&miseneligneModule=' + $("#miseneligneModule").val()   + '&niveauModule=' + $("#niveauModule").val()  + '&avecEnseignant=' + $("#avecEnseignant").val(), 
        dataType: 'json'
    })
        .done(function (response) { 
            var listenseignantshtml = '  '
            for (i = 0; i < response.length; ++i) {
                if( response[i].niveau == 0){ niveau = 'Licence'} else { niveau =" Master"};
                if( response[i].statut == 0){ statut = 'Non commencé'} else if(response[i].statut==1) { statut =" En cours de rédaction "} else { statut = ' Achevé';  };
                listenseignantshtml =listenseignantshtml +  '<tr>   <th scope="row"> <a href="./index.php?idModule=' + response[i].identifiant +' "> ' + response[i].nom +' </a> </th> <td>' + response[i].domaine +'  </td> <td>' + statut +'  </td> <td>' + response[i].datedebut +'  </td> <td>' + response[i].datefin +'  </td> <td>' + niveau+'  </td> </tr> ' 
            }
        
            $('#listModulesFiltre').html( listenseignantshtml );
        })
}

// Exporter la liste des modules selectioner
function listsModulesExport() {
    $.ajax({
        url: './src/fichierphp/controllerExport.php', type: 'POST', 
        data: 'listsModulesExport=' + 10 + '&statutModule=' + $("#statutModule").val()   + '&miseneligneModule=' + $("#miseneligneModule").val()   + '&niveauModule=' + $("#niveauModule").val()  + '&avecEnseignant=' + $("#avecEnseignant").val(), 
        dataType: 'json'
    })
        .done(function (response) {  if(response == "Succès") { window.location.href = "./src/fichierphp/modules.xlsx"; } })
}



$(document).ready(function () {

    $('#listModules').live('click', function() {  listsModules(); })

    $('#listsModulesExport').live('click', function() {  listsModulesExport(); })

});

