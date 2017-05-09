// Javascript

// Login
function showLogin(role) {
	document.getElementById('studentsignup_error').innerHTML = '';
	document.getElementById('teachersignup_error').innerHTML = '';
	$('#signup' + role).modal('hide');    
	$('#login' + role).modal('show'); 		
}

function process_login(sign){
 	var id_num = document.getElementById(sign+'id_num').value; 
 	var password = document.getElementById(sign +'password').value; 
 	var role = document.getElementById(sign +'role').value; 

 	var pattern = /[^0-9]/g;
 	if (!id_num.match(pattern)) {
 		var xmlhttp = new XMLHttpRequest();
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {             

	                 // document.getElementById('temp_value_sam').value = this.responseText;
	  				if (this.responseText == 1) {
	  					window.location = 'faculty.php';
	  				}		
	                document.getElementById(sign +'error').innerHTML = this.responseText;	               
	                              
	            }	            
	        };
	        xmlhttp.open("GET", "process_ajax.php?q=login&id_num="+id_num+"&password="+password+"&role="+role, true);
	        xmlhttp.send();   		
 	}
 	else{
 		document.getElementById(sign +'error').innerHTML = "<div class='alert alert-danger'>Please input Interger Only </div>";
 	}

}

// Signup
function showSignup(role) {   
   	document.getElementById('teacherlogin_error').innerHTML = '';
	document.getElementById('studentlogin_error').innerHTML = '';
	$('#login' + role).modal('hide'); 
	$('#signup' + role).modal('show');    
}
function process_signup(sign){
 	var name = document.getElementById(sign+'name').value; 
 	var password1 = document.getElementById(sign +'password1').value; 
 	var password2 = document.getElementById(sign +'password2').value; 
 	var id_num = document.getElementById(sign +'id_num').value; 
 	var role = document.getElementById(sign +'role').value;     	 	
 	var pattern = /[^0-9]/g;
    if (!id_num.match(pattern)) {
	  	var xmlhttp = new XMLHttpRequest();
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {             

	                 // document.getElementById('temp_value_sam').value = this.responseText;
	                clear_input(sign); 				
	                document.getElementById(sign +'error').innerHTML = this.responseText;	               
	                              
	            }	            
	        };
	        xmlhttp.open("GET", "process_ajax.php?q=signup&name="+name+"&password1="+password1+"&password2="+password2+"&id_num="+id_num+"&role="+role, true);
	        xmlhttp.send();  
	}
	else{
		clear_input(sign);
		document.getElementById(sign +'error').innerHTML = "<div class='alert alert-danger'>Please input Interger Only </div>";

	}
}
function clear_input(sign){
	document.getElementById(sign+'name').value = ''; 
    document.getElementById(sign +'password1').value =''; 
	document.getElementById(sign +'password2').value = ''; 
	document.getElementById(sign +'id_num').value = '';   
}

// Add Class

function addClass(class_val){	
	document.getElementById('addClass_error').innerHTML = '';
	var subject_name = document.getElementById('class_subject').value;
	var subject_code = document.getElementById('class_subject_code').value;
	var pattern = /[^0-9]/g;
	if (!subject_code.match(pattern)) {
		var xmlhttp = new XMLHttpRequest();
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {             

	                 document.getElementById('class_subject').value = '';
	                 document.getElementById('class_subject_code').value = '';
	                 document.getElementById('close_button').innerHTML = "<a href='teacher.php?action=class'><button type='button' class='btn btn-lg btn-success btn-block' >Close</button></a>";
	                 document.getElementById(class_val+'error').innerHTML = this.responseText;	               
	                
	            }	            
	        };
	        xmlhttp.open("GET", "process_ajax.php?q=add_class&subject_name="+subject_name+"&subject_code="+subject_code, true);
	        xmlhttp.send();  
	}
	else{
		document.getElementById(class_val +'error').innerHTML = "<div class='alert alert-danger'>Please input Interger Only </div>";

	}
}	

function updateclass(){

}

