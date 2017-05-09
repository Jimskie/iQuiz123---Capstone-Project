<?php
include ('header.php');
 if ($gl_role == 2) {	
    $rand = rand(0, 99999);
?>
<body>
    <!--  wrapper -->
    <div id="wrapper">
        <!-- navbar top -->
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="navbar">
            <!-- navbar-header -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img src="assets/img/logo.png" alt="" />
                </a>
            </div>
            <!-- end navbar-header -->
            <!-- navbar-top-links -->
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" href="logout.php">
                        <i class="fa fa-sign-out" title="logout"></i>
                    </a>                   
                </li>
                <!-- end main dropdown -->
            </ul>
            <!-- end navbar-top-links -->
        </nav>

          <!-- navbar side -->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <!-- sidebar-collapse -->
            <div class="sidebar-collapse">
                <!-- side-menu -->
                <ul class="nav" id="side-menu">
                    <li>
                        <!-- user image section-->
                        <div class="user-section">                         
                            <div class="user-info">
                                <?php echo "<div><strong>".$gl_name."</strong></div>"; ?>
                                <div class="user-text-online">
                                    <button type='button' class="btn btn-md btn-info btn-block" data-toggle="modal" data-target="#editProfile">Student</button>
                                </div>
                            </div>

                        </div>
                        <!--end user image section-->
                    </li>  
<!--                     <li class="">
                        <a href="student.php?action=profile"><i class="fa fa-dashboard fa-fw"></i>Profile</a>
                    </li> -->
                    <li class="">
                        <a href="student.php?action=group"><i class="fa fa-dashboard fa-fw"></i>Group</a>
                    </li>
                   
               <!--      <li>
                        <a href="teacher.php?action=verse"><i class="fa fa-dashboard fa-fw"></i>Verses</a>
                    </li> -->
<!--                     <li>
                        <a href="teacher.php?action=quiz"><i class="fa fa-dashboard fa-fw"></i>Quiz</a>
                    </li> -->

                </ul>
                <!-- end side-menu -->
            </div>
            <!-- end sidebar-collapse -->
        </nav>
        <!-- end navbar side -->

         <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Student's Dashboard</h1>
                </div>
                <!--End Page Header -->
            </div>

             <?php
                if ($_GET['action']=='group') {
                    include ('student_group.php');
                }
                if ($_GET['action']=='verse') {
                    include ('teacher_verse.php');
                }
                if ($_GET['action']=='student_quiz') {
                    include ('student_quiz.php');
                }
                if ($_GET['action']=='student') {
                    include ('teacher_student.php');
                }
                if ($_GET['action']=='question') {
                    include ('teacher_question.php');
                }
             ?>


        </div>

    </div>
</body>



<?php
    mysqli_close($mysqlic);
    include ('script.php');

    if ($_GET['action'] == 'student_quiz') {
       
        echo"  <script type='text/javascript'>
               $(document).ready(function() {
                timer();
            });
            </script> ";

    }
}
else{
    echo "<meta http-equiv='refresh' content='0.0; url=./' />";
}
?>