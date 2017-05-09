<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){  
    // add verse!
    if ($_POST['indicator'] == '1') { 
        if ($_POST['verse_name'] !='' AND $_FILES['upload_verse']['name'] !='') {
            $verse_name = $_POST['verse_name'];
            $file_name = $mysqlic->real_escape_string($_FILES['upload_verse']['name']);  
            $validExtensions = array('.pdf','.docx','.doc');
            $fileExtension = strrchr($_FILES['upload_verse']['name'], "."); 
            // $file_name = $file_name.$fileExtension;
            $file_location = "verse/".$file_name;

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
                            INSERT INTO
                                    verse
                                        (verse_name, verse_location)
                            VALUES
                                    ('$verse_name', '$file_location')
                        ";
                          $result=$mysqlic->query($query2)or die('Query error..' . $mysqlic->error);
                          move_uploaded_file($_FILES  ['upload_verse']['tmp_name'], $file_location);
                          $error = "<div class='alert alert-danger alert-dismissable'>
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

            


        }
    }
}

?>
<div class="row">
    <div class="col-lg-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                 <button type="button" class="btn btn-primary btn-m"  onclick="query_data('class')" data-toggle="modal" data-target="#addVerse">Add Verse</button>
                    <div id="alert_message"> 
                        
                    </div>
                   
            </div>
            <?php

                $query="
                    SELECT
                        *
                    FROM
                        verse                    
                ";
                $q=$mysqlic->query($query)or die('Query error..' . $mysqlic->error);

                if (($q->num_rows)>0){
                ?>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Verse Name</th>                                        
                                        <th>View</th>                                                         
                                        <th>Assign</th>                                                
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                            $counter = 0;
                                        while ($qrow=$q->fetch_assoc()){ 
                                            $counter = $counter + 1;
                                        echo "<form action='voters_edit.php' method='POST'>";
                                            echo "<tr class='odd gradeX'>";
                                                echo "<td>".$qrow['verse_name']."</td>";
                                                echo "<td><a href='".$qrow['verse_location']."'><button type='button' class='btn btn-primary'>View Verse</button></a></td>";
                                                echo "<input type='hidden' id='verse_name".$counter."' value='".$qrow['verse_name']."'>";
                                                echo "<input type='hidden' id='verse_location".$counter."' value='".$qrow['verse_location']."'>";
                                                echo "<input type='hidden' id='class_id".$counter."' value='".$qrow['fk_class_id']."'>";
                                                echo "<input type='hidden' id='verse_id".$counter."' value='".$qrow['verse_id']."'>";

                                                echo "<td><button type='button' class='btn btn-primary' onclick= 'assign_verse($counter)' data-toggle='modal' data-target='#assignVerse'>Assign Verse</button></td>";
                                                // echo "<td><button type='button' onclick='modify_quiz($counter)' data-toggle='modal' data-target='#modify_quiz' class='btn btn-primary'>Modify</button></td>";                                                                                   
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




<!-- Assign Verse -->
 <div class="modal fade" id="assignVerse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">                                    
            <div class="col-md-7 col-md-offset-4">
                <div class="login-panel panel panel-default">                  
                    <div class="panel-heading">
                        <h3 class="panel-title">Assign Verse</h3>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action='' enctype='multipart/form-data'>
                            <fieldset>
                                <div class="form-group" >
                                    <p id="assignVerse_error"></p>
                                </div>
                                <div class="form-group">   
                                    <p id="display_class"></p>     
                                
                                <!-- Change this to a button or input when using this as a form -->
                               <button type='button' onclick="assinged_verse('assignVerse_')"  class="btn btn-lg btn-success btn-block">Submit</button>
                            </fieldset>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>                                
    </div>
</div>