<?php
//Global Declarations
	session_start();
	$gl_online=(isset($_SESSION['online'])?$_SESSION['online']:'');
	$gl_name=(isset($_SESSION['name'])?$_SESSION['name']:'');
	$gl_user_id=(isset($_SESSION['user_id'])?$_SESSION['user_id']:'');
	$gl_id_num=(isset($_SESSION['id_num'])?$_SESSION['id_num']:'');
	$gl_role=(isset($_SESSION['role'])?$_SESSION['role']:'');
	
?>
