<?php   
session_start(); 
    if(session_destroy())
    {	
    	unset($gl_idnum);
    	unset($gl_online);   
    	unset($gl_id_num);
      unset($gl_role);
      unset($gl_user_id);
    	header("Location: ./");
    }
  
?>