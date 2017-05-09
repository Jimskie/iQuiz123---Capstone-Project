<div class="row">
    <div class="col-lg-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                 <button type="button" class="btn btn-primary btn-m"  data-toggle="modal" data-target="#addGroup">Add Group</button>
                 <a href="student.php?action=group"><button type="button" class="btn btn-primary btn-m" ><i class="fa fa-refresh"></i></button></a>
                 <div id="result"></div>
                 <?php  echo $error; ?>
            </div>
            <?php

                $query="
                    SELECT
                        *
                    FROM
                       student_quiz as t1
                    LEFT JOIN 
                       class as t2
                    ON t1.fk_class_id = t2.class_id
                    WHERE 
                        t1.fk_student_id = '".$gl_user_id."'

                ";
                $q=$mysqlic->query($query)or die('Query error..' . $mysqlic->error);

                if (($q->num_rows)>0){
                ?>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Group Name</th>                                                                         
                                        <th>Subject Code</th>
                                        <th>Group Code</th>
                                        <th>Number of Quiz </th>
                                        <th>Take Quiz</th>                                        
                                        <th>Quiz Result</th>   
                                        <th>Verse</th>                                                                                                                          
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                            $counter = 0;
                                        while ($qrow=$q->fetch_assoc()){ 
                                             $query1="
                                                    SELECT
                                                        *
                                                    FROM
                                                       quiz

                                                    WHERE 
                                                        fk_class_id = '".$qrow['class_id']."'

                                                ";
                                                $q1=$mysqlic->query($query1)or die('Query error..' . $mysqlic->error);
                                                $quiz_number = '';
                                                while ($qrow1=$q1->fetch_assoc()){ 
                                                    $quiz_number = $quiz_number + 1;
                                                }

                                            $counter = $counter + 1;
                                            $quiz_results = '';
                                            $quiz_result = explode('|',$qrow['result']);
                                            $arraycount = count($quiz_result);
                                            $arraycount = $arraycount - 1;
                                            for ($i=0; $i < $arraycount ; $i++) { 
                                                $qval = $i + 1;
                                                $quiz_results .= 'Q'.$qval.': '.$quiz_result[$i].' ';
                                            }                                                                              
                                                
                                        
                                            echo "<tr class='odd gradeX'>";
                                                echo "<td>".$qrow['subject_name']."</td>";
                                                echo "<td>".$qrow['subject_code']."</td>";
                                                echo "<td>".$qrow['group_code']."</td>";
                                                echo "<td>".$quiz_number."</td>";
                                                // echo "<input type='hidden' id='__quiz_number' name='__quiz_number' value=".$quiz_number.">";
                                                if ($qrow['group_code'] !='') {
                                                    echo "<td><button type='button' onclick = select_quiz_number($counter,$quiz_number) class='btn btn-primary btn-m' data-toggle='modal' data-target='#selectQuiz_num'>Take Quiz</button></td>";                                                                                           
                                                }                                              
                                                else{
                                                    echo "<td></td>";
                                                }
                                                
                                                echo "<td>".$quiz_results."</td>";
                                                if ($qrow['verse_location'] !='') {
                                                    echo "<input type='hidden' name='verse_location".$counter."' id='verse_location".$counter."' value='".$qrow['verse_location']."'>";
                                                     echo "<td><button type='button' onclick='view_verse($counter)' data-toggle='modal' data-target='#viewVerse' class='btn btn-primary btn-m'>View Verse</button></td>";
                                                }
                                                else{
                                                    echo "<td></td>";
                                                }
                                               
                                                echo "<input type='hidden' id='subject_name".$counter."' value='".$qrow['subject_name']."'>";
                                                echo "<input type='hidden' id='subject_code".$counter."' value='".$qrow['subject_code']."'>";
                                                echo "<input type='hidden' id='group_code".$counter."' value='".$qrow['group_code']."'>";
                                                echo "<input type='hidden' id='class_id".$counter."' value='".$qrow['class_id']."'>";
                                            echo "</tr>";
                                        
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>                                    
                    </div>
            <?php
                }

            ?>
        </div>
        <!--End Advanced Tables -->
    </div>
</div>

<input type="hidden" name="current_counter" id='current_counter'>
<input type="hidden" name="current_quiz_number" id='current_quiz_number'>



<!-- Modal -->
 <div class="modal fade" id="addGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" onblur="updateclass()">
    <div class="modal-dialog" >
        <div class="modal-content">                                    
            <div class="col-md-7 col-md-offset-4">
                <div class="login-panel panel panel-default">                  
                    <div class="panel-heading">
                        <h3 class="panel-title">Add Group</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group" >
                                    <p id="addGroup_error"></p>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Group Code" id="group_code" name="group_code" type="text" required="required" autofocus>
                                </div>                                                 

                                <!-- Change this to a button or input when using this as a form -->
                                <div id='button_add_group'>
                                    <button type='button' onclick="addGroup('addGroup_')" id='Studentlog' class="btn btn-lg btn-success btn-block">Submit</button>
                                </div>
                            </fieldset>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>                                
    </div>
</div>



<!-- View Verse -->
 <div class="modal fade" id="viewVerse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" onblur="updateclass()">
    <div class="modal-dialog" >
        <div class="modal-content">                                    
            <div class="col-md-7 col-md-offset-4">
                <div class="login-panel panel panel-default">                  
                    <div class="panel-heading">
                        <h3 class="panel-title">View Verse</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group" >
                                    <p id="addGroup_error"></p>
                                </div>
                                <div id='result_verse'></div>
                            </fieldset>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>                                
    </div>
</div>


<!-- Modal Select Quiz Number -->
 <div class="modal fade" id="selectQuiz_num" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">                                    
            <div class="col-md-7 col-md-offset-4">
                <div class="login-panel panel panel-default">                  
                    <div class="panel-heading">
                        <h3 class="panel-title">Select Quiz Number</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group" >
                                    <p id="selectQuiz_number_error"></p>
                                </div>
                                <div class="form-group" id="display_class">
                                    
                                </div>                                                 

                                <!-- Change this to a button or input when using this as a form -->
                                <div id='button_add_group'>
                                    <button type='button' onclick="take_quiz('selectQuiz_number_')" id='Studentlog' class="btn btn-lg btn-success btn-block">Submit</button>
                                </div>
                            </fieldset>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>                                
    </div>
</div>
<!-- Modal -->
 <div class="modal fade" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" >
        <div class="modal-content">                                    
            <div class="col-md-7 col-md-offset-4">
                <div class="login-panel panel panel-default">                  
                    <div class="panel-heading">
                        <h3 class="panel-title">Edit Profile Info</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group" >
                                    <p id="editProfile_error"></p>
                                </div>
                                <div id="result_profile">
                                    

                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Full Name" id="full_name" name="full_name" type="text" required="required" value="<?php echo $gl_name;  ?>" autofocus>
                                </div>    
                                <div class="form-group">
                                    <input class="form-control" placeholder="Current Password" id="current_password" name="current_password" type="password" required="required" autofocus>
                                </div>     
                                <div class="form-group">
                                    <input class="form-control" placeholder="New Password" id="new_password" name="new_password" type="password" required="required" autofocus>
                                </div>     
                                <div class="form-group">
                                    <input class="form-control" placeholder="Confirm Password" id="confirm_password" name="confirm_password" type="password" required="required" autofocus>
                                </div>                                        

                                <!-- Change this to a button or input when using this as a form -->
                                <div id='button_edit_profile'>
                                    <button type='button' onclick="edit_profile('editProfile_')" id='Studentlog' class="btn btn-lg btn-success btn-block">Submit</button>
                                </div>
                            </fieldset>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>                                
    </div>
</div>