<?php
include ('connection.php');
include ('global.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
    if ($_POST['indicator']==1) {
        $counter = $_POST['counter'];        
        $answer = explode('|',$_POST['answer']);
        $quiz_id = $_POST['quiz_id'];
        $student_quiz_id = $_POST['student_quiz_id'];
        $correct_answer = 0;
        for ($i=1; $i <=$counter ; $i++) { 
            $question = strtoupper($_POST['question'.$i]);
            $array_val = $i-1;
            if ($question == strtoupper($answer[$array_val])) {
                $correct_answer = $correct_answer + 1;
            }
        }
        $score = $correct_answer."/".$counter."|";
        $scored = $correct_answer."/".$counter;

        $query2=" SELECT
                        *
                  FROM  
                        student_quiz
                  WHERE 
                        student_quiz_id = '$student_quiz_id'
        ";
        $q2=$mysqlic->query($query2)or die('Query error..' . $mysqlic->error);
        while ($qrow2=$q2->fetch_assoc()){ 
            $result  = $qrow2['result'];
        }    

        $new_result = $result.$score;

        $query1=" UPDATE 
                    student_quiz
                  SET result  = '$new_result'
                  WHERE 
                        student_quiz_id = '$student_quiz_id'
        ";
        $q1=$mysqlic->query($query1)or die('Query error..' . $mysqlic->error);

         echo "
            <div class='modal show' id='vote_message2' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>   
                    <div class='col-md-7 col-md-offset-4'>
                        <div class='login-panel panel panel-default'>                  
                            <div class='panel-heading'>
                                <h3 class='panel-title'>RESULT</h3>
                            </div>
                            <div class='panel-body'>
                                <form role='form'>
                                    <fieldset>                                   
                                        <button type='button' class='close' data-dismiss='alert'>x</button>
                                         <strong>Success! </strong>
                                            Your Score is : ".$scored." 
                                    </fieldset>
                                </form>                        
                            </div>
                        </div>
                    </div>                                 
                    </div>
                </div>           
            </div>
            ";
            echo "<script>
                    localStorage.setItem('second','');
                    localStorage.setItem('minute','');
                    localStorage.setItem('student_quiz_id','');
                    localStorage.setItem('quiz_id','');
            </script>";
           echo "<meta http-equiv='refresh' content='4; url=student.php?action=group' />"; //redirector
    }
}

else{
?>


<div class="row">
    <div class="col-lg-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                 
                 <div id="result">
                    <div id="clockdiv">
                      <div>
                        <span class="days">  <p id="demo"></p></span>
                        <div class="smalltext" id="smalltext">Time</div>
                      </div>
                    </div>
                 </div>
                 <?php  echo $error; ?>
            </div>
            <?php
                $quiz_id = $_GET['id'];
                // get Time Limit
                $query1="
                    SELECT
                        *
                    FROM
                       quiz                    
                    WHERE 
                        quiz_id = '".$quiz_id."'
                ";
                $q1=$mysqlic->query($query1)or die('Query error..' . $mysqlic->error);

                while ($qrow1=$q1->fetch_assoc()){ 
                    $time_limit = $qrow1['quiz_limit'];
                    $quiz_number = $_GET['quiz_number'];
                    echo "<input type='hidden' id='quiz_limit' value=".$time_limit.">";
                    echo "<input type='hidden' id='quiz_number' value=".$quiz_number.">";
                }

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
                ?>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <tbody>
                                    <?php
                                        echo "<form action='' method='POST'>";
                                            $counter = 0;
                                        while ($qrow=$q->fetch_assoc()){ 
                                            $counter = $counter + 1;                                                                    
                                            $answer .= $qrow['answer']."|";
                                            echo "<tr class='odd gradeX'>";
                                                echo "<td>".$counter.".  ".$qrow['question']."</td>";
                                            echo "<tr>";    
                                            echo "<tr class='odd gradeX'>";                                           
                                                if ($qrow['fk_type_id']==1) {

                                                    echo "<td>
                                                                <div class='form-group'>                                                      
                                                                <div class='radio'>
                                                                    <label>
                                                                        <input type='radio' name='question".$counter."' id='question".$counter."' value='A'>".$qrow['choice_a']."
                                                                    </label>
                                                                </div> 
                                                                <div class='radio'>
                                                                    <label>
                                                                        <input type='radio' name='question".$counter."' id='question".$counter."' value='B'>".$qrow['choice_b']."
                                                                        
                                                                    </label>
                                                                </div> 
                                                                <div class='radio'>
                                                                    <label>
                                                                        <input type='radio' name='question".$counter."' id='question".$counter."' value='C'>".$qrow['choice_c']."
                                                                        
                                                                    </label>
                                                                </div> 
                                                                </div>                                                               
                                                            
                                                        </td>";
                                                }
                                                if ($qrow['fk_type_id'] ==2) {
                                                   
                                                    echo "<td><div class='form-group'>
                                                            <input class='form-control' style='width:30%' id='question".$counter."' name='question".$counter."' type='text'>
                                                        </div></td> ";
                                                }
                                                if ($qrow['fk_type_id'] ==3) {
                                                     echo "<td>
                                                                <div class='form-group'>                                                      
                                                                <div class='radio'>
                                                                    <label>
                                                                        <input type='radio' name='question".$counter."' id='question".$counter."' value='True' >True
                                                                    </label>
                                                                </div> 
                                                                <div class='radio'>
                                                                    <label>
                                                                        <input type='radio' name='question".$counter."' id='question".$counter."' value='False'>False
                                                                    </label>
                                                                </div> 
                                                                </div>
                                                            </td>";
                                                }
                                            echo "</tr>";
                                            }
                                        echo "<tr>";
                                        echo "<input type='hidden' name= 'indicator' value=1>";
                                        echo "<input type='hidden' name= 'counter' value=".$counter.">";
                                        echo "<input type='hidden' name= 'answer' value=".$answer.">";
                                        echo "<input type='hidden' name= 'quiz_id' id= 'quiz_id' value=".$_GET['id'].">";
                                        echo "<input type='hidden' name= 'student_quiz_id' id= 'student_quiz_id' value=".$_GET['quiz_id'].">";
                                        echo "<td><button type='submit' id='submit-button' style='width:6%;font-size:15px' class='btn btn-lg btn-success btn-block'>Submit</button></td>";
                                        echo "</form></tr>";
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
<?php 
}
?>

