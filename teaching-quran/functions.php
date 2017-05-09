<?php

function login($userid,$password,$role){
	include ('connection.php');
	if ($userid !='' AND $password !='' AND $role !='') {
		$query="
		        SELECT
		            *
		        FROM
		           users 
		        WHERE 
		        	id_num = '".$userid."' AND 
		        	password = '".$password."' AND fk_role_id = '".$role."'
		    ";
	    $q=$mysqlic->query($query)or die('Query error..' . $mysqlic->error);
		if (($q->num_rows)>0){	
			while ($qrow=$q->fetch_assoc()){  
				session_start();
				$_SESSION['name'] = $qrow['name'] ;
				$_SESSION['user_id'] = $qrow['user_id'] ;
				$_SESSION['id_num'] = $qrow['id_num'] ;
				$_SESSION['role'] = $role;
				$cookie_name = $qrow['name'];
				$cookie_role = $role;
				$cookie_userid = $userid;
				include ('global.php');
				// setcookie($cookie_name,$cookie_userid,$cookie_role,time() + (86400 * 1), "/");
				if ($role == 1) {
				echo "<meta http-equiv='refresh' content='0.0; url=teacher.php?action=class' />";
				}
				if ($role == 2) {
					echo "<meta http-equiv='refresh' content='0.0; url=student.php?action=group' />";
				}
			}			
		}		
		else{
			$error = "<div class='alert alert-danger'>
	                 	User not found or Wrong Password!
	           			</div>";
		}
	}
	else{
		$error = "<div class='alert alert-danger'>
	                Input field empty!
	           	   </div>";
	}
	return $error;
}

function signup($name,$password,$userid,$role){
	include ('connection.php');
	if ($name !='' AND $password !='' AND $userid !='' AND $role !='') {

		$query="
		        SELECT
		            *
		        FROM
		           users
		        WHERE
		           name = '".$name."' AND id_num = '".$userid."'
		    ";
		    $q=$mysqlic->query($query)or die('Query error..' . $mysqlic->error);

		    if (($q->num_rows)>0){
				$error="<div class='alert alert-danger'>
	                 	User already registered         
	           			</div>";
			}
			else{ 

			 	$query1="
	                INSERT INTO
	                        users
	                            (name,password,id_num,fk_role_id)
	                VALUES
	                        ('$name','$password','$userid','$role')
	            ";
	              	$q1=$mysqlic->query($query1)or die('Query error..' . $mysqlic->error);
	              	$error = "<div class='alert alert-success'>
	                 	Successfully Registered! Click Login       
	           			</div>";
			}
	}
	else{
		$error = "<div class='alert alert-danger'>
	                Input field empty!
	           	   </div>";
	}
	return $error;
}

 function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

function addClass($subject_name,$subject_code,$group_code){
	include ('connection.php');
	include ('global.php');
	if ($subject_name !='' AND $subject_code !='' AND $group_code !='') {
		$query="
		        SELECT
		            *
		        FROM
		           class
		        WHERE
		           subject_name= '".$subject_name."' AND subject_code = '".$subject_code."' AND fk_user_id = '".$gl_user_id."'
	    ";
	    $q=$mysqlic->query($query)or die('Query error..' . $mysqlic->error);
	    if (($q->num_rows)>0){
				$error="<div class='alert alert-danger'>
	                 	Class already registered         
	           			</div>";
			}
		else{
			$query1="
	                INSERT INTO
	                        class
	                            (subject_name,subject_code,group_code,fk_user_id)
	                VALUES
	                        ('$subject_name','$subject_code','$group_code','$gl_user_id')
	            ";
	              	$q1=$mysqlic->query($query1)or die('Query error..' . $mysqlic->error);
	              	$error = "<div class='alert alert-success'>
	                 	Class Successfully Added
	           			</div>";
		}
	}
	else{
		$error = "<div class='alert alert-danger'>
	                Input field empty!
	           	   </div>";
	}
	return $error;
}

