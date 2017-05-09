<?php 
include ('connection.php');
include ('global.php');
if ($_POST['indicator'] == '1') { 
        if ($_POST['current_class_id'] !='' AND $_FILES['upload_verse']['name'] !='') {
            $class_id = $_POST['current_class_id'];
            $verse_name = $_POST['verse_name'];
            $file_name = $mysqlic->real_escape_string($_FILES['upload_verse']['name']);  
            $file_name = str_replace(" ", '_', $file_name);
            $validExtensions = array('.pdf','.docx','.doc');
            $fileExtension = strrchr($_FILES['upload_verse']['name'], "."); 
            // $file_name = $file_name.$fileExtension;

            $file_location = "verse/".$file_name;            

            $query3="
                SELECT *
                FROM  class
                WHERE 
                        class_id = '$class_id'
            ";
              $q3=$mysqlic->query($query3)or die('Query error..' . $mysqlic->error);
            while ($qrow3=$q3->fetch_assoc()){ 
                $prev_file_location = $qrow3['verse_location'];
                $prev_file_name = $qrow3['verse_name'];
            }
            $file_locations = $prev_file_location . "verse/".$file_name."|";
            $verse_name = $prev_file_name . $verse_name . "|";

            if($_FILES['upload_verse']['error'] == 0) {
                if (in_array($fileExtension, $validExtensions)) {
                   if (file_exists( $target_dir ."/". $_FILES["upload_verse"]["name"])){                                
                       $error = "<div class='alert alert-danger alert-dismissable'>
                            <button type='button' class='close' data-dismiss='aler' aria-hidden='true'>×</button>
                            File already exist
                            </div>";        
                    }
                    else{
                        $query2="
                            UPDATE
                                    class
                            SET    verse_location = '$file_locations',
                                   verse_name = '$verse_name'
                            WHERE 
                                    class_id = '$class_id'
                        ";
                          $result=$mysqlic->query($query2)or die('Query error..' . $mysqlic->error);
                          move_uploaded_file($_FILES  ['upload_verse']['tmp_name'], $file_location);
                          $error = "<div class='alert alert-success alert-dismissable'>
                            <button type='button' class='close' data-dismiss='aler' aria-hidden='true'>×</button>
                            Verse Successfully Added
                            </div>";      
                    }

                }
                else{   
                    $error = "<div class='alert alert-danger alert-dismissable'>
                            <button type='button' class='close' data-dismiss='aler' aria-hidden='true'>×</button>
                            Format not supported Please try Again
                            </div>";                                       
                }

            }
            else{
                $error = "<div class='alert alert-danger alert-dismissable'>
                            <button type='button' class='close' data-dismiss='aler' aria-hidden='true'>×</button>
                            An error accured while the file was being uploaded
                            </div>"; 
            }

            echo "<meta http-equiv='refresh' content='2; url=teacher.php?action=class' />";


        }
    }
?>