function modify_class(class_val){
	document.getElementById('edit_class_subject').value = document.getElementById('subject_name'+class_val).value;
	document.getElementById('edit_class_subject_code').value = document.getElementById('subject_code'+class_val).value;
	document.getElementById('edit_class_counter').value = class_val;
	$('#editClass').modal('show');	
}
function edit_class(class_val){
	var subject_name = document.getElementById('edit_class_subject').value;
	var subject_code = document.getElementById('edit_class_subject_code').value;
	var counter = document.getElementById('edit_class_counter').value;
	var class_id = document.getElementById('class_id'+counter).value;
	var pattern = /[^0-9]/g;
	if (!subject_code.match(pattern)) {
		var xmlhttp = new XMLHttpRequest();
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {             

	                 document.getElementById('edit_class_subject').value = '';
	                 document.getElementById('edit_class_subject_code').value = '';
	                 document.getElementById('close_button_edit').innerHTML = "<a href='teacher.php?action=class'><button type='button' class='btn btn-lg btn-success btn-block' >Close</button></a>";
	                 document.getElementById(class_val+'error').innerHTML = this.responseText;	               
	                
	            }	            
	        };
	        xmlhttp.open("GET", "process_ajax.php?q=edit_class&subject_name="+subject_name+"&subject_code="+subject_code+"&class_id="+class_id, true);
	        xmlhttp.send();  
	}
	else{
		document.getElementById(class_val +'error').innerHTML = "<div class='alert alert-danger'>Please input Interger Only </div>";
	 }
	
}
function del_class(class_val){
	var counter = document.getElementById('edit_class_counter').value;
	var class_id = document.getElementById('class_id'+counter).value;

	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {             

            document.getElementById('edit_class_subject').value = '';
            document.getElementById('edit_class_subject_code').value = '';
	        document.getElementById('close_button_edit').innerHTML = "<a href='teacher.php?action=class'><button type='button' class='btn btn-lg btn-success btn-block' >Close</button></a>";
			document.getElementById(class_val+'error').innerHTML = this.responseText;	               
            
        }	            
    };
    xmlhttp.open("GET", "process_ajax.php?q=del_class&class_id="+class_id, true);
    xmlhttp.send();  
}

function student_class(class_val){
	// document.getElementById('edit_class_subject').value = document.getElementById('subject_name'+class_val).value;
	// document.getElementById('edit_class_subject_code').value = document.getElementById('subject_code'+class_val).value;
	// document.getElementById('edit_class_counter').value = class_val;
	$('#studentClass').modal('show');	
}

function remove_student(student_val,class_val,counter){
	document.getElementById('delStudent_class').value = class_val; 
	document.getElementById('delStudent_id').value = student_val;
	document.getElementById('delStudent_name').innerHTML = document.getElementById('student_name'+counter).value;
}
function del_student(error){

	class_val = document.getElementById('delStudent_class').value ;
	student_val = document.getElementById('delStudent_id').value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {             
        	window.location = 'teacher.php?action=student&id='+class_val;            
        }	            
    };
    xmlhttp.open("GET", "process_ajax.php?q=remove_student&user_id="+student_val, true);
    xmlhttp.send();  
}

function addQuiz(class_val){	
	document.getElementById('addQuiz_error').innerHTML = '';
	var quiz_name = document.getElementById('quiz_name').value;
	var quiz_number = document.getElementById('quiz_number').value;
	var quiz_class = document.getElementById('class_name').value;	
	var quiz_limit = document.getElementById('quiz_limit').value;	
	var pattern = /(^[0-5][0-9]:[0-5][0-9]$)/;

	if (quiz_limit.match(pattern)) {
		var xmlhttp = new XMLHttpRequest();
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {             

	                document.getElementById('quiz_name').value = '';
	                document.getElementById('class_name').value = '';                 
		            document.getElementById('close_button').innerHTML = "<a href='teacher.php?action=quiz'><button type='button' class='btn btn-lg btn-success btn-block' >Close</button></a>";
	                document.getElementById(class_val+'error').innerHTML = this.responseText;	               
	                
	            }	            
	        };
	        xmlhttp.open("GET", "process_ajax.php?q=add_quiz&quiz_name="+quiz_name+"&quiz_number="+quiz_number+"&quiz_class="+quiz_class+"&quiz_limit="+quiz_limit, true);
	        xmlhttp.send();  
	}
	else{
		document.getElementById(class_val+'error').innerHTML = "<div class='alert alert-danger'>Please Follow Pattern | mm:ss </div>";
	}

}	

function query_data(table_name){
	
	document.getElementById('addQuestionmulti_errors').innerHTML = '';
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {             
             document.getElementById('display_class').innerHTML = this.responseText;	               
        }	            
    };
    xmlhttp.open("GET", "process_ajax.php?q=query_data&table_name="+table_name, true);
    xmlhttp.send();  
}