function editClass($subject_name,$subject_code,$class_id){
	include ('connection.php');
	if ($subject_name !='' AND $subject_code !='' AND $class_id !='') {
		$query="
		        SELECT
		            *
		        FROM
		           class
		        WHERE
		           subject_name= '".$subject_name."' AND subject_code = '".$subject_code."' AND
		           class_id != '".$class_id."'
	    ";
	    $q=$mysqlic->query($query)or die('Query error..' . $mysqlic->error);
	    if (($q->num_rows)>0){
				$error="<div class='alert alert-danger'>
	                 	Class already registered         
	           			</div>";
			}
		else{
			$query1="
	                UPDATE 
	                    class
	                SET subject_name = '$subject_name',
	                	subject_code = '$subject_code'
	                WHERE 
	                     class_id = '$class_id'
	            ";
	              	$q1=$mysqlic->query($query1)or die('Query error..' . $mysqlic->error);
	              	$error = "<div class='alert alert-success'>
	                 	Class Successfully Edited
	           			</div>";
		}
		
	}
	else{
		$error = "<div class='alert alert-danger'>
	                Input field empty!
	           	   </div>";
	}
	return $error;
}

function delClass($class_id){
	include ('connection.php');
		$query="
          DELETE FROM  
              `class`
          WHERE 
            class_id = '$class_id'
          ";
      	$q=$mysqlic->query($query)or die('Query error..' . $mysqlic->error);

		$error = "<div class='alert alert-success'>
	                Class Successfully Deleted
	           	   </div>";	
	return $error;
}

function delStudent($user_id){
	include ('connection.php');
		$query="
          DELETE FROM  
              `student_quiz`
          WHERE 
            fk_student_id = '$user_id'
          ";
      	$q=$mysqlic->query($query)or die('Query error..' . $mysqlic->error);

		$error = "<div class='alert alert-success'>
	                Class Successfully Deleted
	           	   </div>";	
	return $error;
}

function query_data($table_name){
	include ('connection.php');
	include ('global.php');

	if ($table_name == 'question_type') {
		$query="
	        SELECT
	            *
	        FROM
	           ".$table_name."
	       
	    ";
	    $q=$mysqlic->query($query)or die('Query error..' . $mysqlic->error);
	}
	else{

		$query="
		        SELECT
		            *
		        FROM
		           ".$table_name."
		        WHERE 
	        		fk_user_id = ".$gl_user_id."
		    ";
		    $q=$mysqlic->query($query)or die('Query error..' . $mysqlic->error);
		}

		    echo"<select class='form-control' id='class_name' name='class_name' type='text' required='required'>";
		    while ($qrow=$q->fetch_assoc()){
		    	if ($qrow['class_id']) {
		    		echo "<option value=".$qrow['class_id'].">".$qrow['subject_name']."</option>";
		    	}
		    	if ($qrow['question_type_id']) {
		    		echo "<option value=".$qrow['question_type_id'].">".$qrow['question_type']."</option>";
		    		
		    	}
		    }
		    echo"</select>";


}

function addQuiz($quiz_name,$quiz_number,$quiz_class,$quiz_limit){
	include ('connection.php');
	include ('global.php');
	if ($quiz_name !='' AND $quiz_class !='') {
		$query="
		        SELECT
		            quiz_number
		        FROM
		           quiz
		        WHERE
		           fk_class_id = '".$quiz_class."' AND fk_user_id = '".$gl_user_id."'
		        ORDER by quiz_number DESC
		        LIMIT 1;
	    ";
	    $q=$mysqlic->query($query)or die('Query error..' . $mysqlic->error);
	    if (($q->num_rows)>0){
	    	while ($qrow=$q->fetch_assoc()){ 
	    		$quiz_number = $qrow['quiz_number'];
	    		$quiz_number = $quiz_number + 1;
	    	}
			$query1="
	                INSERT INTO
	                        quiz
	                            (quiz_name,quiz_number,fk_class_id,date_created,fk_user_id,quiz_limit)
	                VALUES
	                        ('$quiz_name','$quiz_number','$quiz_class',NOW(),'$gl_user_id','$quiz_limit')
	            ";
	              	$q1=$mysqlic->query($query1)or die('Query error..' . $mysqlic->error);
	              	$error = "<div class='alert alert-success'>
	                 	Quiz Successfully Added
	           			</div>";
		}
		else{
			$quiz_number = 1;
			$query1="
	                INSERT INTO
	                        quiz
	                            (quiz_name,quiz_number,fk_class_id,date_created,fk_user_id,quiz_limit)
	                VALUES
	                        ('$quiz_name','$quiz_number','$quiz_class',NOW(),'$gl_user_id','$quiz_limit')
	            ";
	              	$q1=$mysqlic->query($query1)or die('Query error..' . $mysqlic->error);
	              	$error = "<div class='alert alert-success'>
	                 	Quiz Successfully Added
	           			</div>";

		}
	}
	else{
		$error = "<div class='alert alert-danger'>
	                Input field empty!
	           	   </div>";
	}
	return $error;
}