<div class="row">
    <div class="col-lg-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                 <button type="button" class="btn btn-primary btn-m"  data-toggle="modal" data-target="#addClass">Add Class</button>
                 <a href="teacher.php?action=class"><button type="button" class="btn btn-primary btn-m"  data-toggle="modal" data-target="#addClass"><i class="fa fa-refresh"></i></button></a>

                 <?php  echo $error; ?>
            </div>
            <?php

                $query="
                    SELECT
                        *
                    FROM
                       class
                    WHERE 
                        fk_user_id = '".$gl_user_id."'

                ";
                $q=$mysqlic->query($query)or die('Query error..' . $mysqlic->error);

                if (($q->num_rows)>0){
                ?>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Subject Name</th>
                                        <th>Subject Code</th>
                                        <th>Group Code</th>
                                        <th>Verse</th>
                                        <th>Student</th>                                                                                     
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
                                                echo "<td>".$qrow['subject_name']."</td>";
                                                echo "<td>".$qrow['subject_code']."</td>";
                                                echo "<td>".$qrow['group_code']."</td>";
                                                echo "<td><button type='button' class='btn btn-primary btn-m'  onclick='assign_verse($counter)' data-toggle='modal' data-target='#addVerse'>Add Verse</button></td>";
                                                echo "<input type='hidden' id='subject_name".$counter."' value='".$qrow['subject_name']."'>";
                                                echo "<input type='hidden' id='subject_code".$counter."' value='".$qrow['subject_code']."'>";
                                                echo "<input type='hidden' id='group_code".$counter."' value='".$qrow['group_code']."'>";
                                                echo "<input type='hidden' id='class_id".$counter."' value='".$qrow['class_id']."'>";

                                                echo "<td><a href='teacher.php?action=student&id=".$qrow['class_id']."'><button type='button' class='btn btn-primary'>View Students</button></a></td>";
                                                echo "<td><button type='button' onclick='modify_class($counter)' class='btn btn-primary'>Modify</button></td>";                                                                                   
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

<input type="hidden" name="current_counter" id='current_counter'>


<!-- Modal -->
 <div class="modal fade" id="addClass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" onblur="updateclass()">
    <div class="modal-dialog" >
        <div class="modal-content">                                    
            <div class="col-md-7 col-md-offset-4">
                <div class="login-panel panel panel-default">                  
                    <div class="panel-heading">
                        <h3 class="panel-title">Add Class</h3>                        
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group" >
                                    <p id="addClass_error"></p>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Subject Name" id="class_subject" name="class_subject" type="text" required="required" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Subject Code" id="class_subject_code" name="password" type="text" value="" required="required">
                                </div>                                                    

                                <!-- Change this to a button or input when using this as a form -->
                                <div id='close_button'>
                                    <button type='button' onclick="addClass('addClass_')" id='teacherlog' class="btn btn-lg btn-success btn-block">Submit</button>
                                </div>
                            </fieldset>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>                                
    </div>
</div>

<!--Modify Modal -->
 <div class="modal fade" id="editClass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">                                    
            <div class="col-md-7 col-md-offset-4">
                <div class="login-panel panel panel-default">                  
                    <div class="panel-heading">
                        <h3 class="panel-title">Edit Class</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group" >
                                    <p id="editClass_error"></p>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Subject Name" id="edit_class_subject" name="class_subject" type="text" required="required" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Subject Code" id="edit_class_subject_code" name="password" type="text" value="" required="required">
                                </div>    
                                    <input type="hidden" name="edit_class_counter" id="edit_class_counter">                                                

                                <!-- Change this to a button or input when using this as a form -->
                                <div id='close_button_edit'>
                                   <button type='button' onclick="edit_class('editClass_')" id='editClass' class="btn btn-lg btn-success btn-block">Edit</button>
                                   <button type='button' onclick="del_class('editClass_')" id='teacherlog' class="btn btn-lg btn-danger btn-block">Delete</button>
                                </div>
                            </fieldset>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>                                
    </div>
</div>

<!-- Assign Verse -->
<!-- Modal -->
 <div class="modal fade" id="addVerse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">                                    
            <div class="col-md-7 col-md-offset-4">
                <div class="login-panel panel panel-default">                  
                    <div class="panel-heading">
                        <h3 class="panel-title">Add Verse</h3>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action='' enctype='multipart/form-data'>
                            <fieldset>
                                <div class="form-group" >
                                    <p id="addQuiz_error"></p>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Verse Name" id="verse_name" name="verse_name" type="text" required="required" autofocus>
                                </div>
                                <div class="form-group">
                                    <div class='btn'> 
                                        <label class='fileUpload'>
                                            <input id='upload_verse' type='file' name='upload_verse' />
                                        </label>                                            
                                    </div>
                                </div>   
                                <input type="hidden" name="indicator" value="1">
                                <input type="hidden" name="current_class_id" id='current_class_id'>

                                <!-- Change this to a button or input when using this as a form -->
                               <button type='submit' class="btn btn-lg btn-success btn-block">Submit</button>
                            </fieldset>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>                                
    </div>
</div>