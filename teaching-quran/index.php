<?php
include ('header.php');
if ($gl_role == 1) {
	echo "<meta http-equiv='refresh' content='0.0; url=teacher.php?action=class' />"; //redirector
}
if ($gl_role == 2) {
	echo "<meta http-equiv='refresh' content='0.0; url=student.php?action=group' />"; //redirector
}
?>

<body class="body-Login-back">
    <div class="container">
       	<div class="row">
       		<div class="col-md-4 col-md-offset-4 text-center logo-margin ">
              <img src="assets/img/logo.png" alt=""/>
                </div>
            <div class="col-md-4 col-md-offset-4">
                 <!--  Modals-->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Select Role
                    </div>
                    <div class="panel-body">
                    	<div style="">
                    		<center>
		                        <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#logTeacher">
		                            I'm a Teacher
		                        </button> 
		                        <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#logStudent">
		                            I'm a Student
		                        </button>
	                        </center>
	                    </div>

	                    <!-- for Teacher Login -->
                        <div class="modal fade" id="logTeacher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">                                    
                                    <div class="col-md-7 col-md-offset-4">
						                <div class="login-panel panel panel-default">                  
						                    <div class="panel-heading">
						                        <h3 class="panel-title">Please Sign In</h3>
						                    </div>
						                    <div class="panel-body">
						                        <form role="form">
						                            <fieldset>
						                            	<div class="form-group" >
						                                	<p id="teacherlogin_error"></p>
						                                </div>
						                                <div class="form-group">
						                                    <input class="form-control" placeholder="ID Number" id="teacherlogin_id_num" name="id_num" type="text" pattern="[0-9]+" required="required" autofocus>
						                                </div>
						                                <div class="form-group">
						                                    <input class="form-control" placeholder="Password" id="teacherlogin_password" name="password" type="password" value="" required="required">
						                                </div>		
						                                <input type="hidden" id="teacherlogin_role" name="role" value="1">						                                						                               			                                
						                                <!-- Change this to a button or input when using this as a form -->
						                               <button type='button' onclick="process_login('teacherlogin_')" id='teacherlog' class="btn btn-lg btn-success btn-block">Login</button>
						                            </fieldset>
						                        </form>
						                        <div class="text-center">
											        <ul class="list-inline">											            											            
											            <li><a class="text-muted" href="#" onclick="showSignup('Teacher')">Signup</a></li>
											        </ul>
											    </div>
						                    </div>
						                </div>
						            </div>
                                </div>                                
                            </div>
                        </div>

                         <!-- for Student Login -->
                        <div class="modal fade" id="logStudent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">                                    
                                    <div class="col-md-7 col-md-offset-4">
						                <div class="login-panel panel panel-default">                  
						                    <div class="panel-heading">
						                        <h3 class="panel-title">Please Sign In</h3>
						                    </div>
						                    <div class="panel-body">
						                        <form role='form'>
						                            <fieldset>
						                            	<div class="form-group" >
						                                	<p id="studentlogin_error"></p>
						                                </div>
						                                <div class="form-group">
						                                    <input class="form-control" placeholder="ID Number" id="studentlogin_id_num" name="id_num" type="text" pattern="[0-9]+" required="required" autofocus>
						                                </div>
						                                <div class="form-group">
						                                    <input class="form-control" placeholder="Password" id = "studentlogin_password" name="password" type="password" value="" required="required">
						                                </div>						                                
						                                <!-- Change this to a button or input when using this as a form -->
						                                <input type="hidden" id = "studentlogin_role" name="role" value="2">						                                
						                                <button type='button' id='studentlog'  onclick="process_login('studentlogin_')" class="btn btn-lg btn-success btn-block">Login</button>
						                            </fieldset>
						                        </form>
						                         <div class="text-center">
											        <ul class="list-inline">											            											            
											            <li><a class="text-muted" href="#" onclick="showSignup('Student')">Signup</a></li>											           
											        </ul>
											    </div>
						                    </div>
						                </div>
						            </div>
                                </div>                                
                            </div>
                        </div>

                        <!-- for Student Signup -->
                        <div class="modal fade " id="signupStudent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">                                    
                                    <div class="col-md-7 col-md-offset-4">
						                <div class="login-panel panel panel-default">                  
						                    <div class="panel-heading">
						                        <h3 class="panel-title">Please Signup</h3>
						                    </div>
						                    <div class="panel-body">
						                        <form role="form">
						                            <fieldset>
						                            	<div class="form-group" >
						                                	<p id="studentsignup_error"></p>
						                                </div>
						                                <div class="form-group">
						                                    <input class="form-control" placeholder="Name" id="studentsignup_name" name="name" type="text" required="required" autofocus>
						                                </div>
						                                 <div class="form-group">
						                                    <input class="form-control" placeholder="ID Number" id="studentsignup_id_num" name="id_num" type="text" pattern="[0-9]+" required="required" autofocus>
						                                </div>
						                                <div class="form-group">
						                                    <input class="form-control" placeholder="Password" id="studentsignup_password1" name="password" type="password" required="required" value="">
						                                </div>	
						                                <div class="form-group">
						                                    <input class="form-control" placeholder="Re-Password" id="studentsignup_password2" name="re-password" type="password" required="required" value="">
						                                </div>						                                
						                                <!-- Change this to a button or input when using this as a form -->
						                                <input type="hidden" id= "studentsignup_role" name="role" value="2">
						                                <input type="hidden" name="indicator" value="2">
						                                <button type='button' id='studentsign' onclick="process_signup('studentsignup_')" class="btn btn-lg btn-success btn-block">Signup</button>
						                            </fieldset>
						                        </form>
						                         <div class="text-center">
											        <ul class="list-inline">											            											            
											            <li><a class="text-muted" href="#" onclick="showLogin('Student')">Login</a></li>
											        </ul>
											    </div>
						                    </div>
						                </div>
						            </div>
                                </div>                                
                            </div>
                        </div>

                          <!-- for Teacher Signup -->
                        <div class="modal fade " id="signupTeacher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">                                    
                                    <div class="col-md-7 col-md-offset-4">
						                <div class="login-panel panel panel-default">                  
						                    <div class="panel-heading">
						                        <h3 class="panel-title">Please Signup</h3>
						                    </div>
						                    <div class="panel-body">
						                        <form role ='form'>

						                            <fieldset>
						                             	<div class="form-group" >
						                                	<p id="teachersignup_error"> </p>
						                                </div>
						                                <div class="form-group">
						                                    <input class="form-control" placeholder="Name" id='teachersignup_name' name="name" type="text" required="required" autofocus>
						                                </div>
						                                 <div class="form-group">
						                                    <input class="form-control" placeholder="ID Number" id="teachersignup_id_num" name="id_num" type="text" pattern="[0-9]+" required="required" autofocus>
						                                </div>
						                                <div class="form-group">
						                                    <input class="form-control" placeholder="Password" id="teachersignup_password1" name="password" type="password" required="required" value="">
						                                </div>	
						                                <div class="form-group">
						                                    <input class="form-control" placeholder="Re-Password" id="teachersignup_password2" name="re-password" type="password" required="required" value="">
						                                </div>						                                
						                                <!-- Change this to a button or input when using this as a form -->
						                                <input type="hidden" id="teachersignup_role" name="role" value="1">
						                                <input type="hidden" name="indicator" value="2">
						                                <button type='button' id='teachersign' onclick="process_signup('teachersignup_')" class="btn btn-lg btn-success btn-block">Signup</button>
						                            </fieldset>
						                        </form>
						                         <div class="text-center">
											        <ul class="list-inline">											            											            
											            <li><a class="text-muted" href="#" onclick="showLogin('Teacher')">Login</a></li>
											        </ul>
											    </div>
						                    </div>
						                </div>
						            </div>
                                </div>                                
                            </div>
                        </div>

                    </div>
                </div>
                 <!-- End Modals-->
            </div>
        </div>
    </div>

     <!-- Core Scripts - Include with every page -->
    <?php
    	include ('script.php');
    ?>

 	
</body>

</html>
