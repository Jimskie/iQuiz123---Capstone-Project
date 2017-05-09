<input type="hidden" name="quiz_id_value" id="quiz_id_value" value="<?php echo $_REQUEST['id'];  ?>">
<div class="row">
    <div class="col-lg-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                 <button type="button" class="btn btn-primary btn-m"  onclick="query_data('question_type')" data-toggle="modal" data-target="#SelectType">Add Question</button>
            </div>
            <?php
                $quiz_id = $_GET['id'];
                $query="
                    SELECT
                        *
                    FROM
                        question as t1
                    LEFT JOIN 
                        question_type as t2
                    ON 
                        t1.fk_type_id = t2.question_type_id
                    WHERE 
                        t1.fk_quiz_id = '".$quiz_id."'
                ";
                $q=$mysqlic->query($query)or die('Query error..' . $mysqlic->error);

                if (($q->num_rows)>0){
                ?>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Question Number</th>
                                        <th>Question</th>
                                        <th>Type</th>                                                                    
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                            $counter = 0;
                                        while ($qrow=$q->fetch_assoc()){ 
                                            $counter = $counter + 1;
                                        echo "<form action='voters_edit.php' method='POST'>";
                                            echo "<tr class='odd gradeX'>";
                                                echo "<td>".$counter."</td>";
                                                echo "<td>".$qrow['question']."</td>";
                                                echo "<td>".$qrow['question_type']."</td>";
                                                echo "<input type='hidden' id='question".$counter."' value='".$qrow['question']."'>";
                                                echo "<input type='hidden' id='question_id".$counter."' value='".$qrow['question_id']."'>";                                                
                                                echo "<input type='hidden' id='question_type_name".$counter."' value='".$qrow['question_type']."'>";
                                                echo "<input type='hidden' id='question_type_id".$counter."' value='".$qrow['fk_type_id']."'>";
                                                echo "<input type='hidden' id='choice_a".$counter."' value='".$qrow['choice_a']."'>";
                                                echo "<input type='hidden' id='choice_b".$counter."' value='".$qrow['choice_b']."'>";
                                                echo "<input type='hidden' id='choice_c".$counter."' value='".$qrow['choice_c']."'>";
                                                echo "<input type='hidden' id='answer".$counter."' value='".$qrow['answer']."'>";
                                                echo "<td><button type='button' onclick='modify_question($counter)' data-toggle='modal' data-target='#modify_question' class='btn btn-primary'>Modify</button></td>";                                                                                   
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
                echo "<input type='hidden' id='current_counter' name='current_counter'>";
                echo "<input type='hidden' id='current_question_id' name='current_question_id'>";                
                echo "<input type='hidden' id='current_type_id' name='current_type_id'>";                               
                echo "<input type='hidden' id='current_action' name='current_action'>";
            ?>
        </div>
        <!--End Advanced Tables -->
    </div>
</div>



<!-- Modal -->
 <div class="modal fade" id="SelectType" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">                                    
            <div class="col-md-7 col-md-offset-4">
                <div class="login-panel panel panel-default">                  
                    <div class="panel-heading">
                        <h3 class="panel-title">Select Question Type</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>  
                                <div class="form-group" >
                                    <p id="addQuestionmulti_errors"></p>
                                </div>                                                
                                <div class="form-group">   
                                    <p id="display_class"></p>                                                                           
                                  
                                </div>   

                                <!-- Change this to a button or input when using this as a form -->
                               <button type='button' onclick="selectType()" id='addQuestion_button' class="btn btn-lg btn-success btn-block">Submit</button>
                            </fieldset>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>                                
    </div>
</div>


<!-- Multiple Choice -->
 <div class="modal fade" id="addQuestionMulti" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" onblur="updateclass()">
    <div class="modal-dialog" >
        <div class="modal-content">                                    
            <div class="col-md-8 col-md-offset-4">
                <div class="login-panel panel panel-default">                  
                    <div class="panel-heading">
                        <h3 class="panel-title">Question</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group" >
                                    <p id="addQuestionmulti_error"></p>
                                </div>
                                <div class="form-group" >
                                    <textarea class="form-control" placeholder="Question" id="question_multi" name="question_multi" type="text" required="required" autofocus></textarea>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="A" id="choice_a_multi" name="choice_a_multi" type="text" required="required" autofocus>                                    
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="B" id="choice_b_multi" name="choice_b_multi" type="text" required="required" autofocus>                                    
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="C" id="choice_c_multi" name="choice_c_multi" type="text" required="required" autofocus>                                    
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Answer: (A or B or C)" id="answer_multi" name="answer_multi" type="text" required="required" autofocus>                                    
                                </div>
                                                                          
                                <!-- Change this to a button or input when using this as a form -->
                                <div id="button_multi">
                                    <button type='button' onclick="add_question('addQuestion','multi')" id='add_question_button' class="btn btn-lg btn-success btn-block">Submit</button>
                                </div>
                            </fieldset>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>                                
    </div>
</div>

<!-- Fill in the Blank -->
 <div class="modal fade" id="addQuestionFill" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" onblur="updateclass()">
    <div class="modal-dialog" >
        <div class="modal-content">                                    
            <div class="col-md-8 col-md-offset-4">
                <div class="login-panel panel panel-default">                  
                    <div class="panel-heading">
                        <h3 class="panel-title">Question</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group" >
                                    <p id="addQuestionfill_error"></p>
                                </div>
                                <div class="form-group" >
                                    <textarea class="form-control" placeholder="Question" id="question_fill" name="question_fill" type="text" required="required" autofocus></textarea>
                                </div>                          
                                <div class="form-group">
                                    <input class="form-control" placeholder="Answer" id="answer_fill" name="answer_fill" type="text" required="required" autofocus>                                    
                                </div>
                                                                          
                                <!-- Change this to a button or input when using this as a form -->
                                <div id='button_fill'>
                                    <button type='button' onclick="add_question('addQuestion','fill')" id='del_quiz_button' class="btn btn-lg btn-success btn-block">Submit</button>
                                </div>
                            </fieldset>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>                                
    </div>
</div>


<!-- True or False -->
 <div class="modal fade" id="addQuestionTrueOrFalse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" onblur="updateclass()">
    <div class="modal-dialog" >
        <div class="modal-content">                                    
            <div class="col-md-8 col-md-offset-4">
                <div class="login-panel panel panel-default">                  
                    <div class="panel-heading">
                        <h3 class="panel-title">Question</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group" >
                                    <p id="addQuestiontrue_error"></p>
                                </div>
                                <div class="form-group" >
                                    <textarea class="form-control" placeholder="Question" id="question_true" name="question_true" type="text" required="required" autofocus></textarea>
                                </div>                          
                                <div class="form-group">
                                    <input class="form-control" placeholder="Answer: True or False" id="answer_true" name="answer_true" type="text" required="required" autofocus>                                    
                                </div>
                                                                          
                                <!-- Change this to a button or input when using this as a form -->
                                <div id='button_true'>
                                    <button type='button' onclick="add_question('addQuestion','true')" id='del_quiz_button' class="btn btn-lg btn-success btn-block">Submit</button>
                                </div>
                            </fieldset>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>                                
    </div>
</div>