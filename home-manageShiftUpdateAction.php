<?php
require_once 'core/init.php';
$user = new User();
if(!$user->isLoggedIn()){
  Redirect::to("login.php");
}else{
  $resultresult = $user->data();
  $userlevel = $resultresult->role;
  if($resultresult->verified == false || $resultresult->superadmin == true){
    $user->logout();
    Redirect::to("login.php?error=error");
  }
}
$manageShiftObj = new ManageShift();
$manageShiftID = $_POST["manageShiftID"];
$userID = $_POST["userID"];
$manageShiftDate = $_POST["manageShiftDate"];
$comment = $_POST["comment"];

$manageShiftGroup = array('userID'=>$userID,'manageShiftDate'=>$manageShiftDate,
                                'comment'=>$comment);
$manageShiftResult = $manageShiftObj->update_manage_shift($manageShiftGroup, $manageShiftID, "manageShiftID");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Attendance Setup - DoerHRM</title>
  <?php
  include 'includes/header.php';
  ?>
</head>
<body>
  <?php include 'includes/topbar.php';?>
  <div class="d-flex" id="wrapper">
    <?php include 'includes/navbar.php';?>
    <div id="page-content-wrapper">
    <div class="container-fluid" id="content">

      <div class="row my-4">
        <div class="col">
          <h4 class="m-0"><i class="fas fa-user-cog"></i> Attendance Setup</h4>
        </div>
      </div>

      <ul class="nav nav-tabs row px-2">
        <li class="nav-item col-12 col-xl-2 p-0">
          <a class="nav-link rounded-0 text-center active" data-toggle="tab" href="#attendancegroup"><span class="font-weight-bold">ATTENDANCE GROUP</span></a>
        </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active" id="attendancegroup">
          <div style="margin: auto; width: 40%; padding: 20px;">
            <h1>Successfully updated!</h1><br /><br />
            <a href="home-attendancesetup.php" class="btn btn-primary">Go Back</a>
          </div>
        </div>
      </div>
      <!-- content -->

    </div>
  </div>
</div>

  <script type="text/javascript">
    $(document).ready(function() {
      $("#sidebar-wrapper .active").removeClass("active");
      $("#attendancesetuptab").addClass("active").addClass("disabled");
      document.getElementById("attendancesetuptab").style.backgroundColor = "DeepSkyBlue";
    });
  </script>
  <?php include 'includes/form.php';?>
  <?php include 'includes/footer.php';?>
</body>
</html>