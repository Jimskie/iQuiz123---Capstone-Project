<div class="row">
    <div class="col-lg-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            
            <?php
                $class_id = $_GET['id'];

                $query="
                    SELECT 
                        t2.user_id,t2.name,t1.student_quiz_id,t3.subject_name,t3.group_code,t1.result
                    FROM
                       student_quiz as t1
                    LEFT JOIN 
                        users as t2 
                    ON t1.fk_student_id = t2.user_id

                    LEFT JOIN 
                        class as t3
                    ON t1.fk_class_id = t3.class_id
                    WHERE 
                       t1.fk_class_id = '".$class_id."'
                ";
                $q=$mysqlic->query($query)or die('Query error..' . $mysqlic->error);
                
                ?>         
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Student's Name</th>
                                        <th>Group Name</th>
                                        <th>Group Code</th>
                                        <th>Quizes</th>       
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if (($q->num_rows)>0){
                                                $counter = 0;
                                            while ($qrow=$q->fetch_assoc()){ 

                                                // $query1="
                                                //     SELECT
                                                //         *
                                                //     FROM
                                                //        student_quiz
                                                //     WHERE 
                                                //        fk_student_id = '".$qrow['user_id']."'                                               
                                                      
                                                // ";
                                                // $q1=$mysqlic->query($query1)or die('Query error..' . $mysqlic->error);
                                               
                                                // while ($qrow1=$q1->fetch_assoc()){

                                                    $quiz_result = explode('|',$qrow['result']);
                                                    $arraycount = count($quiz_result);
                                                    $arraycount = $arraycount - 1;

                                                    for ($i=0; $i < $arraycount ; $i++) { 
                                                        $qval = $i + 1;
                                                        $quiz_results .= 'Q'.$qval.': '.$quiz_result[$i].' ';
                                                    // }                                                                              
                                                }


                                                $counter = $counter + 1;
                                            echo "<form action='voters_edit.php' method='POST'>";
                                                echo "<tr class='odd gradeX'>";
                                                    echo "<td>".$qrow['name']."</td>";
                                                    echo "<td>".$qrow['subject_name']."</td>";
                                                    echo "<td>".$qrow['group_code']."</td>";
                                                    echo "<td>".$quiz_results."</td>";

                                                    echo "<input type='hidden' id='student_name".$counter."' value='".$qrow['name']."'>";                                                    
                                                    echo "<input type='hidden' id='subject_name".$counter."' value='".$qrow['subject_name']."'>";
                                                    echo "<input type='hidden' id='subject_code".$counter."' value='".$qrow['subject_code']."'>";
                                                    echo "<input type='hidden' id='group_code".$counter."' value='".$qrow['group_code']."'>";
                                                    echo "<input type='hidden' id='class_id".$counter."' value='".$qrow['class_id']."'>";
                                                                            
                                                    echo"<td><button type='button' onclick='remove_student(".$qrow['user_id'].",".$class_id.",$counter)' class='btn btn-danger btn-m'  data-toggle='modal' data-target='#delStudent'>Remove</button></td>";
                                                echo "</tr>";
                                            echo "</form>";
                                            $quiz_results = '';
                                            $arraycount = '';

                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>                                    
                    </div>
        </div>
        <!--End Advanced Tables -->
    </div>
</div>
<!-- Modal for Students -->
<!-- Modal -->
 <div class="modal fade" id="delStudent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" onblur="updateclass()">
    <div class="modal-dialog" >
        <div class="modal-content">                                    
            <div class="col-md-7 col-md-offset-4">
                <div class="login-panel panel panel-default">                  
                    <div class="panel-heading">
                        <h3 class="panel-title">Remove Student</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group" >
                                    <p id="delClass_error"></p>
                                </div>
                                <input type="hidden" id="delStudent_class" name="delStudent_class">
                                <input type="hidden" id="delStudent_id" name="delStudent_id">

                                <div class="form-group">
                                    <label> Click Confirm to Delete:<p id='delStudent_name'></p></label>
                                </div>
                                                                             

                                <!-- Change this to a button or input when using this as a form -->
                               <button type='button' onclick="del_student('delClass_')" id='teacherlog' class="btn btn-lg btn-success btn-block">Confirm</button>
                            </fieldset>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>                                
    </div>
</div>