function delQuiz($quiz_id){
	include ('connection.php');
		$query="
		        SELECT
		            *
		        FROM
		           question
		        WHERE
		           fk_quiz_id = '".$quiz_id."'

	    ";
	    $q=$mysqlic->query($query)or die('Query error..' . $mysqlic->error);
	    if (($q->num_rows)>0){
				$error="<div class='alert alert-danger'>
	                 	Please remove Question/s Link to this Quiz         
	           			</div>";
			}
		else{
			$query1="
		          DELETE FROM  
		              `quiz`
		          WHERE 
		            quiz_id = '$quiz_id'
		          ";
		      	$q1=$mysqlic->query($query1)or die('Query error..' . $mysqlic->error);

				$error = "<div class='alert alert-success'>
			                Quiz Successfully Deleted
			           	   </div>";	
		}	
	return $error;
}

function addQuestionMulti($question,$choice_a,$choice_b,$choice_c,$answer,$type,$quiz_id,$action,$question_id){
	include ('connection.php');
	if ($question !='' AND $answer !='' AND $type !='' AND $quiz_id !='' ) {
		$answer = strtoupper($answer);

		if ($action != 'Edit') {
			$query="
			        SELECT
			            *
			        FROM
			           question
			        WHERE
			           fk_type_id = '".$type."' AND question = '".$question."' AND answer = '".$answer."' AND fk_quiz_id = '".$quiz_id."'

		    ";
		    $q=$mysqlic->query($query)or die('Query error..' . $mysqlic->error);
		    if (($q->num_rows)>0){
					$error="<div class='alert alert-danger'>
		                 	Question already registered         
		           			</div>";
				}
			else{
				$query1="
		                INSERT INTO
		                        question
		                            (question,fk_type_id,choice_a,choice_b,choice_c,answer,fk_quiz_id)
		                VALUES
		                        ('$question','$type','$choice_a','$choice_b','$choice_c','$answer','$quiz_id')
		            ";
		              	$q1=$mysqlic->query($query1)or die('Query error..' . $mysqlic->error);
		              	$error = "<div class='alert alert-success'>
		                 	Question Successfully Added
		           			</div>";
			}
		}
		else{

				$query="
			        SELECT
			            *
			        FROM
			           question
			        WHERE
			           fk_type_id = '".$type."' AND question = '".$question."' AND answer = '".$answer."' AND fk_quiz_id = '".$quiz_id."'
			           AND question_id != '".$question_id."'
		    ";
		    $q=$mysqlic->query($query)or die('Query error..' . $mysqlic->error);
		    if (($q->num_rows)>0){
					$error="<div class='alert alert-danger'>
		                 	Question already registered         
		           			</div>";
				}
			else{
				$query1="
		                UPDATE 
		                    question
		                SET question = '$question',		                	
		                	choice_a = '$choice_a',
		                	choice_b = '$choice_b',
		                	choice_c = '$choice_c',
		                	answer = '$answer'
		                WHERE 
		                     question_id = '$question_id'
		            ";
		              	$q1=$mysqlic->query($query1)or die('Query error..' . $mysqlic->error);
		              	$error = "<div class='alert alert-success'>
		                 	Question Successfully Edited
		           			</div>";
			}

		}
	}
	else{
		$error = "<div class='alert alert-danger'>
	                Input field empty!
	           	   </div>";
	}
	return $error;
}

function assign_Verse($class_val,$verse_id){
	include ('connection.php');
	if ($class_val !='' AND $verse_id !='') {
		$query="
		        SELECT
		            fk_class_id
		        FROM
		           verse
		        WHERE 
		        	verse_id = '".$verse_id."'
	    ";
	    $q=$mysqlic->query($query)or die('Query error..' . $mysqlic->error);

	    while ($qrow=$q->fetch_assoc()){ 	   
	    	$current_class = $qrow['fk_class_id'];
	    	$class_id = explode('|',$current_class);	  	
	    }
	    if (in_array($class_val, $class_id)){
	    		$error="<div class='alert alert-danger'>
	                 	Verse Already assigned to this Class!       
	           			</div>";
	    	}
	    	else{
	    		$new_class = $current_class."|".$class_val; 

	    		$query1=" UPDATE 
	    					verse
	    				  SET fk_class_id = '$new_class'
	    				  WHERE 
	    				  		verse_id = '$verse_id'
	    		";
	    		$q1=$mysqlic->query($query1)or die('Query error..' . $mysqlic->error);
	    		// $error="<div class='alert alert-success'>
	      //            	Verse was Successfully assigned
	      //      			</div>";
	    		$error = $new_class . '  '. $verse_id;
	    	}
	}
	else{
		$error = "<div class='alert alert-danger'>
	                Input field empty!
	           	   </div>";
	}
	return $error;
}