function modify_quiz(counter){
	document.getElementById('delquiz').value = document.getElementById('quiz_id' + counter).value; 
	document.getElementById('delquiz_name').innerHTML = document.getElementById('quiz_name'+counter).value;
}
function del_quiz(){
	// if (document.getElementById('del_quiz_button').innerHTML = 'Close') {
	// 	window.location = 'teacher.php?action=quiz';
	// }
	quiz_id = document.getElementById('delquiz').value;	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {      

        	document.getElementById('delquiz_name').innerHTML = '';
        	document.getElementById('del_quiz_button').innerHTML = 'Close';
        	document.getElementById('delQuiz_error').innerHTML = this.responseText;
        	setTimeout(redirect(),9000);
        	function redirect(){
        		window.location = 'teacher.php?action=quiz';
        	}
        }	            
    };
    xmlhttp.open("GET", "process_ajax.php?q=remove_quiz&quiz_id="+quiz_id, true);
    xmlhttp.send();  
}

function selectType(){
	document.getElementById('question_multi').value ='';
	document.getElementById('question_fill').value ='';
	document.getElementById('question_true').value ='';
	document.getElementById('choice_a_multi').value = '';
	document.getElementById('choice_b_multi').value = '';
	document.getElementById('choice_c_multi').value = '';
	document.getElementById('answer_multi').value = '';
	document.getElementById('answer_fill').value = '';
	document.getElementById('answer_true').value = '';
	document.getElementById('addQuestionfill_error').value = '';
	document.getElementById('addQuestionmulti_error').value = '';
	document.getElementById('addQuestiontrue_error').value = '';

	var selectType = document.getElementById('class_name').value;
	if (selectType == '1') {
		$('#SelectType').modal('hide');
		$('#addQuestionMulti').modal('show');
	}
	if (selectType == '2') {
		$('#SelectType').modal('hide');
		$('#addQuestionFill').modal('show');
	}
	if (selectType == '3') {
		$('#SelectType').modal('hide');
		$('#addQuestionTrueOrFalse').modal('show');
	}
}

function add_question(question_val,types){	
	document.getElementById(question_val+types+'_error').innerHTML = '';
	var question = document.getElementById('question_'+types).value;
	var action = document.getElementById('current_action').value;
	var answer   = document.getElementById('answer_'+types).value;
	if (document.getElementById('current_action').value=='Edit') {
		var type = document.getElementById('current_type_id').value;
	}
	else{
		var type    = document.getElementById('class_name').value;
	}
	var quiz_id    = document.getElementById('quiz_id_value').value;
	var question_id = document.getElementById('current_question_id').value;
	var pattern = /^(A|B|C)$/i;
	var patternTrue = /^(True|False)$/i;

	if (types == 'multi') {
		var choice_a = document.getElementById('choice_a_multi').value;
		var choice_b = document.getElementById('choice_b_multi').value;
		var choice_c = document.getElementById('choice_c_multi').value;
		if (answer.match(pattern)) {
			if (choice_a !='' && choice_b !='' && choice_c !='') {
				var xmlhttp = new XMLHttpRequest();
		        xmlhttp.onreadystatechange = function() {
		            if (this.readyState == 4 && this.status == 200) {             

		                 document.getElementById('question_multi').value ='';
		                 document.getElementById('choice_a_multi').value = '';
		                 document.getElementById('choice_b_multi').value = '';
		                 document.getElementById('choice_c_multi').value = '';
		                 document.getElementById('answer_multi').value = '';
	                 	 // document.getElementById('button_multi').innerHTML = "<a href="+ window.location.href +"><button type='button' class='btn btn-lg btn-success btn-block' >Close</button></a>";
	                 	 $('#addQuestionMulti').modal('hide'); 
	                 	 $('#SelectType').modal('show'); 
		                 document.getElementById('addQuestionmulti_errors').innerHTML = this.responseText;	               
		                
		            }	            
		        };
		        xmlhttp.open("GET", "process_ajax.php?q=add_question_multi&question="+question+"&choice_a="+choice_a+"&choice_b="+choice_b+"&choice_c="+choice_c+"&answer="+answer+"&type="+type+"&quiz_id="+quiz_id+"&action="+action+"&question_id="+question_id, true);
		        xmlhttp.send(); 
			}
			else{
				document.getElementById(question_val+types+'_error').innerHTML = "<div class='alert alert-danger'>Input Field Empty!</div>";
			}
		}
		else{
			document.getElementById(question_val+types+'_error').innerHTML = "<div class='alert alert-danger'>Please input A B or C </div>";
		 }
	}

	if (types == 'fill') {
		
		var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {             

                 document.getElementById('question_'+types).value ='';		              
                 document.getElementById('answer_fill').value = '';
	             // document.getElementById('button_fill').innerHTML = "<a href="+ window.location.href +"><button type='button' class='btn btn-lg btn-success btn-block' >Close</button></a>";
                 $('#addQuestionFill').modal('hide'); 
             	 $('#SelectType').modal('show'); 
                 document.getElementById('addQuestionmulti_errors').innerHTML = this.responseText;	               
                
            }	            
        };
        xmlhttp.open("GET", "process_ajax.php?q=add_question_multi&question="+question+"&answer="+answer+"&type="+type+"&quiz_id="+quiz_id+"&action="+action+"&question_id="+question_id, true);
        xmlhttp.send();  		
	}

	if (types == 'true') {
		if (answer.match(patternTrue)) {
			var xmlhttp = new XMLHttpRequest();
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {             

	                 document.getElementById('question_'+types).value ='';		              
	                 document.getElementById('answer_true').value = '';
                 	 // document.getElementById('button_true').innerHTML = "<a href="+ window.location.href +"><button type='button' class='btn btn-lg btn-success btn-block' >Close</button></a>";
                 	 $('#addQuestionTrueOrFalse').modal('hide'); 
             	 	 $('#SelectType').modal('show'); 
	                 document.getElementById('addQuestionmulti_errors').innerHTML = this.responseText;	               
	                
	            }	            
	        };
	        xmlhttp.open("GET", "process_ajax.php?q=add_question_multi&question="+question+"&answer="+answer+"&type="+type+"&quiz_id="+quiz_id+"&action="+action+"&question_id="+question_id, true);
	        xmlhttp.send();  
	    }
	    else{
			document.getElementById(question_val+types+'_error').innerHTML = "<div class='alert alert-danger'>Please input True or False</div>";
	    }
		
	}
}

