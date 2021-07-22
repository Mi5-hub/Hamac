<?php
// required headers
ini_set('max_execution_time', 10000);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/disponibility.php';


$database = new Database();

$db = $database->getConnection();

$Dispo = new Disponibility();

if($_SERVER['REQUEST_METHOD']=="POST"){

$data = json_decode(file_get_contents('php://input'), true);


if (isset($data['datedeb']) && isset($data['datefin'])) {

    $debloc = date_format(date_create($data['datedeb']),"Y-m-d");
   $finloc = date_format(date_create($data['datefin']),"Y-m-d");  
	
	//if ($idLoc && $date) {
	
	$stmt = $Dispo->getAllLocation($db);

	$num = $stmt->rowCount();

	if($num>0){
	      # code...
		$Alldispo = array();
	    $Alldispo['disponibility'] = array();
	   
  		// Verification pour chaque location si elle est dispo pour la periode demandee
    while ($List = $stmt->fetch(PDO::FETCH_ASSOC))
    	{
  
            // Verifie la disponibilite pour la location
            $dispo = true;
            $libre = true;

            $date_temp = $debloc;
            while ( strtotime($date_temp) <= strtotime($finloc)) {
              echo $date_temp ." --- ";
              $date_comp =  date_format(date_create($date_temp),"Y-m-d");
                $libre = $Dispo->isVacant($List['idloc'],$date_comp,$db);
                if(!$libre)
                {
                  echo "ts libre";
                    $dispo = false;
                    break;
                }

                $date_temp = date("Y-m-d", strtotime("$date_temp +1 day"));
            }

            if ($dispo) {
              echo "libre " .$List['idloc'];
            	
				      array_push($Alldispo['disponibility'],$List);

            }
        }
	  	// set response code - 200 Ok
	    http_response_code(200);  
	    echo json_encode($Alldispo);
    }
    else
    {

      // set response code - 404 Not found
      http_response_code(404);

      
      echo json_encode(
          array("message" => "No date disponible!")
      );
    }
}
else{

	echo json_encode(
    array(
          "message"=>" date for disponibility is required",
          "date"=>$data,
    )
  );
}
}
else{
  echo json_encode(array('message' => "method not allowed"));
} 

?>