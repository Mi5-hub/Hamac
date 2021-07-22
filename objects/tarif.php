<?php
// required headers

class Tarifs
{

  function GetAllTarif($mysqlid)
  {
  			
  	$Result = $mysqlid->query("select * from tarifs join locations on tarifs.idloc=locations.id");
  	return $Result;

  }
}
	


  
// database connection will be here!
?>