function modify_question(counter){
	document.getElementById('current_counter').value = counter;
	document.getElementById('current_question_id').value = document.getElementById('question_id'+counter).value;
	document.getElementById('current_type_id').value = document.getElementById('question_type_id'+counter).value;
	document.getElementById('current_action').value = 'Edit';
	// Multi
	if (document.getElementById('question_type_id'+counter).value == 1) {
		document.getElementById('question_multi').value = document.getElementById('question'+counter).value;
		document.getElementById('choice_a_multi').value = document.getElementById('choice_a'+counter).value;
		document.getElementById('choice_b_multi').value = document.getElementById('choice_b'+counter).value;
		document.getElementById('choice_c_multi').value = document.getElementById('choice_c'+counter).value;
		document.getElementById('answer_multi').value = document.getElementById('answer'+counter).value;
		$('#addQuestionMulti').modal('show');
	}
	if (document.getElementById('question_type_id'+counter).value == 2) {
		document.getElementById('question_fill').value = document.getElementById('question'+counter).value;
		document.getElementById('answer_fill').value = document.getElementById('answer'+counter).value;
		$('#addQuestionFill').modal('show');
	}
	if (document.getElementById('question_type_id'+counter).value == 3) {
		document.getElementById('question_true').value = document.getElementById('question'+counter).value;
		document.getElementById('answer_true').value = document.getElementById('answer'+counter).value;


		$('#addQuestionTrueOrFalse').modal('show');
	}

}

function assign_verse(counter){
	document.getElementById('current_counter').value = counter;
	document.getElementById('current_class_id').value = document.getElementById('class_id'+counter).value;

	// query_data('class');
}

function assinged_verse(value){

	document.getElementById('assignVerse_error').innerHTML = '';
	var class_val = document.getElementById('class_name').value;
	var current_counter = document.getElementById('current_counter').value;
	var verse_id = document.getElementById('verse_id'+ current_counter).value;
	var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {             
            
                 document.getElementById(value+'error').innerHTML = this.responseText;	               
                
            }	            
        };
        xmlhttp.open("GET", "process_ajax.php?q=assign_verse&class_val="+class_val+"&verse_id="+verse_id, true);
        xmlhttp.send();  
}
function addGroup(group_val){	
	document.getElementById('addGroup_error').innerHTML = '';
	var group_code = document.getElementById('group_code').value;
	var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {             

                document.getElementById('group_code').value = '';
                document.getElementById('button_add_group').innerHTML = "<a href="+ window.location.href +"><button type='button' class='btn btn-lg btn-success btn-block' >Close</button></a>";
				document.getElementById(group_val+'error').innerHTML = this.responseText;	               
                
            }	            
        };
        xmlhttp.open("GET", "process_ajax.php?q=add_group&group_code=" + group_code, true);
        xmlhttp.send();  

}	
function select_quiz_number(counter,quiz_number){
	document.getElementById('current_counter').value = counter;
	document.getElementById('current_quiz_number').value = quiz_number;
	document.getElementById('selectQuiz_number_error').innerHTML = '';
	var class_id = document.getElementById('class_id'+counter).value;


	var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {             
                 document.getElementById('display_class').innerHTML = this.responseText;	               
            }	            
        };
        xmlhttp.open("GET", "process_ajax.php?q=select_quiz_number&class_id=" + class_id, true);
        xmlhttp.send();  

}

