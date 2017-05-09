<?php
include('connection.php');
include('functions.php');

if ($_REQUEST["q"] == 'signup') {
	if ($_REQUEST['name'] !='' AND $_REQUEST ['id_num'] !='' AND $_REQUEST['password1'] !='' AND $_REQUEST['password2'] !='' AND $_REQUEST['role'] !='') {
		if ($_REQUEST["password1"] != $_REQUEST["password2"]) {
			$error = "<div class='alert alert-danger'>
	                 	Mismatch Password   
	           			</div>";
		}

		$name = test_input($_REQUEST['name']);			
		$id_num = test_input($_REQUEST['id_num']);			
		$password = test_input(md5($_REQUEST['password1']));
		$role = test_input($_REQUEST['role']);	

		if (is_integer($id_num)) {
			$error = "<div class='alert alert-danger'>
	                 	Please input Interger Only  
	           			</div>".$id_num;
		}

		if ($error =='') {
			$error =  signup($name,$password,$id_num,$role);
		}
		echo $error;
	}
}

if ($_REQUEST["q"] == 'login') {
	if ($_REQUEST['id_num'] !='' AND $_REQUEST['password'] !='') {
		$id_num = test_input($_REQUEST['id_num']);
		$password = test_input(md5($_REQUEST['password']));
		$role = test_input($_REQUEST['role']);
		$error = login($id_num,$password,$role);
	}
	else{
		$error = "<div class='alert alert-danger'>
	                Input field empty!
	           	   </div>";
	}
	echo $error;
}

if ($_REQUEST["q"] == 'add_class') {
	if ($_REQUEST['subject_name'] !='' AND $_REQUEST['subject_code'] !='') {
		$subject_name = strtoupper($_REQUEST['subject_name']);
		$group_code = substr(($subject_name),0,3).''.rand(0,9999);
		$subject_code = $_REQUEST['subject_code'];
		$error = addClass($subject_name,$subject_code,$group_code);

	}
	else{
		$error = "<div class='alert alert-danger'>
	                Input field empty!
	           	   </div>";
	}
	echo $error;
}

if ($_REQUEST["q"] == 'edit_class') {
	if ($_REQUEST['subject_name'] !='' AND $_REQUEST['subject_code'] !='') {
		$subject_name = strtoupper($_REQUEST['subject_name']);		
		$subject_code = $_REQUEST['subject_code'];
		$class_id = $_REQUEST['class_id'];
		$error = editClass($subject_name,$subject_code,$class_id);

	}
	else{
		$error = "<div class='alert alert-danger'>
	                Input field empty!
	           	   </div>";
	}
	echo $error;

}

if ($_REQUEST["q"] == 'del_class') {
	
	$class_id = $_REQUEST['class_id'];
	$error = delClass($class_id);
	echo $error;

}

if ($_REQUEST["q"] == 'remove_student') {
	
	$user_id = $_REQUEST['user_id'];
	$error = delStudent($user_id);
	echo $error;
}

if ($_REQUEST["q"] == 'query_data') {
	
	$table_name= $_REQUEST['table_name'];
	$error = query_data($table_name);
	echo $error;
}

if ($_REQUEST["q"] == 'add_quiz') {
	if ($_REQUEST['quiz_name'] !='' AND $_REQUEST['quiz_class'] !='') {
		$quiz_name = $_REQUEST['quiz_name'];		
		$quiz_class = $_REQUEST['quiz_class'];
		$quiz_number = $_REQUEST['quiz_number'];
		$quiz_limit = $_REQUEST['quiz_limit'];

		$error = addQuiz($quiz_name,$quiz_number,$quiz_class,$quiz_limit);
	}
	else{
		$error = "<div class='alert alert-danger'>
	                Input field empty!
	           	   </div>";
	}
	echo $error;
}

if ($_REQUEST["q"] == 'remove_quiz') {
	
	$quiz_id = $_REQUEST['quiz_id'];
	$error = delQuiz($quiz_id);
	echo $error;
}

if ($_REQUEST["q"] == 'add_question_multi') {
	if ($_REQUEST['question'] !='' AND $_REQUEST['answer'] !='') {
		$question = $_REQUEST['question'];
		$choice_a = $_REQUEST['choice_a'];
		$choice_b = $_REQUEST['choice_b'];
		$choice_c = $_REQUEST['choice_c'];
		$answer = $_REQUEST['answer'];
		$type = $_REQUEST['type'];
		$quiz_id = $_REQUEST['quiz_id'];
		$action = $_REQUEST['action'];
		$question_id = $_REQUEST['question_id'];
		$error = addQuestionMulti($question,$choice_a,$choice_b,$choice_c,$answer,$type,$quiz_id,$action,$question_id);
	}
	else{
		$error = "<div class='alert alert-danger'>
	                Input field empty!
	           	   </div>";
	}
	echo $error;
}

if ($_REQUEST['q'] == 'assign_verse') {
	$class_val = $_REQUEST['class_val'];
	$verse_id = $_REQUEST['verse_id'];
	$error = assign_Verse($class_val,$verse_id);
	echo $error;
}

if ($_REQUEST["q"] == 'add_group') {
	if ($_REQUEST['group_code'] !='') {
		$group_code = $_REQUEST['group_code'];
		$error = addGroup($group_code);
	}
	else{
		$error = "<div class='alert alert-danger'>
	                Input field empty!
	           	   </div>";
	}
	echo $error;
}

if ($_REQUEST['q'] == 'take_quiz') {
	$class_id = $_REQUEST['class_id'];
	$quiz_number = $_REQUEST['quiz_number'];
	$error = take_quiz($class_id,$quiz_number);
	echo $error;
}

if ($_REQUEST['q'] == 'view_verse') {
	$class_id = $_REQUEST['class_id'];
	$error = view_verse($class_id);
	echo $error;
}

if ($_REQUEST['q'] == 'quiz_status') {
	$quiz_id = $_REQUEST['quiz_id'];
	$quiz_status = $_REQUEST['quiz_status'];
	$error = quiz_status($quiz_id,$quiz_status);
	echo $error;
}

if ($_REQUEST['q'] == 'select_quiz_number') {
	$class_id = $_REQUEST['class_id'];
	$error = select_quiz_number($class_id);
	echo $error;
}

if ($_REQUEST['q'] == 'edit_profile') {
	$name = $_REQUEST['name'];
	$current_pass = $_REQUEST['current_pass'];
	$new_pass = $_REQUEST['new_pass'];
	$confirm_pass = $_REQUEST['confirm_pass'];
	$error = edit_profile($name,$current_pass,$new_pass,$confirm_pass);
	echo $error;
}
?>
