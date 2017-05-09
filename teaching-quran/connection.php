<?php
	error_reporting(~E_NOTICE);	
	$mysqlic = new mysqli('localhost','root','','teaching_quran') or die('Connection Error..' . $mysqlic->connect_error);	
?>