function addGroup($group_code){
	include ('connection.php');
	include ('global.php');
	if ($group_code !='') {
		$query="
		        SELECT
		            *
		        FROM
		           class
		        WHERE
		           group_code= '".$group_code."'
	    ";
	    $q=$mysqlic->query($query)or die('Query error..' . $mysqlic->error);
	    if (($q->num_rows)>0){
	    	while ($qrow=$q->fetch_assoc()){ 
	    		$class_id = $qrow['class_id'];

				$query1="
				        SELECT
				            *
				        FROM
				           student_quiz
				        WHERE
				           fk_class_id= '".$class_id."' AND fk_student_id = $gl_user_id
			    ";
			    $q1=$mysqlic->query($query1)or die('Query error..' . $mysqlic->error);
			     if (($q1->num_rows)>0){
			     	$error = "<div class='alert alert-danger'>
		                Group Code already used
		           	   </div>";
			     }
			     else{
			     	$query2="
	                INSERT INTO
	                        student_quiz
	                            (fk_student_id,fk_class_id)
	                VALUES
	                        ('$gl_user_id','$class_id')
	            ";
	              	$q2=$mysqlic->query($query2)or die('Query error..' . $mysqlic->error);
	              	$error = "<div class='alert alert-success'>
	                 	Successfully Added to a Group
	           			</div>";
			     }
			}
			}
		else{
			$error = "<div class='alert alert-danger'>
	                Group Code not Found!
	           	   </div>";
		}
	}
	else{
		$error = "<div class='alert alert-danger'>
	                Input field empty!
	           	   </div>";
	}
	return $error;
}

function take_quiz($class_id,$quiz_number){
	include ('connection.php');
	include ('global.php');
	$query="
	        SELECT
	            *
	        FROM
	           student_quiz
	        WHERE
	           fk_class_id= '".$class_id."' AND fk_student_id = '".$gl_user_id."'
    ";
    $q=$mysqlic->query($query)or die('Query error..' . $mysqlic->error);
    if (($q->num_rows)>0){
	    	while ($qrow=$q->fetch_assoc()){ 
	    		$quiz_results = '';
                $quiz_result = explode('|',$qrow['result']);
                $arraycount = count($quiz_result);
	    		$student_quiz_id = $qrow['student_quiz_id'];
	    		if ($quiz_number >= $arraycount ) {

	    			$query1="
					        SELECT
					            *
					        FROM
					           quiz
					        WHERE
					           fk_class_id= '".$class_id."' AND quiz_number = '".$quiz_number."'

				    ";
				    $q1=$mysqlic->query($query1)or die('Query error..' . $mysqlic->error);
				
				    if (($q1->num_rows)>0){				    
				    	while ($qrow1=$q1->fetch_assoc()){
				    		if ($qrow1['quiz_status'] == 0) {				    	
						    	$quiz_id = $qrow1['quiz_id'];
						    	echo "<meta http-equiv='refresh' content='0.0; url=student.php?action=student_quiz&id=".$quiz_id."&quiz_id=".$student_quiz_id."&quiz_number=".$quiz_number."' />";
						    }
						    else{
						    	$error = "<div class='alert alert-danger alert-dismissable'>
				    				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
				                	Quiz was Locked
				           	   		</div>";
						    }
				    	}	
				   	}
				   	else{
	    	
	    			$error = "<div class='alert alert-danger alert-dismissable'>
	    				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
	                	Quiz Not Found!
	           	   		</div>";
	           	   	}
	           	}

	           	else{
	           		$error = "<div class='alert alert-danger alert-dismissable'>
	    				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
	                	Quiz Already Taken
	           	   		</div>";
	           	}
	           	
	    		

	    	}
	}
	else{
		$error = "<div class='alert alert-danger alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
	                Quiz Unavailable!
	           	   </div>";
	}
	return $error;
}

