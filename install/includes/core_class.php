<?php

class Core {

	// Function to validate the post data
	function validate_post($data)
	{
		/* Validating the hostname, the database name and the username. The password is optional. */
		return !empty($data['hostname']) && !empty($data['username']) && !empty($data['database']);
	}

	// Function to show an error
	function show_message($type,$message) {
		return $message;
	}

	// Function to write the config file
	function write_config($data) {

		// Config path
		$template_path 	= 'config/database.php';
		$output_path 	= '../application/config/database.php';

		// Open the file
		$database_file = file_get_contents($template_path);

		$newdatabase_file  = str_replace("%HOSTNAME%",$data['hostname'],$database_file);
		$newdatabase_file  = str_replace("%USERNAME%",$data['username'],$newdatabase_file);
		$newdatabase_file  = str_replace("%PASSWORD%",$data['password'],$newdatabase_file);
		$newdatabase_file  = str_replace("%DATABASE%",$data['database'],$newdatabase_file);

		// Write the new database.php file
		$handle = fopen($output_path,'w+');

		// Chmod the file, in case the user forgot
		@chmod($output_path,0777);

		// Verify file permissions
		if(is_writable($output_path)) {

			// Write the file
			if(fwrite($handle,$newdatabase_file)) {
				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}
	}
}