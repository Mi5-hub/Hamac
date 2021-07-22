<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/tarif.php';


$database = new Database();
$db = $database->getConnection();

$Tarifs = new Tarifs();

$stmt = $Tarifs->GetAllTarif($db);
$num = $stmt->rowCount();
  


if($num>0){
      # code...
	$Alltarifs = array();
    $Alltarifs['tarifs'] = array();
   
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

    		/*$annee = substr($row["datedeb"],0,4); 
			$annee++;
    	
    		$row_tarif = array(
    			"idTarifs" => $row['id'],
    			"idloc" => $row['idloc'],
    			"datedeb" => $annee .substr($row["datedeb"],4), 
    			"datefin" => $annee .substr($row["datefin"],4),
    			"periode" => addslashes($row["periode"]),
    			"nbmin" => $row['nbmin'],
    			"nbmax" => $row['nbmax'],
    			"nuit" => $row['nuit'],
    			"weekend" => $row['weekend'],
    			"semaine" => $row['semaine'],
    			"semaine2" => $row['semaine2'],
    			"semaine4" => $row['semaine4'],
    			"nuitpayee" => $row['nuitpayee'],
    			"nuitgratos" => $row['nuitgratos'],
    			"nom"=>,
    			"ville"=>,
    			"type"=>,
    			"nbChambres"=>,


    		);
    		array_push($Alltarifs['tarifs'],$row_tarif);*/
    		array_push($Alltarifs['tarifs'],$row);
    	}

    	

  	// set response code - 200 Ok
      http_response_code(200);
      // show tarifs data in json 
      //echo "mety a";
      echo json_encode($Alltarifs);
    }
    else{

      // set response code - 404 Not found
      http_response_code(404);

      // tell the user no tarif found
      echo json_encode(
          array("message" => "No Tarif found!")
      );
    }
  
// database connection will be here
?>