function take_quiz(val){
	var counter = document.getElementById('current_counter').value;
	var quiz_number = document.getElementById('select_quiz_number').value;
	var class_id = document.getElementById('class_id'+counter).value;

	var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {             
                 document.getElementById(val+'error').innerHTML = this.responseText;	               
            }	            
        };
        xmlhttp.open("GET", "process_ajax.php?q=take_quiz&class_id=" + class_id + "&quiz_number=" + quiz_number, true);
        xmlhttp.send();  
}

function view_verse(counter){
	var class_id = document.getElementById('class_id'+counter).value;
	var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {             
                 document.getElementById('result_verse').innerHTML = this.responseText;	               
            }	            
        };
        xmlhttp.open("GET", "process_ajax.php?q=view_verse&class_id=" + class_id, true);
        xmlhttp.send();  
}

function quiz_status(counter,quiz_id,quiz_status){
	var xmlhttp = new XMLHttpRequest();
   	xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {             
             document.getElementById('alert_message').innerHTML = this.responseText;	                             
        }	            
    };
    xmlhttp.open("GET", "process_ajax.php?q=quiz_status&quiz_id=" + quiz_id + "&quiz_status="+quiz_status, true);
    xmlhttp.send();  
}

function edit_profile(val){
	var name = document.getElementById('full_name').value;
	var current_pass = document.getElementById('current_password').value;
	var new_pass = document.getElementById('new_password').value;
	var confirm_pass = document.getElementById('confirm_password').value;

	var xmlhttp = new XMLHttpRequest();
   	xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) { 
        document.getElementById('button_edit_profile').innerHTML = "<a href="+ window.location.href +"><button type='button' class='btn btn-lg btn-success btn-block' >Close</button></a>";                                     
            document.getElementById(val+'error').innerHTML = this.responseText;	    

        }	            
    };
    xmlhttp.open("GET","process_ajax.php?q=edit_profile&name="+ name +"&current_pass="+current_pass+"&new_pass="+new_pass+"&confirm_pass="+confirm_pass,true);
    xmlhttp.send();  
}

function timer(){
		var student_quiz_id = document.getElementById('student_quiz_id').value;
		var quiz_id = document.getElementById('quiz_id').value;
      	var time_limit = document.getElementById('quiz_limit').value;
 		var time_limit = time_limit.split(":");
 		var quiz_number = document.getElementById('quiz_number').value;

      	if (localStorage.getItem('student_quiz_id') == student_quiz_id & localStorage.getItem('quiz_id') == quiz_id & localStorage.getItem('quiz_number') == quiz_number ){
      		minute = localStorage.getItem('minute');
       		second = localStorage.getItem('second');

      		if (minute < 0 ) {
      			minute = time_limit[0];
       			second = time_limit[1];
       		}
       		
      	}
      	else{
      		var minute = time_limit[0];
      		var second = time_limit[1];
      	}


    	localStorage.setItem('student_quiz_id',student_quiz_id);
    	localStorage.setItem('quiz_id',quiz_id);
    	localStorage.setItem('quiz_number',quiz_number);


	    var x = setInterval(function() {

	      second = second - 1;
	      if (second <= 0) {
	      	if (minute > 0) {
		        minute = minute - 1;
		        second = 59;
		    }
	      }

	      localStorage.setItem('second',second);
	      localStorage.setItem('minute',minute);
	      

	      if (minute == 0 & second == 0) {
	        document.getElementById('demo').innerHTML = minute+':'+second;
	        document.getElementById('smalltext').innerHTML = 'Time Expired';
	        localStorage.setItem('second','');
	        localStorage.setItem('minute','');
	        localStorage.setItem('student_quiz_id','');
	        localStorage.setItem('quiz_id','');
	        localStorage.setItem('quiz_number','');

	        document.getElementById('submit-button').click();
	       	document.getElementById('result').innerHTML = '';
	       	return;
	      }
	      document.getElementById('demo').innerHTML = minute+':'+second;

	    }, 1000);
}