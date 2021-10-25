<?php

if (isset($_SESSION['login']) && isset($_SESSION['password'])) {
  require("./src/fichierphp/bdd.php");
  $bdd = new Bdd; ?>

  <script src="./src/cssJs/pageExport.js"> </script>



  <div class=" cadre">
    <h3> Liste de module en fonction de filtre </h3>
 
    <div class="row">

      <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3">
        <label> Statut </label>
        <span> <select name="statut" id="statutModule">
            <option value="0"> Non Commencé </option>
            <option value="1"> En cours de Rédaction </option>
            <option value="2"> Achevé </option>
          </select> </span>
      </div>

      <div class="col-lg-2 col-md-2 col-xs-2 col-sm-2">
        <label> En Ligne </label>
        <span> <select name="miseenligne" id="miseneligneModule">
            <option value="0"> Non</option>
            <option value="1"> Oui </option>
          </select> </span>
      </div>



      <div class="col-lg-2 col-md-2 col-xs-2 col-sm-2">
        <label>Niveau Module</label>
        <span> <select name="statut" id="niveauModule">
            <option value="0" selected> Licence </option>
            <option value="1"> Master </option>
          </select> </span>
      </div>


      <div class="col-lg-2 col-md-2 col-xs-2 col-sm-2">
        <label> Avec Enseignant </label>
        <span> <select name="statut" id="avecEnseignant">
            <option value="0" selected> oui </option>
            <option value="1"> Non </option>
          </select> </span>
      </div>

      <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3">
        <button type="button" class="btn btn-primary" id="listModules"> Observer </button>
        <button type="button" class="btn btn-primary" id="listsModulesExport"> Export </button>

      </div>
    </div>

    <div class="row" id="listexport">
      <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">


      <table class="table">
        <thead>
          <tr>
            <th scope="col">Nom</th>
            <th scope="col"> Domaine </th>
            <th scope="col"> Statut </th>
            <th scope="col"> Date debut</th>
            <th scope="col"> Date fin </th>
            <th scope="col"> Niveau </th>
          </tr>
        </thead>
        <tbody id="listModulesFiltre">
        
      
        </tbody>
      </table>




    
      </div>
    </div>
  </div>

  </div>

<?php $bdd->closeConnection();
} else {
  header('Location: /PCA/');
}   ?>



<?php

/*
include('PHPExcel-1.8/Classes/PHPExcel.php');

$workbook = new PHPExcel;
$sheet =	$workbook->getActiveSheet();
$sheet->setCellValue('A1','tets 8');



$writer = new PHPExcel_Writer_Excel2007($workbook);

$records = './src/exportExcell/fichier.xlsx';

$writer->save($records);
*/

?>