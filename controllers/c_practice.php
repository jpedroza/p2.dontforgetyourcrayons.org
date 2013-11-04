<?php

class practice_controller extends base_controller {

	public function john() {
						
	$q = "INSERT INTO users SET first_name = 'Albert', 
	last_name = 'Einstein',
	password = 'buba'";
	
	//echo $q;
	
	
	
	
	
	DB::instance(DB_NAME)->query($q); 
			
	}
	
} # eoc

?>