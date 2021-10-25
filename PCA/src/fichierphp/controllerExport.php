<?php


session_start();
if (isset($_SESSION['login']) && isset($_SESSION['password'])) {

    require("bdd.php");
    $bdd = new Bdd;

    function jsonRetour( $valeurRetour) {
        header('Content-Type: application/json');
        echo json_encode( $valeurRetour, JSON_PRETTY_PRINT);
    }

    // Export d'un fichier CSV en fonction des paramètres.
    function ExportCSV( $listModules ) { 
        include('PHPExcel-1.8/Classes/PHPExcel.php');

        $workbook = new PHPExcel; $sheet =	$workbook->getActiveSheet();
        $sheet->setCellValue('A2','Export des Modules');
        $sheet->setCellValue('A4','Nom'); $sheet->setCellValue('B4','Date Debut'); $sheet->setCellValue('C4','Date Fin'); $sheet->setCellValue('D4','Niveau');

        $row = 5;
        while($Module = $listModules->fetch() ){
            $sheet->setCellValue('A'.$row, $Module['nom']);
            $sheet->setCellValue('B'.$row, $Module['datedebut']);
            $sheet->setCellValue('C'.$row, $Module['datefin']);
            $sheet->setCellValue('D'.$row, $Module['niveau']);
            $row = $row + 1;
        }    
        $writer = new PHPExcel_Writer_Excel2007($workbook);
        $records = './modules.xlsx';

        $writer->save($records);
        return true;
    }
    

    // Obtenir la liste des modules en fonction des filtre passer en paramètre
    if( isset( $_POST['listsModulesFiltre']) && isset( $_POST['statutModule']) && isset( $_POST['miseneligneModule'])  && isset( $_POST['niveauModule'])  && isset( $_POST['avecEnseignant']) ) {
        $c =  $bdd->listModulesFiltres( $_POST['statutModule'] ,$_POST['miseneligneModule'] , $_POST['niveauModule'], $_POST['avecEnseignant']);
        $listModulesTab = array();
        while($Module = $c->fetch() ){
        $listModulesTab[] = $Module ;
        }
        jsonRetour( $listModulesTab ); 
    }

    // Obtenir la liste des modules en fonction des filtre passer en paramètre et effectuer un export CSV.
    if( isset( $_POST['listsModulesExport']) && isset( $_POST['statutModule']) && isset( $_POST['miseneligneModule'])  && isset( $_POST['niveauModule'])  && isset( $_POST['avecEnseignant']) ) {
        $listModules =  $bdd->listModulesFiltres( $_POST['statutModule'] ,$_POST['miseneligneModule'] , $_POST['niveauModule'], $_POST['avecEnseignant']);
        ExportCSV($listModules );
        jsonRetour( 'Succès' ); 
    }
    
    


}else { header('Location: /PCA/'); }
