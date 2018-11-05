<?php

function rtrt(){

	$MCI =& get_instance();
	
	return $MCI->security->get_csrf_hash();

}


?>