function view_verse($class_id){
	include ('connection.php');
	include ('global.php');
	$query1="
	        SELECT
	            *
	        FROM
	           class
	        WHERE
	           class_id = '".$class_id."'

    ";
    $q1=$mysqlic->query($query1)or die('Query error..' . $mysqlic->error);
    while ($qrow1=$q1->fetch_assoc()){

        $verse_location = explode('|',$qrow1['verse_location']);
        $verse_name = explode('|', $qrow1['verse_name']);
        $arraycount = count($verse_location);
     	$arraycount = $arraycount - 1;
     	for ($i=0; $i < $arraycount ; $i++) { 
        	echo "<center><a href=".$verse_location[$i]."><button type='button' class='btn btn-primary btn-m'>".$verse_name[$i]."</button><br><br></center>";
    	}
    }

}

function quiz_status($quiz_id,$quiz_status){
	include ('connection.php');
	include ('global.php');
	if ($quiz_status == 0) {
		$quiz_status = 1;
	}
	else{
		$quiz_status = 0;
	}
	$query1=" UPDATE 
				quiz
			  SET quiz_status = '$quiz_status'
			  WHERE 
			  		quiz_id = '$quiz_id'
	";
	$q1=$mysqlic->query($query1)or die('Query error..' . $mysqlic->error);
	echo "<meta http-equiv='refresh' content='0.0; url=teacher.php?action=quiz' />";

}

function select_quiz_number($class_id){
	include ('connection.php');
	include ('global.php');
	$query1="
	        SELECT
	            *
	        FROM
	           quiz
	        WHERE
	           fk_class_id = '".$class_id."'
	        ORDER BY quiz_number ASC
    ";
    $q1=$mysqlic->query($query1)or die('Query error..' . $mysqlic->error);
    if (($q1->num_rows)>0){
     echo"<select class='form-control' id='select_quiz_number' name='select_quiz_number' type='text' required='required'>";
	    while ($qrow1=$q1->fetch_assoc()){	    	
	    	echo "<option value=".$qrow1['quiz_number'].">".$qrow1['quiz_number']."</option>";
	    }
	    echo"</select>";
	}
	else{
		echo "No Quiz Found!";
	}
}

function edit_profile($name,$current_pass,$new_pass,$confirm_pass){
	include ('connection.php');
	include ('global.php');
	if ($name !='') {
		if ($current_pass!='' AND $new_pass !='' AND $confirm_pass !='') {
			if ($new_pass == $confirm_pass) {
				$current_pass = md5($current_pass);
				$query1="
				        SELECT
				            *
				        FROM
				           users
				        WHERE
				           id_num = '".$gl_id_num."'
			    ";
			    $q1=$mysqlic->query($query1)or die('Query error..' . $mysqlic->error);
			     while ($qrow1=$q1->fetch_assoc()){	
			     	if ($current_pass == $qrow1['password']) {
			     		$new_pass = md5($new_pass);

			     		$query2=" UPDATE 
										users
								  SET name = '$name',
								  	  password = '$new_pass'
								  WHERE 
								  	  id_num= '$gl_id_num'
							";
							$q2=$mysqlic->query($query2)or die('Query error..' . $mysqlic->error);
							session_start();
							$_SESSION['name'] = $name;
							include ('global.php');
							$error = "<div class='alert alert-success alert-dismissable'>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
			                Profile Edited Successfully
			           	   </div>";
			     	}
			     	else{
			     		$error = "<div class='alert alert-danger alert-dismissable'>
						<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
		                Current Password Doesn't Match!
		           	   </div>";
			     	}

			     }

			}
			else{
				$error = "<div class='alert alert-danger alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
	                New Password and Confirm Password Doesn't match!
	           	   </div>";
			}

		}
		else{
			$query2=" 
					UPDATE 
						users
				  	SET name = '$name'				  	  
				  	WHERE 
				  	  id_num= '$gl_id_num'
			";
			$q2=$mysqlic->query($query2)or die('Query error..' . $mysqlic->error);
				session_start();
				$_SESSION['name'] = $name;
				include ('global.php');
				$error = "<div class='alert alert-success alert-dismissable'>
						<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
		                Profile Edited Successfully
			           	   </div>";
		}
	}
	else{

		$error = "<div class='alert alert-danger alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
	                Name Should Not Empty!
	           	   </div>";

	}
	return $error;
}

?>