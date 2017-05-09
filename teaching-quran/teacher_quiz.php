<div class="row">
    <div class="col-lg-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                 <button type="button" class="btn btn-primary btn-m"  onclick="query_data('class')" data-toggle="modal" data-target="#addQuiz">Add Quiz</button>
                 <a href="teacher.php?action=quiz"><button type="button" class="btn btn-primary btn-m"  data-toggle="modal" data-target="#addClass"><i class="fa fa-refresh"></i></button></a>
                 <div id="alert_message"> 
                
                </div>
            </div>
            <?php

                $query="
                    SELECT
                        *
                    FROM
                        quiz as t1
                    LEFT JOIN 
                        class as t2
                    ON 
                        t1.fk_class_id = t2.class_id
                    WHERE 
                        t1.fk_user_id = '".$gl_user_id."'

                ";
                $q=$mysqlic->query($query)or die('Query error..' . $mysqlic->error);

                if (($q->num_rows)>0){
                ?>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Quiz Name</th>
                                        <th>Quiz Number</th>
                                        <th>Class Name</th>                                              
                                        <th>Students</th>                                                                                        
                                        <th>Question</th>
                                        <th>Status</th>                                              
                                        <th>Action</th>
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
                                                        student_quiz                                                     
                                                    WHERE 
                                                        fk_class_id = '".$qrow['fk_class_id']."'

                                                ";
                                                $q1=$mysqlic->query($query1)or die('Query error..' . $mysqlic->error);    
                                                    $total = 0;
                                                    $taken = 0;
                                                while ($qrow1=$q1->fetch_assoc()){ 
                                                    $total = $total + 1;
                                                    $result = explode('|',$qrow1['result']);
                                                    $result = count($result);
                                                    $result = $result - 1; 
                                                    if ($qrow['quiz_number'] <= $result) {
                                                        $taken = $taken + 1;
                                                    }
                                                }


                                            $counter = $counter + 1;
                                        echo "<form action='voters_edit.php' method='POST'>";
                                            echo "<tr class='odd gradeX'>";
                                                echo "<td>".$qrow['quiz_name']."</td>";
                                                echo "<td>".$qrow['quiz_number']."</td>";                                                                                                
                                                echo "<td>".$qrow['subject_name']."</td>";
                                                echo "<td>".$taken."/".$total."</td>";
                                                echo "<input type='hidden' id='quiz_name".$counter."' value='".$qrow['quiz_name']."'>";
                                                echo "<input type='hidden' id='quiz_number".$counter."' value='".$qrow['quiz_number']."'>";
                                                echo "<input type='hidden' id='quiz_class".$counter."' value='".$qrow['fk_class_id']."'>";
                                                echo "<input type='hidden' id='quiz_id".$counter."' value='".$qrow['quiz_id']."'>";
                                                $quiz_status = $qrow['quiz_status'];
                                                $quiz_id = $qrow['quiz_id'];
                                                echo "<td><a href='teacher.php?action=question&id=".$qrow['quiz_id']."'><button type='button' class='btn btn-primary'>Modify Questions</button></a></td>";
                                                if ($qrow['quiz_status'] == 0 ) {
                                                    echo "<td><button type='button' id='quiz_status_button".$counter."' onclick='quiz_status($counter,$quiz_id,$quiz_status)' class='btn btn-success'>Unlocked</button></td>";
                                                }
                                                else{
                                                    echo "<td><button type='button' id='quiz_status_button".$counter."' onclick='quiz_status($counter,$quiz_id,$quiz_status)' class='btn btn-danger'>Locked</button></td>";

                                                }
                                                
                                                echo "<td><button type='button' onclick='modify_quiz($counter)' data-toggle='modal' data-target='#modify_quiz' class='btn btn-danger'>Remove</button></td>";                               
                                                

                                            echo "</tr>";
                                        echo "</form>";
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



<!-- Modal -->
 <div class="modal fade" id="addQuiz" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">                                    
            <div class="col-md-7 col-md-offset-4">
                <div class="login-panel panel panel-default">                  
                    <div class="panel-heading">
                        <h3 class="panel-title">Add Quiz</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group" >
                                    <p id="addQuiz_error"></p>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Quiz Name" id="quiz_name" name="quiz_name" type="text" required="required" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Quiz Number" id="quiz_number" name="quiz_number" type="hidden" value="" required="required">
                                </div> 
                                 <div class="form-group">
                                    <input class="form-control" placeholder="Time Limit (mm:ss)" id="quiz_limit" name="quiz_limit" type="text" value="" required="required">
                                </div> 

                                <div class="form-group">   
                                    <p id="display_class"></p>                                                                           
                                  
                                </div>   

                                <!-- Change this to a button or input when using this as a form -->
                                <div id='close_button'>
                                    <button type='button' onclick="addQuiz('addQuiz_')" id='addQuiz_button' class="btn btn-lg btn-success btn-block">Submit</button>
                                </div>
                            </fieldset>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>                                
    </div>
</div>
<input type="hidden" id='addQuestionmulti_errors'>

<!-- Modal -->
 <div class="modal fade" id="modify_quiz" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" onblur="updateclass()">
    <div class="modal-dialog" >
        <div class="modal-content">                                    
            <div class="col-md-7 col-md-offset-4">
                <div class="login-panel panel panel-default">                  
                    <div class="panel-heading">
                        <h3 class="panel-title">Remove Quiz</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group" >
                                    <p id="delQuiz_error"><label> Click Confirm to Delete:<p id='delquiz_name'></p></label></p>
                                </div>
                                <input type="hidden" id="delquiz" name="delquiz">                               

                                <div class="form-group">
                                    
                                </div>
                                                                             

                                <!-- Change this to a button or input when using this as a form -->
                               <button type='button' onclick="del_quiz('delQuiz_')" id='del_quiz_button' class="btn btn-lg btn-success btn-block">Confirm</button>
                            </fieldset>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>                                
    </div>
</div>