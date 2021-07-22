<?php 

/**
Disponibilie class
 * 
 */
class Disponibility
{
	
	// renvoie true si la loc est libre, false sinon
    function isVacant($idloc,$date,$mysqlid)
	{
        $Result = $mysqlid->query("SELECT * FROM planning WHERE idloc='$idloc' AND date='$date'");
        if($Result->rowCount()>0) return false;
        else return true;
    }

	// renvoie true si la loc est libre, false sinon.
	function getDisponibility($idloc,$date,$mysqlid)
	{

        $Result = $mysqlid->query("SELECT * FROM planning WHERE idloc='$idloc' AND date='$date'");
        if($Result->rowCount()>0) return false;
        else return true;
    }
    
    function getLocationTarifsById($idLoc,$date,$mysqlid){
		$Result = $mysqlid->query("select * from tarifs join locations on tarifs.idloc=locations.id where location.id='$idloc'");
		return $Result;
  	}

    function getAllLocation($mysqlid){

	  	$Result = $mysqlid->query("select * from tarifs join locations on tarifs.idloc=locations.id limit 25");
	  	return $Result;
    }

}


 ?>